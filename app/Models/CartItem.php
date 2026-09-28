<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'size',
        'quantity',
        'price',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the cart this item belongs to.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product for this cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the subtotal for this item.
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
