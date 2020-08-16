<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isProject_manager'))
            $projects = Project::with('users')->get();
        return response()->json($projects);
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
            'project_name' => 'unique:projects|required|string|max:255',
            'project_description' => 'required|string|max:255',
            'project_manager' => 'required|integer',

        ]);
//        return User::create($validatedData);
        Project::create([
            'project_name' => $request['project_name'],
            'project_description' => $request['project_description'],
            'project_manager' => $request['project_manager'],
            ]);
        $project_manager = $request['project_manager'];
        $project_name = $request['project_name'];
        $project = DB::table('projects')->where('project_name',$project_name)->select('id')->first();
        $project_id = $project->id;
        return DB::table('project_user')->insert(['user_id' => $project_manager,'project_id' => $project_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
