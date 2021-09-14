<?php

namespace App\Providers;

use App\Events\PriceChanged;
use App\Listeners\MarkPriceListsAsChangedListener;
use App\Listeners\SetLeveIdInSession;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lab404\Impersonate\Events\TakeImpersonation;
use Lab404\Impersonate\Impersonate;

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
            // ... other providers
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

        //
    }
}
