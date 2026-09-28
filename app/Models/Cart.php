<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user who owns this cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this cart.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the total price of the cart.
     */
    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Get the total number of items in the cart.
     */
    public function getItemCountAttribute()
    {
        return $this->items->sum('quantity');
    }
}
