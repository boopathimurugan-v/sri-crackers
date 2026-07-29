<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'short_description', 'long_description',
        'mrp', 'offer_price', 'gst', 'stock', 'unit', 'sku', 'weight', 'brand',
        'featured', 'trending', 'status', 'is_available', 'display_order', 'main_image',
        'image_path', 'discount_percentage', 'rating', 'is_best_seller', 'is_new_arrival',
        'is_featured', 'sort_order', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
