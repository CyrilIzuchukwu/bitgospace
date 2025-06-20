<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\ConsoleServiceProvider::class,
        // ... other providers
    ])
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'check.referral' => \App\Http\Middleware\CheckReferral::class,
            'isAdmin' => \App\Http\Middleware\AdminMiddleware::class,
            'kyc.verified' => \App\Http\Middleware\KycVerified::class,
        ]);
    })
    ->withCommands([
        \App\Console\Commands\SendDailyEmails::class,
        \App\Console\Commands\CheckExpiredDeposits::class,
        \App\Console\Commands\ProcessDailyInvestmentProfits::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
