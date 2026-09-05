<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The Property model has listed `category` and `features` in $fillable (and
 * cast `features` to array) since the 2026-09-02 form rebuild, and both the
 * CMS create/edit forms and the public property-info component read them —
 * but no migration ever created either column. Every Property::create() and
 * ->update() therefore failed at the SQL layer with "Unknown column".
 * Found 2026-09-03 by running the migrations against a real database for the
 * first time.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (! Schema::hasColumn('properties', 'category')) {
                $table->string('category')->nullable()->after('type');
            }

            if (! Schema::hasColumn('properties', 'features')) {
                $table->json('features')->nullable()->after('parking_spaces');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'category')) {
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('properties', 'features')) {
                $table->dropColumn('features');
            }
        });
    }
};
