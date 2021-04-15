<?php

namespace App\Http\Livewire\User;

use App\Role;
use App\User;
use App\Status;
use App\Country;
use App\UserLevel;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{

    use UserTrait;

    public $messageText = '';
    public $country_id;
    public $address_1;
    public $address_2;
    public $city;
    public $state;
    public $postal_code;
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
    public $level;
    public $reseller_id;
    public $provider_id;
    public $customer_id;
    public $previous;


    protected $rules = [
        'status'                => ['required', 'integer', 'exists:statuses,id'],
        'name'                  => ['sometimes', 'string', 'max:255', 'min:3'],
        'last_name'             => ['sometimes', 'string', 'max:255', 'min:3'],
        'socialite_id'          => ['sometimes', 'string', 'max:255', 'min:3'],
        'phone'                 => ['sometimes', 'string', 'max:20', 'min:3'],
        'address'               => ['sometimes', 'string', 'max:255', 'min:3'],
        'email'                 => ['nullable', 'email','unique:users', 'max:255', 'min:3'],
        'sendInvitation'        => ['nullable', 'integer'],
        'password'              => ['same:password_confirmation','required', 'min:8'],

    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount(Request $request)
    {
        $this->previous = URL::previous();
        $this->level = $request->level;
        $this->reseller_id = $request->reseller_id;
        $this->provider_id = $request->provider_id;
        $this->customer_id = $request->customer_id;

    }


    public function save(Request $request)
    {

        switch ($this->level) {
        case 'Super Admin':

            // $newUser = User::create($user);

            // $newUser->assignRole($role->name);

            break;
        case 'provider':

            $this->validate();

            $user = User::create ([
                'email'             => $this->email,
                'name'              => $this->name,
                'last_name'         => $this->last_name,
                'socialite_id'      => $this->socialite_id,
                'address'           => $this->address,
                'phone'             => $this->phone,
                'country_id'        => $this->country_id,
                'password'          => Hash::make($this->password),
                'user_level_id'     => 3, //provider role id = 3
                'notify'            => $this->sendInvitation ?? false,
                'status_id'         => $this->status,
                'provider_id'       => $this->provider_id,
                ]);

                $user->assignRole(config('app.provider'));


                break;

            case 'reseller':

                $this->validate();

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
                    'reseller_id'       => $this->reseller_id,
                    ]);

                    $user->assignRole(config('app.reseller'));

                    break;

                case 'customer':

                    $this->validate();

                    $user = User::create ([
                        'email'             => $this->email,
                        'name'              => $this->name,
                        'last_name'         => $this->last_name,
                        'address'           => $this->address,
                        'phone'             => $this->phone,
                        'country_id'        => $this->country_id,
                        'password'          => Hash::make($this->password),
                        'user_level_id'     => 6, //customer role id = 6
                        'notify'            => $this->sendInvitation ?? false,
                        'status_id'         => $this->status,
                        'customer_id'       => $this->customer_id,
                        ]);

                        $user->assignRole(config('app.customer'));
                        // return redirect()->back();

                        // session()->flash('success','User ' . $this->name . ' created successfully');

                        break;

                        default:

                        break;
                    }

                    session()->flash('success','User ' . $this->name . ' created successfully');
                    return redirect($this->previous);


                }


    public function render()
    {

        $countries = Country::pluck( 'name','id');
        $statuses = Status::pluck( 'name','id');
        $roles = Role::pluck('name','id');
        return view('livewire.user.create-user', compact('countries','roles','statuses'));
    }
}
