<?php

namespace App\Http\Livewire\Profile;

use App\Country;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Traits\UserTrait;
use App\Reseller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShowProfile extends Component
{
    public $user;

    use UserTrait;
    use WithFileUploads;
    protected $listeners = ['refreshTransactions' => '$refresh'];

    public $account;
    public $company_name;
    public $nif;
    public $messageText = '';
    public $country_id;
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
    public $logo;
    public $photo;


    protected $rules = [
        'company_name'  => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
        'nif'           => ['required', 'min:3'],
        'country_id'    => ['required', 'integer', 'min:1'],
        'address'       => ['required', 'string', 'max:255', 'min:3'],
        'city'          => ['required', 'string', 'max:255', 'min:3'],
        'state'         => ['required', 'string', 'max:255', 'min:3'],
        'postal_code'   => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255', 'min:3'],
        'mpnid'         => ['sometimes', 'min:5'],
    ];

    public function mount()
    {
        switch ($this->getUserLevel()) {
            case config('app.super_admin'):
            break;

            case config('app.provider'):
                $this->account = Auth::user()->provider;
                $this->logo = Auth::user()->provider->logo;
            break;

            case config('app.reseller'):
                $this->account = Auth::user()->reseller;
                $this->logo = Auth::user()->reseller->provider->logo;
                $this->mpnid = Auth::user()->reseller->mpnid;
            break;

            case config('app.customer'):
                $this->account = Auth::user()->customer;
            break;
            default:
            return abort(403, __('errors.unauthorized_action'));

        break;
            }

        $this->company_name     = $this->account->company_name ?? '';
        $this->address          = $this->account->address_1 ?? '';
        $this->nif              = $this->account->nif ?? '';
        $this->city             = $this->account->city ?? '';
        $this->state            = $this->account->state ?? '';
        $this->country_id       = $this->account->country_id ?? '';
        $this->postal_code      = $this->account->postal_code ?? '';
        $this->country_id       = $this->account->country_id ?? '';

    }

    public function save()
    {
        $validate = $this->validate();

        try {
            DB::beginTransaction();

            $this->account->company_name  = $this->company_name;
            $this->account->nif         = $this->nif;
            $this->account->country_id    = $this->country_id;
            $this->account->address_1     = $this->address;
            $this->account->city          = $this->city;
            $this->account->state         = $this->state;
            $this->account->postal_code   = $this->postal_code;
            $this->account->mpnid         = $this->mpnid;
            $this->account->save();


            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "message.user_already_exists";
            } else {
                $errorMessage = $e->getMessage();
            }
            return redirect()->back()->with('danger', $errorMessage );

        }
        $this->notify('You\'ve updated '.  $this->account->company_name .' Account successfully', 'Account Details' , 'success');
        $this->emit('refreshTransactions');
    }



    public function savePhoto()
    {
        $this->validate([
            'photo' => 'image|max:2024', // 1MB Max
        ]);

        $validatedData['name'] = $this->photo->store('logos', 'public');



        $this->account->logo = '/storage/' . $validatedData['name'];
        $this->account->save();


        session()->flash('success', 'Logo for ' . $this->account->company_name . ' successfully Uploaded.');
        return redirect()->back();
    }

    public function removePhoto()
    {
        $this->account->logo = '/images/logos/tagydes.png';
        $this->account->save();
        $this->photo = '';

        session()->flash('success', 'Logo for ' . $this->account->company_name . ' removed successfully.');
        return redirect()->back();
    }
    public function render()
    {
        $account = $this->account;
        $countries  = Country::pluck( 'name','id');

        return view('livewire.profile.show-profile', compact('account', 'countries'));
    }
}
