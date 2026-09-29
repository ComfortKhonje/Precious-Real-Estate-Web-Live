<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The forms allow 500-character summaries (validation `max:500`), but these
 * columns were created as string() — VARCHAR(255) on MySQL. Anything between
 * 256 and 500 characters passed validation and then failed the INSERT with
 * "Data too long for column 'summary'", a bare 500 for staff (production log,
 * 2026-09-29, a 330-character update summary). SQLite ignores VARCHAR
 * lengths, so the test suite never saw it.
 *
 * Also widens announcement content from TEXT (64KB) to MEDIUMTEXT, so a long
 * formatted blog post can't hit the same wall.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->text('summary')->nullable()->change();
            $table->mediumText('content')->nullable()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->text('short_description')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('summary')->nullable()->change();
            $table->text('content')->nullable()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('short_description')->nullable()->change();
        });
    }
};
