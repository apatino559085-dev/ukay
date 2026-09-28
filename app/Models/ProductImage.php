<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'image',
        'sort_order',
    ];

    /**
     * Get the product this image belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
