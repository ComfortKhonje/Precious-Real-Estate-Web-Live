<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // These are demo accounts with the literal password "password".
        // Running them on production would hand anyone who guesses the email
        // full CMS access, so this seeder hard-refuses outside local/testing.
        if (! app()->environment(['local', 'testing'])) {
            $this->command?->error('UserSeeder is demo data and refuses to run outside local/testing.');

            return;
        }

        $users = [
            [
                'name' => 'Esther Kachale',
                'email' => 'esther.kachale@preciousrealestate.test',
                'password' => 'password',
            ],
            [
                'name' => 'David Banda',
                'email' => 'david.banda@preciousrealestate.test',
                'password' => 'password',
            ],
            [
                'name' => 'Jane Moyo',
                'email' => 'jane.moyo@preciousrealestate.test',
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'email' => $user['email'],
            ], [
                'name' => $user['name'],
                'password' => Hash::make($user['password']),
                'email_verified_at' => now(),
            ]);
        }
    }
}
