<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->string('subtitle')->nullable();
            $table->string('image_path')->nullable();
            $table->string('discount_tag')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->boolean('is_active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'sort_order', 'is_active']);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'image_path', 'discount_tag', 'button_text', 'button_link', 'is_active']);
        });
    }
};
