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
            'product_name_en' => 'required|string|max:255',
            'product_name_ta' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:100',
            'status' => 'nullable|boolean',
            'is_available' => 'nullable|boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }
}
