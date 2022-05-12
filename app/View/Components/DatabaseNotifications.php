<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification;

class DatabaseNotifications extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.database-notifications');
    }

    // public function sendNotification()
    // {
    //     $user = User::first();

    //     $details = [
    //         'greeting' => 'Hi Artisan',
    //         'body' => 'This is my first notification from RajTechnologies.com',
    //         'thanks' => 'Thank you for using RajTechnologies.com tuto!',
    //         'actionText' => 'View My Site',
    //         'actionURL' => url('/'),
    //         'order_id' => 101
    //     ];

    //     Notification::send($user, new UserNotification($details));

    // }
}
