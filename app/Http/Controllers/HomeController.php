<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display the home page with featured products.
     */
    public function index()
    {
        // Get featured products for the homepage
        $featuredProducts = Product::with('category')
            ->where('featured', true)
            ->take(8)
            ->get();

        // If no featured products, get the latest ones
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with('category')
                ->latest()
                ->take(8)
                ->get();
        }

        $categories = Category::all();

        return view('home.index', compact('featuredProducts', 'categories'));
    }

    /**
     * Display the About Us page.
     */
    public function about()
    {
        return view('home.about');
    }

    /**
     * Display the Size Chart page.
     */
    public function sizeChart()
    {
        $sizes = \App\Models\Size::all();
        return view('home.size-chart', compact('sizes'));
    }
}
