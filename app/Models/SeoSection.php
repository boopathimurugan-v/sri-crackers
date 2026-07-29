<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSection extends Model
{
    protected $fillable = [
        'title',
        'content',
        'position',
        'is_active',
    ];
}
