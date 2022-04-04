<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Str;

class Notifications extends Component
{
    public $user;
    public $teams_webhook;
    public $teams;
    public $mail;
    public $hostname;
    public $port;
    public $encryption;
    public $username;
    public $password;


    public function mount(){
        $tt= explode(',', $this->user->notifications_preferences);

        if (str_contains($this->user->notifications_preferences, 'teams')) {
            $this->teams = true;
        }
        if (str_contains($this->user->notifications_preferences, 'mail')) {
            $this->mail = true;
        }
        $this->teams_webhook = $this->user->teams_webhook;
    }


    public function save(){

        if($this->teams == true){
            if (!str_contains($this->user->notifications_preferences, 'teams')) {
                $this->user->notifications_preferences = $this->user->notifications_preferences.',teams';
            }
            $this->user->teams_webhook = $this->teams_webhook;
            $this->user->save();
        }

        if($this->teams == false){
            $this->user->notifications_preferences = Str::remove(',teams', $this->user->notifications_preferences);
            $this->user->save();
        }
        if($this->mail == true){
            if (!str_contains($this->user->notifications_preferences, 'mail')) {
                $this->user->notifications_preferences = $this->user->notifications_preferences.',mail';
            }
            // $this->user->mail_webhook = $this->teams_webhook;
            $this->user->save();
        }

        if($this->mail == false){

            $this->user->notifications_preferences = Str::remove(',mail', $this->user->notifications_preferences);
            $this->user->save();
        }


        $this->notify('Notifications updated', ' Notifications', 'success');

    }

    public function render()
    {
        return view('livewire.user.notifications');
    }
}
