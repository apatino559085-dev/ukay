<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'shipping_fee',
        'payment_method',
        'status',
        'full_name',
        'email',
        'phone',
        'shipping_address',
        'city',
        'province',
        'postal_code',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
    ];

    /**
     * Get the user who placed this order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        do {
            $number = 'ORD-' . strtoupper(uniqid());
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Get the formatted total with peso sign.
     */
    public function getFormattedTotalAttribute()
    {
        return '₱' . number_format($this->total_amount, 2);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
