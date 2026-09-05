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
        // Lightweight, self-hosted pageview counter for the CMS Analytics
        // page ("how many people have come to see it") — added 2026-09-02.
        // Deliberately not a full analytics system: no session/visitor
        // fingerprinting, no bounce/duration tracking. Good enough for
        // "roughly how much traffic, which pages" without adding cookies
        // or a third-party dependency. Complements (doesn't replace) real
        // Google Analytics — see the app.blade.php GA hook, not wired to a
        // real Measurement ID yet.
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 512);
            $table->timestamp('created_at')->useCurrent();
            $table->index('path');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
