<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * cPanel cron runs `php artisan schedule:run` every minute (see
 * deploy/README.md). prec:post-deploy is a no-op unless a new release has
 * been uploaded, so running it every minute is cheap.
 */
Schedule::command('prec:post-deploy')->everyMinute()->withoutOverlapping(10);

Schedule::command('auth:clear-resets')->daily();
