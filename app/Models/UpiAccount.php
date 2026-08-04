<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpiAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_holder_name',
        'upi_id',
        'qr_image',
        'daily_limit',
        'current_collection',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'daily_limit' => 'decimal:2',
        'current_collection' => 'decimal:2',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'upi_account_id');
    }

    public function remainingLimit(): float
    {
        return max(0, (float) $this->daily_limit - (float) $this->current_collection);
    }

    public function usagePercentage(): float
    {
        if ((float) $this->daily_limit <= 0) {
            return 0;
        }
        $percentage = ((float) $this->current_collection / (float) $this->daily_limit) * 100;
        return min(100, round($percentage, 2));
    }

    public function canAcceptAmount(float $amount): bool
    {
        if (!$this->is_active) {
            return false;
        }
        return ((float) $this->current_collection + $amount) <= (float) $this->daily_limit;
    }

    public function incrementCollection(float $amount): void
    {
        $this->increment('current_collection', $amount);
    }

    public function resetCollection(): void
    {
        $this->update(['current_collection' => 0.00]);
    }
}
