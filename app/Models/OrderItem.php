<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'size',
        'quantity',
        'price',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the order this item belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for this item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
