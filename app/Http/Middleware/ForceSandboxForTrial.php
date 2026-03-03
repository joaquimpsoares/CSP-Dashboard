<?php

namespace App\Http\Middleware;

use App\Instance;
use Closure;
use Illuminate\Http\Request;

class ForceSandboxForTrial
{
    public function handle(Request $request, Closure $next)
    {
        $instanceId = $request->session()->get('instance_id');

        if ($instanceId) {
            $instance = Instance::find($instanceId);
            if ($instance && ($instance->subscription_status ?? 'active') === 'trial') {
                $request->session()->put('environment', 'sandbox');
            }
        }

        return $next($request);
    }
}
