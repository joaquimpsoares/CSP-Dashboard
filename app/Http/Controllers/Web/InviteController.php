<?php

namespace App\Http\Controllers\web;

use App\User;
use App\Invite;
use App\Provider;
use App\Mail\InviteCreated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
{
    public function invite()
    {
        return view('invitation/invite');
    }
    
    public function process(Request $request)
    {
        // validate the incoming request data
        // dd($request->all());
        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random();
        } //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());
        
        //create a new invite record
        $invite = Invite::create([
            'email' => $request->get('email'),
            'token' => $token,
            'provider_id' => $request->provider
            ]);

    //         Invite::create([
    //     'token' => $token,
    //     'email' => $request->input('email')
    // ]);
    // $url = URL::temporarySignedRoute(
 
    //     'registration', now()->addMinutes(300), ['token' => $token]
    // );
   
            
            // send the email
            Mail::to($request->get('email'))->send(new InviteCreated($invite));
            
            // redirect back where we came from
            return redirect()
            ->back();
        }
        
        public function accept($token)
        {
            // Look up the invite
            if (!$invite = Invite::where('token', $token)->first()) {
                //if the invite doesn't exist do something more graceful than this
                abort(404);
            }
            
            $provider = Invite::select('provider_id')->where('token', $token)->first();
            
            $provider = Provider::where('id', $provider->provider_id)->first();
            
            $invite->delete();

            return view('user.register', compact('provider'));
        }

        public function store(Request $request, $token)
        {
                        
            // create the user with the details from the invite
            User::create(['email' => $request->email]);
            
            // delete the invite so it can't be used again
            $invite->delete();
            
            // here you would probably log the user in and show them the dashboard, but we'll just prove it worked
            
            return 'Good job! Invite accepted!';
        }


    }
