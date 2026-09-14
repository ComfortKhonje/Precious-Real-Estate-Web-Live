<?php

return [

    /*
    |--------------------------------------------------------------------------
    | First Super Admin (bootstrap)
    |--------------------------------------------------------------------------
    |
    | The hosting account has no shell access, so the very first CMS login
    | can't be created with `php artisan prec:create-user`. Instead,
    | `prec:post-deploy` (run by cron after each deploy) creates this account
    | ONLY when the users table is completely empty. Remove
    | CMS_BOOTSTRAP_PASSWORD from the server .env after the first login —
    | every other account is then managed from CMS > Staff Accounts.
    |
    | Read through config() rather than env() because config is cached in
    | production, and env() returns null once it is.
    |
    */

    'bootstrap_admin' => [
        'name' => env('CMS_BOOTSTRAP_NAME'),
        'email' => env('CMS_BOOTSTRAP_EMAIL'),
        'password' => env('CMS_BOOTSTRAP_PASSWORD'),
    ],

];
