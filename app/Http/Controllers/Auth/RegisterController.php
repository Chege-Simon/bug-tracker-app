<?php

namespace App\Http\Controllers\Auth;

use App\Developer;
use App\Http\Controllers\Controller;
use App\Project_manager;
use App\Providers\RouteServiceProvider;
use App\Admin;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        if (request()->role == 'admin') {
//            return Validator::make($data, [
//                'first_name' => ['required', 'string', 'max:255'],
//                'last_name' => ['required', 'string', 'max:255'],
//                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
//                'password' => ['required', 'string', 'min:8', 'confirmed'],
//            ]);
//        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data, Request $request)
    {
        if (request()->role == 'admin'){
//            $this->validate($request, [
//                'first_name' => ['required', 'string', 'max:255'],
//                'last_name' => ['required', 'string', 'max:255'],
//                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
//                'password' => ['required', 'string', 'min:8', 'confirmed'],
//            ]);
            return Admin::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'role' => 'Admin',
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }elseif (request()->role == 'developer'){
            $data = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:developers'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            return Developer::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'role' => 'Developer',
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }elseif (request()->role == 'project_manager') {
            $data = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:project_managers'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            return Project_manager::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'role' => 'Project Manager',
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }elseif (request()->role == 'user') {
            $data = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            return User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'role' => 'user',
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
}

}
