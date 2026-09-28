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
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size'       => 'required|string',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $this->getOrCreateCart();

        // Check if product with same size already in cart
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->first();

        if ($cartItem) {
            // Update quantity if already in cart
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            // Add new item to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'size'       => $request->size,
                'quantity'   => $request->quantity,
                'price'      => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Make sure the cart item belongs to the current user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(CartItem $cartItem)
    {
        // Make sure the cart item belongs to the current user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    /**
     * Get or create the user's cart.
     */
    private function getOrCreateCart()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        return $cart;
    }
}
