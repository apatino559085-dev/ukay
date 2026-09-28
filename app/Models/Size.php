<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'width',
        'length',
    ];

    /**
     * Get the products that have this size.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size')
                    ->withPivot('stock')
                    ->withTimestamps();
    }
}
