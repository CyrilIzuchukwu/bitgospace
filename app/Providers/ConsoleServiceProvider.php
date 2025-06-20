<?php

namespace App\Providers;

use App\Console\Commands\CheckExpiredDeposits;
use App\Console\Commands\ProcessDailyInvestmentProfits;
use App\Console\Commands\SendDailyEmails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $schedule = $this->app->make(Schedule::class);
        $schedule->command(SendDailyEmails::class)->daily();
        $schedule->command(CheckExpiredDeposits::class)->daily();
        $schedule->command(ProcessDailyInvestmentProfits::class)->dailyAt('00:00')->timezone(config('app.timezone'))->onOneServer();
        // $schedule->command(ProcessDailyInvestmentProfits::class)->everyMinute();
    }
}
