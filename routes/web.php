<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Cms\AnnouncementsController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\InquiriesController;
use App\Http\Controllers\Cms\TeamMembersController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\PropertyViewController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TermsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

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

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors(['login' => 'Invalid credentials.'])
                ->withInput(['email' => $validated['email']]);
        }

        // Log the user into the web guard and keep legacy session flag for middleware compatibility
        auth()->login($user, $request->filled('remember'));
        $request->session()->regenerate();
        $request->session()->put('cms_authenticated', true);

        return redirect()->route('cms.dashboard');
    })->name('login.submit');

    Route::post('/logout', function (Request $request) {
        // logout from web guard and clear cms session flag
        if (auth()->check()) {
            auth()->logout();
        }

        $request->session()->forget('cms_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('cms.login')->with('status', 'Logged out.');
    })->name('logout');

    Route::middleware('cms.auth')->group(function () {
        Route::get('/', fn() => redirect()->route('cms.dashboard'));
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/properties', [App\Http\Controllers\Cms\PropertiesController::class, 'index'])->name('properties.index');
        Route::get('/properties/create', [App\Http\Controllers\Cms\PropertiesController::class, 'create'])->name('properties.create');
        Route::post('/properties', [App\Http\Controllers\Cms\PropertiesController::class, 'store'])->name('properties.store');
        Route::post('/properties/upload-media', [App\Http\Controllers\Cms\PropertiesController::class, 'uploadMedia'])->name('properties.upload_media');
        Route::get('/properties/{property}/edit', [App\Http\Controllers\Cms\PropertiesController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [App\Http\Controllers\Cms\PropertiesController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [App\Http\Controllers\Cms\PropertiesController::class, 'destroy'])->name('properties.destroy');

        Route::get('/featured', fn() => view('cms.featured.index'))->name('featured.index');

        Route::get('/services', [App\Http\Controllers\Cms\ServicesController::class, 'index'])->name('services.index');
        Route::get('/services/create', [App\Http\Controllers\Cms\ServicesController::class, 'create'])->name('services.create');
        Route::post('/services', [App\Http\Controllers\Cms\ServicesController::class, 'store'])->name('services.store');
        Route::get('/services/{slug}', [App\Http\Controllers\Cms\ServicesController::class, 'edit'])->name('services.edit');
        Route::put('/services/{slug}', [App\Http\Controllers\Cms\ServicesController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [App\Http\Controllers\Cms\ServicesController::class, 'destroy'])->name('services.destroy');

        Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}', [InquiriesController::class, 'show'])->name('inquiries.show');
        Route::delete('/inquiries/{inquiry}', [InquiriesController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementsController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AnnouncementsController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [AnnouncementsController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [AnnouncementsController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementsController::class, 'destroy'])->name('announcements.destroy');

        Route::get('/team-members', [TeamMembersController::class, 'index'])->name('team-members.index');
        Route::get('/team-members/create', [TeamMembersController::class, 'create'])->name('team-members.create');
        Route::post('/team-members', [TeamMembersController::class, 'store'])->name('team-members.store');
        Route::get('/team-members/{teamMember}/edit', [TeamMembersController::class, 'edit'])->name('team-members.edit');
        Route::put('/team-members/{teamMember}', [TeamMembersController::class, 'update'])->name('team-members.update');
        Route::delete('/team-members/{teamMember}', [TeamMembersController::class, 'destroy'])->name('team-members.destroy');

        Route::get('/contact', [App\Http\Controllers\Cms\ContactController::class, 'index'])->name('contact.index');
        Route::put('/contact', [App\Http\Controllers\Cms\ContactController::class, 'update'])->name('contact.update');
        Route::get('/analytics', fn() => view('cms.analytics.index'))->name('analytics.index');
        Route::get('/settings', fn() => view('cms.settings.index'))->name('settings.index');
    });
});
