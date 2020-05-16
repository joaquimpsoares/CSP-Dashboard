<?php

namespace App\Http\Controllers\Web;

use App\Country;
use App\Reseller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ResellerRepositoryInterface;

class ResellerController extends Controller
{

    private $resellerRepository;

    public function __construct(ResellerRepositoryInterface $resellerRepository)
    {
        $this->resellerRepository = $resellerRepository;
    }


    public function getCustomersFromReseller(Reseller $reseller) {
        dd($reseller);
    }
    

    public function index()
    {

        $resellers = $this->resellerRepository->all();        
        
        return view('reseller.index', compact('resellers'));

    }

    
    public function create() { }

    
    public function store(Request $request) { }

    
    public function show(Reseller $reseller) { 
                
        $countries = Country::get();

        return view('reseller.show', compact('reseller', 'countries'));
    }

    
    public function edit(Reseller $reseller) { 

    }

    
    public function update(Request $request, Reseller $reseller) 
    {
        $this->validator($request->all())->validate();
        
        $reseller = Reseller::findOrFail($reseller->id);

        $reseller->company_name         = $request->input('company_name');
        $reseller->nif                  = $request->input('nif');
        $reseller->country_id           = $request->input('country_id');
        $reseller->address_1            = $request->input('address_1');
        $reseller->address_2            = $request->input('address_2');
        $reseller->city                 = $request->input('city');
        $reseller->state                = $request->input('state');
        $reseller->postal_code          = $request->input('postal_code');

        $reseller->save();

        return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.Provider Updated successfully')]);

     }

    
    public function destroy(Reseller $reseller) { }

    public function getPriceList(Reseller $reseller)
    {

        $priceLists = [];

        $priceLists[] = $reseller->priceList;

        $customers = $reseller->customers()->with('priceList')->get();
        
        foreach ($customers as $customer) {
            if (!in_array($customer->priceList, $priceLists))
                $priceLists[] = $customer->priceList;
        }

        return view('priceList.index', compact('priceLists'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'company_name' => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'nif' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
            'address_1' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'min:1'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
            ]);
        }  
}
