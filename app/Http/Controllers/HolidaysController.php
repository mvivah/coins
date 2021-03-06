<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Holiday;
use Auth;
class HolidaysController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        abort('404');
    }

    public function create()
    {
        return Holiday::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Holiday::create(request()->validate(
            [
                'holiday'=>'required',
                'holiday_date'=>'required',
                'created_by'=>Auth::user()->id
            ]
        ));
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
        $holiday = Holiday::findOrFail($id);
        return response()->json($holiday);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return $holiday;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        $data = $request->validate([
            "holiday"    => "required|string",
            "holiday_date"  => "required|string",
        ]);
        $holiday->update([
            'holiday' => $data['holiday'],
            'holiday_date' => $data['holiday_date'],
            'updated_by'=>Auth::user()->id
        ]);

        return ['Holiday update successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
    }
}
