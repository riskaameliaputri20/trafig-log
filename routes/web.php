<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Landing\LandingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
});
Route::get('/logout' , [AuthController::class , 'logout'])->middleware('auth')->name('logout');

// Landing Page
Route::name('landing.')->group(function () {

    Route::controller(LandingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

});

// Dashboard Page
Route::prefix('dashboard-admin')->middleware('auth')->name('dashboard.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

});
