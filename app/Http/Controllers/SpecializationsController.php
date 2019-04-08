<?php

namespace App\Http\Controllers;
use Auth;
use App\Specialization;
use Illuminate\Http\Request;

class SpecializationsController extends Controller
{
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
    public function getSpecilization(Request $request)
    {    
        return Specialization::where('expertise_id','=',$request->expertise)->get();
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
            "expertise_id"    => "required",
            "specialization"  => "required",
        ]);

        //save the validated data
        foreach($request->specialization as $key => $value) {
            $data = [
                'expertise_id' => $data['expertise_id'], 
                'specialization' =>  $request->specialization[$key],
                'created_by'=>Auth::user()->id,
                'created_at'=>now()
            ];
            Specialization::insert($data); 
        }
        return ['Targets successfully added'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Specialization::findOrFail($id); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Specialization $Specialization, Request $request)
    {
        $data = $request->validate([
            "expertise_id"    => "required",
            "specialization"  => "required",
        ]);

        $Specialization->update([
            'specialization' => $data['specialization'],
            'updated_by'=>Auth::user()->id
        ]);
        return ['Specialization updated successfully'];
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
