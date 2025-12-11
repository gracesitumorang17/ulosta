<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftarkan command kustom aplikasi.
     *
     * Anda juga bisa menggunakan autoload dari folder Commands,
     * namun daftar ini memastikan command tersedia di semua environment.
     */
    protected $commands = [
        \App\Console\Commands\BackfillSellerIds::class,
        \App\Console\Commands\CleanupDummyImages::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
