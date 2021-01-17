<?php

namespace App\Http\Controllers\Web;

use App\Role;
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
use Tagydes\MicrosoftConnection\Facades\ServiceCosts;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;
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

        $countries = Country::pluck( 'name','id');
        $roles = Role::pluck( 'name','id');
        $statuses = Status::pluck( 'name','id');

        return view('customer.create', compact('customer','countries','statuses','roles'));

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
                $e = "errors.user_already_exists";
            } else {
                $errorMessage = $e->getMessage();
            }
            return redirect()->back()->with('danger', $errorMessage );
        }

        return redirect()->route('customer.index')->with('success', ucwords(trans_choice('messages.customer_created_successfully', 1)) );

    }


    public function storeAndBuy(Request $request) {

        $validate = $this->validator($request->all())->validate();

        $user = $this->getUser();


    }

    public function show(Customer $customer) {

        $countries = Country::get();

        $customer = Customer::find($customer['id']);

        $users = User::where('customer_id', $customer->id)->get();

        $costs = $this->CustomerServiceCosts($customer);

        $statuses = Status::get();

        $subscriptions = [];

        $subscriptions = $this->subscriptionRepository->subscriptionsOfCustomer($customer);
        $licensesCount = $subscriptions->sum('amount');

        $serviceCosts = $this->CustomerServiceCosts($customer);

        return view('customer.show', compact('licensesCount','costs','customer','countries','subscriptions','users','statuses','serviceCosts'));

    }

    Public function CustomerServiceCosts($customer)
    {

        $instance =session()->get('instance_id');

        try {
            $customer = new TagydesCustomer([
                'id' => $customer->microsoftTenantInfo->first()->tenant_id,
                'username' => 'bill@tagydes.com',
                'password' => 'blabla',
                'firstName' => 'Nombre',
                'lastName' => 'Apellido',
                'email' => 'bill@tagydes.com',
                ]);
        $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceCosts($customer);
        return $resources;

        } catch (\Throwable $th) {

        }
    }

    Public function serviceCostsLineitems($id)
    {

        $instance = session()->get('instance_id');

            $customer = new TagydesCustomer([
                'id' => $id,
                'username' => 'bill@tagydes.com',
                'password' => 'blabla',
                'firstName' => 'Nombre',
                'lastName' => 'Apellido',
                'email' => 'bill@tagydes.com',
                ]);

        $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceCostsLineitems($customer);

        return $resources;
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
                $errorMessage = $e->getMessage();
            }
            return redirect()->back()->with('danger', $errorMessage );

            }

            return redirect()->back()->with('success', 'Customer Updated succesfully');
        }


    public function destroy(Customer $customer) {

        $customer = Customer::find($customer->id);
        $customer->delete();

        return redirect()->route('customer.index');

    }

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

        // $countryName = Country::where('id', $data['country_id'])->first();
        // $countryRules = AppCountryrules::where('iso2Code', $countryName->iso_3166_2)->first();
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
            'status'            => ['required', 'integer', 'exists:statuses,id'],
            'name'              => ['sometimes', 'string', 'max:255'],
            'last_name'         => ['sometimes', 'string', 'max:255'],
            'socialite_id'      => ['sometimes', 'string', 'max:255'],
            'phone'             => ['sometimes', 'string', 'max:20'],
            'address'           => ['sometimes', 'string', 'max:255'],
            'email'             => ['nullable', 'email', 'max:255'],
            'sendInvitation'    => ['nullable', 'integer'],
            'password'          => ['sometimes', 'string', 'max:255'],
            'markup'            => ['sometimes', 'integer'],
            ]);
    }
}
