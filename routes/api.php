<?php

use App\Http\Controllers\Api\ContactSubmissionController;
use App\Http\Controllers\Api\InquiriesController;
use App\Http\Controllers\Api\PropertiesController;
use Illuminate\Support\Facades\Route;

/*
 * 2026-09-14: trimmed to only what the public website actually calls.
 *
 * This file used to also expose token login (`/api/login`, Sanctum) and full
 * create/update/delete endpoints for properties, announcements, services,
 * inquiries and settings. Nothing used them — the CMS is server-rendered
 * and writes through its own session-authenticated routes in web.php — but
 * they were a second, parallel way into every piece of data, with no role
 * checks. Removed rather than kept "just in case".
 *
 * Accounts are created from CMS > Staff Accounts (or
 * `php artisan prec:create-user` where a shell is available) — never here.
 */

// Public form submissions — unauthenticated writes, so throttled.
Route::post('/inquiries/public', [InquiriesController::class, 'storePublic'])->middleware('throttle:10,1');
Route::post('/contact', [ContactSubmissionController::class, 'store'])->middleware('throttle:10,1');

// "Load more" / live filtering on the public properties page.
Route::get('/properties', [PropertiesController::class, 'index'])->middleware('throttle:60,1');
