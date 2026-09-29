<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Optional "when it happened" dates for an update, separate from
 * published_at (when the post went up). Lets a post about a multi-day
 * event — a workshop, an open house, an office closure — show its real
 * span ("12–14 Sep 2026") instead of only the day it was written.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->date('event_start_date')->nullable()->after('published_at');
            $table->date('event_end_date')->nullable()->after('event_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['event_start_date', 'event_end_date']);
        });
    }
};
