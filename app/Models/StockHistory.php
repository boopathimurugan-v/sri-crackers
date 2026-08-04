<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'previous_stock',
        'added_quantity',
        'new_stock',
        'remarks',
        'updated_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
