<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Target;
use App\TargetTeam;
use Auth;
use Gate;
class TargetsController extends Controller
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

        abort(404,"Sorry, You cannot access this page");
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
            "team_id"=> "required",
            "target_category"=>"required",
            "target_name"=> "required",
            "target_value"=> "required",
            "target_period"=> "required",
            "assessable"=> "required",
        ]);

        $target = Target::create([
            "target_category"=>$data['target_category'],
            'target_name'=> $data['target_name'],
            'target_value'=> $data['target_value'],
            'target_period'=> $data['target_period'],
            'assessable'=>$data['assessable'],
            'created_by'=>Auth::user()->id
        ]);

        foreach($request->team_id as $key => $value) {
            $data = [
                'team_id' => $request->team_id[$key], 
                'target_id' =>  $target->id,
                'created_by'=>Auth::user()->id,
                'created_at'=>now()
            ];
            TargetTeam::insert($data); 
        }
        return ['Targets successfully added'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($team)
    {
        $period = date('Y');
        $targets = Target::where(['target_period'=>$period,'assessable'=>1])
                        ->join('target_teams', 'target_teams.target_id', '=', 'targets.id')
                        ->where('target_teams.team_id', '=', $team)
                        ->get(['targets.id as id','targets.target_name as name']);
        return $targets;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Target::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Target $target)
    {
        $data = $request->validate([
            "team_id"=> "required",
            "target_category"=>"required",
            "target_name"=> "required",
            "target_value"=> "required",
            "target_period"=> "required",
            "assessable"=> "required",
        ]);

        $run = $target->update([
            "target_category"=>$data['target_category'],
            'target_name'=> $data['target_name'],
            'target_value'=> $data['target_value'],
            'target_period'=> $data['target_period'],
            'assessable'=>$data['assessable'],
            'updated_by'=>Auth::user()->id
        ]);
        if(!$run){
            return ['Update Failed'];
        }
        else{
            return ['Target Updated successfully'];
        }
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
