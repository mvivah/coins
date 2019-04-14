<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Team;
use App\User;
use App\Target;
use App\Assessment;
use App\TaskUser;
use DB;
use Session;
use Gate;
use Auth;
class TeamsController extends Controller
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
    public function assessmentSummary($team)
    {
        $users = User::where(['team_id'=>$team]);
        $assessments = [];
        $assessQuality =  $assessQuantity = $assessBusiness = $assessPersonal = $assessTeam = $index = 0;
        foreach($users as $user ):
            $assessments[$index]['user'] = $user->name;

            $result = Assessment::where(['user_id' => $user->id])->get();
            //$assessments[$index]['result'] = $result;
        endforeach;
        // dd($assessments);
    }

    public function timesheetSummary($id)
    {
        $personal_targets = Assessment::where('user_id',$id)->get();
        // $timesheets = [];
        // $index = 0;
        //     $timesheets[$index]['user'] = $id;
        //     foreach(['Proposal','EOI','Pre-Qualification'] as $type):
        //         $timesheets = TaskUser::where(['user_id' => $id])->get();
        //     endforeach;
        return $personal_targets;
    }

    public function opportunitySummary($team)
    {
        $users = User::where(['team_id'=>$team]);
        $summary = [];
        $index = 0;
        foreach( $users as $user ):
            $summary[$index]['user'] = $user->name;
            foreach( ['Proposal','EOI','Pre-Qualification'] as $type ):
                foreach( ['Identified','Qualified','Prepared','Submitted','Won'] as $stage ):
                    $opportunities = DB::table('opportunities')
                                ->join('opportunity_user','opportunity_user.opportunity_id','=','opportunities.id')
                                ->where(['opportunities.type'=>$type,'opportunities.sales_stage'=>$stage,'opportunity_user.user_id' => $user->id])
                                ->get();
                    $stage = strtolower(implode(explode(' ',$stage),''));
                    $summary[$index][$type][$stage] = $opportunities->count();
                endforeach;
            endforeach;
            $index +=1;
        endforeach;
        return $summary;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'team_name'=>'required',
            'team_code'=>'required',
            'team_leader'=>'nullable'
        ]);

        $team = Team::create([
            'team_name' => $data['team_name'],
            'team_code'=>$data['team_code'],
            'team_leader' => $data['team_leader'],
            'created_by'=>Auth::user()->id
        ]);

        return ['Team Created successfully'];
    }

    public function show($id)
    {
        $team = Team::findOrFail($id);
        $users = User::where('team_id',$id)->get();
        $user_data = [];
        // foreach($team->users as $user){
        //     // $assessments = Target::selectRaw("targets.target_category AS category,assessments.assessment_score/targets.target_value*100 AS score")
        //     //                     ->join('assessments', 'assessments.target_id', '=', 'targets.id')
        //     //                     ->where(['assessments.user_id' => $user->id])
        //     //                     ->groupBy("category")
        //     //                     ->get();
        //     //$assessments = DB::SELECT("SELECT targets.target_category AS category, assessments.assessment_score/targets.target_value*100 AS score FROM assessments JOIN targets ON assessments.target_id = targets.id  WHERE assessments.user_id =$user->id  GROUP BY category");
        //     $timesheets = $this->timesheetSummary( $user->id);
        //     array_push($user_data,[
        //         $timesheets
        //    ]); 
        // }
        return view('teams.show', compact('team','users'));
        // return view('teams.show', compact('opportunities','assessments','timesheets'));
        // return view('teams.show', compact('opportunities','assessments','timesheets'));
        // return view('teams.show', compact('opportunities','assessments','timesheets'));
    }

    public function edit(Team $team)
    {
        return response()->json($team);
    }

    public function update(Request $request,Team $team)
    {
        $data = $request->validate([
            'team_name'=>'required',
            'team_code'=>'required',
            'team_leader'=>'required',
        ]);
        
        $team->update([
            'team_name' => $data['team_name'],
            'team_code'=>$data['team_code'],
            'team_leader'=>$data['team_leader'],
            'updated_by'=>Auth::user()->id
        ]);
        return ['Team updated successfully'];
    }

    public function getteamleader(Team $team){
        if($team->team_leader != null){
            return [$team->team_leader];
        }else{
            return [];
        }

    }

    public function destroy(Team $team)
    {
        $team->delete();
    }
}
