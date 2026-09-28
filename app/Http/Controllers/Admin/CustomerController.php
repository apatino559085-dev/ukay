<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display all customers (non-admin users).
     */
    public function index()
    {
        $customers = User::where('is_admin', false)
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show a specific customer.
     */
    public function show(User $customer)
    {
        $customer->load('orders');
        return view('admin.customers.show', compact('customer'));
    }
}
