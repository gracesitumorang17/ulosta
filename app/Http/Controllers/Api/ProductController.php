<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Get all products
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true)->where('stock', '>', 0);

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by tag
        if ($request->has('tag') && $request->tag != '') {
            $query->where('tag', $request->tag);
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);

        return $this->successResponse([
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ], 'Products retrieved successfully');
    }

    /**
     * Get single product
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->notFoundResponse('Product not found');
        }

        return $this->successResponse($product, 'Product retrieved successfully');
    }

    /**
     * Get products by category
     */
    public function byCategory($category)
    {
        $products = Product::where('category', $category)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return $this->successResponse([
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ], 'Products retrieved successfully');
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q', '');

        $products = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%')
                      ->orWhere('category', 'like', '%' . $keyword . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return $this->successResponse([
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ], 'Search results retrieved successfully');
    }
}
