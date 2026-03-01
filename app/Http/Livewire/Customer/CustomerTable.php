<?php

namespace App\Http\Livewire\Customer;

use App\Role;
use App\User;
use App\Status;
use App\Country;
use App\Customer;
use Livewire\Component;
// use Livewire\WithPagination;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use App\Exports\CustomersExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class CustomerTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use UserTrait;

    public $search = '';
    public $password;
    public $email;
    public $password_confirmation;
    public $showEditModal = false;
    public $showCreateUser = false;

    /**
     * Customer edit form state.
     *
     * Note: using an array (instead of an Eloquent model) ensures Livewire hydrates
     * input values correctly when the modal opens.
     */
    public array $editing = [];
    public ?int $editingId = null;

    public User $creatingUser;

    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];

    public function mount()
    {
        $this->editing = $this->blankEditing();
        $this->editingId = null;

        $this->creatingUser = $this->makeBlankTransactionUser();
    }

    protected $rules = [
        'editing.company_name'          => 'required|string|regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/|max:255',
        'editing.nif'                   => 'required|min:3',
        'editing.country_id'            => 'required|integer|min:1|exists:countries,id',
        'editing.address_1'             => 'required|string|max:255|min:3',
        'editing.address_2'             => 'nullable|string|max:255|min:3',
        'editing.city'                  => 'required|string|max:255|min:3',
        'editing.state'                 => 'required|string|max:255|min:3',
        'editing.postal_code'           => 'required|string|max:255|min:3',
        'editing.status_id'             => 'required|integer|exists:statuses,id',
        'editing.markup'                => 'nullable|integer|min:1',
        // price list can be null in DB; if missing, customer can be created but won't have store pricing until set
        'editing.price_list_id'         => 'nullable|integer|exists:price_lists,id',
        'editing.direct_buy'         => 'required|boolean',

        'creatingUser.name'             => 'sometimes|string|max:255|min:3',
        'creatingUser.last_name'        => 'sometimes|string|max:255|min:3',
        'creatingUser.socialite_id'     => 'sometimes|string|max:255|min:3',
        'creatingUser.phone'            => 'sometimes|string|max:20|min:3',
        'creatingUser.address'          => 'sometimes|string|max:255|min:3',
        'email'                         => 'required|email|unique:users|max:255|min:3',
        'creatingUser.status_id'        => 'nullable|integer|exists:statuses,id',
        'password'                      => 'same:password_confirmation|required|min:6',
        'password_confirmation'         => 'same:password|required|min:6',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingSearch(){$this->resetPage();}

    public function blankEditing(): array
    {
        return [
            'company_name' => '',
            'nif' => '',
            'country_id' => null,
            'address_1' => '',
            'address_2' => '',
            'city' => '',
            'state' => '',
            'postal_code' => '',
            'markup' => null,
            'direct_buy' => 0,
            // Defaults for create flows
            'status_id' => 1,
            'price_list_id' => null,
        ];
    }

    public function makeBlankTransactionUser(){return User::make(['date' => now(), 'status' => 'success', 'status_id' => 1]);}
    public function exportSelected(){return Excel::download(new CustomersExport, 'Customers.xlsx');}

    public function edit($customerId)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->showCreateUser = false;

        $customer = Customer::query()->findOrFail($customerId);
        $customer = $customer->fresh();

        $this->editingId = (int) $customer->id;
        $this->editing = array_merge($this->blankEditing(), [
            'company_name' => $customer->company_name,
            'nif' => $customer->nif,
            'country_id' => $customer->country_id,
            'address_1' => $customer->address_1,
            'address_2' => $customer->address_2,
            'city' => $customer->city,
            'state' => $customer->state,
            'postal_code' => $customer->postal_code,
            'markup' => $customer->markup,
            'direct_buy' => (int) ($customer->direct_buy ?? 0),
            'price_list_id' => $customer->price_list_id,
        ]);

        $this->showEditModal = true;
    }


    public function create()
    {
        $this->editing = $this->blankEditing();
        $this->editingId = null;

        // Default customer status
        $this->editing['status_id'] = 1;

        // Default price list based on current actor
        $actor = Auth::user();
        $defaultPriceListId = null;
        if ($actor?->reseller?->price_list_id) {
            $defaultPriceListId = $actor->reseller->price_list_id;
        } elseif ($actor?->provider?->availablePriceLists()?->exists()) {
            $defaultPriceListId = $actor->provider->availablePriceLists()->first()?->id;
        }
        $this->editing['price_list_id'] = $defaultPriceListId;

        $this->creatingUser = $this->makeBlankTransactionUser();

        $this->showEditModal = true;
        $this->showCreateUser = true;
    }

    public function submit()
    {
        return $this->showCreateUser ? $this->savecreate() : $this->save();
    }

    public function save()
    {
        if (!$this->editingId) {
            $this->notify('error', 'No customer selected for edit');
            return;
        }

        // Validate only customer fields when editing.
        $editRules = [
            'editing.company_name' => $this->rules['editing.company_name'],
            'editing.nif' => $this->rules['editing.nif'],
            'editing.country_id' => $this->rules['editing.country_id'],
            'editing.address_1' => $this->rules['editing.address_1'],
            'editing.address_2' => $this->rules['editing.address_2'],
            'editing.city' => $this->rules['editing.city'],
            'editing.state' => $this->rules['editing.state'],
            'editing.postal_code' => $this->rules['editing.postal_code'],
            'editing.markup' => $this->rules['editing.markup'],
            'editing.direct_buy' => $this->rules['editing.direct_buy'],
        ];
        $this->validate($editRules);

        $customer = Customer::query()->findOrFail($this->editingId);

        // Normalize values
        $payload = $this->editing;
        $payload['direct_buy'] = (bool) ($payload['direct_buy'] ?? false);

        $customer->update($payload);

        $this->showEditModal = false;
        $this->resetPage();

        $this->notify('success', 'Customer updated successfully');
    }

    public function savecreate()
    {
        // Ensure defaults
        $this->editing['status_id'] = $this->editing['status_id'] ?? 1;

        // validate full create rules
        $this->validate();

        try {
            $newCustomer =  Customer::create([
                'company_name'  => $this->editing['company_name'],
                'nif'           => $this->editing['nif'],
                'country_id'    => $this->editing['country_id'],
                'address_1'     => $this->editing['address_1'],
                'address_2'     => $this->editing['address_2'],
                'city'          => $this->editing['city'],
                'state'         => $this->editing['state'],
                'postal_code'   => $this->editing['postal_code'],
                'direct_buy'    => (bool) ($this->editing['direct_buy'] ?? false),
                'status_id'     => $this->editing['status_id'] ?? 1,
                'price_list_id' => $this->editing['price_list_id'] ?? null,
            ]);
            $user = User::create ([
                'email'                     => $this->email,
                'name'                      => $this->creatingUser->name,
                'last_name'                 => $this->creatingUser->last_name,
                'address'                   => $this->creatingUser->address,
                'phone'                     => $this->creatingUser->phone,
                'country_id'                => $this->editing['country_id'],
                'notifications_preferences' => 'database',
                'password'                  => Hash::make($this->password),
                'user_level_id'             => 6, //Customer role id = 6
                'status_id'                 => $this->creatingUser->status_id ?? 1,
                'customer_id'               => $newCustomer->id,
                // 'notify'            => $this->sendInvitation ?? false,
            ]);

            $newCustomer->resellers()->attach(Auth::user()->reseller->id);
            $user->assignRole(config('app.customer'));

        } catch (\Throwable $e) {
            Log::error('Error saving Customer: ' . $e->getMessage());
            $this->notify('error', 'Customer create failed: ' . $e->getMessage());
            return;
        }

        $this->notify('success','Customer ' . ($this->editing['company_name'] ?? '') . ' created successfully');
        $this->showEditModal = false;
        $this->resetPage();

    }


    public function getRowsQueryProperty()
    {
        $customers = Customer::query()
        ->where(function ($q)  {
            $q->where('company_name', "like", "%{$this->search}%");
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orwhereHas('resellers', function(Builder $q){
                $q->where('company_name', 'like', "%{$this->search}%");
            });
            $q->orwhereHas('country', function(Builder $q){
                $q->where('name', 'like', "%{$this->search}%");
            });
        })->with(['country', 'subscriptions', 'status']);
        return $this->applySorting($customers);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        $countries  = Country::pluck( 'name','id');
        $roles      = Role::pluck( 'name','id');
        $statuses   = Status::pluck( 'name','id');

        return view('livewire.customer.customer-table', [
            'customers' => $this->rows,
            'countries' => $countries,
            'statuses'  => $statuses,
            'roles'     => $roles,
        ]);
    }
}
