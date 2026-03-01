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

    public array $editing = [];
    public ?int $editingId = null;

    public array $creatingUserForm = [];


    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];

    /**
     * Livewire rules are dynamic: when editing an existing provider we should NOT
     * require user creation fields (email/password/status), only when creating.
     */
    protected function rules(): array
    {
        $editRules = [
            'editing.company_name'          => 'required|string|regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/|max:255',
            'editing.nif'                   => 'required|string|max:15|min:3',
            'editing.country_id'            => 'required|integer|min:1|exists:countries,id',
            'editing.address_1'             => 'required|string|max:255|min:3',
            'editing.address_2'             => 'nullable|string|max:255|min:3',
            'editing.city'                  => 'required|string|max:255|min:3',
            'editing.state'                 => 'required|string|max:255|min:3',
            'editing.postal_code'           => 'required|string|max:15|min:3',
            ];

        if (!$this->showCreateUser) {
            return $editRules;
        }

        $createRules = [
            // provider fields
            ...$editRules,

            // user fields (required on create)
            'creatingUserForm.name'             => 'required|string|max:255|min:3',
            'creatingUserForm.last_name'        => 'required|string|max:255|min:3',
            'creatingUserForm.socialite_id'     => 'nullable|string|max:255|min:3',
            'creatingUserForm.phone'            => 'required|string|max:20|min:3',
            'creatingUserForm.address'          => 'required|string|max:255|min:3',
            'email'                         => 'required|email|unique:users|max:255|min:3',
            'creatingUserForm.status_id'        => 'nullable|integer|exists:statuses,id',
            'password'                      => 'same:password_confirmation|required|min:6',
            'password_confirmation'         => 'same:password|required|min:6',
        ];

        return $createRules;
    }

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
        ];
    }

    public function create()
    {
        $this->editing = $this->blankEditing();
        $this->editingId = null;

        $this->creatingUserForm = $this->blankCreatingUser();

        $this->showEditModal = true;
        $this->showCreateUser = true;
    }

    public function edit($providerId)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->showCreateUser = false;

        $provider = Provider::query()->findOrFail($providerId)->fresh();

        $this->editingId = (int) $provider->id;
        $this->editing = array_merge($this->blankEditing(), [
            'company_name' => $provider->company_name,
            'nif' => $provider->nif,
            'country_id' => $provider->country_id,
            'address_1' => $provider->address_1,
            'address_2' => $provider->address_2,
            'city' => $provider->city,
            'state' => $provider->state,
            'postal_code' => $provider->postal_code,
        ]);

        $this->showEditModal = true;
        $this->useCachedRows();
    }

    public function submit()
    {
        return $this->showCreateUser ? $this->savecreate() : $this->save();
    }

    public function save()
    {
        if (!$this->editingId) {
            $this->notify('error', 'No provider selected for edit');
            return;
        }

        $this->validate();

        $provider = Provider::query()->findOrFail($this->editingId);
        $provider->update($this->editing);

        $this->showEditModal = false;
        $this->resetPage();
        $this->notify('success', 'Provider updated successfully');
    }

    public function updated($propertyName)
    {
        // Avoid validating create-user fields while editing existing providers
        if (!$this->showCreateUser && (
            str_starts_with($propertyName, 'creatingUserForm.') ||
            in_array($propertyName, ['email', 'password', 'password_confirmation'], true)
        )) {
            return;
        }

        $this->validateOnly($propertyName);
    }

    public function savecreate()
    {
        // Validate using the create rules
        $this->validate();

        try {
            DB::beginTransaction();

            $newProvider = Provider::create([
                'company_name'  => $this->editing['company_name'],
                'nif'           => $this->editing['nif'],
                'country_id'    => $this->editing['country_id'],
                'address_1'     => $this->editing['address_1'],
                'address_2'     => $this->editing['address_2'],
                'city'          => $this->editing['city'],
                'state'         => $this->editing['state'],
                'postal_code'   => $this->editing['postal_code'],
                'status_id'     => 1,
            ]);

            $priceList = PriceList::create([
                'name' => 'Price List - ' . $newProvider->company_name,
                'description' => 'Default Provider Price List' . $newProvider->company_name,
            ]);
            $priceList->update(['provider_id' => $newProvider->id]);

            $user = User::create([
                'email'                     => $this->email,
                'name'                      => $this->creatingUserForm['name'],
                'last_name'                 => $this->creatingUserForm['last_name'],
                'address'                   => $this->creatingUserForm['address'],
                'phone'                     => $this->creatingUserForm['phone'],
                'country_id'                => $this->editing['country_id'],
                'notifications_preferences' => 'database',
                'password'                  => Hash::make($this->password),
                'user_level_id'             => 3, // Provider role level
                'status_id'                 => $this->creatingUserForm['status_id'] ?? 1,
                'provider_id'               => $newProvider->id,
            ]);

            $user->assignRole(config('app.provider'));

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Provider create failed', [
                'error' => $e->getMessage(),
                'provider' => $this->editing,
                'email' => $this->email,
            ]);
            $this->notify('error', 'Provider create failed: ' . $e->getMessage());
            return;
        }

        $this->notify('success', 'Provider ' . ($this->editing['company_name'] ?? '') . ' created successfully');
        $this->showEditModal = false;
        $this->resetPage();
    }

    public function mount()
    {
        $this->editing = $this->blankEditing();
        $this->editingId = null;

        $this->creatingUserForm = $this->blankCreatingUser();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function blankCreatingUser(): array
    {
        return [
            'name' => '',
            'last_name' => '',
            'socialite_id' => null,
            'phone' => '',
            'address' => '',
            'status_id' => 1,
        ];
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
