<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\TeamMemberSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminEmail = env('CMS_ADMIN_EMAIL', 'admin@preciousrealestate.test');

        \App\Models\User::firstOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Admin User',
            'password' => 'password',
        ]);

        $this->call([
            PropertySeeder::class,
            ServiceSeeder::class,
            TeamMemberSeeder::class,
        ]);

        $this->call([
            // UserSeeder::class,
            PropertySeeder::class,
            // CategorySeeder::class,
        ]);
    }
}
