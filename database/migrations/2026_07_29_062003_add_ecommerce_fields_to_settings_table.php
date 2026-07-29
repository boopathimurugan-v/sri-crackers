<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('announcement_text')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('pricelist_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['announcement_text', 'phone_2', 'youtube_url', 'pricelist_url']);
        });
    }
};
