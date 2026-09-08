<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Replaces the free-text `icon` column (a bare filename with no
            // black/yellow pairing) for new selections. `icon` is left in
            // place rather than dropped — nothing reads it once the views
            // are updated, dropping it is a separate cleanup call.
            $table->foreignId('service_icon_id')->nullable()->after('icon')
                ->constrained('service_icons')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_icon_id');
        });
    }
};
