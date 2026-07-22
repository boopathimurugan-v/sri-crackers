<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:1000',
            'long_description' => 'nullable|string',
            'mrp' => 'required|numeric|min:0',
            'offer_price' => 'required|numeric|min:0|lt:mrp',
            'gst' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:100',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $productId,
            'weight' => 'nullable|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'trending' => 'boolean',
            'status' => 'boolean',
            'is_available' => 'boolean',
            'display_order' => 'nullable|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }
}
