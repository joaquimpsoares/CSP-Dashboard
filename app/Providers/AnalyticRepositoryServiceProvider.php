<?php

namespace App\Providers;

use App\Repositories\AnalyticRepository;
use App\Repositories\AnalyticRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AnalyticRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AnalyticRepositoryInterface::class, AnalyticRepository::class);
    }
}
