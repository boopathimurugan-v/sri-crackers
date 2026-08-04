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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'product_code')) {
                $table->string('product_code')->nullable()->after('name');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'upi_account_id')) {
                $table->foreignId('upi_account_id')->nullable()->constrained('upi_accounts')->nullOnDelete()->after('status');
            }
            if (!Schema::hasColumn('orders', 'selected_upi')) {
                $table->string('selected_upi')->nullable()->after('upi_account_id');
            }
            if (!Schema::hasColumn('orders', 'upi_id')) {
                $table->string('upi_id')->nullable()->after('selected_upi');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('upi_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'product_code')) {
                $table->dropColumn('product_code');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'upi_account_id')) {
                $table->dropForeign(['upi_account_id']);
                $table->dropColumn(['upi_account_id', 'selected_upi', 'upi_id', 'payment_status']);
            }
        });
    }
};
