<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('type')->nullable();
            $table->text('message')->nullable();
            // FK constraint added separately in
            // 2026_09_04_000000_add_property_foreign_key_to_inquiries_table.php
            // because this migration runs (2026_06_02_000004) BEFORE
            // create_properties_table (2026_06_02_102132) in timestamp order —
            // declaring the FK inline here fails on a clean `migrate:fresh`
            // with "Foreign key constraint is incorrectly formed" since
            // `properties` doesn't exist yet at this point in the run.
            $table->foreignId('property_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
