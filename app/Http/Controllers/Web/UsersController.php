<?php

namespace App\Http\Controllers\web;

use App\User;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;

class UsersController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->all();
        
        return view('user.list', compact('users'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'provider_id' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            ]);
        }     

    
    /**
     * Register user for provider.
     *
     * @return void
     */
    public function registerInvitation(Request $request){

        $this->validator($request->all())->validate();

        $provider =  User::create([
            'username' => $request['email'],
            'provider_id' => $request['provider_id'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'address_2' => $request['address_2'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'user_level_id' => "3"
            ]);


                return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(User $user)
    {

        // $id = Auth::user()->id;
        $user= User::where('id', $user->id)->with('country')->first();
        
        dd($user->notifications);
        $notifications = explode(', ',$user->notifications_preferences);

        $countries = Country::get();

        return view('user.profile', compact('user', 'countries','notifications'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $userequest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $userequest)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $userequest
     * @param  \App\User  $user
     * @returttn \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        dd($request->all());

        $user = User::findOrFail($user->id);
        
        // dd($user);

        $this->validate($request, [

            'username' => 'String',
            'email' => 'String',
            'first_name' => 'String',
            'last_name' => 'String',
            'address' => 'String',
            'city' => 'String',
            'country' => 'String',
            'postal_code' => 'String',
            'avatar' => ['sometimes', 'image' => 'mimes:jpg,jpeg,bmp,svg,png,gif', 'max:5000' ]    
        ]);
        
        
        if(request()->has('avatar')){
            $avataruploaded = request()->file('avatar');
            $avatarname = time() . '.' . $avataruploaded->getClientOriginalExtension() ;
            $avatarpath = public_path('/images/profile/');
            $avataruploaded->move($avatarpath, $avatarname);
            
            $user->username             = $request->input('username');
            $user->email                = $request->input('email');
            $user->first_name           = $request->input('first_name');
            $user->last_name            = $request->input('last_name');
            $user->address              = $request->input('address');
            $user->city                 = $request->input('city');
            $user->state                = $request->input('state');
            $user->country_id           = $request->input('country_id');
            $user->postal_code          = $request->input('postal_code');
            $user->avatar               = '/images/profile/' . $avatarname;
            
            $user->save();
            
            return redirect()->back()->with('success', 'Instance created succesfully');
            
        }
                $user->username             = $request->input('username');
                $user->email                = $request->input('email');
                $user->first_name           = $request->input('first_name');
                $user->last_name            = $request->input('last_name');
                $user->address              = $request->input('address');
                $user->city                 = $request->input('city');
                $user->state                = $request->input('state');
                $user->country_id           = $request->input('country_id');
                $user->postal_code          = $request->input('postal_code');
            
            $user->save();
            
            return redirect()->back()->with('success', 'Instance created succesfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
