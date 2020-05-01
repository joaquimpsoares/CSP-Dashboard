<?php

namespace App\Http\Controllers\web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        // dd($users);


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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $userequest, User $user)
    {
        //
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
