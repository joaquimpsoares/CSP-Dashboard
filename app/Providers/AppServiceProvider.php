<?php

namespace App\Providers;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Pagination\LengthAwarePaginator;


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
        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) return;

            $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($thing) {
                    return '"'.$thing.'"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });

        Component::macro('notify', function ($message) {
            $this->dispatchBrowserEvent('notify', $message);
        });

        Model::unguard();
        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount , 2) ; ?>";
        });

        Paginator::useBootstrap();

        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate',
                function ($perPage = 10, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
    }

        // View::'layouts.nav'('key', 'value');
        /**
        * Log jobs
        *
        * Job dispatched & processing
        */
        Queue::before(function (JobProcessing $event) {

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
        Queue::after(function ( JobProcessed $event) {
            Log::notice('Job ID: ' . $event->job->getJobId());
            Log::notice('Job done: ' . $event->job->resolveName());
            Log::notice('Job Attempts: ' . $event->job->attempts());
            // User::first()->notify(new SuccessJob($event));
        });

        /**
        * Log jobs
        *
        * Job failed
        */
        Queue::failing(function ( JobFailed $event ) {

            // Log::error('Job failed: ' . $event->job->resolveName() . '(' . $event->exception->getMessage() . ')');
            // User::first()->notify(new FailedJob($event));

        });
    }
}
