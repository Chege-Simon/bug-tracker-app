<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Project_managerHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:project_manager');
    }
    public function index()
    {
        return view('home');
    }
}
