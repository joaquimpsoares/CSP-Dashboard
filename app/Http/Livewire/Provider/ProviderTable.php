<?php

namespace App\Http\Livewire\Provider;

use App\Role;
use App\User;
use App\Status;
use App\Country;
use App\Provider;
use App\PriceList;
use Livewire\Component;
use Livewire\WithPagination;
use GuzzleHttp\Handler\Proxy;
use App\Http\Traits\UserTrait;
use App\Exports\ProvidersExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class ProviderTable extends Component
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

    public Provider $editing;
    public User $creatingUser;


    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];

    protected $rules = [
            'editing.company_name'          => 'required|string|regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/|max:255',
            'editing.nif'                   => 'required|min:3',
            'editing.country_id'            => 'required|integer|min:1|exists:countries,id',
            'editing.address_1'             => 'required|string|max:255|min:3',
            'editing.address_2'             => 'nullable|string|max:255|min:3',
            'editing.city'                  => 'required|string|max:255|min:3',
            'editing.state'                 => 'required|string|max:255|min:3',
            'editing.postal_code'           => 'required|string|max:255|min:3',
            // 'editing.status_id'             => 'required|integer|exists:statuses,id',
            // 'editing.markup'                => 'nullable|integer|min:3',
            // 'editing.price_list_id'         => 'required|integer|exists:price_list,id',

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

    public function create()
    {
        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->creatingUser = $this->makeBlankTransactionUser();

        $this->showEditModal = true;
        $this->showCreateUser = true;
    }

    public function edit(Provider $provider)
    {
        $this->showCreateUser = false;
        $this->showEditModal = true;
        $this->useCachedRows();

        if ($this->editing->isNot($provider)) $this->editing = $provider;
        $this->editing = $provider;
    }

    public function save()
    {
        $this->editing->save();
        $this->showEditModal = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function savecreate()
    {

        $user = $this->getUser();
        try {
            DB::beginTransaction();
            $newProvider =  Provider::create([
                'company_name'  => $this->editing->company_name,
                'nif'           => $this->editing->nif,
                'country_id'    => $this->editing->country_id,
                'address_1'     => $this->editing->address_1,
                'address_2'     => $this->editing->address_2,
                'city'          => $this->editing->city,
                'state'         => $this->editing->state,
                'postal_code'   => $this->editing->postal_code,
                'status_id'     => 1
            ]);

            $priceList = PriceList::create([
                'name' => 'Price List - ' . $newProvider->company_name,
                'description' => 'Default Provider Price List' . $newProvider->company_name
                ]);

                $priceList->update(['provider_id' => $newProvider->id]);
            $user = User::create ([
                'email'             => $this->email,
                'name'              => $this->creatingUser->name,
                'last_name'         => $this->creatingUser->last_name,
                'address'           => $this->creatingUser->address,
                'phone'             => $this->creatingUser->phone,
                'country_id'        => $this->editing->country_id,
                'password'          => Hash::make($this->password),
                'user_level_id'     => 3, //Customer role id = 3
                'status_id'         => $this->creatingUser->status_id,
                'provider_id'       => $newProvider->id,
            ]);

            $user->assignRole(config('app.provider'));
            DB::commit();

        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $e = "errors.user_already_exists";
            } else {
                $this->messageText = $e->getMessage();
                session()->flash('danger', $this->messageText );
            }
        }

        $this->notify('success','Customer ' . $this->editing->company_name . ' created successfully');
        // return redirect()->to('/provider');
        $this->showEditModal = false;

    }

    public function mount()
    {
        $this->editing      = $this->makeBlankTransaction();
        $this->creatingUser = $this->makeBlankTransactionUser();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function makeBlankTransaction()
    {
        return Provider::make(['date' => now(), 'status' => 'success']);
    }
    public function makeBlankTransactionUser()
    {
        return User::make(['date' => now(), 'status' => 'success']);
    }

    public function getRowsQueryProperty()
    {
        $query = Provider::query();

        $providers = $query
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
            with(['country', 'resellers', 'status']);

        return $this->applySorting($providers);
    }
    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }



    public function exportSelected()
    {
        return Excel::download(new ProvidersExport, 'Providers.xlsx');
    }

    public function render()
    {

        $countries  = Country::pluck( 'name','id');
    $roles      = Role::pluck( 'name','id');
    $statuses   = Status::pluck( 'name','id');

        return view('livewire.provider.provider-table',[

            'providers' => $this->rows,
            'countries' => $countries,
            'statuses'  => $statuses,
            'roles'     => $roles
        ]);
    }
}
