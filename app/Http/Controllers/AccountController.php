<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Show the customer's account page.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->latest()->get();

        return view('account.index', compact('user', 'orders'));
    }

    /**
     * Update the customer's profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:255',
            'province'    => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'address', 'city', 'province', 'postal_code'
        ]));

        return redirect()->route('account.index')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the customer's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('account.index')->with('success', 'Password updated successfully!');
    }

    /**
     * Show a specific order's details.
     */
    public function orderDetails(Order $order)
    {
        // Make sure the order belongs to the current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('account.order-details', compact('order'));
    }
}
