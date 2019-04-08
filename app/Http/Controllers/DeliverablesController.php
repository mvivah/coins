<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deliverable;
use Auth;
class DeliverablesController extends Controller
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
        //
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
        $data = $request->validate([
            'project_id'=>'required',
            'deliverable_name'=>'required',
            'deliverable_status'=>'required',
            'deliverable_completion'=>'required|date',
        ]);
        
        Deliverable::create([
            'project_id' => $data['project_id'],
            'deliverable_name' => $data['deliverable_name'],
            'deliverable_status' => $data['deliverable_status'],
            'deliverable_completion' => $data['deliverable_completion'],
            'created_by'=>Auth::user()->id
        ]);
        return ['Success'=>'Deliverable created successfully'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deliverable = Deliverable::findOrFail($id);
        return $deliverable;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Deliverable $deliverable)
    {
        return $deliverable;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deliverable $deliverable)
    {
        $data = $request->validate([
            'deliverable_name'=>'required',
            'deliverable_status'=>'required',
            'deliverable_completion'=>'required|date',
        ]);
        $deliverable->update([
            'deliverable_name' => $data['deliverable_name'],
            'deliverable_status' => $data['deliverable_status'],
            'deliverable_completion' => $data['deliverable_completion'],
            'updated_by'=>Auth::user()->id
        ]);
        return ['Deliverable updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deliverable $deliverable)
    {
        $deliverable->delete();
    }
}
