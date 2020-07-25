<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{
    protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('guest:developer')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login.developer');
    }
    protected function guard()
    {
        return Auth::guard('developer');
    }
}
