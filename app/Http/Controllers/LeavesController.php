<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave;
use App\Holiday;
use App\Leaveforward;
use App\Leavesetting;
use App\Leavetracker;
use App\Notifications\LeaveApplied;
use App\Notifications\leave_statusChange;
use Session;
use Auth;
use DB;
class LeavesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return abort(404);

    }

    public function checkSettings($duration,$leaveType){

        $msg ='';
        $bookable = [];
        $settings = Leavesetting::where(['leave_type'=>$leaveType])->get(['bookable_days']);
        foreach($settings as $setting){
            array_push($bookable,$setting->bookable_days);
        }
        $bookable = $bookable[0];
        switch ($leaveType){
            case 'Annual':
                if( $duration > $bookable){
                    $msg .=' cannot exceed '.$bookable.' days'; 
                }else{
                    $msg .='Passed';
                }
                break;
            case 'Maternity':
                if( $duration != $bookable){
                    $msg .=' allows only '.$bookable.' days';
                }else{
                    $msg .='Passed';
                }
            break;
            case 'Paternity':
                if( $duration != $bookable){
                $msg .=' allows only '.$bookable.' days';
            }else{
                $msg .='Passed';
            }
            break;
            case 'Compassionate':
                if( $duration > $bookable){
                    $msg .='allows only '.$bookable.' days';
                }else{
                    $msg .='Passed';
                }
            break;
            default:
            $msg .='Passed';
        }
        return $msg;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'=>'required',
            'the_leavesetting'=>'required',
            'leave_start'  => 'required|date|after:tomorrow',
            'leave_end'    => 'required|date|after:leave_start',
            'leave_detail'=>'required',
            ]);

        $holidays = Holiday::get('holiday_date');
        $leave_start = strtotime($request->leave_start); 
        $leave_end = strtotime($request->leave_end);

        //Get all dates by name
        $leaveDays = [];
        for ($i=$leave_start; $i<=$leave_end; $i+=86400) {  
            array_push($leaveDays,date("Y-m-d", $i));
        }

        //Subtract weekends
        $leftDays = [];
        foreach ($leaveDays as $date){
            $day = date("D", strtotime($date));
            if($day != 'Sat' && $day != 'Sun'){
                array_push($leftDays,$date);
            }
        }
        //Calculate leave duration
        $array_dates = [];

        foreach($holidays as $holiday){

            array_push($array_dates,$holiday->holiday_date);

        }

        $result = array_diff($leftDays,$array_dates);

        $leave_duration = (int)sizeof($result);

        if($this->checkSettings($leave_duration,$request->leaveType) == 'Passed'){

            if($request->leaveType =='Annual'||$request->leaveType =='Annual Leave'){

                $forwards = Leaveforward::where(['user_id'=>$request->user_id])->get(['days_left']);

                $days_cforward = [];

                foreach($forwards as $forward){

                    array_push($days_cforward,$forward->days_left);
                }

                $days_cforward = (int)$days_cforward[0];

                if($days_cforward>0){

                    if( $days_cforward < $leave_duration ){

                        $forwarded_days_left = 0;

                    }else{

                        $forwarded_days_left = $days_cforward - $leave_duration;

                    }
                }else{
                    return ['Found nothing'];
                }

                $update_leave_forward = Leaveforward::where(['user_id'=>$request->user_id])
                                                    ->update([
                                                        'days_taken'=> $leave_duration,
                                                        'days_left'=> $forwarded_days_left,
                                                        'created_by'=>Auth::user()->id
                                                    ]);
            }
            else{
            }
            
            if( $request->user_id != Auth::user()->id && Auth::user()->level != 'Consultant'){
                $leave_status = 'Confirmed';
            }
            else{
                $leave_status = 'Pending';
            }

            $save_leave = Leave::create([
                'user_id'=> $data['user_id'],
                'leavesetting_id'=> $data['the_leavesetting'],
                'leave_start'=> $data['leave_start'],
                'leave_end'=> $data['leave_end'],
                'leave_detail'=>$data['leave_detail'],
                'duration'=>$leave_duration,
                'leave_status'=>$leave_status,
                'created_by'=>$request->user_id
            ]);

            // Leavetracker::create([
            //     'user_id'=> $data['the_leavesetting'],
            //     'leavesetting_id'=> $data['leave_start'],
            //     'leave_year'=> date('Y'),
            //     'days_taken'=> $data['leave_end'],
            //     'days_left'=>$data['leave_detail'],
            //     'created_by'=>Auth::user()->id
            // ]);
            if( $save_leave ){
                return ['success'];
            }
            else{
                return ['Failed'];
            }
        }else{
            return $request->leaveType.' leave'.$this->checkSettings($leave_duration,$request->leaveType);
        }

        return $request->leaveType;
        
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
