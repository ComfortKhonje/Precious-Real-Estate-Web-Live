<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UpdatesController;
use App\Http\Controllers\Cms\LoginController as CmsLoginController;
use App\Http\Controllers\Cms\DashboardController as CmsDashboardController;
use App\Http\Controllers\Cms\PropertyController as CmsPropertyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/team', TeamController::class)->name('team');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('property.view');
Route::get('/services', ServicesController::class)->name('services');
Route::get('/contact', ContactController::class)->name('contact');
Route::get('/updates', UpdatesController::class)->name('updates');
Route::get('/terms', TermsController::class)->name('terms');
Route::get('/privacy', PrivacyController::class)->name('privacy');
Route::get('/credits', CreditsController::class)->name('credits');
Route::get('/inquiry', InquiryController::class)->name('inquiry');

// Service shortcuts for named route resolution
Route::get('/management', fn () => redirect()->to(route('services') . '#management'))->name('management');
Route::get('/valuation', fn () => redirect()->to(route('services') . '#valuation'))->name('valuation');
Route::get('/sales-letting', fn () => redirect()->to(route('services') . '#sales-letting'))->name('sales-letting');
Route::get('/development', fn () => redirect()->to(route('services') . '#development'))->name('development');
Route::get('/title-deeds', fn () => redirect()->to(route('services') . '#title-deeds'))->name('title-deeds');

/*
|--------------------------------------------------------------------------
| CMS (Frontend-only scaffolding)
|--------------------------------------------------------------------------
| Local testing path: /cms
| Production can mount this group on a CMS subdomain (e.g. cms.preciousrealestate.mw).
*/
Route::prefix('cms')->name('cms.')->group(function () {
    Route::get('/login', [CmsLoginController::class, 'show'])->name('login');
    Route::post('/login', [CmsLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [CmsLoginController::class, 'logout'])->name('logout');

    Route::middleware('cms.auth')->group(function () {
        Route::get('/', fn () => redirect()->route('cms.dashboard'));
        Route::get('/dashboard', fn () => view('cms.dashboard'))->name('dashboard');

        Route::get('/properties', [CmsPropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/create', [CmsPropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties', [CmsPropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/edit', [CmsPropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [CmsPropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [CmsPropertyController::class, 'destroy'])->name('properties.destroy');

        Route::get('/featured', fn () => view('cms.featured.index'))->name('featured.index');

        Route::get('/services', fn () => view('cms.services.index'))->name('services.index');
        Route::get('/services/{slug}', function (string $slug) {
            $titleMap = [
                'property-valuation' => 'Property Valuation',
                'property-management' => 'Property Management',
                'property-development' => 'Property Development',
                'property-sales-letting' => 'Property Sales & Letting',
                'title-deed-processing' => 'Title Deed Processing',
            ];

            $serviceTitle = $titleMap[$slug] ?? str($slug)->replace('-', ' ')->title();
            return view('cms.services.edit', compact('serviceTitle'));
        })->name('services.edit');

        Route::get('/inquiries', fn () => view('cms.inquiries.index'))->name('inquiries.index');

        Route::get('/announcements', fn () => view('cms.announcements.index'))->name('announcements.index');
        Route::get('/announcements/create', fn () => view('cms.announcements.create'))->name('announcements.create');

        Route::get('/contact', fn () => view('cms.contact.index'))->name('contact.index');
        Route::get('/analytics', fn () => view('cms.analytics.index'))->name('analytics.index');
        Route::get('/settings', fn () => view('cms.settings.index'))->name('settings.index');
    });
});
