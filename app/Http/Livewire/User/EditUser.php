<?php

namespace App\Http\Livewire\User;

use App\Role;
use App\User;
use Exception;
use App\Invite;
use App\Country;
use App\Models\Status;
use Livewire\Component;
use App\Mail\InviteCreated;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class EditUser extends Component
{
    use WithFileUploads;
    public User $editingUser;
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
        'editingUser.name'              => ['sometimes', 'string', 'max:255', 'min:3'],
        'editingUser.status_id'         => ['sometimes', 'integer', 'exists:statuses,id'],
        'editingUser.country_id'         => ['sometimes', 'integer', 'exists:countries,id'],
        'editingUser.last_name'         => ['sometimes', 'string', 'max:255', 'min:3'],
        'editingUser.socialite_id'      => ['sometimes', 'string', 'max:255', 'min:3'],
        'editingUser.city'              => ['sometimes', 'string', 'max:20', 'min:3'],
        'editingUser.phone'             => ['sometimes', 'string', 'max:20', 'min:3'],
        'editingUser.address'           => ['sometimes', 'string', 'max:255', 'min:3'],
        'editingUser.email'             => ['nullable', 'email', 'max:255', 'min:3'],
        // 'editingUser.sendInvitation'    => ['nullable', 'integer'],
        'editingUser.locale'            => ['sometimes', 'string', 'in:es,en']
    ];

    public function mount(User $user)
    {
        $this->editingUser = $user;
    }
    public function makeBlankTransaction()
    {
        return User::make(['date' => now(), 'status' => 'success']);
    }


    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);
    }

    public function savedetails()
    {


        try {

            $this->editingUser->update();
            // $this->user->save();

        } catch (Exception $e) {
            Log::info('Error creating Customer Microsoft: '.$e->getMessage());
            $this->notify('User ' . $e->getMessage() . ' Not updated successfully');
        }


        $this->notify('User ' . $this->user->name . ' updated successfully');
        // return redirect()->to('/');
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

        session()->flash('success','User ' . $this->user->name . ' updated successfully');
        return redirect()->to('/');
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
            'email' => $this->user->email,
            'token' => $token,
            'provider_id' => $user
        ]);

        // send the email
        Mail::to($this->user->email)->send(new InviteCreated($invite));

        session()->flash('message', 'Message sent to ' . $this->user->email . ' successfully.');
        // redirect back where we came from
        return redirect()->back();
    }

    public function render(User $user)
    {

        $user = $this->editingUser;
        $edit = true;
        $countries = Country::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        return view('livewire.user.edit-user', compact('edit', 'user', 'countries', 'roles', 'statuses'));
    }
}
