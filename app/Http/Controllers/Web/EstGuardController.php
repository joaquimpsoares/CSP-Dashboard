<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\CheckSubscriptionEstRiskJob;
use Illuminate\Http\Request;

class EstGuardController extends Controller
{
    public function trigger(Request $request)
    {
        $environment = session('environment', 'live');
        $providerId  = auth()->user()->provider?->id ?? null;

        CheckSubscriptionEstRiskJob::dispatch($environment, $providerId);

        return back()->with('est_check_queued',
            'EST risk check queued. Results will appear shortly.');
    }
}
