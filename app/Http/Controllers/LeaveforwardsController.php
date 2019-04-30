<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leaveforward;
use Session;
use Auth;
class LeaveforwardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return abort('404');

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'=>'required',
            'previous_year'=>'required',
            'days_forwarded'=>'required',
        ]);

        Leaveforward::create([
            'user_id' => $data['user_id'],
            'previous_year' => $data['previous_year'],
            'days_forwarded' => $data['days_forwarded'],
            'days_left' => $data['days_forwarded'],
            'created_by'=>Auth::user()->id
        ]);
        return ['Record created successfully'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Leaveforward = Leaveforward::where(['user_id'=>$id])->get();
        return $Leaveforward;
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
    public function update(Request $request, Leaveforward $leaveforward)
    {
        $data = $request->validate([
            'user_id'=>'required',
            'previous_year'=>'required',
            'days_forwarded'=>'required',
        ]);
        Leaveforward::update([
            'user_id' => $data['user_id'],
            'previous_year' => $data['previous_year'],
            'days_forwarded' => $data['days_forwarded'],
            'updated_by'=>Auth::user()->id
        ]);
        return ['Record updated successfully'];
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
