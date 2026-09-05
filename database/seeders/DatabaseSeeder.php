<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * 2026-09-03 fixes: `User` was referenced without an import, so
     * `php artisan db:seed` fatalled before it ever reached the service /
     * team seeders. The admin account was also created with the literal
     * password "password" — fine locally, a standing takeover of the whole
     * CMS if it ever ran on production. The password now comes from
     * CMS_ADMIN_PASSWORD, and falls back to a printed random string rather
     * than a guessable constant.
     */
    public function run(): void
    {
        $adminEmail = env('CMS_ADMIN_EMAIL', 'admin@preciousrealestate.test');
        $adminPassword = env('CMS_ADMIN_PASSWORD');
        $generated = false;

        if (! $adminPassword) {
            $adminPassword = Str::password(16);
            $generated = true;
        }

        $user = User::firstOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Admin User',
            'password' => $adminPassword,
        ]);

        if ($generated && $user->wasRecentlyCreated) {
            $this->command?->warn("Admin account created: {$adminEmail}");
            $this->command?->warn("Generated password (shown once): {$adminPassword}");
            $this->command?->warn('Set CMS_ADMIN_PASSWORD in .env to control this yourself.');
        }

        $this->call([
            ServiceSeeder::class,
            TeamMemberSeeder::class,
        ]);
    }
}
