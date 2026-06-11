<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        User::firstOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Admin User',
            'password' => 'password',
        ]);

        $this->call([
            ServiceSeeder::class,
            TeamMemberSeeder::class,
        ]);
    }
}
