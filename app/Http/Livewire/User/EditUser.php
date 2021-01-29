<?php

namespace App\Http\Livewire\User;

use App\Role;
use App\Status;
use App\Country;
use Livewire\Component;
use Illuminate\Http\File;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;


class EditUser extends Component
{
    use WithFileUploads;

    public $user;
    public $photo;
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


    protected $rules = [
        'name'                  => ['sometimes', 'string', 'max:255', 'min:3'],
        'status'                => ['sometimes', 'integer', 'exists:statuses,id'],
        'last_name'             => ['sometimes', 'string', 'max:255', 'min:3'],
        // 'socialite_id'          => ['sometimes', 'string', 'max:255', 'min:3'],
        'city'                  => ['sometimes', 'string', 'max:20', 'min:3'],
        'phone'                 => ['sometimes', 'string', 'max:20', 'min:3'],
        'address'               => ['sometimes', 'string', 'max:255', 'min:3'],
        'email'                 => ['nullable', 'email','unique:users', 'max:255', 'min:3'],
        'sendInvitation'        => ['nullable', 'integer'],
        'password'              => ['same:password_confirmation','required', 'min:6'],
    ];

    public function mount(){

        $this->name          = $this->user->name;
        $this->status        = $this->user->status->id;
        $this->last_name     = $this->user->last_name;
        $this->socialite_id  = $this->user->socialite_id;
        $this->address       = $this->user->address;
        $this->city          = $this->user->city;
        $this->phone         = $this->user->phone;
        $this->state         = $this->user->state;
        $this->country_id    = $this->user->country_id;
        $this->postal_code   = $this->user->postal_code;
    }



    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);
    }

    public function savedetails()
    {
        // $this->validate();
        $this->user->name             = $this->name;
        $this->user->status_id        = $this->status;
        $this->user->last_name        = $this->last_name;
        $this->user->address          = $this->address;
        $this->user->city             = $this->city;
        $this->user->phone            = $this->phone;
        $this->user->state            = $this->state;
        $this->user->country_id       = $this->country_id;
        $this->user->postal_code      = $this->postal_code;
        $this->user->update();


        session()->flash('message-details', 'user '. $this->user->name . ' successfully Updated.');
    }

    public function saveauth()
    {

        $this->user->email          = $this->email;
        $this->user->socialite_id   = $this->socialite_id;
        $this->user->password       = Hash::make($this->password);
        $this->user->update();

        session()->flash('message-auth', 'User '. $this->user->name . ' successfully Updated.');
    }


    public function savephoto()
    {

        $validatedData = $this->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['name'] = $this->photo->store('profile', 'public');


        $this->user->avatar = '/storage/'.$validatedData['name'];
        $this->user->save();
        $this->photo = '';

        session()->flash('message', 'Avatar for '. $this->user->name . ' successfully Uploaded.');


    }

    public function render()
    {
        $user = $this->user;
        $edit = true;
        $countries = Country::pluck( 'name','id');
        $statuses = Status::pluck( 'name','id');
        $roles = Role::pluck('name','id');
        return view('livewire.user.edit-user', compact('edit', 'user','countries','roles','statuses'));
    }
}
