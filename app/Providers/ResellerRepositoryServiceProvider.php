<?php

namespace App\Providers;

use App\Repositories\ResellerRepository;
use App\Repositories\ResellerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ResellerRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(ResellerRepositoryInterface::class, ResellerRepository::class);
    }
}
