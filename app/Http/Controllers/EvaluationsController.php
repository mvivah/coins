<?php

namespace App\Http\Controllers;
use App\Evaluation;
use Auth;
use Illuminate\Http\Request;

class EvaluationsController extends Controller
{
    public function index()
    {
        abort('404');
    }

    public function create()
    {
        abort('404');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        "evaluationable_id"    => "required",
        "evaluationable_type"  => "required|string",
        "exceptional_tasks"    => "required|string",
        "results_achieved"  => "required|string",
        "challenges_faced"  => "required|string",
        "improvement_plans"  => "required|string",
        ]);
        
        $evaluation = Evaluation::create([
            'evaluationable_id' => $data['evaluationable_id'],
            'evaluationable_type' => $data['evaluationable_type'],
            'exceptional_tasks' => $data['exceptional_tasks'],
            'results_achieved' => $data['results_achieved'],
            'challenges_faced' => $data['challenges_faced'],
            'improvement_plans' => $data['improvement_plans'],
            'user_id' => Auth::user()->id,
        ]);
        
        if($evaluation){
            return ['Information saved successfully'];
        }else{
            return ['Failed to save information'];
        }
    }

    public function show($id)
    {
        abort('404');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        abort('404');
    }
}
