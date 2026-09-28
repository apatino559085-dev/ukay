<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    /**
     * Get all products in this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
