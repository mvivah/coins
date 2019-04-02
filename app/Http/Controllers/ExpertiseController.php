<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expertise;
use App\Specialization;
use Auth;
class ExpertiseController extends Controller
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
    public function create()
    {
        //
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
            "field_name"    => "required|string|min:5|unique:expertises",
            "field_description"  => "required|string|min:15",
        ]);
        //save the validated data
        Expertise::create([
            'field_name' => $data['field_name'],
            'field_description' => $data['field_description'],
            'created_by'=>Auth::user()->id
        ]);
    }

    public function addSpecialization(Request $request)
    {
        return $request;
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Expertise $expertise)
    {
        return $expertise;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expertise $expertise)
    {
            //validate the received data
            $data = $request->validate([
            "field_name"    => "required|string|min:5",
            "field_description"  => "required|string|min:15",
        ]);
        //save the validated data
        $expertise->update([
            'field_name' => $data['field_name'],
            'field_description' => $data['field_description'],
            'updated_by'=>Auth::user()->id
        ]);

        return ['Expertise updated successfully'];
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
