<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/project', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/ticket', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/miscellaneous', function (Request $request) {
    return $request->user();
});


Route::apiResources(['user' => 'API\UserController']);
Route::apiResources(['project' => 'API\ProjectController']);
Route::apiResources(['miscellaneous' => 'API\MiscellaneousController']);
Route::apiResources(['ticket' => 'API\TicketController']);
Route::apiResources(['issues' => 'API\IssuesController']);
