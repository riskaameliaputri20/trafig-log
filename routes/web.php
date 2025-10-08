<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Landing\LandingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

// Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
 });

// Landing Page
Route::name('landing.')->group(function () {

    Route::controller(LandingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

});

// Dashboard Page
Route::prefix('admin')->name('admin.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

});
