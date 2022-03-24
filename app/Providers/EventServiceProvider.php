<?php

namespace App\Providers;

use App\Subscription;
use App\Events\PriceChanged;
use Lab404\Impersonate\Impersonate;
use App\Listeners\SetLeveIdInSession;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Lab404\Impersonate\Events\TakeImpersonation;
use App\Listeners\MarkPriceListsAsChangedListener;
use App\Observers\SubscriptionObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\MSCustomerCreationEvent::class => [
            \App\Listeners\MSCustomerCreationListener::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Graph\GraphExtendSocialite@handle',
            'SocialiteProviders\Microsoft\MicrosoftExtendSocialite@handle',
        ],
          'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Failed' => [
            'App\Listeners\LogFailedLogin',
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\SetLeveIdInSession',
            'App\Listeners\AzureBudgetLogin',
            'App\Listeners\LogSuccessfulLogin',
        ],
        'Lab404\Impersonate\Events\TakeImpersonation' =>[
            'App\Listeners\SetImpersonationLeveIdInSession',
        ],
        'Lab404\Impersonate\Events\LeaveImpersonation' =>[
            'App\Listeners\LeaveImpersonationLeveIdInSession',
        ],
        PriceChanged::class => [
            MarkPriceListsAsChangedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Subscription::observe(SubscriptionObserver::class);
    }
}
