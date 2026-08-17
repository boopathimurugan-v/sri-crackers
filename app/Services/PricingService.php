<?php

namespace App\Services;

use App\Models\Setting;

class PricingService
{
    /**
     * Get the global discount percentage configured by admin.
     * Returns a float between 0 and 100.
     */
    public function getDiscountPercentage(): float
    {
        $settings = Setting::first();
        if ($settings && isset($settings->overall_discount_percentage)) {
            return (float) $settings->overall_discount_percentage;
        }
        return 0.0;
    }

    /**
     * Calculate cart totals for a list of items.
     *
     * Each item must have:
     *   - price    (float) — the selling price per unit
     *   - quantity (int)   — number of units
     *
     * Returns an array with:
     *   - net_amount      (float) — sum of price × qty (before discount)
     *   - discount_pct    (float) — the applied discount percentage
     *   - discount_amount (float) — discount_pct % of net_amount
     *   - total_amount    (float) — net_amount minus discount_amount (final payable)
     */
    public function calculateCartTotals(array $items, ?float $discountPct = null): array
    {
        if ($discountPct === null) {
            $discountPct = $this->getDiscountPercentage();
        }

        $netAmount = 0.0;
        foreach ($items as $item) {
            $price    = (float) ($item['price'] ?? 0);
            $quantity = (int)   ($item['quantity'] ?? 1);
            $netAmount += $price * $quantity;
        }

        $discountAmount = round(($netAmount * $discountPct) / 100, 2);
        $totalAmount    = round($netAmount - $discountAmount, 2);

        return [
            'net_amount'      => round($netAmount, 2),
            'discount_pct'    => $discountPct,
            'discount_amount' => $discountAmount,
            'total_amount'    => $totalAmount,
        ];
    }

    /**
     * Calculate totals for a single product line.
     * Convenience wrapper around calculateCartTotals().
     */
    public function calculateLineTotal(float $price, int $quantity, ?float $discountPct = null): array
    {
        return $this->calculateCartTotals([
            ['price' => $price, 'quantity' => $quantity]
        ], $discountPct);
    }
}
