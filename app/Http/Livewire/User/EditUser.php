<?php

namespace App\Http\Livewire\User;

use App\Role;
use App\Invite;
use App\Status;
use App\Country;
use Livewire\Component;
use Illuminate\Http\File;
use App\Mail\InviteCreated;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


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
    public $status_id;
    public $name;
    public $last_name;
    public $socialite_id;
    public $phone;
    public $address;
    public $email;
    public $sendInvitation;
    public $password;
    public $password_confirmation;
    public $locale;


    protected $rules = [
        'name'              => ['sometimes', 'string', 'max:255', 'min:3'],
        'status'            => ['sometimes', 'integer', 'exists:statuses,id'],
        'last_name'         => ['sometimes', 'string', 'max:255', 'min:3'],
        'socialite_id'      => ['sometimes', 'string', 'max:255', 'min:3'],
        'city'              => ['sometimes', 'string', 'max:20', 'min:3'],
        'phone'             => ['sometimes', 'string', 'max:20', 'min:3'],
        'address'           => ['sometimes', 'string', 'max:255', 'min:3'],
        'email'             => ['nullable', 'email', 'max:255', 'min:3'],
        'sendInvitation'    => ['nullable', 'integer'],
        'password'          => ['sometimes', 'confirmed', 'min:8'],
        'locale' => ['sometimes', 'string', 'in:es,en']
    ];

    public function mount()
    {

        $this->name          = $this->user->name;
        $this->email          = $this->user->email;
        $this->status_id        = $this->user->status->id;
        $this->last_name     = $this->user->last_name;
        $this->socialite_id  = $this->user->socialite_id;
        $this->address       = $this->user->address;
        $this->city          = $this->user->city;
        $this->phone         = $this->user->phone;
        $this->state         = $this->user->state;
        $this->country_id    = $this->user->country_id;
        $this->postal_code   = $this->user->postal_code;
        $this->locale = $this->user->locale;
    }



    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);
    }

    public function savedetails()
    {
        $this->validate([
            'name'              => ['sometimes', 'string', 'max:255', 'min:3'],
            'status_id'         => ['sometimes', 'integer', 'exists:statuses,id'],
            // 'country_id'        => ['sometimes', 'integer', 'exists:countries,id'],
            'last_name'         => ['sometimes', 'string', 'max:255', 'min:3'],
            // 'city'              => ['sometimes', 'string', 'max:20', 'min:3'],
            'phone'             => ['sometimes', 'string', 'max:20', 'min:3'],
            'address'           => ['sometimes', 'string', 'max:255', 'min:3'],
            'sendInvitation'    => ['nullable', 'integer'],
            'locale'            => ['sometimes', 'string', 'in:es,en,fr,pt']
        ]);


        $this->user->name             = $this->name;
        $this->user->status_id        = $this->status_id;
        $this->user->country_id       = $this->country_id;
        $this->user->last_name        = $this->last_name;
        // $this->user->city             = $this->city;
        $this->user->phone            = $this->phone;
        $this->user->address          = $this->address;
        $this->user->locale = $this->locale;
        // $this->user->state            = $this->state;
        // $this->user->postal_code      = $this->postal_code;
        $this->user->update();


        session()->flash('message-details', 'user ' . $this->user->name . ' successfully Updated.');
    }

    public function saveauth()
    {

        $this->validate([
            'socialite_id'  => ['nullable', 'string', 'max:255', 'min:3'],
            'email'         => ['nullable', 'email', 'max:255', 'min:3'],
            'password'      => ['nullable', 'confirmed', 'min:8'],
        ]);

        $this->user->email          = $this->email;
        $this->user->socialite_id   = $this->socialite_id;
        $this->user->password       = Hash::make($this->password);
        $this->user->update();

        session()->flash('message-auth', 'User ' . $this->user->name . ' successfully Updated.');
    }


    public function savephoto()
    {

        $validatedData = $this->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['name'] = $this->photo->store('profile', 'public');


        $this->user->avatar = '/storage/' . $validatedData['name'];
        $this->user->save();
        $this->photo = '';

        session()->flash('message', 'Avatar for ' . $this->user->name . ' successfully Uploaded.');
    }

    public function sendInvitation()
    {

        $user = Auth::user()->id;
        // validate the incoming request data
        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random();
        } //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());

        //create a new invite record
        $invite = Invite::create([
            'email' => $this->email,
            'token' => $token,
            'provider_id' => $user
        ]);

        // send the email
        Mail::to($this->email)->send(new InviteCreated($invite));

        session()->flash('message', 'Message sent to ' . $this->user->email . ' successfully.');
        // redirect back where we came from
        return redirect()->back();
    }

    public function render()
    {
        $user = $this->user;
        $edit = true;
        $countries = Country::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        return view('livewire.user.edit-user', compact('edit', 'user', 'countries', 'roles', 'statuses'));
    }
}
