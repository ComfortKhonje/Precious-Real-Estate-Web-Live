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
        Schema::table('inquiries', function (Blueprint $table) {
            // Null = unread. The CMS inquiries list already promised
            // "new inquiries will be highlighted" in its empty-state copy,
            // but nothing ever set or read a "new" flag — added to back
            // that claim with a real one, stamped the first time a staff
            // member opens the inquiry (see InquiriesController::show()).
            $table->timestamp('viewed_at')->nullable()->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('viewed_at');
        });
    }
};
