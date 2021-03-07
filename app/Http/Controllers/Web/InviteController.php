<?php

namespace App\Http\Controllers\web;

use App\User;
use App\Invite;
use App\Provider;
use App\Mail\InviteCreated;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;


// use Illuminate\Foundation\Auth\ResetsPasswords;
class InviteController extends Controller
{

    public function invite()
    {
        return view('invitation/invite');
    }

    public function process(Request $request)
    {
        // validate the incoming request data
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

            $provider = Invite::where('token', $token)->first();

            $email = $provider->email;

            return view('user.invitation', compact('provider','token', 'email'));
        }


        /**
        * Reset the given user's password.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
        */
        public function reset(Request $request)
        {
            $request->validate($this->rules(), $this->validationErrorMessages());

            // Here we will attempt to reset the user's password. If it is successful we
            // will update the password on an actual user model and persist it to the
            // database. Otherwise we will parse the error and return the response.
            $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                    $this->resetPassword($user, $password);
                }
            );

            // If the password was successfully reset, we will redirect the user back to
            // the application's home authenticated view. If there is an error we can
            // redirect them back to where they came from with their error message.
            return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
        }

        /**
        * Get the password reset validation rules.
        *
        * @return array
        */
        protected function rules()
        {
            return [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
            ];
        }

        /**
        * Get the password reset validation error messages.
        *
        * @return array
        */
        protected function validationErrorMessages()
        {
            return [];
        }

        /**
        * Get the password reset credentials from the request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return array
        */
        protected function credentials(Request $request)
        {
            return $request->only(
                'email', 'password', 'password_confirmation', 'token'
            );
        }

        /**
        * Reset the given user's password.
        *
        * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
        * @param  string  $password
        * @return void
        */
        protected function resetPassword(Request $request)
        {

            $invite = Invite::where('token', $request->token)->first();

            $this->setUserPassword($request->email, $request->password);

            $user = User::where('email',$request->email)->first();

            $user->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
            $invite->delete();

            $this->guard()->login($user,true);
            return redirect('/home')
            ->with('status', trans('changed password'));

        }

        /**
        * Set the user's password.
        *
        * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
        * @param  string  $password
        * @return void
        */
        protected function setUserPassword($user, $password)
        {
            $user = User::where('email',$user)->first();
            $user->password = Hash::make($password);

            $user->save();
        }

        /**
        * Get the response for a successful password reset.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  string  $response
        * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
        */
        protected function sendResetResponse(Request $request, $response)
        {
            if ($request->wantsJson()) {
                return new JsonResponse(['message' => trans($response)], 200);
            }

            return redirect($this->redirectPath())
            ->with('status', trans($response));
        }

        /**
        * Get the response for a failed password reset.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  string  $response
        * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
        */
        protected function sendResetFailedResponse(Request $request, $response)
        {
            if ($request->wantsJson()) {
                throw ValidationException::withMessages([
                    'email' => [trans($response)],
                    ]);
                }

                return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
            }

            /**
            * Get the broker to be used during password reset.
            *
            * @return \Illuminate\Contracts\Auth\PasswordBroker
            */
            public function broker()
            {
                return Password::broker();
            }

            /**
            * Get the guard to be used during password reset.
            *
            * @return \Illuminate\Contracts\Auth\StatefulGuard
            */
            protected function guard()
            {
                return Auth::guard();
            }



        }
