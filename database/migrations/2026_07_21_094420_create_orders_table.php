<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            
            // Billing Address
            $table->string('billing_name');
            $table->string('billing_email')->nullable();
            $table->string('billing_phone');
            $table->text('billing_address');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_pincode');
            
            // Shipping Address
            $table->boolean('is_shipping_same')->default(true);
            $table->string('shipping_name')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_pincode')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
