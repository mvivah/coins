<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use App\User;
use App\Charts\ScoreChart;
use Session;
use Auth;
use Gate;
use DB;
class ScoresController extends Controller
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
        // if(!Gate::allows('isAdmin')){
        //     abort(404,"Sorry, You cannot access this page");
        // }

        //$scores = Score::all();
        $scores = Score::groupBy('opportunity_id')->get();
        return view('pages.scores',compact('scores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'opportunity_id' => 'required',
            'opening_date' => 'required|date',
            'firm_name' => 'required',
            'technical_score' => 'required',
            'financial_score' => 'required',
        ]);
        foreach($request->firm_name as $key => $value) {
            $data = array(
                'created_by'=>Auth::user()->id,
                'opportunity_id' => $request->opportunity_id, 
                'opening_date' =>  $request->opening_date,
                'firm_name' =>  $request->firm_name[$key],
                'technical_score' =>$request->technical_score[$key],
                'financial_score' =>$request->financial_score[$key],
                'created_at'=>now()
            );
            Score::insert($data); 
        }
         
        return redirect('opportunities')->with('success', 'Bid Scores added successfully');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $score)
    {
        //
    }
}
