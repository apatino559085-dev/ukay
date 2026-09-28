<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product');
        $shipping = 100.00;

        return view('cart.index', compact('cart', 'shipping'));
    }

    /**
     * Add an ukay product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size'       => 'nullable|string',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if item is sold out
        if ($product->is_sold) {
            return redirect()->back()->with('error', 'Sorry! This unique ukay item is already SOLD OUT.');
        }

        $cart = $this->getOrCreateCart();
        $requestedQty = $request->quantity ?? 1;
        $size = $request->size ?? $product->size_text ?? 'Standard';

        // Check if product is already in cart
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Since ukay items are unique (stock = 1), cap quantity at max available stock
            $newQty = min($product->stock, $cartItem->quantity + $requestedQty);
            $cartItem->update(['quantity' => $newQty]);
        } else {
            // Add new item to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'size'       => $size,
                'quantity'   => min($product->stock, $requestedQty),
                'price'      => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Thrift item added to your bag!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $product = $cartItem->product;
        $newQty = min($product->stock, $request->quantity);

        $cartItem->update([
            'quantity' => $newQty,
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from your cart.');
    }

    /**
     * Get or create the user's cart.
     */
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }
}
