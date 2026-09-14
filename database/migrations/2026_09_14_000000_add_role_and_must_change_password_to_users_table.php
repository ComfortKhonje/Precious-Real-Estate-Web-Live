<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * CMS roles (super_admin / admin / editor) — before this every account had
 * full access to everything. must_change_password forces a new password on
 * first login when an account was created or reset by someone else.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('editor')->after('email')->index();
            $table->boolean('must_change_password')->default(false)->after('password');
        });

        // Accounts that existed before roles all had full access — keep it
        // that way rather than silently demoting someone mid-session.
        DB::table('users')->update(['role' => 'super_admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'must_change_password']);
        });
    }
};
