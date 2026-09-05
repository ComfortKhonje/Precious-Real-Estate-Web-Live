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
        Schema::table('properties', function (Blueprint $table) {
            // gallery JSON column superseded by the property_images table
            // (real relationship, per-image sort order + featured flag +
            // file cleanup on delete). Decided 2026-09-02 full review.
            if (Schema::hasColumn('properties', 'gallery')) {
                $table->dropColumn('gallery');
            }

            $table->index('status');
            $table->index('type');
            $table->index('is_featured');
            $table->index('is_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['type']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_available']);
            $table->json('gallery')->nullable();
        });
    }
};
