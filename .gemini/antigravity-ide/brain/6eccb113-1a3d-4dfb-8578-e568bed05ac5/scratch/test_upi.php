<?php

require __DIR__ . '/../../../../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\UpiRotationService;
use App\Models\UpiAccount;

echo "--- UPI Smart Rotation Test ---" . PHP_EOL;

$service = new UpiRotationService();

// Reset collections first for predictable test
UpiAccount::query()->update(['current_collection' => 0.00]);

// Test 1: First order ₹2,000
$acc1 = $service->allocateUpiAccount(2000);
echo "Order ₹2,000 -> Allocated: " . ($acc1 ? $acc1->name : 'None') . PHP_EOL;
if ($acc1) { $acc1->incrementCollection(48000); } // Set collection to 50000

// Test 2: Next order ₹5,000 when UPI 1 is full
$acc2 = $service->allocateUpiAccount(5000);
echo "Order ₹5,000 (after UPI 1 full) -> Allocated: " . ($acc2 ? $acc2->name : 'None') . PHP_EOL;

// Test 3: When all UPI accounts reach limit
UpiAccount::query()->update(['current_collection' => 50000.00]);
$acc3 = $service->allocateUpiAccount(1000);
echo "Order ₹1,000 (when all full) -> Allocated: " . ($acc3 ? $acc3->name : 'None (Unavailable Notice)') . PHP_EOL;

// Reset back to 0
UpiAccount::query()->update(['current_collection' => 0.00]);

echo "--- Test Completed Successfully ---" . PHP_EOL;
