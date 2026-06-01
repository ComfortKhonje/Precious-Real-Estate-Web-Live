<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\PropertyViewController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TermsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/team', TeamController::class)->name('team');
Route::get('/properties', PropertiesController::class)->name('properties');
Route::get('/properties/{id}', [PropertyViewController::class, 'show'])->name('property.view');
Route::get('/services', ServicesController::class)->name('services');
Route::get('/contact', ContactController::class)->name('contact');
Route::get('/terms', TermsController::class)->name('terms');
Route::get('/privacy', PrivacyController::class)->name('privacy');
Route::get('/credits', CreditsController::class)->name('credits');
Route::get('/inquiry', InquiryController::class)->name('inquiry');

/*
|--------------------------------------------------------------------------
| CMS (Frontend-only scaffolding)
|--------------------------------------------------------------------------
| Local testing path: /cms
| Production can mount this group on a CMS subdomain (e.g. cms.preciousrealestate.mw).
*/
Route::prefix('cms')->name('cms.')->group(function () {
    Route::get('/login', function () {
        return view('cms.auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $cmsEmail = (string) env('CMS_EMAIL', '');
        $cmsPasswordHash = (string) env('CMS_PASSWORD_HASH', '');
        $cmsPassword = (string) env('CMS_PASSWORD', '');

        $emailOk = $cmsEmail !== '' && hash_equals($cmsEmail, $validated['email']);
        $passwordOk = false;

        if ($cmsPasswordHash !== '') {
            $passwordOk = Hash::check($validated['password'], $cmsPasswordHash);
        } elseif ($cmsPassword !== '') {
            // Local/dev fallback only. Prefer CMS_PASSWORD_HASH.
            $passwordOk = hash_equals($cmsPassword, $validated['password']);
        }

        if (!($emailOk && $passwordOk)) {
            return back()
                ->withErrors(['login' => 'Invalid credentials.'])
                ->withInput(['email' => $validated['email']]);
        }

        $request->session()->regenerate();
        $request->session()->put('cms_authenticated', true);

        return redirect()->route('cms.dashboard');
    })->name('login.submit');

    Route::post('/logout', function (Request $request) {
        $request->session()->forget('cms_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('cms.login')->with('status', 'Logged out.');
    })->name('logout');

    Route::middleware('cms.auth')->group(function () {
        Route::get('/', fn () => redirect()->route('cms.dashboard'));
        Route::get('/dashboard', fn () => view('cms.dashboard'))->name('dashboard');

        Route::get('/properties', fn () => view('cms.properties.index'))->name('properties.index');
        Route::get('/properties/create', fn () => view('cms.properties.create'))->name('properties.create');

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
