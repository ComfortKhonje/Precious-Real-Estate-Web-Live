<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

/**
 * Replaces the public `POST /api/register` endpoint, which was removed
 * 2026-09-03 because it let anyone on the internet create an account that
 * the CMS login would then accept. CMS accounts are now created deliberately
 * from the server (cPanel Terminal or SSH).
 *
 *   php artisan prec:create-user "Precious Tembo" precious@preciousrealestate.mw
 */
class CreateCmsUser extends Command
{
    protected $signature = 'prec:create-user
                            {name : Full name of the staff member}
                            {email : Login email}
                            {--password= : Password (omit to generate one)}
                            {--role=super_admin : super_admin, admin or editor}';

    protected $description = 'Create (or update) a CMS staff account';

    public function handle(): int
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->option('password');
        $generated = false;

        if (! $password) {
            $password = Str::password(16);
            $generated = true;
        }

        $validator = Validator::make(
            ['name' => $name, 'email' => $email, 'password' => $password, 'role' => $this->option('role')],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'password' => ['required', Password::min(8)],
                'role' => ['required', Rule::in(array_keys(User::ROLES))],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => $password, 'role' => $this->option('role'), 'must_change_password' => $generated]
        );

        $this->info(($user->wasRecentlyCreated ? 'Created' : 'Updated')." CMS account for {$email}");

        if ($generated) {
            $this->warn("Generated password (shown once): {$password}");
        }

        return self::SUCCESS;
    }
}
