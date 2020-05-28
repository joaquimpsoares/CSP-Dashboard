<?php

namespace App\Providers;

use App\Repositories\SubscriptionRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SubscriptionRepositoryInterface;

class SubscriptionRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
    }
}
