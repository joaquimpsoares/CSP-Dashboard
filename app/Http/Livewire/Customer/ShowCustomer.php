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
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\SubscriptionService;

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
        dd($importCount);


        try {
            foreach(collect($this->selected) as $row){
                $subscription = $this->toImport->where('id', $row)->first();

                if($subscription['billingCycle'] == 'one_time'){
                    dd($subscription);
                    $product = explode(':', $subscription['offerId']);
                    $product = Product::where('sku', $product[0].':'.$product[1])->first();
                }

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

                    // dd($price, $offerId, $subscription['offerId']);

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

    public function mount()
    {
        $this->creatingUser = $this->makeBlankTransactionUser();

        // Ensure the edit form is always bound to a real model instance
        // (avoids validating/saving against an empty model state)
        if ($this->customer instanceof Customer) {
            $this->editing = $this->customer;
        }
    }
    public function updated($propertyName){$this->validateOnly($propertyName);}

    public function checkQualificationStatus(Customer $customer){

        $return = $customer->checkCustomerQualification($customer);

        if(!$return->isempty()){
            if(array_key_exists('qualification', $return[0])){
                $this->customer->update([
                    'qualification' => $return[0]['qualification'],
                ]);
            }else{
                if($return[0]['vettingStatus'] == 'Denied'){
                    $this->customer->update([
                        'qualification' => $return[0]['vettingReason'],
                    ]);
                }
            }
        }
        $this->emit('refreshTransactions');
    }

    public function edit(Customer $customer)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        // Always edit the freshest version from DB
        $this->editing = $customer->fresh();
        $this->showEditModal = true;
    }

    public function disable(Customer $customer){
        $this->showconfirmationModal = false;
        foreach ($customer->subscriptions as $subscriptions) {
            try {
                $connection = MicrosoftCspConnection::where('provider_id', $subscriptions->instance->provider_id)->firstOrFail();
                $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
                $service    = new SubscriptionService($client);
                $tenantId   = $subscriptions->customer->microsoftTenantInfo->first()->tenant_id;
                $service->updateStatus($tenantId, $subscriptions->subscription_id, 'suspended');
                Log::info(Auth::user()->name . ' MS subscription ' . $subscriptions->subscription_id . ' suspended');
                $subscriptions->update(['status_id' => 2]);
            } catch (Exception $e) {
                $this->notify('danger', 'Error Placing order to Microsoft: ' . $e->getMessage());
                Log::info('Error Placing order to Microsoft: ' . $e->getMessage());
            }
        }
        $customer->update(['status_id' => 2]);
        $this->notify('Customer ' . $customer->company_name . ' is disabled, refresh page');
    }

    public function enable(Customer $customer){
        foreach ($customer->subscriptions as $subscriptions) {
            try {
                $connection = MicrosoftCspConnection::where('provider_id', $subscriptions->instance->provider_id)->firstOrFail();
                $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
                $service    = new SubscriptionService($client);
                $tenantId   = $subscriptions->customer->microsoftTenantInfo->first()->tenant_id;
                $service->updateStatus($tenantId, $subscriptions->subscription_id, 'active');
                Log::info(Auth::user()->name . ' MS subscription ' . $subscriptions->subscription_id . ' active');
                $subscriptions->update(['status_id' => 1]);
            } catch (Exception $e) {
                $this->notify('danger', 'Error Placing order to Microsoft: ' . $e->getMessage());
                Log::info('Error Placing order to Microsoft: ' . $e->getMessage());
            }
        }
        $customer->update(['status_id' => 1]);
        $this->notify('Customer ' . $customer->company_name . ' is enabled, refresh page');
    }

    public function CustomerServiceCosts($customer)
    {
        // Service costs API not yet implemented in MicrosoftCspConnection module.
        Log::warning('ShowCustomer::CustomerServiceCosts() — service costs API not yet implemented.');
        return null;
    }

    public function ImportSubscriptions(Customer $customer)
    {
        // Subscription import from Partner Center not yet implemented in MicrosoftCspConnection module.
        Log::warning('ShowCustomer::ImportSubscriptions() — subscription import API not yet implemented.');
        $this->notify(' ', 'Subscription import is not available in this version.', 'info');
    }

    public function CustomerLicenseUsage($customer)
    {
        // License usage API not yet implemented in MicrosoftCspConnection module.
        Log::warning('ShowCustomer::CustomerLicenseUsage() — license usage API not yet implemented.');
        return null;
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

    public function save(Customer $customer)
    {
        // Validate the edit form before persisting
        $this->validate();

        DB::beginTransaction();

        try {
            // Persist local changes
            $this->editing->save();

            // If qualification changed, sync it with Microsoft and store status locally
            if (collect($this->editing->getChanges())->has('qualification')) {
                $return = $this->editing->updateCustomerQualification($customer, $this->editing->qualification);

                $vettingStatus = $return['vettingStatus'] ?? null;
                $vettingReason = $return['vettingReason'] ?? null;

                if ($vettingStatus === 'Denied') {
                    $customer->update([
                        'qualification_status' => $vettingReason ?: 'Denied',
                    ]);

                    DB::rollBack();
                    $this->notify('', $vettingReason ?: 'Qualification denied', 'error');
                    return;
                }

                if ($vettingStatus === 'InReview') {
                    $customer->update([
                        'qualification_status' => 'InReview',
                    ]);
                    $this->notify('', 'Your qualification is InReview', 'info');
                }

                if ($vettingStatus === 'Approved') {
                    $customer->update([
                        'qualification_status' => 'Approved',
                    ]);
                    $this->notify('', 'Your qualification is Approved', 'success');
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error('Customer save failed', [
                'customer_id' => $customer->id ?? null,
                'error' => $th->getMessage(),
            ]);
            $this->notify('', 'Save failed: ' . $th->getMessage(), 'error');
            return;
        }

        $this->showEditModal = false;
        $this->customer->refresh();

        $this->notify('Customer ' . $customer->company_name . ' saved successfully', 'success');
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
