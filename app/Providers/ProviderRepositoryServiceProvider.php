<?php

namespace App\Providers;

use App\Repositories\ProviderRepository;
use App\Repositories\ProviderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ProviderRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
    }
}
