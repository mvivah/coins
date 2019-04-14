<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TaskUser;
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

    public function show($id)
    {
        $taskuser = TaskUser::findOrFail($id);
        return response()->json($taskuser);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(timesheet $taskuser)
    {
        
        return response()->json($taskuser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(timesheet $taskuser)
    {
        $taskuser->delete();
    }
}
