<?php

namespace App\Services;

use App\Models\UpiAccount;
use App\Models\Order;

class UpiRotationService
{
    /**
     * Get the next available active UPI account for a given order amount.
     * Checks active accounts ordered by display_order.
     * If current_collection + amount <= daily_limit, allocates that account.
     * Returns null if all active UPI accounts have reached their daily limit.
     */
    public function allocateUpiAccount(float $amount): ?UpiAccount
    {
        $activeAccounts = UpiAccount::where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($activeAccounts as $account) {
            if ($account->canAcceptAmount($amount)) {
                return $account;
            }
        }

        return null;
    }

    /**
     * Process allocation for an order: allocate UPI account, increment collection, and associate with order.
     */
    public function assignUpiToOrder(Order $order): array
    {
        $amount = (float) $order->total_amount;
        $upiAccount = $this->allocateUpiAccount($amount);

        if (!$upiAccount) {
            return [
                'success' => false,
                'message' => 'Online UPI payment is temporarily unavailable. Please contact customer support.',
                'upi_account' => null,
            ];
        }

        // Increment current collection for the selected UPI
        $upiAccount->incrementCollection($amount);

        // Update Order details
        $order->update([
            'upi_account_id' => $upiAccount->id,
            'selected_upi' => $upiAccount->name,
            'upi_id' => $upiAccount->upi_id,
            'payment_status' => 'pending',
        ]);

        return [
            'success' => true,
            'message' => 'UPI account assigned successfully.',
            'upi_account' => $upiAccount,
        ];
    }
}
