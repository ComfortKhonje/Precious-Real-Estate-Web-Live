<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_icons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Storage directory holding both black.svg and yellow.svg for
            // this icon (same directory-per-asset convention as Property's
            // featured_image / Announcement's cover_image, just with a
            // color suffix instead of a size suffix).
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_icons');
    }
};
