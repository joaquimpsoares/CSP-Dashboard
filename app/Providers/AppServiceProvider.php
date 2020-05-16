<?php

namespace App\Providers;

use App\User;
use App\Notifications\FailedJob;
use App\Notifications\SuccessJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        

        // View::'layouts.nav'('key', 'value');
        /**
        * Log jobs
        *
        * Job dispatched & processing
        */
        Queue::before(function ( JobProcessing $event ) {

            Log::info('Job UUID: ' . $event->job->uuid());
            Log::info('Job ID: ' . $event->job->getJobId());
            Log::info('Job ready: ' . $event->job->resolveName());
            Log::info('Job ready: ' . $event->job->getRawBody());
            Log::info('Job Attempts: ' . $event->job->attempts());

        });

        /**
        * Log jobs
        *
        * Job processed
        */
        Queue::after(function ( JobProcessed $event ) {
            Log::notice('Job ID: ' . $event->job->getJobId());
            Log::notice('Job done: ' . $event->job->resolveName());
            Log::notice('Job Attempts: ' . $event->job->attempts());
            User::first()->notify(new SuccessJob($event));
        });

        /**
        * Log jobs
        *
        * Job failed
        */
        Queue::failing(function ( JobFailed $event ) {

            Log::error('Job failed: ' . $event->job->resolveName() . '(' . $event->exception->getMessage() . ')');
            User::first()->notify(new FailedJob($event));

        });
    }
}
