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
    public function index(Request $request)
    {
        $statuses = Status::pluck('name','id');
        $provider = Auth::user()->provider;
        $users = $this->userRepository->paginate($perPage = 20, $request->search, $request->status);

        // $users = $this->userRepository->all();

        return view('user.list', compact('users','provider','statuses'));
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

        $countries = Country::pluck( 'name','id');
        $statuses = Status::pluck( 'name','id');
        $roles = Role::pluck('name','id');

        $level = $request->level;
        $customer_id = $request->customer_id;

        return view('user.add', compact('user','countries','statuses','level','customer_id','roles'));

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $userequest
    * @return \Illuminate\Http\Response
    */
//     public function store(Request $request)
//     {


//         $validate = $this->validator($request->all())->validate();

//         switch ($this->getUserLevel()) {
//             case config('app.super_admin'):
//                 $id = Auth::User()->id;
//                 $mainUser = $this->userRepository->create($validate, config('app.super_admin'), $id);
//             break;
//             case config('app.provider'):
//                 $id = Auth::user()->provider;

//                 $mainUser = $this->userRepository->create($validate, $request->level, $id);
//             break;

//             default:
//             # code...
//         break;
//     }



//     // $customer = Customer::where('id', $request->customer_id)->first();
//     // $mainUser = $this->userRepository->create($validate, $request->level, $id);


//     return redirect()->route('user.index')->with('success', ucwords(trans_choice('messages.user_created_successfully', 1)) );

// }

    /**
    * Display the specified resource.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {

        $roles = Role::get();

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
        $countries = Country::pluck( 'name','id');
        $statuses = Status::pluck( 'name','id');
        $roles = Role::pluck('name','id');
        // $socialLogins = $this->users->getUserSocialLogins($user->id);
        $u = auth()->user();
        // $roles = Role::where('order',$u->getRole())->orWhere('order', 5)->pluck('name','id');

        return view('user.edit',compact('edit', 'user','countries','roles','statuses'));
    }

    public function updatelogin(Request $request, User $user){

        $data = $request->all();
        DB::beginTransaction();

        if (! $data['password']) {
            unset($data['password']);
            unset($data['password_confirmation']);
            $user->email           = $request->input('email');
            $user->username        = $request->input('username');
            $user->update();
        }else{

            $user->email           = $request->input('email');
            $user->username        = $request->input('username');
            $user->password        = Hash::make($request->input('password'));
            $user->update();

        }

            // $user->email           = $request->input('email');
            // $user->username        = $request->input('username');
            // $user->update();
        DB::commit();
            //    $tt = $user->update([$user->id = $data]);

        return redirect()->back()->with('success', 'User Updated succesfully');


    }

    public function updatedetails(Request $request, User $user){

        $this->user->update(auth()->id(), $request->except('role_id', 'status'));


        return redirect()->back()->with('success', 'User Updated succesfully');


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

        // $user = User::findOrFail($user->id);
        // $role = Role::findOrFail($request->role_id);
        // $validate = $this->validator($request->all())->validate();

        try {
            DB::beginTransaction();

            if(request()->has('avatar')){
                $avataruploaded = request()->file('avatar');
                $avatarname = time() . '.' . $avataruploaded->getClientOriginalExtension() ;
                $avatarpath = public_path('/images/profile/');
                $avataruploaded->move($avatarpath, $avatarname);


                $user->email            = $request->input('email');
                $user->name             = $request->input('name');
                $user->last_name        = $request->input('last_name');
                $user->socialite_id     = $request->input('socialite_id');
                $user->address          = $request->input('address');
                $user->city             = $request->input('city');
                $user->phone            = $request->input('phone');
                $user->state            = $request->input('state');
                $user->country_id       = $request->input('country_id');
                $user->postal_code      = $request->input('postal_code');
                $user->avatar           = '/images/profile/' . $avatarname;

                $user->update();
                DB::commit();
                // $user->password         = Hash::make($request->input('password'));

                return redirect()->back()->with('success', 'User Updated succesfully');

            }

            $user->email            = $request->input('email');
            $user->name             = $request->input('name');
            $user->last_name        = $request->input('last_name');
            $user->socialite_id     = $request->input('socialite_id');
            $user->address          = $request->input('address');
            $user->city             = $request->input('city');
            $user->phone            = $request->input('phone');
            $user->state            = $request->input('state');
            $user->country_id       = $request->input('country_id');
            $user->postal_code      = $request->input('postal_code');
            $user->update();
            // $user->password      = Hash::make($request->input('password'));

            DB::commit();
            return redirect()->back()->with('success', 'User Updated succesfully');

        } catch (\PDOException $e) {

            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "errors.user_already_exists";
            } else {
                $errorMessage = $e->getMessage();
            }
            return redirect()->back()->with('danger', $errorMessage );

        }

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
                $errorMessage = $e->getMessage();
            }
            return redirect()->back()->with('danger', $errorMessage );

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
        return Validator::make($data,
        [
            'email'         => ['sometimes', 'email', 'max:255'],
            'address'       => ['sometimes', 'string', 'max:255'],
            'address_2'     => ['sometimes', 'string', 'max:255'],
            'country_id'    => ['sometimes', 'integer', 'min:1'],
            'city'          => ['sometimes', 'string', 'max:255'],
            'state'         => ['sometimes', 'string', 'max:255'],
            'postal_code'   => ['sometimes', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
            'status'        => ['sometimes', 'integer', 'exists:statuses,id'],
            'role_id'       => ['sometimes', 'integer', 'exists:roles,id'],
            'name'          => ['sometimes', 'string', 'max:255'],
            'last_name'     => ['sometimes', 'string', 'max:255'],
            'phone'         => ['sometimes', 'string', 'max:20'],
            'email'         => ['sometimes', 'string', 'max:255'],
            'socialite_id'  => ['sometimes', 'string', 'max:255'],
            'password'      => ['sometimes', 'string', 'max:255'],
            'avatar'        => ['sometimes', 'image' => 'mimes:jpg,jpeg,bmp,svg,png,gif', 'max:5000' ]
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
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'address_2' => $request['address_2'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'user_level_id' => "3"
            ]);


            return view('home');
        }
    }
