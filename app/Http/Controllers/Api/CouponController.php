<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Validate a promo coupon code against an order amount.
     */
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $code = strtoupper(trim($request->code));
        $amount = (float) $request->amount;

        $coupon = Coupon::where('code', $code)->where('is_active', true)->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'كوبون الخصم غير موجود أو غير صالح.',
            ], 404);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json([
                'status' => 'error',
                'message' => 'عذراً، هذا الكوبون انتهت صلاحيته.',
            ], 400);
        }

        if ($amount < (float) $coupon->min_order_amount) {
            return response()->json([
                'status' => 'error',
                'message' => "الحد الأدنى لتطبيق هذا الكوبون هو \${$coupon->min_order_amount}.",
            ], 400);
        }

        $discount = $coupon->calculateDiscount($amount);

        return response()->json([
            'status' => 'success',
            'message' => "تم تفعيل الكوبون! حصلت على خصم {$coupon->discount_percentage}% (\${$discount}).",
            'coupon' => [
                'code' => $coupon->code,
                'discount_percentage' => $coupon->discount_percentage,
                'discount_amount' => $discount,
                'final_amount' => max(0, $amount - $discount),
            ],
        ], 200);
    }

    /**
     * Get active public coupons for promo banners.
     */
    public function getActiveCoupons()
    {
        $coupons = Coupon::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'coupons' => $coupons,
        ], 200);
    }
}
