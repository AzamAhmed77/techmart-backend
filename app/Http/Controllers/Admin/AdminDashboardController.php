<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Dashboard Overview
     */
    public function index()
    {
        $totalRevenue = Order::whereIn('status', ['delivered', 'processing', 'pending'])->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::count();

        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $processingOrdersCount = Order::where('status', 'processing')->count();
        $deliveredOrdersCount = Order::where('status', 'delivered')->count();

        $recentOrders = Order::with('items')->latest()->take(8)->get();
        $topProducts = Product::orderBy('rating', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'pendingOrdersCount',
            'processingOrdersCount',
            'deliveredOrdersCount',
            'recentOrders',
            'topProducts'
        ));
    }

    /**
     * Orders Management
     */
    public function orders(Request $request)
    {
        $query = Order::with('items')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    /**
     * Update Order Status
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', "تم تحديث حالة الطلب #{$order->order_number} بنجاح إلى ({$order->status_arabic})");
    }

    /**
     * Products Management
     */
    public function products(Request $request)
    {
        $query = Product::latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(15);
        $categories = Product::distinct()->pluck('category');

        return view('admin.products', compact('products', 'categories'));
    }

    /**
     * Store New Product
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'image_url' => 'required|url',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['rating'] = 5.0;
        $validated['reviews_count'] = 0;

        Product::create($validated);

        return redirect()->back()->with('success', 'تمت إضافة المنتج الجديد إلى المتجر بنجاح!');
    }

    /**
     * Update Existing Product
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'image_url' => 'required|url',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        return redirect()->back()->with('success', 'تم تحديث بيانات المنتج بنجاح!');
    }

    /**
     * Delete Product
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'تم حذف المنتج من المتجر بنجاح!');
    }

    /**
     * Coupons Management
     */
    public function coupons()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons', compact('coupons'));
    }

    /**
     * Store Coupon
     */
    public function storeCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'max_discount_amount' => 'nullable|numeric|min:1',
            'min_order_amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_active'] = true;

        Coupon::create($validated);

        return redirect()->back()->with('success', "تم إنشاء الكوبون {$validated['code']} بنجاح!");
    }

    /**
     * Toggle Coupon Status
     */
    public function toggleCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['is_active' => !$coupon->is_active]);

        $status = $coupon->is_active ? 'تفعيل' : 'تعطيل';
        return redirect()->back()->with('success', "تم {$status} الكوبون {$coupon->code} بنجاح!");
    }

    /**
     * Customers List
     */
    public function customers()
    {
        $customers = User::withCount('orders')->latest()->paginate(20);
        return view('admin.customers', compact('customers'));
    }
}
