<?php

namespace App\Providers;

use App\Repositories\PriceListRepository;
use App\Repositories\PriceListRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PriceListRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(PriceListRepositoryInterface::class, PriceListRepository::class);
    }
}
