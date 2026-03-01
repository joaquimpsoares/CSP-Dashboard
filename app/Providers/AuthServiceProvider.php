<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            // 1) Super Admin sees everything.
            if ($user->hasRole('Super Admin')) {
                return true;
            }

            // 2) Direct providers must NOT access reseller management.
            // We infer direct/indirect from the provider's Microsoft instance (instances.external_type).
            if ($user->hasRole('Provider')) {
                $provider = $user->provider;

                $cspMode = null;
                if ($provider) {
                    try {
                        $cspMode = $provider->instances()
                            ->where('type', 'Microsoft')
                            ->orderByDesc('id')
                            ->value('external_type'); // 'direct'|'indirect'|null
                    } catch (\Throwable $e) {
                        $cspMode = null;
                    }
                }

                if ($cspMode === 'direct') {
                    // In direct mode there is no middleman reseller layer.
                    // Provider can purchase/manage on behalf of customers directly.
                    $blockedAbilities = [
                        config('app.reseller_index'),
                        config('app.reseller_show'),
                        config('app.reseller_create'),
                        config('app.reseller_edit'),
                        config('app.reseller_delete'),
                    ];

                    if (in_array($ability, $blockedAbilities, true)) {
                        return false;
                    }
                }
            }

            return null;
        });
    }
}
