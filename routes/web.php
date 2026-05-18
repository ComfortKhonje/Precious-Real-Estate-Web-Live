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
