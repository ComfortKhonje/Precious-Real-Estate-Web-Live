<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Byline for Blog-category posts ("Posted by"). Not restricted
            // to Blog at the DB level — harmless if set on other
            // categories, the CMS just only really surfaces it for Blog.
            $table->foreignId('team_member_id')->nullable()->after('category')
                ->constrained('team_members')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('team_member_id');
        });
    }
};
