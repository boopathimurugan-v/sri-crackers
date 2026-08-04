<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Repeat & High Value Customer
        $user1 = User::firstOrCreate(
            ['email' => 'ramesh.sivakasi@gmail.com'],
            [
                'name' => 'Ramesh Kumar',
                'phone' => '9842101234',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_blocked' => false,
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(45),
            ]
        );

        // Add 2 orders for Ramesh
        if ($user1->orders()->count() === 0) {
            Order::create([
                'user_id' => $user1->id,
                'order_number' => 'ORD-RAMESH-01',
                'subtotal' => 6000.00,
                'total_amount' => 6000.00,
                'status' => 'delivered',
                'billing_name' => 'Ramesh Kumar',
                'billing_phone' => '9842101234',
                'billing_address' => '12, Main Street',
                'billing_city' => 'Sivakasi',
                'billing_state' => 'Tamil Nadu',
                'billing_pincode' => '626123',
                'payment_status' => 'success',
                'selected_upi' => 'UPI 1',
                'created_at' => Carbon::now()->subDays(15),
            ]);

            Order::create([
                'user_id' => $user1->id,
                'order_number' => 'ORD-RAMESH-02',
                'subtotal' => 3500.00,
                'total_amount' => 3500.00,
                'status' => 'processing',
                'billing_name' => 'Ramesh Kumar',
                'billing_phone' => '9842101234',
                'billing_address' => '12, Main Street',
                'billing_city' => 'Sivakasi',
                'billing_state' => 'Tamil Nadu',
                'billing_pincode' => '626123',
                'payment_status' => 'success',
                'selected_upi' => 'UPI 2',
                'created_at' => Carbon::now()->subDays(2),
            ]);
        }

        // 2. New Customer
        $user2 = User::firstOrCreate(
            ['email' => 'priya.madurai@gmail.com'],
            [
                'name' => 'Priya Sundaram',
                'phone' => '9876543210',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_blocked' => false,
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(5),
            ]
        );

        if ($user2->orders()->count() === 0) {
            Order::create([
                'user_id' => $user2->id,
                'order_number' => 'ORD-PRIYA-01',
                'subtotal' => 2200.00,
                'total_amount' => 2200.00,
                'status' => 'processing',
                'billing_name' => 'Priya Sundaram',
                'billing_phone' => '9876543210',
                'billing_address' => '45, Bypass Road',
                'billing_city' => 'Madurai',
                'billing_state' => 'Tamil Nadu',
                'billing_pincode' => '625001',
                'payment_status' => 'success',
                'selected_upi' => 'UPI 1',
                'created_at' => Carbon::now()->subDays(1),
            ]);
        }

        // 3. Blocked Customer
        User::firstOrCreate(
            ['email' => 'blocked.user@test.com'],
            [
                'name' => 'Karthik Raja',
                'phone' => '9443199887',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_blocked' => true,
                'status' => 'blocked',
                'created_at' => Carbon::now()->subDays(60),
            ]
        );
    }
}
