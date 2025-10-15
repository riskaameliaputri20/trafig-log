<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
});
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Landing Page
Route::name('landing.')->group(function () {

    Route::get('/', [LandingController::class, 'index'])->name('index');
    // produk
    Route::get('/products', [ProductController::class, 'index'])->name('product');
    // blog
    Route::get('/blogs', [BlogController::class, 'index'])->name('blog');
    Route::get('/blogs/category/{name}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/blogs/{slug}', [BlogController::class, 'detail'])->name('blog.detail');

});

// Dashboard Page
Route::prefix('dashboard-admin')->name('dashboard.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

});
