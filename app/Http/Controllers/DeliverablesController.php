<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Deliverable;
use App\DeliverableOpportunity;
use App\DeliverableProject;
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
            'deliverable_completion'=>'required|date|after:tomorrow',
        ]);
        
        Deliverable::create([
            'project_id' => $data['project_id'],
            'deliverable_name' => $data['deliverable_name'],
            'deliverable_status' => $data['deliverable_status'],
            'deliverable_completion' => $data['deliverable_completion'],
            'created_by'=>Auth::user()->id
        ]);
        return ['Deliverable created successfully'];
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
            'deliverable_completion'=>'required|date|after:tomorrow',
        ]);
        $deliverable->update([
            'deliverable_name' => $data['deliverable_name'],
            'deliverable_status' => $data['deliverable_status'],
            'deliverable_completion' => $data['deliverable_completion'],
            'updated_by'=>Auth::user()->id
        ]);
        return ['Deliverable updated successfully'];
    }

    public function pickdeliverables(Request $request){
        if(!$request->id)
        {
            
            return Deliverable::where(['deliverable_type'=>$request->deliverable_type])->get(['id','deliverable_name']);
        
        }else{
            if($request->deliverable_type =='Opportunity'){

                return DeliverableOpportunity::where(['deliverable_id'=>$request->id])->get(['id','deliverable_id','deliverable_status','deliverable_completion']);
            
            }else{

                return DeliverableProject::where(['deliverable_id'=>$request->id])->get(['id','deliverable_id','deliverable_status','deliverable_completion']);
            }
        }
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

    public function deriverableOpportunities(Request $request){
        $oid = $request->opportunity_id;
        $pid  = $request->project_id;
        if(!$request->project_id){

            $data = $request->validate([
                'opportunity_id'=>'required',
                'deliverable_id'=>Rule::unique('deliverable_opportunity')->where(function($query) use($oid) {
                    return $query->where('opportunity_id',$oid);
                }),
                'deliverable_status'=>'required',
                'deliverable_completion'=>'required|date|after:today',
            ]);

            DeliverableOpportunity::firstOrCreate([
                'opportunity_id' => $data['opportunity_id'],
                'deliverable_id' => $data['deliverable_id'],
                'deliverable_status' => $data['deliverable_status'],
                'deliverable_completion' => $data['deliverable_completion'],
                'created_by'=>Auth::user()->id,
            ]);

        }else{

            $data = $request->validate([
                'project_id'=>'required',
                'deliverable_id'=>Rule::unique('deliverable_project')->where(function ($query) use($pid) {
                    return $query->where('project_id', $pid);
                }),
                'deliverable_status'=>'required',
                'deliverable_completion'=>'required|date|after:today',
            ]);

            DeliverableProject::create([
                'project_id' => $data['project_id'],
                'deliverable_id' => $data['deliverable_id'],
                'deliverable_status' => $data['deliverable_status'],
                'deliverable_completion' => $data['deliverable_completion'],
                'created_by'=>Auth::user()->id,
            ]);

        }

        return ['Deliverable added successfully'];
    }

    public function deriverablesUpdate(Request $request, DeliverableOpportunity $deliverableopportunity, DeliverableProject $deliverableProject){
        
        if(!$request->project_id){

            $data = $request->validate([
                'deliverable_id'=>'required',
                'opportunity_id'=>'required',
                'deliverable_status'=>'required',
                'deliverable_completion'=>'required|date',
            ]);

            if($deliverableopportunity->update([
                'deliverable_id' => $data['deliverable_id'],
                'deliverable_status' => $data['deliverable_status'],
                'deliverable_completion' => $data['deliverable_completion'],
                'updated_by'=>Auth::user()->id
            ])){
                return $request;
            }else{
                return ['Failed'];
            }

        }else{
            $data = $request->validate([
                'deliverable_id'=>'required',
                'project_id'=>'required',
                'deliverable_status'=>'required',
                'deliverable_completion'=>'required|date',
            ]);

            $deliverableProject->update([
                'deliverable_id' => $data['deliverable_id'],
                'deliverable_status' => $data['deliverable_status'],
                'deliverable_completion' => $data['deliverable_completion'],
                'updated_by'=>Auth::user()->id
            ]);
        }

        return ['Deliverable updated successfully'];
    }
}
