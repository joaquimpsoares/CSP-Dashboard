<?php

namespace App\Console;


use MatviiB\Scheduler\Console\Kernel as SchedulerKernel;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('SyncAzure:daily')->dailyAt('20:00');
        // $schedule->command('SyncAzure:daily')->dailyAt('20:00');
        $schedule->command('command:SyncBullet')->dailyAt('20:00');
        $schedule->command('command:checkSubscriptionExpiration')->dailyAt('20:00');
        $schedule->command('SyncAzureBudget:daily')->dailyAt('20:00');
        $schedule->command('command:checkSubscriptionExpiration')->monthly();
        $schedule->command('command:RenewSubscriptions')->dailyAt('20:00');
        $schedule->command('command:billed')->dailyAt('20:00');
        $schedule->command('command:CheckInstanceExpiration')->dailyAt('20:00');
        $schedule->command('command:SyncMSFTInvoices')->monthlyOn('4', '20:00');
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
