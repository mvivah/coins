<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Serviceline;
use Session;
use Auth;
class ServicelinesController extends Controller
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
            "service_beneficiary" => "required|string",
            "service_code"  => "required|string",
            "service_name" => "required|string",
        ]);
        //save the validated data
        Serviceline::create([
            'beneficiary' => $data['service_beneficiary'],
            'service_code' => $data['service_code'],
            'service_name' => $data['service_name'],
            'created_by'=>Auth::user()->id
        ]);

        return NULL;
    }

    public function getServicelines(Request $request){
        return Serviceline::where(['beneficiary'=>$request->beneficiary])->get();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Serviceline $serviceline)
    {
        return response()->json($serviceline);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Serviceline $serviceline)
    {
        $data = $request->validate([
            "service_beneficiary" => "required|string",
            "service_code"  => "required|string",
            "service_name" => "required|string",
        ]);
        
        $serviceline->update([
            'beneficiary' => $data['service_beneficiary'],
            'service_code'=>$data['service_code'],
            'service_name'=>$data['service_name'],
            'updated_by'=>Auth::user()->id]);
        return ['Serviceline updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serviceline $serviceline)
    {
        $serviceline->delete();
    }
}
