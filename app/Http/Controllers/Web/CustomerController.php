<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Status;
use App\Country;
use App\Customer;
use App\Instance;
use App\Reseller;
use App\PriceList;
use App\countryrules;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use App\Countryrules as AppCountryrules;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\ServiceCosts;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;




class CustomerController extends Controller
{
    use UserTrait;

    public $countryRules;
    private $subscriptionRepository;
    private $customerRepository;
    private $userRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, UserRepositoryInterface $userRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userRepository = $userRepository;

    }

    public function index(Customer $customer) {

        $customers = $this->customerRepository->all();

        return view('customer.index', compact('customers'));
    }


    public function create(Customer $customer){



        $countries = Country::get()->sortByDesc('id');
        $countryRules = AppCountryrules::get();
        $statuses = Status::get();

        return view('customer.create', compact('customer','countries','statuses','countryRules'));

    }

    public function store(Request $request) {

        $validate = $this->validator($request->all())->validate();

        $user = $this->getUser();

        try {
            DB::beginTransaction();

            $customer = $this->customerRepository->create($validate);


            $customer->resellers()->attach($user->reseller->id);

            $priceList = $customer->resellers->first()->priceList;

            // $customer->priceLists()->associate($priceList);

            $customer->save();


            $mainUser = $this->userRepository->create($validate, 'customer', $customer);

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "messages.user_already_exists";
            } else {
                $errorMessage = "messages.error";
            }
            return redirect()->route('customer.index')
            ->with([
                'alert' => 'danger',
                'message' => trans('messages.customer_not_created') . " (" . trans($errorMessage) . ")."
            ]);
        }

        return redirect()->route('customer.index')->with(['alert' => 'success', 'message' => trans('messages.customer_created_successfully')]);
    }


    public function storeAndBuy(Request $request) {

        $validate = $this->validator($request->all())->validate();

        $user = $this->getUser();


    }



    // public function update(Request $request, Customer $customer) {


    //     $validate = $this->validator($request->all())->validate();

    //     $user = $this->getUser();

    //     try {
    //         DB::beginTransaction();

    //         $customer = $this->customerRepository->create($validate);

    //         $customer->resellers()->attach($user->reseller->id);

    //         $mainUser = $this->userRepository->create($validate, 'customer', $customer);

    //         DB::commit();
    //     } catch (\PDOException $e) {
    //         DB::rollBack();
    //         if ($e->errorInfo[1] == 1062) {
    //             $errorMessage = "message.user_already_exists";
    //         } else {
    //             $errorMessage = "message.error";
    //         }
    //         return redirect()->route('customer.index')
    //         ->with([
    //             'alert' => 'danger',
    //             'message' => trans('messages.customer_not_created') . " (" . trans($errorMessage) . ")."
    //         ]);
    //     }

    //     return redirect()->route('customer.index')->with(['alert' => 'success', 'message' => trans('messages.Provider Created successfully')]);
    // }


    public function show(Customer $customer) {

        $countries = Country::get();

        $customer = Customer::find($customer['id']);

        $users = User::where('customer_id', $customer->id)->get();

        $costs = $this->CustomerServiceCosts($customer);

        $statuses = Status::get();

        $subscriptions = [];

        $subscriptions = $this->subscriptionRepository->subscriptionsOfCustomer($customer);
        $licensesCount = $subscriptions->sum('amount');

        return view('customer.show', compact('licensesCount','costs','customer','countries','subscriptions','users','statuses'));

    }

    Public function CustomerServiceCosts($customer)
    {

        $instance = Instance::where('id', $customer->resellers->first()->provider->instances->first()->id)->first();
        try {
            $customer = new TagydesCustomer([
                'id' => $customer->microsoftTenantInfo->first()->tenant_id,
                'username' => 'bill@tagydes.com',
                'password' => 'blabla',
                'firstName' => 'Nombre',
                'lastName' => 'Apellido',
                'email' => 'bill@tagydes.com',
                ]);

            $resources = ServiceCosts::withCredentials(
            $instance->external_id,$instance->external_token
            )->serviceCosts($customer);
            return $resources;

        } catch (\Throwable $th) {

        }

    }



    public function edit(Customer $customer) { }


    public function update(Request $request, Customer $customer) {

        $validate = $this->validator($request->all())->validate();

        $user = $this->getUser();

        try {
            DB::beginTransaction();

                $customer = $this->customerRepository->update($customer, $validate);

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "message.user_already_exists";
            } else {
                $errorMessage = "message.error";
            }
            return redirect()->route('customer.index')
            ->with([
                'alert' => 'danger',
                'message' => trans('messages.customer_not_created') . " (" . trans($errorMessage) . ")."
                ]);
            }

            return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.customer_updated_successfully')]);
        }


    public function destroy(Customer $customer) { }

    public function getPriceList($customer)
    {

        $customer = Customer::with('priceList')->where('id', $customer)->first();
    }

    public function getMainUser(Customer $customer)
    {
        /* Check if can buy to this customer */
        if (!$this->customerRepository->canInteractWithCustomer($customer)) {
            return abort(401);
        }
        /* End Check */

        $user = $customer->users()->first()->format();

        return $user;
    }
    protected function validator(array $data)
    {

        $countryName = Country::where('id', $data['country_id'])->first();
        $countryRules = AppCountryrules::where('iso2Code', $countryName->iso_3166_2)->first();
        return Validator::make($data, [
            'company_name' => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'nif' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
            // 'nif' => ['required', 'string', 'regex:/'.$countryRules->vatIdRegex.'/'],
            'email' => ['required', 'email', 'max:255'],
            'address_1' => ['required', 'string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'min:1'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'max:255'],
            // 'postal_code' => ['required', 'string', 'regex:/'.$countryRules->postalCodeRegex.'/'],
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
            'sendInvitation' => ['nullable', 'integer'],
        ]);
    }
}
