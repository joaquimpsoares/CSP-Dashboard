<?php

namespace App\Providers;


use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class OrderRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }
}
