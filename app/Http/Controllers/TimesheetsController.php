<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timesheet;
use App\User;
use Auth;
use Session;
use DB;
class TimesheetsController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return abort(404);
    }

    public function store(Request $request){
        $data = $request->validate([
            'beneficiary'=>'required',
            'serviceline_id'=>'required',
            'task_id'=>'nullable',
            'activity_date'=>'required',
            'duration'=>'required',
            'activity_description'=>'required'
        ]);
            
        foreach($request->activity_date as $key => $value){

            $data = array(
                'user_id'=>Auth::user()->id,
                'beneficiary' => $request->beneficiary,
                'serviceline_id' => $request->serviceline_id,
                'task_id' =>  $request->task_id,
                'activity_date' =>  $request->activity_date[$key],
                'duration' =>  $request->duration[$key],
                'activity_description' => $request->activity_description,
                'created_by'=>Auth::user()->id,
                'created_at'=>now()
            );

           Timesheet::insert($data);
        }
        return ['Record added successfully!'];
    }
    public function show($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        return response()->json($timesheet);
    }

    public function edit(Timesheet $timesheet,Request $request)
    {
        
        return response()->json($timesheet);
    }
    
    public function update(Timesheet $timesheet,Request $request )
    {
        $data = $request->validate([
            'beneficiary'=>'required',
            'serviceline_id'=>'required',
            'activity_date'=>'required|date',
            'duration'=>'required',
            'activity_description'=>'required'
        ]);
            
        foreach($request->activity_date as $key => $value) {
            $data = array(
                'beneficiary' => $request->beneficiary,
                'serviceline_id' => $request->serviceline_id,
                'activity_date' =>  $request->activity_date[$key],
                'duration' =>  $request->duration[$key],
                'activity_description' => $request->activity_description,
                'updated_by'=>Auth::user()->id,
                'updated_at'=>now()
            );

            $timesheet->where('user_id', Auth::user()->id)->update($data); 
        }
        return ['Your record was updated!'];
    }
    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();
    }
}
