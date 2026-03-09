<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOnboardingComplete
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        if (! $user) {
            return $next($request);
        }

        // Skip for onboarding routes themselves, logout, and password routes
        if ($request->routeIs('onboarding.*', 'logout', 'password.*')) {
            return $next($request);
        }

        // Only enforce for Provider-role users still in onboarding
        if (! $user->hasRole(['PROVIDER', 'Provider']) || $user->onboarding_step >= 3) {
            return $next($request);
        }

        $stepRoutes = [
            0 => 'onboarding.verify',
            1 => 'onboarding.type',
            2 => 'onboarding.plan',
        ];

        $redirect = $stepRoutes[$user->onboarding_step] ?? 'onboarding.verify';

        return redirect()->route($redirect);
    }
}
