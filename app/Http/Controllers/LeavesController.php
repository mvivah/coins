<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave;
use App\Holidays;
use App\Leaveforwards;
use App\Leavesettings;
use App\Notifications\LeaveApplied;
use App\Notifications\leave_statusChange;
use Session;
use Auth;
use DB;
class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return abort(404);

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'leavesetting_id'=>'required',
            'start_date'  => 'required|date|after:tommorrow',
            'end_date'    => 'required|date|after:start_date',
            'leave_detail'=>'required',
            'duration'=>'required',
            'leave_status'=>'required'
            ]);
        Leave::create([
            'leavesetting_id'=> $data['leavesetting_id'],
            'start_date'=> $data['start_date'],
            'end_date'=> $data['end_date'],
            'leave_detail'=>$data['leave_detail'],
            'duration'=>$data['duration'],
            'leave_status'=>$data['leave_status'],
            'created_by'=>Auth::user()->id
        ]);
        return redirect('profile')->with('success', 'Information has been added');
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
        $leave = Leave::findOrFail($id);
        return($leave);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, Leave $leave)
    {
        $id = $request->id;
        $updated = Leave::where('id', $id)->update(['status' => $request->status]);
        if($updated){
            return("Leave ".$status);
        }else{
            return("Leave status Change failed");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        $leave->delete();
    }
}
