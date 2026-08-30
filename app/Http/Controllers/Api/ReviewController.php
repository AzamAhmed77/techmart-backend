<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Get reviews for a product.
     */
    public function getProductReviews($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'المنتج غير موجود.',
            ], 404);
        }

        $reviews = Review::with('user:id,name,email')
            ->where('product_id', $productId)
            ->orderBy('id', 'desc')
            ->get();

        $avgRating = $reviews->avg('rating') ?: (float) $product->rating;
        $reviewsCount = $reviews->count() ?: (int) $product->reviews_count;

        return response()->json([
            'status' => 'success',
            'rating' => round((float) $avgRating, 1),
            'reviews_count' => $reviewsCount,
            'reviews' => $reviews,
        ], 200);
    }

    /**
     * Add or update review for a product.
     */
    public function addReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'يرجى اختيار التقييم بالنجوم.',
            'rating.min' => 'التقييم يجب أن يكون بين 1 و 5 نجوم.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات التقييم غير صالحة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $productId = $request->product_id;

        $review = Review::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $productId,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        // Recalculate average rating for product
        $product = Product::find($productId);
        $avgRating = Review::where('product_id', $productId)->avg('rating');
        $count = Review::where('product_id', $productId)->count();

        if ($product) {
            $product->rating = round((float) $avgRating, 1);
            $product->reviews_count = $count;
            $product->save();
        }

        $review->load('user:id,name,email');

        return response()->json([
            'status' => 'success',
            'message' => 'شكراً لك! تمت إضافة تقييمك بنجاح.',
            'review' => $review,
            'product_rating' => $product ? $product->rating : 5.0,
            'reviews_count' => $count,
        ], 200);
    }
}
