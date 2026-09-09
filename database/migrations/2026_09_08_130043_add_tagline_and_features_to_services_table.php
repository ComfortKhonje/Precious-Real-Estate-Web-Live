<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('tagline')->nullable()->after('title');
            // Bullet-point highlights for the services page detail section.
            // Previously the detail section faked this by splitting
            // `content` on newlines — that conflated the long-form
            // description with the bullet list in one field.
            $table->json('features')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['tagline', 'features']);
        });
    }
};
