<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the FK that 2026_06_02_000004_create_inquiries_table.php used to
 * declare inline. That migration runs before `properties` exists
 * (timestamp order), so a clean `migrate:fresh` failed with
 * "Foreign key constraint is incorrectly formed". Split out here, after
 * create_properties_table (2026_06_02_102132), so both fresh installs and
 * already-deployed databases (where the inquiries table already exists
 * without this constraint) converge on the same schema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->foreign('property_id')
                ->references('id')->on('properties')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
        });
    }
};
