<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('projects')->with('tickets')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',

        ]);
//        return User::create($validatedData);
        return User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'role' => 'user',
            'email' => $request['email'],
            'password' => Hash::make('tracker2020'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);


        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);

        $this->validate($request,[
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $currentPhoto = $user->profile_pic;

        if($request->profile_pic != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr
                ($request->profile_pic, 0, strpos($request->profile_pic, ';')))
                [1])
                [1];

            \Image::make($request->profile_pic)->save(public_path('images/profile/').$name);
            $request->merge(['profile_pic' => $name]);

            $userPhoto = public_path('images/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }

        }

        $user->update($request->all());
//        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isSupreme');
        $user = User::findOrFail($id);

        //delete user
        $user->delete();
        return ['message' => 'User Deleted'];

    }

}
