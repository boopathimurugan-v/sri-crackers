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
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'gst_enabled')) {
                $table->boolean('gst_enabled')->default(true);
            }
            if (!Schema::hasColumn('settings', 'gst_percentage')) {
                $table->decimal('gst_percentage', 5, 2)->default(18.00);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'gst_enabled')) {
                $table->dropColumn('gst_enabled');
            }
            if (Schema::hasColumn('settings', 'gst_percentage')) {
                $table->dropColumn('gst_percentage');
            }
        });
    }
};
