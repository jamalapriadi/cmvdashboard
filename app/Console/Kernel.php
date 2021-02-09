<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\OfficialOtomationFollower::class,
        Commands\UnitSosmedInstagram::class,
        Commands\ReplicateCek::class,
        Commands\InstagramInfo::class,
        Commands\OfficialTwitterFollower::class,
        Commands\OfficialFacebookFollower::class,
        Commands\OfficialInstagramFollower::class, 
        Commands\OfficialYoutubeFollower::class,
        Commands\ScrapPortal::class,
        Commands\ScrapDeskripsiPortal::class,
        Commands\ScrapGoogleTrend::class,
        Commands\ScrapLiputannam::class,
        Commands\ScrapTribunParameter::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('scrap:googletrend')
            ->timezone('Asia/Jakarta')  
            ->everyFiveMinutes();
            
        $schedule->command('scrap:portal')
            ->timezone('Asia/Jakarta')  
            ->everyFifteenMinutes();

        $schedule->command('scrap:liputannam')
            ->timezone('Asia/Jakarta')  
            ->everyFifteenMinutes();

        $schedule->command('scrap:tribunparameter')
            ->timezone('Asia/Jakarta')  
            ->everyFifteenMinutes();
            
        // $schedule->command('official:twitter')
        //     ->timezone('Asia/Jakarta')  
        //     ->dailyAt('13:00');

        // $schedule->command('official:facebook')
        //     ->timezone('Asia/Jakarta')  
        //     ->dailyAt('13:00');

        // $schedule->command('official:instagram')
        //     ->timezone('Asia/Jakarta')  
        //     ->dailyAt('13:00');

        // $schedule->command('official:youtube')
        //     ->timezone('Asia/Jakarta')  
        //     ->dailyAt('13:00');

        // $schedule->command('replicate:cek')
        //     ->timezone('Asia/Jakarta')  
        //     ->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
