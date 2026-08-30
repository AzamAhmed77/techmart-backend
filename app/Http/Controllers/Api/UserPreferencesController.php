<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserPreferencesController extends Controller
{
    // ==========================================
    // 1. User Isolated Favorites
    // ==========================================

    public function getFavorites(Request $request)
    {
        $userId = $request->user()->id;

        $favoriteProductIds = Favorite::where('user_id', $userId)->pluck('product_id');
        $products = Product::whereIn('id', $favoriteProductIds)->get();

        return response()->json([
            'status' => 'success',
            'favorite_ids' => $favoriteProductIds,
            'data' => $products,
        ]);
    }

    public function toggleFavorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'المنتج غير موجود'], 422);
        }

        $userId = $request->user()->id;
        $productId = $request->product_id;

        $existing = Favorite::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            $isFavorite = false;
            $message = 'تمت إزالة المنتج من المفضلة';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $isFavorite = true;
            $message = 'تمت إضافة المنتج إلى المفضلة';
        }

        $currentIds = Favorite::where('user_id', $userId)->pluck('product_id');

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'is_favorite' => $isFavorite,
            'favorite_ids' => $currentIds,
        ]);
    }

    // ==========================================
    // 2. User Isolated Cart
    // ==========================================

    public function getCart(Request $request)
    {
        $userId = $request->user()->id;

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        $formatted = $cartItems->map(function ($item) {
            return [
                'product' => $item->product,
                'quantity' => $item->quantity,
            ];
        });

        return response()->json([
            'status' => 'success',
            'items' => $formatted,
            'data' => $formatted,
        ]);
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'بيانات غير صالحة'], 422);
        }

        $userId = $request->user()->id;
        $productId = $request->product_id;
        $quantity = $request->input('quantity', 1);

        $item = CartItem::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $this->getCart($request);
    }

    public function updateCartQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'بيانات غير صالحة'], 422);
        }

        $userId = $request->user()->id;
        $productId = $request->product_id;
        $quantity = (int) $request->quantity;

        if ($quantity <= 0) {
            CartItem::where('user_id', $userId)->where('product_id', $productId)->delete();
        } else {
            CartItem::updateOrCreate(
                ['user_id' => $userId, 'product_id' => $productId],
                ['quantity' => $quantity]
            );
        }

        return $this->getCart($request);
    }

    public function removeFromCart($productId, Request $request)
    {
        $userId = $request->user()->id;
        CartItem::where('user_id', $userId)->where('product_id', $productId)->delete();

        return $this->getCart($request);
    }

    public function clearCart(Request $request)
    {
        $userId = $request->user()->id;
        CartItem::where('user_id', $userId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تفريغ السلة بنجاح',
            'data' => [],
        ]);
    }

    // ==========================================
    // 3. User Profile Settings Update
    // ==========================================

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => 'nullable|string|max:255',
        ];

        if ($request->filled('password')) {
            $rules['current_password'] = 'required|string';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $validator = Validator::make($request->all(), $rules, [
            'name.string' => 'الاسم يجب أن يكون نصاً صالحاً.',
            'current_password.required' => 'يرجى إدخال كلمة المرور الحالية لتغيير كلمة المرور.',
            'password.min' => 'كلمة المرور يجب أن لا تقل عن 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first() ?? 'بيانات التحديث غير صالحة',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'كلمة المرور الحالية غير صحيحة.',
                ], 422);
            }
            $user->password = Hash::make($request->password);
        }

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث البيانات الشخصية بنجاح',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                ],
            ],
        ]);
    }
}
