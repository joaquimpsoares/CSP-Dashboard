<?php

namespace App\Http\Livewire\Reseller;

use App\Role;
use App\User;
use App\Status;
use App\Country;
use App\Reseller;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateReseller extends Component
{
    use UserTrait;

    public $company_name;
    public $nif;
    public $messageText = '';
    public $country_id;
    public $address_1;
    public $address_2;
    public $city;
    public $state;
    public $postal_code;
    public $mpnid;
    public $status;
    public $name;
    public $last_name;
    public $socialite_id;
    public $phone;
    public $address;
    public $email;
    public $sendInvitation;
    public $password;
    public $password_confirmation;
    public $markup;

    protected $rules = [
        'company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
        'nif'                   => ['required', 'min:3'],
        'country_id'            => ['required', 'integer', 'min:1'],
        'address_1'             => ['required', 'string', 'max:255', 'min:3'],
        'address_2'             => ['nullable', 'string', 'max:255', 'min:3'],
        'city'                  => ['required', 'string', 'max:255', 'min:3'],
        'state'                 => ['required', 'string', 'max:255', 'min:3'],
        'postal_code'           => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255', 'min:3'],
        'status'                => ['required', 'integer', 'exists:statuses,id'],
        'name'                  => ['sometimes', 'string', 'max:255', 'min:3'],
        'last_name'             => ['sometimes', 'string', 'max:255', 'min:3'],
        'socialite_id'          => ['sometimes', 'string', 'max:255', 'min:3'],
        'phone'                 => ['sometimes', 'string', 'max:20', 'min:3'],
        'address'               => ['sometimes', 'string', 'max:255', 'min:3'],
        'email'                 => ['nullable', 'email','unique:users', 'max:255', 'min:3'],
        'markup'                => ['nullable', 'integer', 'min:3'],
        'mpnid'                 => ['sometimes', 'integer', 'min:3'],
        'sendInvitation'        => ['nullable', 'integer'],
        'password'              => ['same:password_confirmation','required', 'min:6'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function save()
    {
        $user = $this->getUser();
        $this->validate();
    try {
        DB::beginTransaction();
        $newReseller =  Reseller::create([
            'company_name'  => $this->company_name,
            'nif'           => $this->nif,
            'country_id'    => $this->country_id,
            'address_1'     => $this->address_1,
            'address_2'     => $this->address_2,
            'city'          => $this->city,
            'state'         => $this->state,
            'postal_code'   => $this->postal_code,
            'status_id'     => $this->status,
            'mpnid'         => $this->mpnid,
            'provider_id'   => $user->provider->id,
            'price_list_id'   => $user->provider->priceList->id,
            ]);

        $user = User::create ([
            'email'             => $this->email,
            'name'              => $this->name,
            'last_name'         => $this->last_name,
            'address'           => $this->address,
            'phone'             => $this->phone,
            'country_id'        => $this->country_id,
            'password'          => Hash::make($this->password),
            'user_level_id'     => 4, //reseller role id = 4
            'notify'            => $this->sendInvitation ?? false,
            'status_id'         => $this->status,
            'reseller_id'       => $newReseller->id,
            ]);

            $user->assignRole(config('app.reseller'));

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $e = "errors.user_already_exists";
            } else {
                $this->messageText = $e->getMessage();
                session()->flash('danger', $this->messageText );
                return redirect()->back();
            }
        }

        session()->flash('success','Reseller ' . $this->company_name . ' created successfully');
        return redirect()->to('/reseller');


        }



        public function render()
        {
            $countries  = Country::pluck( 'name','id');
            $roles      = Role::pluck( 'name','id');
            $statuses   = Status::pluck( 'name','id');

        return view('livewire.reseller.create-reseller', compact('countries','roles','statuses'));
    }
}
