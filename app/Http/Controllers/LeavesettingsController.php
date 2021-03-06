<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leavesetting;
use Session;
use Auth;
class LeavesettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        abort('404');

    }

    public function store(Request $request)
    {
        Leavesetting::create(request()->validate(
            ['leave_type'=>'required',
            'annual_lot'=>'required',
            'bookable_days'=>'required',
           'created_by'=>Auth::user()->id]
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leavesetting = Leavesetting::findOrFail($id);
        return $leavesetting;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Leavesetting $leavesetting)
    {
        return response()->json($leavesetting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Leavesetting $leavesetting)
    {
        $data = $request->validate([
            'leave_type'=>'required',
            'annual_lot'=>'required',
            'bookable_days'=>'required'
        ]);
        $leavesetting->update([
            'leave_type' => $data['leave_type'],
            'annual_lot' => $data['annual_lot'],
            'bookable_days' => $data['bookable_days'],
            'updated_by'=>Auth::user()->id
        ]);
        return ['Leave settings updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leavesetting $leavesetting)
    {
        $leavesetting->delete();
    }
}
