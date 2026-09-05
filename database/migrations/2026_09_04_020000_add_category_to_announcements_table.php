<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The public Updates page used to show fake per-item category badges
 * (Announcement/News/Update) on hardcoded placeholder entries. Now that the
 * page is backed by real Announcement data (2026-09-04 news/updates
 * consolidation), the badge needs a real column behind it.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('category')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
