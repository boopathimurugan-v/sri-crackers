<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image_path')->nullable();
            $table->integer('discount_percentage')->default(0);
            $table->decimal('rating', 3, 1)->default(5.0);
            $table->boolean('is_best_seller')->default(0);
            $table->boolean('is_new_arrival')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn([
                'brand_id', 'image_path', 'discount_percentage', 'rating', 
                'is_best_seller', 'is_new_arrival', 'is_featured', 'sort_order', 'is_active'
            ]);
        });
    }
};
