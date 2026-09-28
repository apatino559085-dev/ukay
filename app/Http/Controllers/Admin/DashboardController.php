<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalProducts  = Product::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalOrders    = Order::count();
        $totalSales     = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalOrders',
            'totalSales',
            'recentOrders'
        ));
    }
}
