<?php

use App\Http\Controllers\Api\AnnouncementsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactSubmissionController;
use App\Http\Controllers\Api\InquiriesController;
use App\Http\Controllers\Api\PropertiesController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

/*
 * SECURITY, 2026-09-03: `POST /api/register` used to be public and
 * unauthenticated. Because the CMS login (`/cms/login`) authenticates against
 * the very same `users` table, anyone on the internet could self-register and
 * then sign straight into the CMS with full admin rights — create/delete
 * listings, read every inquiry (customer names, emails, phone numbers),
 * change settings. PREC has a fixed, tiny set of staff accounts, so
 * self-service registration has no legitimate use here at all.
 *
 * Accounts are now created deliberately with `php artisan prec:create-user`.
 * If a real registration flow is ever needed, it must at minimum be
 * invite-gated and must NOT share the CMS user table without a role column.
 */
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Public form submissions (no authentication required).
// Throttled: these are unauthenticated write endpoints and were previously
// wide open to automated spam / DB flooding.
Route::post('/inquiries/public', [InquiriesController::class, 'storePublic'])->middleware('throttle:10,1');
Route::post('/contact', [ContactSubmissionController::class, 'store'])->middleware('throttle:10,1');

// Public data endpoints (read-only, no auth)
Route::get('/properties', [PropertiesController::class, 'index']);
Route::get('/properties/{property}', [PropertiesController::class, 'show']);
Route::get('/announcements', [AnnouncementsController::class, 'index']);
Route::get('/announcements/{announcement}', [AnnouncementsController::class, 'show']);
Route::get('/services', [ServicesController::class, 'index']);
Route::get('/services/{service}', [ServicesController::class, 'show']);

// Protected endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // CMS resource endpoints (protected)
    Route::apiResource('properties', PropertiesController::class)->except(['index', 'show']);
    Route::apiResource('announcements', AnnouncementsController::class)->except(['index', 'show']);
    Route::apiResource('services', ServicesController::class)->except(['index', 'show']);
    Route::apiResource('inquiries', InquiriesController::class)->only(['index', 'show', 'destroy']);

    // Settings (simple key/value API)
    Route::get('settings', [SettingsController::class, 'index']);
    Route::post('settings', [SettingsController::class, 'store']);
    Route::put('settings/{key}', [SettingsController::class, 'update']);
});
