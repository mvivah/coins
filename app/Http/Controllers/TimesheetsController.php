<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timesheet;
use App\User;
use Auth;
use Session;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $evaluations = Evaluation::where( 'user_id', '=', Auth::user()->id )->get();
        return view('timesheets.create', compact('categories','evaluations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //validate the received data
        $data = $request->validate([
            'beneficiary'=>'required',
            'serviceline_id'=>'required',
            'om_number'=>'nullable',
            'activity_date'=>'required',
            'duration'=>'required',
            'activity_description'=>'required'
        ]);
            
        foreach($request->activity_date as $key => $value) {
            $data = array(
                'user_id'=>Auth::user()->id,
                'beneficiary' => $request->beneficiary,
                'serviceline_id' => $request->serviceline_id,
                'om_number' => $request->om_number,
                'activity_date' =>  $request->activity_date[$key],
                'duration' =>  $request->duration[$key],
                'activity_description' => $request->activity_description,
                'created_at'=>now()
            );
            Timesheet::insert($data); 
        }
    return ['Your record was added!'];
    //return $request;
    }

    public function storeEvaluations(Request $request){

        //validate the received data
        $data = $request->validate([
            'activity_desc'=>'required',
            'intended_objective'=>'required',
            'strength_demonstrated'=>'required',
            'improvement_points'=>'required',
            'personal_rating'=>'required',
        ]);
        $status = 'Draft';
        //saveResponses the validated data
        Evaluation::create([
            'activity_desc' => $data['activity_desc'],
            'intended_objective' => $data['intended_objective'],
            'strength_demonstrated' => $data['strength_demonstrated'],
            'improvement_points' => $data['improvement_points'],
            'personal_rating' => $data['personal_rating'],
            'user_id'=>Auth::user()->id,
            'status'=>$status,
        ]);
        return redirect('timesheets')->with('success', 'Your record was added successfully');
    }

    public function supervisorComments(Request $request, Evaluation $evaluation){

        Timesheet::update(request()->validate([
            'supervisor_rating'=>'required',
            'supervisor_comment'=>'required',
            'supervisor_id'=>Auth::user()->id
        ]));

        return NULL;
    }
    
    public function directorComments(Request $request, Evaluation $evaluation){

        $status = 'Approved';
        Timesheet::update(request()->validate([
            'director_comment'=>'required',
            'director_id'=>Auth::user()->id,
            'status'=>$status
        ]));

        return NULL;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timesheet = Timesheet::find($id);
        return response()->json($timesheet);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(timesheet $timesheet)
    {
        
        return response()->json($timesheet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,timesheet $timesheet)
    {
     
        $data = $request->validate([
            'serviceline_id'=>'required',
            'beneficiary'=>'required',
            'activity_date'=>'required',
            'duration'=>'required',
            'om_number'=>'nullable',
            'activity_description'=>'required'
        ]);
        
        foreach($request->activity_date as $key => $value) {
            $data = array(
                'user_id'=>Auth::user()->id,
                'serviceline_id' => $request->serviceline_id,
                'beneficiary' => $request->beneficiary,
                'om_number' => $request->om_number,
                'activity_date' =>  $request->activity_date[$key],
                'duration' =>  $request->duration[$key],
                'activity_description' => $request->activity_description,
                'created_at'=>now()
            );
            $timesheet->update($data); 
        }
        return ['Timesheet updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(timesheet $timesheet)
    {
        $timesheet->delete();
    }
}
