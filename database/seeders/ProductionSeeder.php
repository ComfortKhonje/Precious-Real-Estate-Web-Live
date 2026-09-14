<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * The baseline content a fresh production database needs: the service icon
 * library, the five services and the team roster. Deliberately NOT the demo
 * properties/announcements DatabaseSeeder adds for local development, and no
 * user accounts (see config/cms.php for how the first login is created).
 *
 * Run automatically by `prec:post-deploy` when the services table is empty.
 */
class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceIconSeeder::class,
            ServiceSeeder::class,
            TeamMemberSeeder::class,
        ]);
    }
}
