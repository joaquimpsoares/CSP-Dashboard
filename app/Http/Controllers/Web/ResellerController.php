<?php

namespace App\Http\Controllers\Web;

use App\Role;
use App\User;
use App\Status;
use App\Country;
use App\Customer;
use App\Reseller;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;


class ResellerController extends Controller
{

    use UserTrait;

    private $resellerRepository;
    private $customerRepository;
    private $subscriptionRepository;
    private $userRepository;

    private $providerRepository;

    public function __construct(ProviderRepositoryInterface $providerRepository,ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, UserRepositoryInterface $userRepository)
    {
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userRepository = $userRepository;

    }


    public function index()
    {

        $customers = new Collection();

        $countCustomers =  $customers->count();

        $resellers = $this->resellerRepository->all();

        return view('reseller.index', compact('resellers', 'countCustomers'));

    }


    public function create() {

        $countries = Country::pluck( 'name','id');
        $statuses = Status::pluck( 'name','id');
        $roles = Role::pluck( 'name','id');

        return view('reseller.create', compact('countries', 'statuses','roles'));
    }


    public function store(Request $request) {

        $user = $this->getUser();

        $validate = $this->validator($request->all())->validate();

        try {
            DB::beginTransaction();

            $reseller = $this->resellerRepository->create($validate, $user);

            $mainUser = $this->userRepository->create($validate, 'reseller', $reseller);

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "message.user_already_exists";
            } else {
                $errorMessage = $e->getMessage();
            }
            return redirect()->back()->with('danger', $errorMessage );
        }

        return redirect()->route('reseller.index')->with('success', ucwords(trans_choice('messages.reseller_created_successfully', 1)) );
    }

    public function show(Reseller $reseller) {

        $countries = Country::get();

        $statuses = Status::get();

        $subscriptions = [];
        $customers = new Collection();
        foreach ($reseller as $resellers){
            $reseller = Reseller::find($reseller['id']);
            $customers = $this->customerRepository->customersOfReseller($reseller);

            $subscriptions = $customers->flatMap(function ($values) {
                $customer = Customer::find($values['id']);
                $subscriptions = $this->subscriptionRepository->subscriptionsOfCustomer($customer);
                return $subscriptions;
            });
            foreach ($customers as $customer){

            }
        }

        $users = User::where('reseller_id', $reseller->id)->get();
            return view('reseller.show', compact('reseller','customers', 'countries', 'subscriptions','statuses', 'users'));
        }


    public function edit(Reseller $reseller) {

        $statuses = Status::get();

        $countries = Country::all();
        return view('reseller.edit', compact('countries','reseller','statuses'));
    }


    public function update(Request $request, Reseller $reseller){

        // dd($request->all());
        $validate = $this->validator($request->all())->validate();
        $reseller = Reseller::findOrFail($reseller->id);
        // dd($reseller)    ;

        $reseller->company_name         = $request->input('company_name');
        $reseller->nif                  = $request->input('nif');
        $reseller->country_id           = $request->input('country_id');
        $reseller->address_1            = $request->input('address_1');
        $reseller->address_2            = $request->input('address_2');
        $reseller->city                 = $request->input('city');
        $reseller->state                = $request->input('state');
        $reseller->postal_code          = $request->input('postal_code');
        $reseller->mpnid                = $request->input('mpnid');
        $reseller->status_id            = $request->input('status_id');

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
                'company_name'      => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
                'nif'               => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
                'country_id'        => ['required', 'integer', 'min:1'],
                'address_1'         => ['required', 'string', 'max:255'],
                'address_2'         => ['nullable', 'string', 'max:255'],
                'city'              => ['required', 'string', 'max:255'],
                'state'             => ['required', 'string', 'max:255'],
                'postal_code'       => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
                'mpnid'             => ['sometimes', 'integer'],
                'role_id'           => ['sometimes', 'integer', 'exists:roles,id'],
                'status_id'         => ['required', 'integer', 'exists:statuses,id'],
                'name'              => ['sometimes', 'string', 'max:255'],
                'last_name'         => ['sometimes', 'string', 'max:255'],
                'socialite_id'      => ['sometimes', 'string', 'max:255'],
                'phone'             => ['sometimes', 'string', 'max:20'],
                'address'           => ['sometimes', 'string', 'max:255'],
                'email'             => ['nullable', 'email', 'max:255'],
                'sendInvitation'    => ['nullable', 'integer'],
                'password'          => ['sometimes', 'string', 'max:255'],
                ]);
        }
    }
