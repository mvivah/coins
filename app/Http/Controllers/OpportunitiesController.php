<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Opportunity;
use App\Project;
use App\Team;
use App\Task;
use App\Contact;
use App\User;
use App\OpportunityUser;
use Carbon\Carbon;
use App\Notifications\OpportunityCreated;
use App\Notifications\OpportunityAssigned;
use App\Notifications\OpportunityWon;
use App\DeliverableOpportunity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use App\Charts\CoinChart;
use Session;
use Auth;
use DB;
use Gate;
class OpportunitiesController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }
    
    public function index(){

        $opportunities_stage = Opportunity::selectRaw("count('id') as opportunities,sales_stage" )
                                            ->whereMonth('created_at', now())
                                            ->orWhere('updated_at', now())
                                            ->groupBy("sales_stage")
                                            ->get();
        $stageData = [];
        $stageLables = [];
        foreach($opportunities_stage as $data){
            array_push($stageData,[
                    $data->opportunities
            ]); 
            array_push($stageLables,[
                $data->sales_stage
            ]);
        }

        $opportunity_stage = new CoinChart;
        $opportunity_stage->labels($stageLables);
        $colors = ['#229954','#BA4A00','#7DCEA0','#D1F2EB','#E8DAEF','#C0392B','#76D7C4','#117864','#E67E22','#AF7AC5'];
        $opps = $opportunity_stage->dataset('Opportunities per Sales stage', 'bar',$stageData);
        $opps->backgroundColor($colors);


        $opportunity_team = Opportunity::selectRaw("count('id') as opportunities,teams.team_code as team_code")
                                        ->join('teams', 'opportunities.team_id', '=', 'teams.id')
                                        ->whereMonth('opportunities.created_at', now())
                                        ->orWhere('opportunities.updated_at', now())
                                        ->groupBy("teams.team_code")
                                        ->get();
        $teamData = [];
        $teamLables = [];
        foreach($opportunity_team as $data){
            array_push($teamData,[
                    $data->opportunities
            ]); 
            array_push($teamLables,[
                $data->team_code
            ]);
        }
        $opportunity_team = new CoinChart;
        $opportunity_team->labels($teamLables);
        $opportunity_team->title('Opportunities per Team');
        $colors = ['#C0392B','#76D7C4','#117864','#E67E22','#AF7AC5','#D5F5E3','#D5DBDB','#7DCEA0','#D1F2EB','#E8DAEF'];
        $opps = $opportunity_team->dataset('Group by Team', 'pie',$teamData);
        $opps->backgroundColor($colors);

        if(!Gate::allows('isAdmin')){
            $opportunities = Opportunity::where('team_id', Auth::user()->team_id)
                                        ->orwhere('created_by', Auth::user()->id)
                                        ->get();
        }
        else
        {
            $opportunities = Opportunity::all();
        }
            
        return view('opportunities.index', compact('opportunity_stage','opportunity_team','opportunities'));
    }

    public function makeSummary($type,$start_date = NULL)
    {
        $start_date = isset($start_date)? $start_date : 30;
        $backDate = today()->subDays($start_date);
        $teams = Team::all();
        $sales_stages = ['Lost','Won','Under preparation','Under Review','Submitted','Not submitted','Dropped'];      
        $total = [];
        $index = 0;
        foreach($teams as $team ):
            $total[$index]['team'] = $team->team_code;
            foreach($sales_stages as $sales_stage):
                $proposals = Opportunity::where(['team_id'=> $team->id,'type'=>$type,'sales_stage'=>$sales_stage])
                                        ->whereBetween('created_at', [$backDate->toDateTimeString(),today()->toDateTimeString()])->get();
                $sales_stage = strtolower(implode(explode(' ',$sales_stage),''));
                $total[$index][$sales_stage] = $proposals->count();
            endforeach;
            $index +=1;
        endforeach;
        return $total;
    }

    public function store(Request $request)
    {
        $opportunity = new Opportunity();
        $latest = $opportunity->latestOM();

        //validate the received data
        $data = $request->validate([
            'opportunity_name'=>'required',
            'contact_id'=>'required',
            'country'=>'required',
            'revenue'=>'nullable',
            'sales_stage'=>'required',
            'type'=>'required',
            'lead_source'=>'required',
            'external_deadline'=>'required|date|after:internal_deadline',
            'internal_deadline'=>'required|date|after:today',
            'team_id'=>'required',
            'probability'=>'nullable',
            'funder'=>'required',
        ]);

        $run = Opportunity::create([
            'opportunity_name' => $data['opportunity_name'],
            'contact_id' => $data['contact_id'],
            'country' => $data['country'],
            'revenue' => $data['revenue'],
            'sales_stage' => $data['sales_stage'],
            'type' => $data['type'],
            'lead_source' => $data['lead_source'],
            'external_deadline' => $data['external_deadline'],
            'internal_deadline' => $data['internal_deadline'],
            'team_id' => $data['team_id'],
            'probability' => $data['probability'],
            'funder' => $data['funder'],
            'om_number'=>$latest + 1,
            'created_by'=>Auth::user()->id
        ]);
        
        if(!$run){
            return ['The opportunity not created'];;
        }else{

            $team_leader = Team::where('id','=',$request->team_id)->pluck('team_leader')->first();
            if( !User::find($team_leader)){
            }else{
                User::find($team_leader)->notify(new OpportunityCreated($opportunity));
            }      
            return ['Opportunity successfully created'];
        }
    }

    /**
     * Display the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOpportunity(Opportunity $opportunity)
    {
        return Opportunity::findOrFail($opportunity->id);
    }


    public function show($id)
    {
        $opportunity = Opportunity::findOrFail($id);

        $deliverables = DeliverableOpportunity::where(['deliverable_opportunity.opportunity_id'=>$id])
                                                ->join('deliverables', 'deliverable_opportunity.deliverable_id', '=', 'deliverables.id')
                                                ->get();

        $opportunity_tasks = Task::join('deliverables', 'tasks.deliverable_id', '=', 'deliverables.id')
                                    ->join('deliverable_opportunity', 'tasks.deliverable_id', '=', 'deliverable_opportunity.deliverable_id')->get();
        return view('opportunities.show',compact('opportunity','deliverables','opportunity_tasks'));
    }

    public function edit($id)
    {
        $opps = Opportunity::findOrFail($id);
        $contact = json_decode(Contact::where(['id'=>$opps->contact_id])->pluck('account_name'), true);
        $opportunity = json_decode(Opportunity::findOrFail($id), true);
        return $opportunity+$contact;
    }

    public function update(Request $request, Opportunity $opportunity)
    {       
        $data = $request->validate([
            'opportunity_name'=>'required',
            'contact_id'=>'required',
            'country'=>'required',
            'revenue'=>'nullable',
            'sales_stage'=>'required',
            'type'=>'required',
            'lead_source'=>'required',
            'external_deadline'=>'required',
            'internal_deadline'=>'required',
            'team_id'=>'required',
            'probability'=>'nullable',
            'funder'=>'required',
        ]);

        $run = $opportunity->update([
            'opportunity_name' => $data['opportunity_name'],
            'contact_id' => $data['contact_id'],
            'country' => $data['country'],
            'revenue' => $data['revenue'],
            'sales_stage' => $data['sales_stage'],
            'type' => $data['type'],
            'lead_source' => $data['lead_source'],
            'external_deadline' => $data['external_deadline'],
            'internal_deadline' => $data['internal_deadline'],
            'team_id' => $data['team_id'],
            'probability' => $data['probability'],
            'funder' => $data['funder'],
            'updated_by'=>Auth::user()->id
        ]);

        if( $request->type == 'Proposal' && $request->sales_stage == 'Closed Won' ){

            $project = Project::create([
                'opportunity_id'=>$opportunity->id,
                'project_status'=>'Open',
                'project_stage'=>'Initiation',
                'created_by'=>Auth::user()->id
            ]);
        }
        if(!$run){
            return ['This opportunity was not updated'];;
        }else{
            $team_leader = Team::where('id','=',$request->team_id)->pluck('team_leader')->first();
            if( !User::find($team_leader)){
            }else{
                User::find($team_leader)->notify(new OpportunityWon($project));
            }      
            return ['Opportunity successfully created'];
        }
    }

    public function addConsultants(Request $request){
        $data = $request->validate([
            "opportunity_id"    => "required",
            "user_id"  => "required",
        ]);

        OpportunityUser::create([
            'opportunity_id' => $data['opportunity_id'],
            'user_id' => $data['user_id'],
            'created_by'=>Auth::user()->id
        ]);

        $user = User::findOrFail($request->user_id);
        $opportunity = Opportunity::findOrFail($request->opportunity_id)->first();
        if( $user != NULL) $user->notify(new OpportunityAssigned($opportunity));
        return ['Cosulntant added successfully'];
    }

    public function removeConsultant($id){
        $user = OpportunityUser::where('user_id',$id)->first()->delete();
        if($user){
            return['Success'];
        }else{
            return['Failed'];
        }
    }

    public function destroy($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->delete();
        return redirect()->url('opportunities');
    }

    public function filterOpportunities(Request $request){

        $type = $request->opportunityType;
        $stage = $request->opportunityStage;
        $start_date = $request->opportunityStart." 00:00:00";
        $stopDate = $request->opportunityEnd." 00:00:00";
        $team_id = $request->opportunityTeam;
        $country = $request->opportunityCountry;
        
        $opportunities = [];

        if( $team_id == 0 && $type == 'NULL' && $stage  == 'NULL' && $country == 'All Countries'){
        
            $opportunities = Opportunity::whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id == 0 && $type == 'NULL' && $stage == 'NULL' && $country != 'All Countries'){
        
            $opportunities = Opportunity::where('country',$country)->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id == 0 && $type == 'NULL' && $stage != 'NULL' && $country == 'All Countries'){
        
            $opportunities = Opportunity::where('sales_stage',$stage)->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id == 0 && $type == 'NULL' && $stage != 'NULL' && $country != 'All Countries'){

            $opportunities = Opportunity::where(['sales_stage'=>$stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }elseif( $team_id == 0 && $type != 'NULL' && $stage  == 'NULL' && $country == 'All Countries'){
        
            $opportunities = Opportunity::where('type',$type)->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }elseif( $team_id == 0 && $type != 'NULL' && $stage  == 'NULL' && $country != 'All Countries' ){

            $opportunities = Opportunity::where(['type'=>$type,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();
    
        }elseif( $team_id == 0 && $type != 'NULL' && $stage != 'NULL' && $country == 'All Countries'){

            $opportunities = Opportunity::where(['type'=> $type,'sales_stage'=>$stage])->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }elseif( $team_id == 0 && $type != 'NULL' && $stage != 'NULL' && $country != 'All Countries'){

            $opportunities = Opportunity::where(['type'=> $type,'sales_stage'=>$stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id != 0 && $type == 'NULL' && $stage  == 'NULL' && $country == 'All Countries'){
            
            $opportunities = Opportunity::where('team_id', $team_id)->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id != 0 && $type == 'NULL' && $stage  == 'NULL' && $country != 'All Countries'){

            $opportunities = Opportunity::where(['team_id'=>$team_id,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id != 0 && $type == 'NULL' && $stage != 'NULL' && $country == 'All Countries'){

            $opportunities = Opportunity::where(['team_id'=> $team_id,'sales_stage'=>$stage])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id != 0 && $type == 'NULL' && $stage != 'NULL' && $country != 'All Countries'){

            $opportunities = Opportunity::where(['team_id'=> $team_id,'sales_stage'=>$stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id != 0 && $type != 'NULL' && $stage  == 'NULL' && $country == 'All Countries'){

            $opportunities = Opportunity::where(['team_id'=> $team_id,'type'=>$type])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id != 0 && $type != 'NULL' && $stage == 'NULL' && $country != 'All Countries'){

            $opportunities = Opportunity::where(['team_id'=> $team_id,'type'=>$type,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $team_id != 0 && $type != 'NULL' && $stage != 'NULL' && $country == 'All Countries'){

            $opportunities = Opportunity::where(['team_id'=> $team_id,'type'=>$type,'sales_stage'=>$stage])->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }
        else{
            $opportunities = Opportunity::where(['team_id'=> $team_id,'type'=>$type,'sales_stage'=>$stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();
        }


        $results = [];

        foreach($opportunities as $data){
            array_push($results,[
                'id'=>$data->id,
                'name'=>$data->opportunity_name,
                'om_number'=>$data->om_number,
                'type'=>$data->type,
                'country'=>$data->country,
                'sales_stage'=>$data->sales_stage,
                'revenue'=>$data->revenue,
                'external_deadline' => $data->external_deadline,
                'internal_deadline' => $data->internal_deadline,
            ]); 
        }
        
        return  $results;
    }

    public function export() 
    {
        return Excel::download(new OpportunitiesExport, 'opportunities.xlsx');
    }

    public function excel(){
        //$opportunities = $this->filterOpportunities();
        $opportunities = Opportunity::all();
        $opportunity_array = ['OM Number','Type','Sales Stage','Country','Revenue','Internal deadline','External deadline'];
        foreach($opportunities as $opportunity){
            $opportunity_array = [
                'OM Number'=>$opportunity->om_number,
                'Type'=>$opportunity->type,
                'Country'=>$opportunity->country,
                'Sales Stage'=>$opportunity->sales_stage,
                'Revenue'=>$opportunity->revenue,
                'Internal Deadline' => $opportunity->internal_deadline,
                'External Deadline' => $opportunity->external_deadline,
            ];
        }
        Excel::create('Opportunities',function($excel) use($opportunity_array){
            $excel->setTitle('Opportunities');
            $excel->sheet('Opportunities',function($sheet) use($opportunity_array){
                $sheet->fromArray($opportunity_array, null, 'A1', false,false);
            });
        })->download('xlsx');
    }

}
