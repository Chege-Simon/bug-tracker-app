<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Project;
use App\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use \Illuminate\Http\Response;

class AttachmentController extends Controller
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
        $files = Attachment::all();
        return response()->json($files);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $allFiles = Attachment::all();
        $fileName = time().'-'.$request->file->getClientOriginalName();
        $fileType = $request->file->getClientOriginalExtension();
        $fileSize = $request->file->getSize();
        $project_id =  $request->posted_for;

        $request->file->move(public_path('upload'), $fileName);
        Attachment::create([
            'posted_for' => $project_id,
            'file' => $fileName,
            'file_type'=>$fileType,
            'file_size'=>$fileSize
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
        $file = Attachment::findOrFail($id);
        $myFile = public_path('upload').'/'.$file->file;
        $headers = array(
            'Content-Type: application/pdf',
            );
//        $headers = ('Content-Type', $file->file_type);
        return Response::download($myFile);
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
        $file = Attachment::findOrFail($id);
        $myFile = public_path('upload').'/'.$file->file;
        if (is_file($myFile)) {
            if(unlink($myFile)){
                $file->delete();
                return ['message' => 'File Deleted'];
            }
        }
    }
}
