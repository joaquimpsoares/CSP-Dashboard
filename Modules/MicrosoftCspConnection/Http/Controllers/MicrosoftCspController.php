<?php

namespace Modules\MicrosoftCspConnection\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspResolver;
use Throwable;

class MicrosoftCspController extends Controller
{
    private MicrosoftCspResolver $resolver;

    public function __construct(MicrosoftCspResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Show the module status page.
     */
    public function index(Request $request): Renderable
    {
        $provider   = $request->user()->provider ?? null;
        $connection = $provider
            ? MicrosoftCspConnection::where('provider_id', $provider->id)->first()
            : null;

        return view('microsoftcspconnection::index', compact('connection', 'provider'));
    }

    /**
     * Attempt token acquisition and return a JSON connection status.
     */
    public function test(Request $request): JsonResponse
    {
        $provider = $request->user()->provider ?? null;

        if (! $provider) {
            return response()->json([
                'status'        => 'error',
                'token_acquired' => false,
                'message'       => 'No provider is associated with your account.',
            ], 422);
        }

        try {
            $client = $this->resolver->forProvider($provider);
            $token  = $client->getPartnerCenterAccessToken();

            return response()->json([
                'status'         => 'ok',
                'token_acquired' => ! empty($token),
                'message'        => 'Partner Center token acquired successfully.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status'         => 'error',
                'token_acquired' => false,
                'message'        => $e->getMessage(),
            ], 500);
        }
    }
}
