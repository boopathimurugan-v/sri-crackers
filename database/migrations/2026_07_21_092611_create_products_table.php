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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->decimal('mrp', 10, 2);
            $table->decimal('offer_price', 10, 2);
            $table->decimal('gst', 5, 2)->default(0); // percentage
            $table->integer('stock')->default(0);
            $table->string('sku')->nullable()->unique();
            $table->decimal('weight', 8, 2)->nullable(); // kg or string depending on requirements, let's use decimal
            $table->string('brand')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('trending')->default(0);
            $table->boolean('status')->default(1);
            $table->string('main_image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
