<?php

namespace App\Http\Controllers\Web;

use App\Instance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;

class InstanceSandboxController extends Controller
{
    public function update(Request $request, Instance $instance)
    {
        $this->authorize(config('app.instances_edit'));

        $data = $request->validate([
            'sandbox_tenant_id'     => 'nullable|string|max:255',
            'sandbox_client_id'     => 'nullable|string|max:255',
            'sandbox_client_secret' => 'nullable|string|max:1000',
            'sandbox_refresh_token' => 'nullable|string|max:2000',
        ]);

        $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->first();

        if (! $connection) {
            return redirect()->back()->withErrors(['connection' => 'No Microsoft CSP Connection found for this provider.']);
        }

        $connection->update($data);

        return redirect()->back()->with('success', 'Sandbox credentials updated successfully.');
    }
}
