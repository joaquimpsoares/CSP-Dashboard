<?php

namespace App\Http\Controllers\Web;

use App\Instance;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;


class InstanceController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $instances = Instance::all();
        
        return view('packages.microsoft', compact('instances'));
        
        // return view('packages.microsoft.conf', compact('instances'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {   

        return view('packages.microsoft.create');
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        
        // dd($request->all());
        
        if($request->direct_reseller === 'on' )
        $external_type = 'direct';
        else
        $external_type = 'indirect';  
        
        // dd($external_type);
        
      $this->validate($request, [
            'name' => 'required|String',
            'tenant_id' => 'required|String',
            'external_url' => 'String'
            ]);
        
        
    $user = Auth::user();
        
    $create = Instance::create([
        'name' => $request->name,
        'user_id' => $user->id,
        'provider_id' => $request->provider,
        'tenant_id' => $request->tenant_id,
        'type' => 'microsoft',
        'external_type' => $external_type,
        'external_id' => '66127fdf-8259-429c-9899-6ec066ff8915',
        'external_url' => $request->external_url
        ]);

        dd($create);
        
        return redirect()->back()->with('success', 'Instance created succesfully');
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
        // dd($instances);
        return view('packages.microsoft', compact('instances'));
    }
        
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $instances = Instance::findOrFail($id);
        
        return view('packages.microsoft.microsoft', compact('instances'));
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
        
        // dd($request->all());
        
        if($request->direct_reseller === 'on' )
        $external_type = 'direct';
        else
        $external_type = 'indirect';            
        
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
            $instance->user_id          = $user->id;
            $instance->external_type    = $external_type;
            $instance->external_url     = $request->input('external_url');
            
            $instance->save();
            
            return redirect()->back()->with('success', 'Instance updated succesfully');
        }


        public function getMasterToken($id)
        {
            $instance = Instance::findorFail($id);

            if( !$instance){
                return redirect()->back()->with('warning', 'The account has no assigned tenant');
            }
            
            if( ! $instance->external_token){
                $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->tenant_id);
                $instance->update([
                    'external_token' => $externalToken,
                    'external_token_updated_at' => now()
                ]);
            }
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