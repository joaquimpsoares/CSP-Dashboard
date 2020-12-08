<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    public function handleProviderCallback()
    {

        $socialiteUser = Socialite::driver('graph')
            ->setTenantId(env('GRAPH_TENANT_ID'))
            ->user();


        $user = User::firstOrCreate([
            'socialite_id' => $socialiteUser->getId(),
            'email' => $socialiteUser->getEmail(),
        ],
        [
            'name' => $socialiteUser->getName(),
            'user_level_id' => '3',
            'provider_id' => '1',

        ]);

        Auth()->login($user, true);

        return redirect('/');
    }

}
