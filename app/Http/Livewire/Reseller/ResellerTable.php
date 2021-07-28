<?php

namespace App\Http\Livewire\Reseller;

use App\Role;
use App\User;
use App\Status;
use App\Country;
use App\Reseller;
use App\Countryrules;
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
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;


class ResellerTable extends Component
{
    use WithPagination;
    use UserTrait;

    public $search = '';
    // public $statuses;
    // public $countries;
    public Reseller $creating;
    public $showEditModal = false;

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


    // public function rules()
    // {
    //     $country=Country::find($this->country_id);

    //     if (isset($this->country_id)) {

    //         $reg = Countryrules::where('iso2code', $country->iso_3166_2)->first();
    //         if(isset($reg->isPostalCodeRequired)){
    //             if($reg->isPostalCodeRequired == true){
    //                 return [
    //                     'company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
    //                     'nif'                   => ['required', 'min:3'],
    //                     'country_id'            => ['required', 'integer', 'min:1'],
    //                     'address_1'             => ['required', 'string', 'max:255', 'min:3'],
    //                     'address_2'             => ['nullable', 'string', 'max:255', 'min:3'],
    //                     'city'                  => ['required', 'string', 'max:255', 'min:3'],
    //                     'state'                 => ['required', 'string', 'max:255', 'min:3'],
    //                     'postal_code'           => ['required', new checkPostalCodeRule(!isset($this->country_id) ?? $country->iso_3166_2),'min:3'],
    //                     'status'                => ['required', 'integer', 'exists:statuses,id'],
    //                     'name'                  => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'last_name'             => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'socialite_id'          => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'phone'                 => ['sometimes', 'string', 'max:20', 'min:3'],
    //                     'address'               => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'email'                 => ['nullable', 'email','unique:users', 'max:255', 'min:3'],
    //                     'markup'                => ['nullable', 'integer', 'min:3'],
    //                     'mpnid'                 => ['sometimes', 'integer', 'min:3'],
    //                     'sendInvitation'        => ['nullable', 'integer'],
    //                     'password'              => ['same:password_confirmation','required', 'min:6'],
    //                 ];
    //             }else{
    //                 return [
    //                     'company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
    //                     'nif'                   => ['required', 'min:3'],
    //                     'country_id'            => ['required', 'integer', 'min:1'],
    //                     'address_1'             => ['required', 'string', 'max:255', 'min:3'],
    //                     'address_2'             => ['nullable', 'string', 'max:255', 'min:3'],
    //                     'city'                  => ['required', 'string', 'max:255', 'min:3'],
    //                     'state'                 => ['required', 'string', 'max:255', 'min:3'],
    //                     'postal_code'           => ['required', 'string', 'max:255', 'min:3'],
    //                     'status'                => ['required', 'integer', 'exists:statuses,id'],
    //                     'name'                  => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'last_name'             => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'socialite_id'          => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'phone'                 => ['sometimes', 'string', 'max:20', 'min:3'],
    //                     'address'               => ['sometimes', 'string', 'max:255', 'min:3'],
    //                     'email'                 => ['nullable', 'email','unique:users', 'max:255', 'min:3'],
    //                     'markup'                => ['nullable', 'integer', 'min:3'],
    //                     'mpnid'                 => ['sometimes', 'integer', 'min:3'],
    //                     'sendInvitation'        => ['nullable', 'integer'],
    //                     'password'              => ['same:password_confirmation','required', 'min:6'],
    //                     // 'postal_code'           => ['required', new checkPostalCodeRule(!isset($this->country_id) ?? $country->iso_3166_2),'min:3'],
    //                     // 'postal_code'           => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255', 'min:3'],
    //                 ];
    //             }
    //         }
    //     }

    // }



    public function create(Reseller $reseller)
    {
        $this->creating = $reseller;
        $this->showEditModal = true;
    }

    public function save()
    {
        // $this->validate();

        $user = $this->getUser();
        $country=Country::find($this->country_id);
        try {
            // $newCustomer = TagydesCustomer::withCredentials($user->provider->instances->first()->external_id, $user->provider->instances->first()->external_token)
            // ->checkAddress([
            //     'AddressLine1'  => $this->address_1,
            //     'City'          => $this->city,
            //     'State'         => $this->state,
            //     'PostalCode'    => $this->postal_code,
            //     'Country'       => $country->iso_3166_2,
            // ]);

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
                'price_list_id' => $user->provider->priceList->id,
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

        } catch (ClientException $e) {

            dd($e->getMessage());
            // if ($e->errorInfo[1] == 1062) {
                //     $e = "errors.user_already_exists";
                // } else {
                    $this->showEditModal = false;
                    // notify()->error('Welcome to Laravel Notify ⚡️');
                    $this->notify('Customer ' . $e->getMessage() . ' created successfully');
                    Log::info('Error saving reseller: '.$e->getMessage());
                    // }
                }


                $this->notify('success','Reseller ' . $this->company_name . ' created successfully');
                return redirect()->to('/reseller');


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
                $search = $this->search;
                $query = Reseller::query();
                $resellers = $query
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
                with(['country', 'customers', 'status'])->paginate(10);

                $resellers->getCollection()->map(function(Reseller $reseller){
                    $reseller->setRawAttributes(json_decode(json_encode($reseller->format()), true)); // Coverts to array recursively (make helper from it?)
                    return $reseller;
                });

                $countries  = Country::pluck( 'name','id');
                $roles      = Role::pluck( 'name','id');
                $statuses   = Status::pluck( 'name','id');
                return view('livewire.reseller.reseller-table', compact('resellers','countries', 'statuses','roles'));
            }
        }
