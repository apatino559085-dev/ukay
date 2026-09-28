<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cart->load('items.product');
        $shipping = 100.00;
        $user = auth()->user();

        return view('checkout.index', compact('cart', 'shipping', 'user'));
    }

    /**
     * Process the order.
     */
    public function placeOrder(Request $request)
    {
        // Validate checkout form
        $request->validate([
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email',
            'phone'           => 'required|string|max:20',
            'shipping_address'=> 'required|string',
            'city'            => 'required|string|max:255',
            'province'        => 'required|string|max:255',
            'postal_code'     => 'required|string|max:10',
            'payment_method'  => 'required|in:cod,gcash,bank_transfer',
        ]);

        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cart->load('items.product');
        $shipping = 100.00;
        $subtotal = $cart->total;
        $total = $subtotal + $shipping;

        // Create the order
        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => Order::generateOrderNumber(),
            'total_amount'     => $total,
            'shipping_fee'     => $shipping,
            'payment_method'   => $request->payment_method,
            'status'           => 'pending',
            'full_name'        => $request->full_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'shipping_address' => $request->shipping_address,
            'city'             => $request->city,
            'province'         => $request->province,
            'postal_code'      => $request->postal_code,
        ]);

        // Create order items from cart items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'size'       => $item->size,
                'quantity'   => $item->quantity,
                'price'      => $item->price,
                'subtotal'   => $item->price * $item->quantity,
            ]);

            // Decrease product stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear the cart
        $cart->items()->delete();

        return redirect()->route('order.success', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Show order success page.
     */
    public function success(Order $order)
    {
        // Make sure the order belongs to the current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('checkout.success', compact('order'));
    }
}
