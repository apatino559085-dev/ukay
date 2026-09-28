<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show a specific order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // Send status update notification email to customer
        try {
            if ($order->email) {
                \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderStatusUpdatedMail($order));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Status email error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Order status updated and notification email sent to customer!');
    }
}
