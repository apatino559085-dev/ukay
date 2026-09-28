<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the shop / ukay finds page with products, search, and filters.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search filter (Item Name, Brand, Description, Category)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('size_text', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Condition filter
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Availability filter (e.g. available vs sold)
        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('stock', '>', 0)->where('status', '!=', 'sold');
            } elseif ($request->availability === 'sold') {
                $query->where(function($q) {
                    $q->where('stock', '<=', 0)->orWhere('status', 'sold');
                });
            }
        }

        // Sort
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                // Show available items first, then latest
                $query->orderByRaw("CASE WHEN stock > 0 AND status != 'sold' THEN 0 ELSE 1 END")
                      ->latest();
                break;
        }

        $products = $query->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a single thrift item's details.
     */
    public function show(Product $product)
    {
        // Load relationships
        $product->load(['category', 'images', 'sizes']);

        // Get related thrift items from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
