<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get list of products with optional search, category filter, and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category') && $request->category !== 'All' && $request->category !== 'الكل') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('ids')) {
            $ids = explode(',', $request->input('ids'));
            $query->whereIn('id', $ids);
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        // Price & Rating Filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float)$request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float)$request->input('max_price'));
        }
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', (float)$request->input('min_rating'));
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'asc');
        $allowedSort = ['id', 'price', 'rating', 'name', 'created_at'];
        if (in_array($sortBy, $allowedSort)) {
            $query->orderBy($sortBy, $sortDir === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('id', 'asc');
        }

        // Pagination: default 20 items per page
        $perPage = min((int)$request->input('per_page', 20), 100);
        $page = max((int)$request->input('page', 1), 1);

        $total = $query->count();
        $products = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'status' => 'success',
            'count' => $products->count(),
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => (int)ceil($total / $perPage),
            'has_more' => ($page * $perPage) < $total,
            'products' => $products,
            'data' => $products,
        ], 200);
    }

    /**
     * Get single product details.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'المنتج غير موجود',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'product' => $product,
            'data' => $product,
        ], 200);
    }

    /**
     * Get unique categories.
     */
    public function categories()
    {
        $categories = Product::select('category')->distinct()->pluck('category');

        return response()->json([
            'status' => 'success',
            'categories' => $categories,
            'data' => $categories,
        ], 200);
    }
}
