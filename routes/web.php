<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Landing\LandingController;

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
Route::prefix('beranda')->middleware('auth')->name('dashboard.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/user-behavior', 'userBehavior')->name('userBehavior');
        Route::get('/error-logs', 'analyzeErrorLogs')->name('analyzeErrorLogs');
        Route::post('/upload-file', 'uploadFile')->name('uploadFile');
        Route::post('/remove-upload-file', 'removeFile')->name('removeFile');
        Route::get('/login-activity', 'loginActivity')->name('loginActivity');
        Route::get('/server-performance', 'analyzeServerPerformance')->name('analyzeServerPerformance');
        Route::get('/popular-endpoints', 'popularEndpoints')->name('popularEndpoints');
    });
    Route::get('/export/parsed-log', [ExportController::class, 'exportParsedLog'])->name('export.parse-log');
    Route::get('/export/threats', [ExportController::class, 'exportThreats'])->name('export.threats');
    Route::get('/export/error-logs', [ExportController::class, 'exportErrorLogs'])->name('export.error-logs');
    Route::get('/export/user-behavior', [ExportController::class, 'exportUserBehavior'])->name('export.user-behavior');
    Route::get('/export/login-activity', [ExportController::class, 'exportLoginActivity'])->name('export.login-activity');

    Route::get('/setting/account', [SettingController::class, 'account'])->name('setting.account');
    Route::post('/setting/account', [SettingController::class, 'accountUpdate'])->name('setting.account.update');


});



