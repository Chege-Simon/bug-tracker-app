<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/registration', function () {
    return view('auth.registration');
});

Route::get('/register/admin', function () {
    return view('auth.register.admin');
});

Route::get('/register/user', function () {
    return view('auth.register.user');
});

Route::get('/register/developer', function () {
    return view('auth.register.developer');
});

Route::get('/register/project_manager', function () {
    return view('auth.register.project_manager');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('{path}','HomeController@index')->where( 'path', '([A-z]+)?' );


Route::prefix('admin')
    ->as('admin.')
    ->group(function() {
        Route::get('home', 'Home\AdminHomeController@index')->name('home');
        Route::namespace('Auth\Login')
            ->group(function() {
                Route::get('login', 'AdminController@showLoginForm')->name('login');
                Route::post('login', 'AdminController@login')->name('login');
                Route::post('logout', 'AdminController@logout')->name('logout');
            });
    });

Route::prefix('project_manager')
    ->as('project_manager.')
    ->group(function() {
        Route::get('home', 'Home\Project_managerHomeController@index')->name('home');
        Route::namespace('Auth\Login')
            ->group(function() {
                Route::get('login', 'Project_managerController@showLoginForm')->name('login');
                Route::post('login', 'Project_managerController@login')->name('login');
                Route::post('logout', 'Project_managerController@logout')->name('logout');
            });
    });

Route::prefix('developer')
    ->as('developer.')
    ->group(function() {
        Route::get('home', 'Home\DeveloperHomeController@index')->name('home');
        Route::namespace('Auth\Login')
            ->group(function() {
                Route::get('login', 'DeveloperController@showLoginForm')->name('login');
                Route::post('login', 'DeveloperController@login')->name('login');
                Route::post('logout', 'DeveloperController@logout')->name('logout');
            });
    });
