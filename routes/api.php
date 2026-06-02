<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Public auth endpoints
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // CMS resource endpoints
    Route::apiResource('properties', App\Http\Controllers\Api\PropertiesController::class);
    Route::apiResource('announcements', App\Http\Controllers\Api\AnnouncementsController::class);
    Route::apiResource('services', App\Http\Controllers\Api\ServicesController::class);
    Route::apiResource('inquiries', App\Http\Controllers\Api\InquiriesController::class)->only(['index','show','destroy','store']);
    
    // Settings (simple key/value API)
    Route::get('settings', [App\Http\Controllers\Api\SettingsController::class, 'index']);
    Route::post('settings', [App\Http\Controllers\Api\SettingsController::class, 'store']);
    Route::put('settings/{key}', [App\Http\Controllers\Api\SettingsController::class, 'update']);
});
