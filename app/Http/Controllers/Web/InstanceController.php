<?php

namespace App\Http\Controllers\Web;

use App\Instance;
use App\Provider;
use App\PriceList;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\ProviderRepositoryInterface;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;

class InstanceController extends Controller
{

    private $providerRepository;



    public function __construct(ProviderRepositoryInterface $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }


    public $provider;

    public function index()
    {
        return view('instance.index');
    }

    public function create(Request $request)
    {

        $provider_id = $request->provider;

        $provider = Provider::findorfail($provider_id);

        return view('packages.microsoft.create', compact('provider'));
    }

    public function kascreate(Request $request)
    {
        $provider_id = $request->provider;

        $provider = Provider::findorfail($provider_id);

        return view('packages.kaspersky.create', compact('provider'));
    }

    public function store(Request $request)
    {

        if($request->external_type === 'direct_reseller' )
            $external_type = 'direct';
        else
            $external_type = 'indirect';

        $this->validate($request, [
            'name' => 'required|String',
            'provider_id' => 'required|integer|exists:providers,id',
            'tenant_id' => 'required|String',
            'external_url' => 'nullable|String'
        ]);

        // CSP mode lock is enforced at provider level, but only for Microsoft instances.
        // If a provider already has a Microsoft instance with external_type set, you cannot create a new Microsoft instance with a different mode.
        $existingMode = Instance::query()
            ->where('provider_id', $request->provider_id)
            ->where('type', 'Microsoft')
            ->whereNotNull('external_type')
            ->orderByDesc('id')
            ->value('external_type');

        if (!empty($existingMode) && $external_type !== $existingMode) {
            return redirect()->back()->withErrors([
                'external_type' => 'This provider is locked to CSP mode "' . $existingMode . '". You cannot create a Microsoft instance in mode "' . $external_type . '".',
            ])->withInput();
        }

        $instance = Instance::create([
            'name' => $request->name,
            'provider_id' => $request->provider_id,
            'tenant_id' => $request->tenant_id,
            'type' => 'Microsoft',
            'external_type' => $external_type,
            'external_id' => '66127fdf-8259-429c-9899-6ec066ff8915',
            'external_url' => $request->external_url,
            'certificate'  => Crypt::encryptString($request->certificate),
        ]);

        $priceList = PriceList::updateOrcreate([
            'instance_id' => $instance->id,
        ],[
            'name' => $request->name,
        ]);

        return redirect()->route('provider.index')->with('success', 'Instance created succesfully');
    }

            /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function show($id)
            {

                $instances = Instance::findOrFail($id);

                return view('packages.microsoft', compact('instances'));
            }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Instance $instance)
    {
        // Ensure provider relation is available for the sidebar.
        $instance->loadMissing('provider');

        $certificate = null;
        $expiration = null;

        if (($instance->type ?? '') === 'kaspersky') {
            try {
                $certificate = $instance->certificate ? Crypt::decryptString($instance->certificate) : null;
            } catch (DecryptException $e) {
                $certificate = null;
            }
        }

        // Historical logic: Microsoft token validity ~90 days from updated_at.
        if (($instance->type ?? '') === 'Microsoft' && $instance->external_token_updated_at) {
            $expiration = $instance->external_token_updated_at->copy()->addDays(90);
        }

        return view('instance.edit', compact('instance', 'certificate', 'expiration'));
    }

            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function update(Request $request, $id)
            {
                $this->validate($request, [
                    'name' => 'nullable|string',
                    'tenant_id' => 'nullable|string',
                    'external_type' => 'nullable|string|in:direct,indirect',
                    'external_url' => 'nullable|string',
                    'certificate' => 'nullable|string',
                ]);

                $instance = Instance::findOrFail($id);

                if ($request->has('name')) {
                    $instance->name = $request->input('name');
                }
                if ($request->has('tenant_id')) {
                    $instance->tenant_id = $request->input('tenant_id');
                }
                if ($request->has('external_type')) {
                    $newType = $request->input('external_type');

                        // Only Microsoft instances have CSP mode and the lock rules.
                    if (($instance->type ?? '') === 'Microsoft') {
                        // Once CSP mode is defined, it must not change (direct <-> indirect).
                        if (!empty($instance->external_type) && $newType !== $instance->external_type) {
                            return redirect()->back()->withErrors([
                                'external_type' => 'CSP mode is locked once defined. You cannot change this instance from ' . $instance->external_type . ' to ' . $newType . '.',
                            ])->withInput();
                        }

                        $instance->external_type = $newType;
                    }
                }
                if ($request->has('external_url')) {
                    $instance->external_url = $request->input('external_url');
                }

                // Only update certificate for kaspersky instances and when provided.
                if (($instance->type ?? '') === 'kaspersky' && $request->filled('certificate')) {
                    $instance->certificate = Crypt::encryptString($request->input('certificate'));
                }

                $instance->save();

                return redirect()->back()->with('success', 'Instance updated successfully');
            }


            public function getMasterToken($id)
            {
                // external token refresh is no longer available — credentials are DB-per-provider via MicrosoftCspConnection.
                Log::warning('InstanceController::getMasterToken() — external token refresh not available; credentials are now DB-per-provider via MicrosoftCspConnection.');
                return redirect()->back()->with('warning', 'Token refresh is not available in this version. Configure credentials in the Microsoft CSP Connection settings.');
            }

                    /**
                    * Remove the specified resource from storage.
                    *
                    * @param  int  $id
                    * @return \Illuminate\Http\Response
                    */
                    public function destroy($id)
                    {
                        $instance = Instance::findOrFail($id);

                        $instance->delete();

                        return redirect()->route('url()->previous()')->with('success', 'Instance deleted succesfully');
                    }
                }
