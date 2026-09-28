<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'size_text',
        'color',
        'condition',
        'measurements',
        'description',
        'price',
        'material',
        'stock',
        'image',
        'featured',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'featured' => 'boolean',
    ];

    /**
     * Get the category this product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get additional images for this product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get the sizes available for this product.
     */
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size')
                    ->withPivot('stock')
                    ->withTimestamps();
    }

    /**
     * Check if product is sold out.
     */
    public function getIsSoldAttribute()
    {
        return $this->stock <= 0 || $this->status === 'sold';
    }

    /**
     * Get the formatted price with PHP peso sign.
     */
    public function getFormattedPriceAttribute()
    {
        return '₱' . number_format($this->price, 2);
    }

    /**
     * Get image URL with SVG fallback if file does not exist.
     */
    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path($value))) {
            return asset($value);
        }

        $title = rawurlencode($this->name ?? 'Thrift Find');
        return 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="600" height="800" viewBox="0 0 600 800"><rect width="100%" height="100%" fill="%23f3f4f6"/><rect x="40" y="40" width="520" height="720" fill="none" stroke="%23e5e7eb" stroke-width="2"/><circle cx="300" cy="350" r="100" fill="%23e5e7eb"/><path d="M 230 450 Q 300 390 370 450" fill="none" stroke="%239ca3af" stroke-width="6"/><text x="50%" y="580" font-family="Helvetica, Arial, sans-serif" font-size="22" font-weight="bold" fill="%23111827" text-anchor="middle">' . $title . '</text><text x="50%" y="620" font-family="Helvetica, Arial, sans-serif" font-size="14" letter-spacing="2" fill="%236b7280" text-anchor="middle">THRIFT FINDS UKAY</text></svg>';
    }
}
