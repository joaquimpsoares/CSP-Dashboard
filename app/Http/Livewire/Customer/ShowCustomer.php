<?php

namespace App\Http\Livewire\Customer;

use App\User;
use App\Price;
use Exception;
use App\Country;
use App\Product;
use App\Customer;
use App\Instance;
use App\Subscription;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class ShowCustomer extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithCachedRows;

    public $customer;
    public $country;
    public $countries;
    public $statuses;
    public $toImport;
    public $email;
    public $filtered;
    public $password;
    public $password_confirmation;
    public Customer $editing;
    public User $creatingUser;
    public $showEditModal = false;
    public $showconfirmationModal = false;
    public $showuserCreateModal = false;
    public $showImportModal = false;
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];

    public function renderingWithBulkActions(){
        if ($this->selectAll) $this->selectPageRows();
    }

    public function selectAll(){
        $this->selectAll = true;
    }

    public function updatedSelected(){
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage($value){
        if ($value) return $this->selectPageRows();
        $this->selectAll = false;
        $this->selected = [];
    }

    public function selectPageRows(){$this->selected = $this->filtered->pluck('id')->map(fn($id) => (string) $id);}

    public function importSelected(){

        $importCount = collect($this->selected)->count();

        try {
            foreach(collect($this->selected) as $row){
                $subscription = $this->toImport->where('id', $row)->first();
                if(collect($subscription)->has('productType')){
                    $product = explode(':', $subscription['offerId']);
                    $product = Product::where('sku', $product[0].':'.$product[1])->first();
                }else{
                    $product = Product::where('sku', $subscription['offerId'])->first();
                }

                if(!$product){
                    $this->showImportModal = false;
                    $this->notify(' ', 'Check Product exists ' . $subscription['offerName'] .'-'. $subscription['offerId']. ' Subscription','error');
                }else{
                    $instanceid = $product->instance_id;
                    if(collect($subscription)->has('productType')){
                        $product = explode(':', $subscription['offerId']);
                        $offerId = $product['0'].":".$product['1'];
                        $price = Price::where('instance_id', $instanceid)->where('product_sku', $product[0].':'.$product[1])->first();
                    }else{
                        $price = Price::where('instance_id', $instanceid)->where('product_sku', $subscription['offerId'])->first();
                        $offerId =$subscription['offerId'];
                    }

                    $subscriptions                  = new Subscription();
                    $subscriptions->name            = $subscription['offerName'];
                    $subscriptions->subscription_id = $subscription['id'];
                    $subscriptions->customer_id     = $this->customer->id; //Local customer id
                    $subscriptions->product_id      = $offerId;
                    $subscriptions->catalog_item_id = $subscription['offerId'] ?? [];
                    $subscriptions->term            = $subscription['termDuration'] ?? 'none';
                    $subscriptions->billing_type    = $product->billing ?? 'license';
                    $subscriptions->instance_id     = $instanceid;
                    $subscriptions->order_id        = $subscription['orderId'];
                    $subscriptions->amount          = $subscription['quantity'];
                    $subscriptions->msrpid          = $this->customer->format()['mpnid'];
                    $subscriptions->expiration_data = $subscription['commitmentEndDate']; //Set subscription expiration date
                    $subscriptions->billing_period  = $subscription['billingCycle'];
                    $subscriptions->currency        = $price->currency;

                    $subscriptions->tenant_name     = $this->customer->microsoftTenantInfo->first()->tenant_domain;
                    $subscriptions->status_id       = 1;
                    $subscriptions->save();
                    $this->showImportModal = false;

                }
            }
            $this->notify(' ', 'You\'ve Imported '. $importCount .' - '. $subscriptions->id .' / '. $subscriptions->name .'  Subscription','success');
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    protected $listeners = ['refreshTransactions' => '$refresh'];


    public function rules(){
        return [
            'editing.company_name'  => ['required','string','regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/','max:255'],
            'editing.address_1'     => ['required','string','max:255','min:3'],
            'editing.address_2'     => ['nullable','string','max:255','min:3'],
            'editing.city'          => ['required','string','max:255','min:3'],
            'editing.country_id'    => ['required','integer','min:1','exists:countries,id'],
            'editing.state'         => ['required','string','max:255','min:3'],
            'editing.nif'           => ['required','min:3'],
            'editing.postal_code'   => ['required','string','max:255','min:3'],
            'editing.markup'        => ['required','min:1'],
            'editing.status_id'     => ['required','exists:statuses,id'],
            'editing.price_list_id' => ['required','integer','exists:price_lists,id'],
            'editing.qualification' => ['nullable', 'string', 'min:1'],

            'creatingUser.name'             => ['sometimes', 'string', 'max:255', 'min:3'],
            'creatingUser.last_name'        => ['sometimes', 'string', 'max:255', 'min:3'],
            'creatingUser.socialite_id'     => ['sometimes', 'string', 'max:255', 'min:3'],
            'creatingUser.phone'            => ['sometimes', 'string', 'max:20', 'min:3'],
            'creatingUser.address'          => ['sometimes', 'string', 'max:255', 'min:3'],
            'email'                         => ['required', 'email', 'unique:users', 'max:255', 'min:3'],
            'creatingUser.status_id'        => ['required', 'integer', 'exists:statuses,id'],
            'password'                      => ['same:password_confirmation', 'required', 'min:6'],
            'password_confirmation'         => ['same:password', 'required', 'min:6'],

        ];
    }
    public function makeBlankTransactionUser(){return User::make(['date' => now(), 'status' => 'success']);}

    public function mount(){$this->creatingUser = $this->makeBlankTransactionUser();}
    public function updated($propertyName){$this->validateOnly($propertyName);}

    public function checkQualificationStatus(Customer $customer){

        $return = $customer->checkCustomerQualification($customer);

        if(!$return->isempty()){
            $this->customer->update([
                'qualification_status' => $return[0]['vettingStatus'],
            ]);
            if($return[0]['vettingStatus'] == 'Denied'){
                $this->customer->update([
                    'qualification' => $return[0]['vettingReason'],
                ]);
            }
        }
        $this->emit('refreshTransactions');
    }

    public function edit(Customer $customer){
        $this->editing = $customer;
        $this->showEditModal = true;
    }

    public function disable(Customer $customer){
        $this->showconfirmationModal = false;
        foreach ($customer->subscriptions as $key => $subscriptions) {
            $subscription = new TagydesSubscription([
                'id'            => $subscriptions->subscription_id,
                'orderId'       => $subscriptions->order_id,
                'offerId'       => $subscriptions->product_id,
                'customerId'    => $subscriptions->customer->microsoftTenantInfo->first()->tenant_id,
                'name'          => $subscriptions->name,
                'status'        => $subscriptions->status_id,
                'quantity'      => $subscriptions->amount,
                'currency'      => $subscriptions->currency,
                'billingCycle'  => $subscriptions->billing_period,
                'created_at'    => $subscriptions->created_at->__toString(),
            ]);


            try {
                SubscriptionFacade::withCredentials($subscriptions->instance->external_id, $subscriptions->instance->external_token)->update($subscription, ['status' => 'suspended']);
                Log::info(Auth::user()->name. 'MS subscriptions: '.$subscription .'suspended');
                $subscriptions->update(['status_id' => 2]);

            } catch (Exception $e) {
                $this->notify('danger','Error Placing order to Microsoft: '.$e->getMessage());
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
            }
        }
        $customer->update(['status_id' => 2]);
        $this->notify('Customer ' . $customer->company_name . ' is disabled, refresh page');
    }

    public function enable(Customer $customer){

        foreach ($customer->subscriptions as $key => $subscriptions) {
            $subscription = new TagydesSubscription([
                'id'            => $subscriptions->subscription_id,
                'orderId'       => $subscriptions->order_id,
                'offerId'       => $subscriptions->product_id,
                'customerId'    => $subscriptions->customer->microsoftTenantInfo->first()->tenant_id,
                'name'          => $subscriptions->name,
                'status'        => $subscriptions->status_id,
                'quantity'      => $subscriptions->amount,
                'currency'      => $subscriptions->currency,
                'billingCycle'  => $subscriptions->billing_period,
                'created_at'    => $subscriptions->created_at->__toString(),
            ]);


            try {
                SubscriptionFacade::withCredentials($subscriptions->instance->external_id, $subscriptions->instance->external_token)->update($subscription, ['status' => 'active']);
                Log::info(Auth::user()->name. 'MS subscriptions: '.$subscription .'active');
                $subscriptions->update(['status_id' => 1]);

            } catch (Exception $e) {
                $this->notify('danger','Error Placing order to Microsoft: '.$e->getMessage());
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
            }
        }
        $customer->update(['status_id' => 1]);
        $this->notify('Customer ' . $customer->company_name . ' is enabled, refresh page');
    }

    Public function CustomerServiceCosts($customer){
        if (!$customer->subscriptions->isEmpty()){
            $instance = $customer->subscriptions->first()->instance_id;
            $instance = Instance::find($instance);
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
    }

    Public function ImportSubscriptions(Customer $customer){
        if (!$customer->subscriptions->isEmpty()){
            $instance = $customer->subscriptions->first()->instance_id;
            $instance = Instance::find($instance);
            $subscriptions = $customer->subscriptions;
            try {
                $customer = new TagydesCustomer([
                    'id' => $customer->microsoftTenantInfo->first()->tenant_id,
                    'username' => 'bill@tagydes.com',
                    'password' => 'blabla',
                    'firstName' => 'Nombre',
                    'lastName' => 'Apellido',
                    'email' => 'bill@tagydes.com',
                ]);

                $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->CheckCustomerSubscriptions($customer);
                $this->toImport = collect($resources['items']);
                $resources = collect($resources['items']);

                if($resources->count() <> $subscriptions->count()){
                    $this->filtered = $resources->whereNotIn('id', $subscriptions->pluck('subscription_id'));
                    if(!$this->filtered->isempty()){
                        $this->showImportModal = true;
                    }else{
                        $this->notify(' ', 'We didn\'t found subscription(s) to import', 'info');
                        return false;
                    }
                    return $this->filtered;
                }else{
                    $this->notify(' ', 'We didn\'t found subscription(s) to import', 'info');
                    return false;
                }


            } catch (\Throwable $th) {
                $this->notify(' ', 'We found error(s), contact your administrator', 'error');
                logger($th->getMessage());

            }
        }
    }

    Public function CustomerLicenseUsage($customer){
        if (!$customer->subscriptions->isEmpty()){
            $instance = $customer->subscriptions->first()->instance_id;
            $instance = Instance::find($instance);
            try {
                $customer = new TagydesCustomer([
                    'id' => $customer->microsoftTenantInfo->first()->tenant_id,
                    'username' => 'bill@tagydes.com',
                    'password' => 'blabla',
                    'firstName' => 'Nombre',
                    'lastName' => 'Apellido',
                    'email' => 'bill@tagydes.com',
                ]);
                $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceUsage($customer);
                return $resources;

            } catch (\Throwable $th) {

            }
        }
    }

    public function enableUser(User $user){
        if($user->status_id == 1){
            $this->notify(' ', 'User ' . $user->name . ' already Enabled', 'info');
            return false;
        }
    }

    public function deleteUser(User $user){
        $user->delete();
        $this->notify(' ', 'User ' . $user->name . ' Deleted successfully', 'info');
        $this->emit('refreshTransactions');
    }

    public function addUser(){
        $this->creatingUser = $this->makeBlankTransactionUser();
        $this->showEditModal = true;
        $this->showuserCreateModal = true;
    }

    public function save(Customer $customer){
        // $this->validate();
        DB::beginTransaction();
        $this->editing->save();
        if(collect($this->editing->getChanges())->has('qualification')){
            try {
                $return = $this->editing->updateCustomerQualification($customer, $this->editing->qualification);

                if ($return['vettingStatus'] == 'Denied') {
                    $this->notify('', $return['vettingReason'] ,'error' );
                    DB::rollBack();
                    $this->editing->qualification_status = $return['vettingReason']->update();
                    return false;
                }

                if ($return['vettingStatus'] == 'InReview') {
                    $customer->update([
                        'qualification_status' => $return['vettingStatus']
                    ]);
                    $this->notify('','Your Qualification is '. $return['vettingStatus'] ,'info' );
                }

            } catch (\Throwable $th) {
                DB::rollBack();
                $this->showEditModal = false;
                $this->notify('error','updating ' . $th->getMessage());
            }
        }

        DB::commit();

        $this->showEditModal = false;
        $this->notify('Customer ' . $customer->company_name . ' saved successfully, refresh page');
        $this->emit('refreshTransactions');

    }

    public function saveuser(Customer $customer){
        $user = User::create ([
            'email'                     => $this->email,
            'name'                      => $this->creatingUser->name,
            'last_name'                 => $this->creatingUser->last_name,
            'address'                   => $this->creatingUser->address,
            'phone'                     => $this->creatingUser->phone,
            'notifications_preferences' => 'database',
            'country_id'                => $customer->country_id,
            'password'                  => Hash::make($this->password),
            'user_level_id'             => 6, //customer role id = 6
            'status_id'                 => 1,
            'customer_id'               => $customer->id,
            // 'notify'                 => $this->sendInvitation ?? false,
        ]);

        $user->assignRole(config('app.customer'));

        $this->notify(' ', 'User ' . $user->name . ' Created successfully', 'info');
        $this->emit('refreshTransactions');

        $this->showuserCreateModal = false;
        $this->showEditModal = false;
    }

    public function disableUser(User $user){
        if($user->status_id == 2){
            $this->notify(' ', 'User ' . $user->name . ' already disabled', 'info');
            return false;
        }
        $user->fill([
            'status_id' => '2',
        ]);
        $user->save();
        $this->notify(' ', 'User ' . $user->name . ' Disabled successfully', 'info');

        $this->emit('refreshTransactions');
    }

    public function render(Customer $customer){
        $customer = $this->customer;
        $countries = Country::get();
        $statuses = Status::get();
        $subscriptions = $this->customer->subscriptions;
        // $costs = $this->CustomerServiceCosts($customer);
        $usage = $this->CustomerLicenseUsage($customer);
        return view('livewire.customer.show-customer', compact('statuses','countries', 'customer', 'subscriptions','usage'));
    }
}
