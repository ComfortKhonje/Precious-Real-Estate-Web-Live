<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The public property detail page's "Location Details" section used to be
 * entirely hardcoded — every property, regardless of real location, showed
 * the same fake paragraph and the same fixed five-item amenity list
 * ("Schools, Shopping centers, Restaurants, Health facilities, Main road
 * networks"). This column lets staff enter the real nearby amenities per
 * property, same comma-separated-string-to-array shape as the existing
 * `features` column.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->json('nearby_amenities')->nullable()->after('features');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('nearby_amenities');
        });
    }
};
