<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
    * Where to redirect users after login.
    *
    * @var string
    */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
    * Redirect the user to the GitHub authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider()
    {
        return Socialite::with('graph')
        ->setTenantId(env('GRAPH_TENANT_ID'))
        ->redirect();
    }

    /**
    * Obtain the user information from GitHub.
    *
    * @return \Illuminate\Http\Response
    */
    public function handleProviderCallback(Request $request)
    {

        if ($request->has('error')){
            return Redirect::route('login')->with('danger','Please ask for the correct permissions to access the app: '.$request);
        };


        $socialiteUser = Socialite::driver('graph')
        ->setTenantId(env('GRAPH_TENANT_ID'))
        ->stateless()
        ->user();

        $user = User::where('socialite_id', $socialiteUser->getId());

        Auth()->login($user, true);

        return redirect('/');
    }


}
