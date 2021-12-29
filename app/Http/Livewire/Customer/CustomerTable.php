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

    public Customer $editing;
    public User $creatingUser;

    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];

    public function mount()
    {
        $this->editing      = $this->makeBlankTransaction();
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
        'editing.price_list_id'         => 'required|integer|exists:price_lists,id',


        'creatingUser.name'             => 'sometimes|string|max:255|min:3',
        'creatingUser.last_name'        => 'sometimes|string|max:255|min:3',
        'creatingUser.socialite_id'     => 'sometimes|string|max:255|min:3',
        'creatingUser.phone'            => 'sometimes|string|max:20|min:3',
        'creatingUser.address'          => 'sometimes|string|max:255|min:3',
        'email'                         => 'required|email|unique:users|max:255|min:3',
        'creatingUser.status_id'        => 'required|integer|exists:statuses,id',
        'password'                      => 'same:password_confirmation|required|min:6',
        'password_confirmation'         => 'same:password|required|min:6',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingSearch(){$this->resetPage();}
    public function makeBlankTransaction(){return Customer::make(['date' => now(), 'status' => 'success']);}
    public function makeBlankTransactionUser(){return User::make(['date' => now(), 'status' => 'success']);}
    public function exportSelected(){return Excel::download(new CustomersExport, 'Customers.xlsx');}

    public function edit(Customer $customer)
    {
        $this->showCreateUser = false;
        $this->showEditModal = true;
        $this->useCachedRows();

        if ($this->editing->isNot($customer)) $this->editing = $customer;
        $this->editing = $customer;
    }


    public function create()
    {
        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->creatingUser = $this->makeBlankTransactionUser();

        $this->showEditModal = true;
        $this->showCreateUser = true;
    }

    public function save()
    {
        $this->editing->save();
        $this->showEditModal = false;
    }

    public function savecreate()
    {
        // $this->validate();
        $user = $this->getUser();
        try {
            $newCustomer =  Customer::create([
                'company_name'  => $this->editing->company_name,
                'nif'           => $this->editing->nif,
                'country_id'    => $this->editing->country_id,
                'address_1'     => $this->editing->address_1,
                'address_2'     => $this->editing->address_2,
                'city'          => $this->editing->city,
                'state'         => $this->editing->state,
                'postal_code'   => $this->editing->postal_code,
                'status_id'     => 1,
                'price_list_id' => $this->editing->price_list_id,
            ]);
            $user = User::create ([
                'email'             => $this->email,
                'name'              => $this->creatingUser->name,
                'last_name'         => $this->creatingUser->last_name,
                'address'           => $this->creatingUser->address,
                'phone'             => $this->creatingUser->phone,
                'country_id'        => $this->editing->country_id,
                'password'          => Hash::make($this->password),
                'user_level_id'     => 6, //Customer role id = 6
                'status_id'         => $this->creatingUser->status_id,
                'customer_id'       => $newCustomer->id,
                // 'notify'            => $this->sendInvitation ?? false,
            ]);

            $newCustomer->resellers()->attach(Auth::user()->reseller->id);
            $user->assignRole(config('app.customer'));

        } catch (ClientException $e) {

            $this->showEditModal = false;

            $this->notify('Customer ' . $e->getMessage() . ' created successfully');
            Log::info('Error saving Customer: '.$e->getMessage());
        }

        $this->notify('success','Customer ' . $this->editing->company_name . ' created successfully');
        return redirect()->to('/customer');
        $this->showEditModal = false;

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
        })->
        with(['country', 'subscriptions', 'status']);
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
            'roles'     => $roles
        ]);
    }
}
