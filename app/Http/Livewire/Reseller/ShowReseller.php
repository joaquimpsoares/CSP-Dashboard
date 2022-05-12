<?php

namespace App\Http\Livewire\Reseller;

use App\User;
use App\Country;
use App\Reseller;
use App\Models\Status;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Exception\ClientException;

class ShowReseller extends Component
{
    public $reseller;
    public $country;
    public $countries;
    public $statuses;
    public $email;
    public $password;
    public $password_confirmation;
    public Reseller $editing;
    public User $creatingUser;
    public $showEditModal = false;
    public $showuserCreateModal = false;
    public $showconfirmationModal = false;

    public function rules()
    {
        return [
            'editing.company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            // 'editing.nif'                   => ['required', new checkvatIdRule($this->reseller->country->iso_3166_2),'min:3'],
            'editing.nif'                   => ['required', 'min:3'],
            'editing.country_id'            => ['required', 'integer', 'min:1','exists:countries,id'],
            'editing.address_1'             => ['required', 'string', 'max:255', 'min:3'],
            'editing.address_2'             => ['nullable', 'string', 'max:255', 'min:3'],
            'editing.city'                  => ['required', 'string', 'max:255', 'min:3'],
            'editing.state'                 => ['required', 'string', 'max:255', 'min:3'],
            // 'editing.postal_code'           => ['required', 'string', new checkPostalCodeRule($this->reseller->country->iso_3166_2), 'max:255', 'min:3'],
            'editing.postal_code'           => ['required', 'string', 'max:255', 'min:3'],
            'editing.status_id'             => ['required', 'exists:statuses,id'],
            'editing.markup'                => ['nullable', 'integer', 'min:3'],
            'editing.mpnid'                 => ['nullable', 'integer', 'min:3'],
            'editing.price_list_id'         => ['integer', 'exists:price_lists,id'],

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

    public function updated($propertyName){$this->validateOnly($propertyName);}
    public function makeBlankTransaction(){return Reseller::make(['date' => now(), 'status' => 'success']);}
    public function makeBlankTransactionUser(){return User::make(['date' => now(), 'status' => 'success']);}
    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function edit(Reseller $reseller){
        $this->showuserCreateModal = false;
        $this->editing = $reseller;
        $this->showEditModal = true;
    }

    public function disable(Reseller $reseller){
        $this->showconfirmationModal = false;
        $reseller->status_id = 2;
        $reseller->save();
        $this->notify('Reseller ' . $reseller->company_name . ' is disabled, refresh page');
    }

    public function enable(Reseller $reseller){
        $reseller->status_id = 1;
        $reseller->save();
        $this->notify('Reseller ' . $reseller->company_name . ' is enabled, refresh page');
    }

    public function addUser(){
        $this->creatingUser = $this->makeBlankTransactionUser();
        $this->showEditModal = true;
        $this->showuserCreateModal = true;
    }

    public function deleteUser(User $user){
        $user->delete();
        $this->notify(' ', 'User ' . $user->name . ' Deleted successfully', 'info');
        $this->emit('refreshTransactions');
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

    public function enableUser(User $user){
        if($user->status_id == 1){
            $this->notify(' ', 'User ' . $user->name . ' already Enabled', 'info');
        return false;
    }

        $user->fill([
            'status_id' => '1',
        ]);
        $user->save();
        $this->notify(' ', 'User ' . $user->name . ' Activated successfully', 'info');

        $this->emit('refreshTransactions');
    }

    public function saveuser(Reseller $reseller){
        $user = User::create ([
            'email'                     => $this->email,
            'name'                      => $this->creatingUser->name,
            'last_name'                 => $this->creatingUser->last_name,
            'address'                   => $this->creatingUser->address,
            'phone'                     => $this->creatingUser->phone,
            'notifications_preferences' => 'database',
            'country_id'                => $reseller->country_id,
            'password'                  => Hash::make($this->password),
            'user_level_id'             => 4, //reseller role id = 4
            'status_id'                 => 1,
            'reseller_id'               => $reseller->id,
            // 'notify'                 => $this->sendInvitation ?? false,
        ]);

        $user->assignRole(config('app.reseller'));
        $this->notify(' ', 'User ' . $user->name . ' Created successfully', 'info');

        $this->emit('refreshTransactions');

        $this->showuserCreateModal = false;
        $this->showEditModal = false;
    }

    public function mount()
    {
        $this->countries = Country::get();
        $this->statuses = Status::get();
        $this->reseller = Reseller::where('id', $this->reseller)->first();
        // dd($this->reseller);
        $this->editing      = $this->makeBlankTransaction();
        $this->creatingUser = $this->makeBlankTransactionUser();
    }

    public function save(Reseller $reseller)
    {
        try {
            $this->editing->save();
            $this->showEditModal = false;

        } catch (ClientException $e) {
            $this->showEditModal = false;
            $this->notify('Customer ' . $e->getMessage() . ' created successfully');
            Log::info('Error saving reseller: '.$e->getMessage());
        }

    }

    public function render(Reseller $reseller, Status $statuses, Country $countries)
    {
        return view('livewire.reseller.show-reseller', compact('statuses','countries', 'reseller'))->extends('layouts.master');
    }
}
