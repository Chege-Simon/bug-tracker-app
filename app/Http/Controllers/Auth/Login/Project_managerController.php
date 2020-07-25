<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Project_managerController extends Controller
{
    protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('guest:project_manager')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login.project_manager');
    }
    protected function guard()
    {
        return Auth::guard('project_manager');
    }
}
