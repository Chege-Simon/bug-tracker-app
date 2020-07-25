<?php

namespace App\Http\Controllers\Auth\Login;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController as DefaultLoginController;

class AdminController extends DefaultLoginController
{
    protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login.admin');
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
