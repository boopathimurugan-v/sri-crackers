<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'product_name_en', 'product_name_ta', 'product_code', 'slug', 'short_description', 'long_description',
        'price', 'mrp', 'offer_price', 'gst', 'stock', 'unit', 'sku', 'weight', 'brand',
        'featured', 'trending', 'status', 'is_available', 'display_order', 'main_image',
        'image_path', 'discount_percentage', 'rating', 'is_best_seller', 'is_new_arrival',
        'is_featured', 'sort_order', 'is_active'
    ];

    public function getPriceAttribute()
    {
        if (isset($this->attributes['price']) && $this->attributes['price'] > 0) {
            return (float)$this->attributes['price'];
        }
        if (isset($this->attributes['offer_price']) && $this->attributes['offer_price'] > 0) {
            return (float)$this->attributes['offer_price'];
        }
        if (isset($this->attributes['mrp']) && $this->attributes['mrp'] > 0) {
            return (float)$this->attributes['mrp'];
        }
        return 0.00;
    }

    public function getEnglishNameAttribute(): string
    {
        if (!empty($this->product_name_en)) {
            return $this->product_name_en;
        }

        if (preg_match('/^(.*?)\s*\((.*?)\)$/u', trim($this->name ?? ''), $matches)) {
            return trim($matches[1]);
        }

        return $this->name ?? '';
    }

    public function getTamilNameAttribute(): ?string
    {
        if (!empty($this->product_name_ta)) {
            return $this->product_name_ta;
        }

        if (preg_match('/^(.*?)\s*\((.*?)\)$/u', trim($this->name ?? ''), $matches)) {
            return trim($matches[2]);
        }

        return null;
    }

    public function getFormattedNameAttribute(): string
    {
        $en = $this->english_name;
        $ta = $this->tamil_name;

        return !empty($ta) ? "{$en} ({$ta})" : $en;
    }

    public function getFormattedNameHtmlAttribute(): string
    {
        $en = e($this->english_name);
        $ta = $this->tamil_name;

        if (!empty($ta)) {
            return '<span class="fw-bold font-bold text-slate-900">' . $en . '</span> <span class="text-xs text-gray-500 font-normal">(' . e($ta) . ')</span>';
        }

        return '<span class="fw-bold font-bold text-slate-900">' . $en . '</span>';
    }

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

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class)->latest();
    }

    public function isInStock(): bool
    {
        return $this->stock > 0 && $this->is_available && $this->status;
    }
}
