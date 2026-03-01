<?php

namespace App\Http\Livewire\Reseller;

use App\Role;
use App\User;
use App\Country;
use App\Reseller;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use App\Exports\ResellersExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class ResellerTable extends Component
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

    public array $editing = [];
    public ?int $editingId = null;

    public User $creatingUser;
    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];


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
            'status_id' => null,
            'markup' => null,
            'mpnid' => null,
            'price_list_id' => null,
        ];
    }

    public function mount()
    {
        $this->editing = $this->blankEditing();
        $this->editingId = null;

        $this->creatingUser = $this->makeBlankTransactionUser();
    }

    protected $rules = [
        'editing.company_name'          => 'required|string|regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/|max:255',
        'editing.nif'                   => 'required|min:3',
        'editing.country_id'            => 'required|integer|min:1',
        'editing.address_1'             => 'required|string|max:255|min:3',
        'editing.address_2'             => 'nullable|string|max:255|min:3',
        'editing.city'                  => 'required|string|max:255|min:3',
        'editing.state'                 => 'required|string|max:255|min:3',
        'editing.postal_code'           => 'required|string|max:255|min:3',
        'editing.status_id'             => 'required|integer|exists:statuses,id',
        'editing.markup'                => 'nullable|integer|min:3',
        'editing.mpnid'                 => 'sometimes|integer|min:3',
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

    public function makeBlankTransactionUser(){return User::make(['date' => now(), 'status' => 'success']);}

    public function edit($resellerId)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->showCreateUser = false;

        $reseller = Reseller::query()->findOrFail($resellerId)->fresh();

        $this->editingId = (int) $reseller->id;
        $this->editing = array_merge($this->blankEditing(), [
            'company_name' => $reseller->company_name,
            'nif' => $reseller->nif,
            'country_id' => $reseller->country_id,
            'address_1' => $reseller->address_1,
            'address_2' => $reseller->address_2,
            'city' => $reseller->city,
            'state' => $reseller->state,
            'postal_code' => $reseller->postal_code,
            'status_id' => $reseller->status_id,
            'markup' => $reseller->markup,
            'mpnid' => $reseller->mpnid,
            'price_list_id' => $reseller->price_list_id,
        ]);

        $this->showEditModal = true;
    }

    public function create()
    {
        $this->editing = $this->blankEditing();
        $this->editingId = null;

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
            $this->notify('error', 'No reseller selected for edit');
            return;
        }

        $this->validate();

        $reseller = Reseller::query()->findOrFail($this->editingId);
        $reseller->update($this->editing);

        $this->showEditModal = false;
        $this->resetPage();

        $this->notify('success', 'Reseller updated successfully');
    }

    public function savecreate()
    {
        $user = $this->getUser();
        try {

            $newReseller =  Reseller::create([
                'company_name'  => $this->editing['company_name'],
                'nif'           => $this->editing['nif'],
                'country_id'    => $this->editing['country_id'],
                'address_1'     => $this->editing['address_1'],
                'address_2'     => $this->editing['address_2'],
                'city'          => $this->editing['city'],
                'state'         => $this->editing['state'],
                'postal_code'   => $this->editing['postal_code'],
                'status_id'     => 1,
                'mpnid'         => $this->editing['mpnid'],
                'provider_id'   => $user->provider->id,
                'price_list_id' => $user->provider->availablePriceLists->first()->id,
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
                'user_level_id'             => 4, //reseller role id = 4
                'status_id'                 => $this->creatingUser->status_id,
                'reseller_id'               => $newReseller->id,
                // 'notify'            => $this->sendInvitation ?? false,
            ]);

            $user->assignRole(config('app.reseller'));

        } catch (ClientException $e) {
            $this->showEditModal = false;

            $this->notify('Reseller ' . $e->getMessage() . ' created successfully');
            Log::info('Error saving reseller: '.$e->getMessage());
        }

        $this->notify('success','Reseller ' . ($this->editing['company_name'] ?? '') . ' created successfully');
        return redirect()->route('reseller.index');
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
        $this->useCachedRows();
        return $this->applySorting($resellers);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function updatingSearch(){$this->resetPage();}

    public function exportSelected(){return Excel::download(new ResellersExport, 'resellers.xlsx');}

    public function render()
    {
        $countries  = Country::pluck( 'name','id');
        $roles      = Role::pluck( 'name','id');
        $statuses   = Status::pluck( 'name','id');
        return view('livewire.reseller.reseller-table',
        [
            'resellers' => $this->rows,
            'countries' => $countries,
            'statuses'  => $statuses,
            'roles'     => $roles
        ])->extends('layouts.master');
    }
}
