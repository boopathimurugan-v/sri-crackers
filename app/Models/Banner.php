<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'image', 'link', 'sort_order', 'start_date', 'end_date', 'status',
        'subtitle', 'image_path', 'discount_tag', 'button_text', 'button_link', 'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
