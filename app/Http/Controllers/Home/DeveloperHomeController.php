<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeveloperHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:developer');
    }
    public function index()
    {
        return view('home');
    }
}
