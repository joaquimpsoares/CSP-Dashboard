<?php

namespace App\Http\Livewire\User;

use App\User;
use App\Country;
use App\Models\BullethqInvoices;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class GeneralSettings extends Component
{
    public User $editing;
    public BullethqInvoices $bulletInvoices;
    public $password;
    public $password_confirmation;
    public $token;
    public $token_name;

    public $teams_webhook;
    public $teams;
    public $mail;
    public $hostname;
    public $port;
    public $encryption;
    public $username;

    public function mount(User $user){
        $this->editing = $user;

        $tt= explode(',', $this->editing->notifications_preferences);

        if (str_contains($this->editing->notifications_preferences, 'teams')) {
            $this->teams = true;
        }
        if (str_contains($this->editing->notifications_preferences, 'mail')) {
            $this->mail = true;
        }

        $this->teams_webhook = $this->editing->teams_webhook;
    }

    public function rules()
    {
        return [
            'bulletInvoices.outstandingAmount' => ['required', 'min:3'],
            'editing.name'         => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.last_name'    => ['required', 'min:3'],
            'editing.socialite_id' => ['required', 'integer', 'min:1','exists:countries,id'],
            'editing.email'        => ['required', 'email', 'unique:users', 'max:255', 'min:3'],
            'editing.phone'        => ['required', 'string', 'max:255', 'min:3'],
            'editing.username'     => ['required', 'string', 'max:255', 'min:3'],
            'editing.address'      => ['required', 'string', 'max:255', 'min:3'],
            'editing.city'         => ['required', 'string', 'max:255', 'min:3'],
            'editing.state'        => ['required', 'string', 'max:255', 'min:3'],
            'editing.postal_code'  => ['required', 'string', 'max:255', 'min:3'],
            'editing.status_id'    => ['required', 'exists:statuses,id'],
            'editing.country_id'   => ['required', 'exists:countries,id'],
            'editing.locale'       => ['required', 'string', 'max:255', 'min:3'],

            'password'              => ['same:password_confirmation', 'sometimes', 'min:8'],
            'password_confirmation' => ['same:password', 'sometimes', 'min:8'],
            'token_name'            => ['required', 'string', 'max:255', 'min:3'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save_user(){
        $this->editing->save();
        $this->notify('','User saved successfully','success');
    }

    public function saveNotifications(){

        if($this->teams == true){
            if (!str_contains($this->editing->notifications_preferences, 'teams')) {
                $this->editing->notifications_preferences = $this->editing->notifications_preferences.',teams';
            }
            $this->editing->teams_webhook = $this->teams_webhook;
            $this->editing->save();
        }

        if($this->teams == false){
            $this->editing->notifications_preferences = Str::remove(',teams', $this->editing->notifications_preferences);
            $this->editing->save();
        }
        if($this->mail == true){
            if (!str_contains($this->editing->notifications_preferences, 'mail')) {
                $this->editing->notifications_preferences = $this->editing->notifications_preferences.',mail';
            }
            // $this->editing->mail_webhook = $this->teams_webhook;
            $this->editing->save();
        }

        if($this->mail == false){
            $this->editing->notifications_preferences = Str::remove(',mail', $this->editing->notifications_preferences);
            $this->editing->save();
        }

        $this->notify('Notifications updated', ' Notifications', 'success');

    }


    public function saveauth(){
        $this->editing->password = Hash::make($this->password);
        $this->editing->save();
        $this->notify('User ' . $this->editing->name . ' Password updated successfully','success');

    }

    public function generateToken(){
        if($this->token_name){
            $this->validateOnly('token_name');
            $user = Auth::user()->createToken($this->token_name)->plainTextToken;
            $this->token = $user;
        }
    }
    function cleanData($invoice) {
        // dd($invoice);
        $bad_symbols = array( ".");
        $invoice = str_replace($bad_symbols, "", $invoice);
        // dd( number_format($invoice));
        // $invoice = number_format($invoice, 2, '.', '');
        // $invoice = (int) str_replace( ',','', $invoice);
    }

    public function deleteToken($tokenId){
        Auth::user()->tokens()->where('id', $tokenId)->delete();
        $this->emit('refreshTransactions');
    }

    public function render(User $user, BullethqInvoices $invoice)
    {
        $countries = Country::get();
        $invoices =BullethqInvoices::get();

        return view('livewire.user.general-settings', compact('user','countries','invoices'))->extends('layouts.master');
    }
}
