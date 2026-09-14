<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Password reset emails link to the CMS's own reset screen (the
        // default expects an unprefixed `password.reset` route).
        ResetPassword::createUrlUsing(
            fn ($user, string $token) => route('cms.password.reset', ['token' => $token, 'email' => $user->getEmailForPasswordReset()])
        );
    }
}
