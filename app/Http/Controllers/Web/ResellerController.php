<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Status;
use App\Country;
use App\Customer;
use App\Reseller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;



class ResellerController extends Controller
{

    use UserTrait;

    private $resellerRepository;
    private $customerRepository;
    private $subscriptionRepository;
    private $userRepository;


    public function __construct(ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, UserRepositoryInterface $userRepository)
    {
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userRepository = $userRepository;

    }


    public function getCustomersFromReseller(Reseller $reseller) {
        dd($reseller);
    }


    public function index()
    {

        $resellers = $this->resellerRepository->all();

        return view('reseller.index', compact('resellers'));

    }


    public function create() {

        $countries = Country::get();
        $statuses = Status::get();

        return view('reseller.create', compact('countries', 'statuses'));
     }


    public function store(Request $request) {
        $user = $this->getUser();

        $validate = $this->validator($request->all())->validate();

        try {
        DB::beginTransaction();

        $reseller =  Reseller::create([

            'company_name' => $validate['company_name'],
            'nif' => $validate['nif'],
            'country_id' => $validate['country_id'],
            'address_1' => $validate['address_1'],
            'address_2' => $validate['address_2'],
            'city' => $validate['city'],
            'state' => $validate['state'],
            'postal_code' => $validate['postal_code'],
            'status_id' => "1",
            'provider_id' => $user->provider->id
            ]);

        $mainUser = $this->userRepository->create($validate, 'reseller', $reseller);
        


            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "message.user_already_exists";
            } else {
                $errorMessage = "message.error";
            }
            return redirect()->route('reseller.index')
            ->with([
                'alert' => 'danger',
                'message' => trans('messages.Provider Created unsuccessfully') . " (" . trans($errorMessage) . ")."
                ]);
            }

            return redirect()->route('reseller.index')->with(['alert' => 'success', 'message' => trans('messages.reseller Created successfully')]);
     }


    public function show(Reseller $reseller) {

        $countries = Country::get();

        $customers = new Collection();
        foreach ($reseller as $resellers){
            $reseller = Reseller::find($reseller['id']);
            $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
            foreach ($customers as $customer){
                $customer = Customer::find($customer['id']);
                $subscriptions = $this->subscriptionRepository->subscriptionsOfCustomer($customer);
            }
        }


            return view('reseller.show', compact('reseller','customers', 'countries', 'subscriptions'));
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

            return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.Reseller Updated successfully')]);

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
                'email' => ['required', 'email', 'max:255'],
                'address_1' => ['required', 'string', 'max:255'],
                'address_2' => ['required', 'string', 'max:255'],
                'country_id' => ['required', 'integer', 'min:1'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'postal_code' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
                'status_id' => ['required', 'integer', 'exists:statuses,id'],
                'sendInvitation' => ['nullable', 'integer'],
                ]);
            }
        }
