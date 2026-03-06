<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Instance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnvironmentController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'environment' => 'required|in:sandbox,live',
        ]);

        $instanceId = session('instance_id');
        $instance   = $instanceId ? Instance::find($instanceId) : null;

        // Trial accounts are locked to sandbox.
        if ($instance && ($instance->subscription_status ?? 'active') === 'trial') {
            session(['environment' => 'sandbox']);
            return redirect()->back();
        }

        session(['environment' => $validated['environment']]);

        return redirect()->back();
    }
}
