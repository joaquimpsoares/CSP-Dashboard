<?php

namespace App\Http\Controllers\web;

use App\Role;
use App\User;
use App\Status;
use App\Country;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notification;
use App\Repositories\UserRepositoryInterface;

class UsersController extends Controller
{
    use UserTrait;

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
        $provider = Auth::user()->provider;
        $users = $this->userRepository->all();

        return view('user.list', compact('users','provider'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function profile(User $user)
    {

        $user = $this->getUser();

        $provider = $user->provider;

        $user= User::where('id', $user->id)->with('country')->first();

        // instance $userlevel


        $notifications = explode(', ',$user->notifications_preferences);

        $countries = Country::get();

        return view('user.profile', compact('user', 'countries','notifications','provider'));
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(User $user, Request $request)
    {

        $countries = Country::get();
        $statuses = Status::get();

        $level = $request->level;
        $customer_id = $request->customer_id;

        return view('user.add', compact('user','countries','statuses','level','customer_id'));

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $userequest
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $user = $this->getUser();

        $validate = $this->validator($request->all())->validate();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):
                $id = Auth::User()->id;
                $mainUser = $this->userRepository->create($validate, $request->level, $id);

            break;
            case config('app.provider'):
                $id = Auth::user()->provider->id;

                $mainUser = $this->userRepository->create($validate, $request->level, $id);
            break;

            default:
            # code...
        break;
    }



    $customer = Customer::where('id', $request->customer_id)->first();
    $mainUser = $this->userRepository->create($validate, $request->level, $id);
}

/**
* Display the specified resource.
*
* @param  \App\User  $user
* @return \Illuminate\Http\Response
*/
public function show(User $user)
{
    // dd($user->roles);

    $roles = Role::get();

    // $notificaciont = Notification::all();
    $countries = Country::get();

    return view('user.profile',compact('user','countries','roles'));

}

/**
* Show the form for editing the specified resource.
*
* @param  \App\User  $user
* @return \Illuminate\Http\Response
*/
public function edit(User $user)
{
    $edit = true;
    $countries = Country::get();


    // $roles = $roleRepository->lists();
    // $statuses = UserStatus::lists();
    // $socialLogins = $this->users->getUserSocialLogins($user->id);
    $u = auth()->user();
    // $roles = Role::where('order',$u->getRole())->orWhere('order', 5)->pluck('name','id');


    return view('user.edit',compact('edit', 'user','countries'));
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

    $user = User::findOrFail($user->id);

    // $validate = $this->validator($request->all())->validate();

    try {
        DB::beginTransaction();

        if(request()->has('avatar')){
            // dd('hh');
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
            // $user->password             = Hash::make($request->input('password'));
            $user->avatar               = '/images/profile/' . $avatarname;

            $user->save();
            DB::commit();

            return redirect()->back()->with('success', 'User Updated succesfully');

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
        // $user->password             = Hash::make($request->input('password'));

        $user->save();
        DB::commit();
        return redirect()->back()->with('success', 'User Updated succesfully');

    } catch (\PDOException $e) {
        DB::rollBack();
        if ($e->errorInfo[1] == 1062) {
            $errorMessage = "errors.user_already_exists";
        } else {
            $errorMessage = "errors.error";
        }
        return redirect()->back()->with('danger', ucwords(trans_choice($errorMessage, 1)) );

    }
    return redirect()->route('provider.index')->with('success', ucwords(trans_choice('messager.user_updated_succesfully', 1)) );

}

public function updatepassword(Request $request, User $user)
{
    $user = User::findOrFail($user->id);

     try {
        DB::beginTransaction();

        $user->password = Hash::make($request->input('password'));

        $user->save();
        DB::commit();

        return redirect()->back()->with('success', 'User Password Updated succesfully');

    } catch (\PDOException $e) {
        DB::rollBack();
        if ($e->errorInfo[1] == 1062) {
            $errorMessage = "errors.user_already_exists";
        } else {
            $errorMessage = "errors.error";
        }
        return redirect()->back()->with('danger', ucwords(trans_choice($errorMessage, 1)) );

    }
    return redirect()->back()->with('success', ucwords(trans_choice('messager.User Password Updated succesfully', 1)) );

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

protected function validator(array $data)
{
    return Validator::make($data, [
        'email' => ['sometimes', 'email', 'max:255'],
        'address_1' => ['sometimes', 'string', 'max:255'],
        'address_2' => ['sometimes', 'string', 'max:255'],
        'country_id' => ['sometimes', 'integer', 'min:1'],
        'city' => ['sometimes', 'string', 'max:255'],
        'state' => ['sometimes', 'string', 'max:255'],
        'postal_code' => ['sometimes', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
        'status_id' => ['sometimes', 'integer', 'exists:statuses,id'],
        'first_name' => ['sometimes', 'string', 'max:255'],
        'last_name' => ['sometimes', 'string', 'max:255'],
        'email' => ['sometimes', 'string', 'max:255'],
        'password' => ['sometimes', 'string', 'max:255'],
        'avatar' => ['sometimes', 'image' => 'mimes:jpg,jpeg,bmp,svg,png,gif', 'max:5000' ]
        ]);
    }


    /**
    * Register user for provider.
    *
    * @return void
    */
    public function registerInvitation(Request $request){

        $this->validator($request->all())->validate();

        $user =  User::create([
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
    }
