<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UpiAccount;

class UpiAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (UpiAccount::count() === 0) {
            UpiAccount::create([
                'name' => 'UPI 1',
                'account_holder_name' => 'SRI CRACKERS MAIN',
                'upi_id' => 'sricrackers1@upi',
                'daily_limit' => 50000.00,
                'current_collection' => 0.00,
                'is_active' => true,
                'display_order' => 1,
            ]);

            UpiAccount::create([
                'name' => 'UPI 2',
                'account_holder_name' => 'SRI CRACKERS STORE 2',
                'upi_id' => 'sricrackers2@upi',
                'daily_limit' => 50000.00,
                'current_collection' => 0.00,
                'is_active' => true,
                'display_order' => 2,
            ]);

            UpiAccount::create([
                'name' => 'UPI 3',
                'account_holder_name' => 'SRI CRACKERS TRADERS 3',
                'upi_id' => 'sricrackers3@upi',
                'daily_limit' => 50000.00,
                'current_collection' => 0.00,
                'is_active' => true,
                'display_order' => 3,
            ]);
        }
    }
}
