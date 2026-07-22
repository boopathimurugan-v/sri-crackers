<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComboOffer extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'price', 'sort_order', 'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
