<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Customer;
use App\Provider;
use App\Reseller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProviderRepositoryInterface;

class ProviderController extends Controller
{
    
    private $providerRepository;
    
    public function __construct(ProviderRepositoryInterface $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }
    
    public function getPriceList(Provider $provider)
    {
        $resellers = $provider->resellers()->with('priceList')->get();
        
        $priceLists = [];
        foreach ($resellers as $reseller) {
            if (!in_array($reseller->priceList, $priceLists))
            $priceLists[] = $reseller->priceList;
        }
        
        return view('priceList.index', compact('priceLists'));
        
    }
    
    public function index()
    {
        $providers = $this->providerRepository->all();
        return view('provider.index', compact('providers'));
    }
    
    
    public function create()
    {
        return view('provider.create');
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }     
    
    public function store(Request $request)
    {
        //  dd($request['username']);
        
        $this->validator($request->all())->validate();

 
        $user =  User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'username' => $request['email'],
            'user_level_id' => '3',
            'password' => Hash::make($request['password']),
            ]);
                
            return redirect()->route('home')->with(['alert' => 'success', 'message' => trans('messages.User Created successfully    ')]);
                
            }
            
            
            public function show(Provider $provider)
            {
                $resellers = Reseller::get()->all();
                $customers = Customer::get()->all();
                
                return view('provider.show', compact('provider', 'resellers', 'customers'));
            }
            
            
            public function edit(Provider $provider)
            {
                //
            }
            
            
            public function update(Request $request, Provider $provider)
            {
                //
            }
            
            
            public function destroy(Provider $provider)
            {
                //
            }
        }
