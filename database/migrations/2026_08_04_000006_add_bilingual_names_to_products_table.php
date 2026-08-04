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
            if (!Schema::hasColumn('products', 'product_name_en')) {
                $table->string('product_name_en')->nullable()->after('name');
            }
            if (!Schema::hasColumn('products', 'product_name_ta')) {
                $table->string('product_name_ta')->nullable()->after('product_name_en');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'product_name_en')) {
                $table->dropColumn('product_name_en');
            }
            if (Schema::hasColumn('products', 'product_name_ta')) {
                $table->dropColumn('product_name_ta');
            }
        });
    }
};
