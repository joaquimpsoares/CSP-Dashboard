<?php

namespace App\Http\Livewire\Reseller;

use App\Role;
use App\User;
use App\Country;
use App\Reseller;
use App\Countryrules;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use App\Exports\ResellersExport;
use App\Rules\checkPostalCodeRule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;


class ResellerTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use UserTrait;

    public $search = '';
    // public $statuses;
    // public $countries;
    public $password;
    public $password_confirmation;
    public $showEditModal = false;
    public $showCreateUser = false;

    public Reseller $editing;
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

    public function rules()
    {
        return [
            'editing.company_name'          => 'required'|'string'|'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/'|'max:255',
            'editing.nif'                   => 'required'|'min:3',
            'editing.country_id'            => 'required'|'integer'|'min:1',
            'editing.address_1'             => 'required'|'string'|'max:255'|'min:3',
            'editing.address_2'             => 'nullable'|'string'|'max:255'|'min:3',
            'editing.city'                  => 'required'|'string'|'max:255'|'min:3',
            'editing.state'                 => 'required'|'string'|'max:255'|'min:3',
            'editing.postal_code'           => 'required'|'string'|'regex:/^[0-9A-Za-z.\-]+$/'|'max:255'|'min:3',
            'editing.status_id'             => 'required'|'integer'|'exists:statuses,id',
            'editing.markup'                => 'nullable'|'integer'|'min:3',
            'editing.mpnid'                 => 'sometimes'|'integer'|'min:3',
            'editing.price_list_id'         => 'required'|'integer'|'exists:price_list,id',

            'creatingUser.name'             => 'sometimes'|'string'|'max:255'|'min:3',
            'creatingUser.last_name'        => 'sometimes'|'string'|'max:255'|'min:3',
            'creatingUser.socialite_id'     => 'sometimes'|'string'|'max:255'|'min:3',
            'creatingUser.phone'            => 'sometimes'|'string'|'max:20'|'min:3',
            'creatingUser.address'          => 'sometimes'|'string'|'max:255'|'min:3',
            'creatingUser.email'            => 'nullable'|'email','unique:users'|'max:255'|'min:3',
            'creatingUser.status_id'        => 'required'|'integer'|'exists:statuses,id',
            'password'                      => 'same:password_confirmation'|'required'|'min:6',
            // 'creatingUser.password_confirmation'          => 'same:creatingUser.password'|'required'|'min:6',
            //required', new checkPostalCodeRule(!isset($this->country_id) ?? $country->iso_3166_2),'min:3'],
            //'postal_code'           => ['requir
        ];
    }

    public function makeBlankTransaction()
    {
        return Reseller::make(['date' => now(), 'status' => 'success']);
    }
    public function makeBlankTransactionUser()
    {
        return User::make(['date' => now(), 'status' => 'success']);
    }

    public function edit(Reseller $reseller)
    {
        $this->showCreateUser = false;
        $this->showEditModal = true;
        $this->useCachedRows();

        if ($this->editing->isNot($reseller)) $this->editing = $reseller;
        $this->editing = $reseller;
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
        $user = $this->getUser();

        try {

            $newReseller =  Reseller::create([
                'company_name'  => $this->editing->company_name,
                'nif'           => $this->editing->nif,
                'country_id'    => $this->editing->country_id,
                'address_1'     => $this->editing->address_1,
                'address_2'     => $this->editing->address_2,
                'city'          => $this->editing->city,
                'state'         => $this->editing->state,
                'postal_code'   => $this->editing->postal_code,
                'status_id'     => 1,
                'mpnid'         => $this->editing->mpnid,
                'provider_id'   => $user->provider->id,
                'price_list_id' => $user->provider->priceList->id,
            ]);

            $user = User::create ([
                'email'             => $this->creatingUser->email,
                'name'              => $this->creatingUser->name,
                'last_name'         => $this->creatingUser->last_name,
                'address'           => $this->creatingUser->address,
                'phone'             => $this->creatingUser->phone,
                'country_id'        => $this->creatingUser->country_id,
                'password'          => Hash::make($this->password),
                'user_level_id'     => 4, //reseller role id = 4
                // 'notify'            => $this->sendInvitation ?? false,
                'status_id'         => $this->creatingUser->status_id,
                'reseller_id'       => $newReseller->id,
            ]);

            $user->assignRole(config('app.reseller'));

        } catch (ClientException $e) {

            $this->showEditModal = false;

            $this->notify('Customer ' . $e->getMessage() . ' created successfully');
            Log::info('Error saving reseller: '.$e->getMessage());
        }


        $this->notify('success','Reseller ' . $this->editing->company_name . ' created successfully');
        return redirect()->to('/reseller');
        $this->showEditModal = false;

    }

    public function getRowsQueryProperty()
    {
        $resellers = Reseller::query()
        ->where(function ($q)  {
            $q->where('company_name', "like", "%{$this->search}%");
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orWhere('mpnid', 'like', "%{$this->search}%");
            $q->orwhereHas('provider', function(Builder $q){
                $q->where('company_name', 'like', "%{$this->search}%");
            });
            $q->orwhereHas('country', function(Builder $q){
                $q->where('name', 'like', "%{$this->search}%");
            });
        })->
        with(['country', 'customers', 'status']);

        return $this->applySorting($resellers);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return Excel::download(new ResellersExport, 'resellers.xlsx');
    }

    public function render()
    {
        $countries  = Country::pluck( 'name','id');
        $roles      = Role::pluck( 'name','id');
        $statuses   = Status::pluck( 'name','id');
        return view('livewire.reseller.reseller-table'
        , [
            'resellers' => $this->rows,
            'countries' => $countries,
            'statuses'  => $statuses,
            'roles'     => $roles
        ]);
    }
}
