<?php

use App\Http\Controllers\Api\AnnouncementsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactSubmissionController;
use App\Http\Controllers\Api\InquiriesController;
use App\Http\Controllers\Api\PropertiesController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

// Public auth endpoints
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public form submissions (no authentication required)
Route::post('/inquiries/public', [InquiriesController::class, 'storePublic']);
Route::post('/contact', [ContactSubmissionController::class, 'store']);

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
