<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Auth;
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
        $projects = Project::with('users')->with('tickets')->get();
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
            'project_name' => 'unique:projects|required|string|max:1000',
            'project_description' => 'required|string|max:5000',
            'project_manager' => 'required|integer',

        ]);
        $maker = Auth::user()->id;
        Project::create([
            'project_name' => $request['project_name'],
            'project_description' => $request['project_description'],
            'project_manager' => $request['project_manager'],
            'owner' => $request['owner'],
            'created_by' => $maker,
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

//        $project = Project::findOrFail($id);
        $project = Project::with('tickets')->with('issues')->find($id);
        return response()->json($project);
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
        $project=Project::findOrFail($id);
        $this->validate($request,[

            'owner' => 'string|max:255',
            'project_name' => 'string|max:255',
            'project_description' => 'string|max:5000',
        ]);
        $project->update($request->all());
        $project->where('id',$id)->update(['status'=> $request->project_status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return ['message' => 'Project Deleted'];
    }
}
