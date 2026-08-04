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
        Schema::create('upi_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. UPI 1, GPay Main
            $table->string('account_holder_name');
            $table->string('upi_id'); // e.g. sricrackers@upi
            $table->string('qr_image')->nullable();
            $table->decimal('daily_limit', 12, 2)->default(50000.00);
            $table->decimal('current_collection', 12, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upi_accounts');
    }
};
