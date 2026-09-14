<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Cms\AnnouncementsController;
use App\Http\Controllers\Cms\AuthController as CmsAuthController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\InquiriesController;
use App\Http\Controllers\Cms\TeamMembersController;
use App\Http\Controllers\Cms\UsersController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UpdatesController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/team', TeamController::class)->name('team');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('property.view');
Route::get('/services', ServicesController::class)->name('services');
Route::get('/contact', ContactController::class)->name('contact');
Route::get('/updates', [UpdatesController::class, 'index'])->name('updates');
Route::get('/updates/{id}', [UpdatesController::class, 'show'])->name('updates.show');
Route::get('/terms', TermsController::class)->name('terms');
Route::get('/privacy', PrivacyController::class)->name('privacy');
Route::get('/credits', CreditsController::class)->name('credits');
Route::get('/inquiry', InquiryController::class)->name('inquiry');

// 2026-09-04: /news was a redundant second implementation of the same
// concept as /updates (two nav tabs, two controllers, two Announcement
// queries). Consolidated into /updates — these redirects keep old links
// (already in the sitemap since the site's June launch) from 404ing.
Route::redirect('/news', '/updates', 301);
Route::get('/news/{id}', fn ($id) => redirect()->route('updates.show', $id, 301));

// XML sitemap (added 2026-09-03). Generated per request so it can never
// go stale after a listing is added or removed in the CMS.
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

/*
|--------------------------------------------------------------------------
| CMS (Frontend-only scaffolding)
|--------------------------------------------------------------------------
| Local testing path: /cms
| Production can mount this group on a CMS subdomain (e.g. cms.preciousrealestate.mw).
*/
Route::prefix('cms')->name('cms.')->group(function () {
    // Login is rate limited inside AuthController (per IP+email and per IP).
    Route::get('/login', [CmsAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CmsAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [CmsAuthController::class, 'logout'])->name('logout');

    Route::get('/forgot-password', [CmsAuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [CmsAuthController::class, 'sendResetLink'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', [CmsAuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [CmsAuthController::class, 'resetPassword'])->middleware('throttle:10,1')->name('password.update');

    /*
     * Roles (2026-09-14) — see User::ROLES.
     *   editor:      the routes directly in this group
     *   admin+:      the cms.role:admin group below
     *   super_admin: enforced per-account inside UsersController
     * Every role can open Settings for their own profile and password; the
     * site-wide parts of that page are admin-only.
     */
    Route::middleware('cms.auth')->group(function () {
        Route::get('/', fn() => redirect()->route('cms.dashboard'));
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/properties', [App\Http\Controllers\Cms\PropertiesController::class, 'index'])->name('properties.index');
        Route::get('/properties/create', [App\Http\Controllers\Cms\PropertiesController::class, 'create'])->name('properties.create');
        Route::post('/properties', [App\Http\Controllers\Cms\PropertiesController::class, 'store'])->name('properties.store');
        // Bare GET (no /edit) 405'd with a raw MethodNotAllowedHttpException —
        // only PUT/DELETE were registered on this URI. There's no separate
        // read-only "view" screen in this admin CMS, so send it straight to
        // the edit form instead of a dead end. Same fix applied below for
        // announcements and team-members (found 2026-09-06, same pattern,
        // same root cause on all three).
        Route::get('/properties/{property}', fn (App\Models\Property $property) => redirect()->route('cms.properties.edit', $property));
        Route::get('/properties/{property}/edit', [App\Http\Controllers\Cms\PropertiesController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [App\Http\Controllers\Cms\PropertiesController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [App\Http\Controllers\Cms\PropertiesController::class, 'destroy'])->name('properties.destroy');

        Route::get('/services', [App\Http\Controllers\Cms\ServicesController::class, 'index'])->name('services.index');
        Route::get('/services/create', [App\Http\Controllers\Cms\ServicesController::class, 'create'])->name('services.create');
        Route::post('/services', [App\Http\Controllers\Cms\ServicesController::class, 'store'])->name('services.store');
        Route::get('/services/{slug}', [App\Http\Controllers\Cms\ServicesController::class, 'edit'])->name('services.edit');
        Route::put('/services/{slug}', [App\Http\Controllers\Cms\ServicesController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [App\Http\Controllers\Cms\ServicesController::class, 'destroy'])->name('services.destroy');

        Route::post('/service-icons', [App\Http\Controllers\Cms\ServiceIconsController::class, 'store'])->name('service-icons.store');
        Route::delete('/service-icons/{serviceIcon}', [App\Http\Controllers\Cms\ServiceIconsController::class, 'destroy'])->name('service-icons.destroy');

        Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}', [InquiriesController::class, 'show'])->name('inquiries.show');

        Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementsController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AnnouncementsController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}', fn (App\Models\Announcement $announcement) => redirect()->route('cms.announcements.edit', $announcement));
        Route::get('/announcements/{announcement}/edit', [AnnouncementsController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [AnnouncementsController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementsController::class, 'destroy'])->name('announcements.destroy');

        Route::get('/team-members', [TeamMembersController::class, 'index'])->name('team-members.index');
        Route::get('/team-members/create', [TeamMembersController::class, 'create'])->name('team-members.create');
        Route::post('/team-members', [TeamMembersController::class, 'store'])->name('team-members.store');
        Route::get('/team-members/{teamMember}', fn (App\Models\TeamMember $teamMember) => redirect()->route('cms.team-members.edit', $teamMember));
        Route::get('/team-members/{teamMember}/edit', [TeamMembersController::class, 'edit'])->name('team-members.edit');
        Route::put('/team-members/{teamMember}', [TeamMembersController::class, 'update'])->name('team-members.update');
        Route::delete('/team-members/{teamMember}', [TeamMembersController::class, 'destroy'])->name('team-members.destroy');

        Route::get('/settings', [App\Http\Controllers\Cms\SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings/profile', [App\Http\Controllers\Cms\SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('/settings/password', [App\Http\Controllers\Cms\SettingsController::class, 'updatePassword'])->name('settings.password');

        Route::middleware('cms.role:admin')->group(function () {
            Route::delete('/inquiries/{inquiry}', [InquiriesController::class, 'destroy'])->name('inquiries.destroy');

            Route::get('/contact', [App\Http\Controllers\Cms\ContactController::class, 'index'])->name('contact.index');
            Route::put('/contact', [App\Http\Controllers\Cms\ContactController::class, 'update'])->name('contact.update');
            Route::get('/analytics', [App\Http\Controllers\Cms\AnalyticsController::class, 'index'])->name('analytics.index');
            Route::put('/settings', [App\Http\Controllers\Cms\SettingsController::class, 'update'])->name('settings.update');
            Route::post('/settings/maintenance', [App\Http\Controllers\Cms\SettingsController::class, 'toggleMaintenance'])->name('settings.maintenance');
            Route::post('/settings/test-email', [App\Http\Controllers\Cms\SettingsController::class, 'sendTestEmail'])->middleware('throttle:5,1')->name('settings.test-email');

            Route::get('/users', [UsersController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
            Route::post('/users', [UsersController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
        });
    });
});
