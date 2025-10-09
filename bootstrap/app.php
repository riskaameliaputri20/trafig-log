<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('log:parse')->timezone('Asia/Makassar')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/scheduler.log'));
        $schedule->call(function () {
            Log::info('Scheduler dijalankan pada: ' . now('Asia/Makassar'));
        })->everyMinute();
    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
