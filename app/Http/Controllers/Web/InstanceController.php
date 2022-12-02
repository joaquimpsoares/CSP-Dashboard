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
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;





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
        $instances = Instance::withExpired()->get();
        // $instances = Instance::all();

        return view('packages.cards', compact('instances'));
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
            'tenant_id' => 'required|String',
            'external_url' => 'String'
        ]);

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

        switch ($instance->type) {
            case 'kaspersky':

                try {
                    $certificate = Crypt::decryptString($instance->certificate);
                } catch (DecryptException $e) {
                    //
                }
                return view('packages.kaspersky.kaspersky', compact('instance','certificate'));
                break;

                default:
                if ($instance->external_token_updated_at == null)

                $expiration = $instance->external_token_updated_at;

                else

                $expiration = $instance->external_token_updated_at->addDays(90);

                return view('packages.microsoft.microsoft', compact('instance', 'expiration'));
                break;
            }



                return view('packages.microsoft.microsoft', compact('instance', 'expiration'));
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


                $user = Auth::user();

                $this->validate($request, [
                    'name' => 'String',
                    'tenant_id' => 'String',
                    'external_type' => 'String|in:direct,indirect',
                    'external_url' => 'String'
                ]);


                $instance = Instance::findOrFail($id);

                $instance->name             = $request->input('name');
                $instance->tenant_id        = $request->input('tenant_id');
                $instance->external_type    = $request->external_type;
                $instance->external_url     = $request->input('external_url');

                $instance->certificate      = Crypt::encryptString($request->input('certificate'));

                $instance->save();

                return redirect()->back()->with('success', 'Instance updated succesfully')->withInput(['tab'=>'tabPageID']);;
            }


            public function getMasterToken($id)
            {
                $instance = Instance::findorFail($id);
                if( !$instance){
                    return redirect()->back()->with('warning', 'The account has no assigned tenant');
                }

                    $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->tenant_id);
                    // dd(date("Y-m-d h:i:s", $externalToken['expiration']));
                    // $expire = date("Y-m-d h:i:s", $externalToken['expiration']);
                    $external_token = $externalToken['token'];
                    $update = $instance->update([
                        'external_token' => $external_token,
                        'external_token_updated_at' => date("Y-m-d h:i:s", $externalToken['expiration']),
                        'expires_at' => Carbon::now()->addMonth(3),
                    ]);


                return redirect()->back()->with('success', 'Instance updated succesfully');
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
