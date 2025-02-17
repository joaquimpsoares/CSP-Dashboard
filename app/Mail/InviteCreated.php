<?php

namespace App\Mail;

use App\User;
use App\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
{
    $this->invite = $invite;
}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
           return $this->from(Auth::user()->email)->subject('Welcome to Tagydes')->view('emails.invite', ['invite' => $this->invite]);

    }
}
