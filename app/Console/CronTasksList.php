<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

/**
 * Trait CronTasksList
 *
 * To use: uncomment all lines and copy your commands list
 * from app/Console/Kernel.php schedule() to tasks() function.
 *
 * @package App\Console
 */
trait CronTasksList
{
    public function tasks(Schedule $schedule)
    {
        // paste your commands here
        // $schedule->command('example:command')->yearly()->withoutOverlapping();command:SyncMSFTInvoices
        // $schedule->command('SyncAzure:daily')->dailyAt('20:00');
        // $schedule->command('SyncAzure:daily')->dailyAt('20:00');
        $schedule->command('SyncAzureBudget:daily')->dailyAt('20:00');
        $schedule->command('command:checkSubscriptionExpiration')->monthly();
        $schedule->command('command:RenewSubscriptions')->dailyAt('20:00');
        $schedule->command('command:billed')->dailyAt('20:00');
        $schedule->command('command:SyncMSFTInvoices')->monthlyOn('4', '20:00');

    }
}
