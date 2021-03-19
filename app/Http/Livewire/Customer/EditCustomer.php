<?php

namespace App\Http\Livewire\Customer;

use App\Status;
use App\Country;
use App\Customer;
use App\Reseller;
use Livewire\Component;
use App\Http\Traits\UserTrait;

class EditCustomer extends Component
{

    use UserTrait;

    public $customer;
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
        'email'                 => ['nullable', 'email','unique:users', 'max:255', 'min:3'],
        'name'                  => ['sometimes', 'string', 'max:255', 'min:3'],
        'last_name'             => ['sometimes', 'string', 'max:255', 'min:3'],
        'socialite_id'          => ['sometimes', 'string', 'max:255', 'min:3'],
        'phone'                 => ['sometimes', 'string', 'max:20', 'min:3'],
        'address'               => ['sometimes', 'string', 'max:255', 'min:3'],
        'sendInvitation'        => ['nullable', 'integer'],
        'password'              => ['same:password_confirmation','required', 'min:6'],
        'markup'                => ['nullable', 'integer', 'min:3'],
    ];

    public function mount(Customer $customer)
    {
        // dd($customer);

        $this->company_name = $customer->company_name;
        $this->nif          = $customer->nif;
        $this->country_id   = $customer->country_id;
        $this->address_1    = $customer->address_1;
        $this->address_2    = $customer->address_2;
        $this->city         = $customer->city;
        $this->state        = $customer->state;
        $this->postal_code  = $customer->postal_code;
        $this->status       = $customer->status->id;


    }

    public function changereseller(Customer $customer, Reseller $reseller)
    {
        $customer->resellers()->attach($reseller->id);
    }

    public function render()
    {
        $customer = $this->customer;

        $resellers  = Reseller::pluck( 'company_name','id');
        $countries  = Country::pluck( 'name','id');
        $statuses   = Status::pluck( 'name','id');
        return view('livewire.customer.edit-customer', compact('customer','countries','statuses','resellers'));
    }
}
