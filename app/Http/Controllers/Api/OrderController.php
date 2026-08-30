<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\InAppNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Create a new order.
     */
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'shipping_address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'string', 'in:cod,card,mada,apple_pay'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'coupon_code' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ], [
            'recipient_name.required' => 'اسم المستلم مطلوب.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'shipping_address.required' => 'عنوان التوصيل مطلوب.',
            'city.required' => 'المدينة مطلوبة.',
            'items.required' => 'السلة فارغة.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات الطلب غير مكتملة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        try {
            return DB::transaction(function () use ($request, $user) {
                $subtotal = 0.0;
                $processedItems = [];

                foreach ($request->items as $itemData) {
                    $product = Product::find($itemData['product_id']) ?? Product::first();
                    if (!$product) {
                        continue;
                    }

                    $qty = (int) $itemData['quantity'];
                    $itemPrice = (float) $product->price;
                    $itemTotal = $itemPrice * $qty;
                    $subtotal += $itemTotal;

                    $processedItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_image' => $product->image_url,
                        'price' => $itemPrice,
                        'quantity' => $qty,
                        'total' => $itemTotal,
                    ];
                }

                if (empty($processedItems)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'لم يتم العثور على أي من المنتجات المحددة في النظام.',
                    ], 400);
                }

                // Calculate discount if coupon provided
                $discount = 0.0;
                $couponCode = $request->coupon_code ? strtoupper(trim($request->coupon_code)) : null;
                if ($couponCode) {
                    $coupon = Coupon::where('code', $couponCode)->where('is_active', true)->first();
                    if ($coupon && $coupon->isValidForAmount($subtotal)) {
                        $discount = $coupon->calculateDiscount($subtotal);
                    }
                }

                $shippingFee = $subtotal > 500 ? 0.00 : 15.00; // Free shipping over $500
                $total = max(0, ($subtotal - $discount) + $shippingFee);

                $orderNumber = Order::generateOrderNumber();

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'shipping_fee' => $shippingFee,
                    'total' => $total,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'paid',
                    'recipient_name' => $request->recipient_name,
                    'phone' => $request->phone,
                    'shipping_address' => $request->shipping_address,
                    'city' => $request->city,
                    'coupon_code' => $couponCode,
                    'notes' => $request->notes,
                ]);

                foreach ($processedItems as $pItem) {
                    $pItem['order_id'] = $order->id;
                    OrderItem::create($pItem);
                }

                // Clear user's database cart
                CartItem::where('user_id', $user->id)->delete();

                // Create In-App Notification
                InAppNotification::create([
                    'user_id' => $user->id,
                    'title' => "تم تأكيد طلبك بنجاح #{$orderNumber} 🎉",
                    'message' => "شكراً لتسوقك من TECH MART! طلبك بقيمة \${$total} قيد التجهيز الآن وسيتم شحنه قريباً.",
                    'type' => 'order',
                    'action_id' => (string) $order->id,
                    'is_read' => false,
                ]);

                $order->load('items');

                return response()->json([
                    'status' => 'success',
                    'message' => 'تم إنشاء وتأكيد طلبك بنجاح!',
                    'order' => $order,
                ], 201);
            });
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إنشاء الطلب: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user orders list.
     */
    public function getOrders(Request $request)
    {
        $user = $request->user();
        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders,
        ], 200);
    }

    /**
     * Get order details with items.
     */
    public function getOrderDetails(Request $request, $id)
    {
        $user = $request->user();
        $order = Order::with('items')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'الطلب غير موجود.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'order' => $order,
        ], 200);
    }

    /**
     * Cancel an order if still pending.
     */
    public function cancelOrder(Request $request, $id)
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'الطلب غير موجود.',
            ], 404);
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'لا يمكن إلغاء الطلب لأنه دخل مرحلة التجهيز أو الشحن.',
            ], 400);
        }

        $order->status = 'cancelled';
        $order->save();

        InAppNotification::create([
            'user_id' => $user->id,
            'title' => "تم إلغاء الطلب #{$order->order_number}",
            'message' => "تم إلغاء طلبك بنجاح بناءً على رغبتك.",
            'type' => 'order',
            'action_id' => (string) $order->id,
            'is_read' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم إلغاء الطلب بنجاح.',
            'order' => $order,
        ], 200);
    }
}
