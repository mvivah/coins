<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Project;
use App\Associate;
use App\User;
use App\Team;
use App\Task;
use App\DeliverableProject;
use App\ProjectUser;
use App\AssociateProject;
use App\Notifications\ProjectAssigned;
use App\Notifications\ProjectCompleted;
use Session;
use Auth;
use DB;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){

        $projects = Project::all();
        return view('projects.index',['projects'=>$projects,]);
    }

    public function show(Project $project){

        $project = Project::findOrFail($project->id);

        $deliverables = DeliverableProject::where(['deliverable_project.project_id'=>$project->id])
                                            ->join('deliverables', 'deliverable_project.deliverable_id', '=', 'deliverables.id')
                                            ->get();

        $project_tasks = Task::join('deliverables', 'tasks.deliverable_id', '=', 'deliverables.id')
                                    ->join('deliverable_project', 'tasks.deliverable_id', '=', 'deliverable_project.deliverable_id')->get();  

        return view('projects.show',compact('project','deliverables','project_tasks'));

    }
    
    public function edit(Project $project){

        return (Project::findOrFail($project->id));

    }

    public function update(Request $request, Project $project){

        $data = $request->validate([
            "project_status"    => "required",
            "project_stage"  => "required",
            "initiation_date"  => "required|date|after:tomorrow",
            "completion_date"  => "required|date|after:initiation_date",
        ]);

        $run = $project->update([
            'project_status' => $data['project_status'],
            'project_stage' => $data['project_stage'],
            'initiation_date' => $data['initiation_date'],
            'completion_date' => $data['completion_date'],
            'updated_by'=>Auth::user()->id
        ]);

        if(!$run){
            return ['Project has not been updated'];;
        }else{
            $project = Project::find($request->id);
            $team_leader = Team::where('id','=',$request->team_id)->pluck('team_leader')->first();
    
            $receiver = User::find($team_leader);
            if( !$receiver){
            }else{
                User::find($team_leader)->notify(new OpportunityCreated($opportunity));
            }

            return ['Project has been successfully updated'];
        }
    }

    public function addAssociates(Request $request, Project $project){

        $data = $request->validate([
            "projectAssociate"=> "required",
            'associate_id' => "required|unique:associate_project",
        ]);

        AssociateProject::create([
            'project_id' => $data['projectAssociate'],
            'associate_id' => $data['associate_id'],
            'created_by'=>Auth::user()->id
        ]);

        //$associate = Associate::where(['id'=>$request->associate_id])->get('id');
        $project = Project::findOrFail($request->projectAssociate);
        Associate::find($request->associate_id)->notify(new ProjectAssigned($project));

        return ['Associate added successfully'];
        
    }
    
    public function log(Request $request){

        return $request;

    }

    public function removeAssociate(Request $request){

        $associate = AssociateProject::where('associate_id',$request->associate_id)->first();
        $associate->delete();
        return ['Associate removed'];

    }

    public function addConsultants(Request $request){

        $data = $request->validate([
            "project_id"    => "required",
            "user_id" =>"required|unique:project_user",
        ]);
        ProjectUser::create([
            'project_id' => $data['project_id'],
            'user_id' => $data['user_id'],
            'created_by'=>Auth::user()->id
        ]);

        $user = User::findOrFail($request->user_id);
        $project = Project::findOrFail($request->project_id);
        if( $user != NULL) $user->notify(new ProjectAssigned($project));
        return ['Cosulntant added successfully'];

    }

    public function removeConsultant(Request $request){

        $user = ProjectUser::where('user_id',$request->user_id)->first();
        $user->delete();
        return ['You have sucessfully removed a consultant'];

    }

    public function filterProjects(Request $request){

        $project_status = $request->project_status;
        $project_stage = $request->project_stage;
        $start_date = $request->projectStart." 00:00:00";
        $stopDate = $request->projectEnd." 00:00:00";
        $country = $request->projectCountry;
        
        $projects = [];

        if( $project_status == 'NULL' && $project_stage  == 'NULL' && $country == 'All Countries'){
        
            $projects = Project::whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status == 'NULL' && $project_stage == 'NULL' && $country != 'All Countries'){
        
            $projects = Project::where('country',$country)->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status == 'NULL' && $project_stage != 'NULL' && $country == 'All Countries'){
        
            $projects = Project::where('project_stage',$project_stage)->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status == 'NULL' && $project_stage != 'NULL' && $country != 'All Countries'){

            $projects = Project::where(['project_stage'=>$project_stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }elseif( $project_status != 'NULL' && $project_stage  == 'NULL' && $country == 'All Countries'){
        
            $projects = Project::where('project_status',$project_status)->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }elseif( $project_status != 'NULL' && $project_stage  == 'NULL' && $country != 'All Countries' ){

            $projects = Project::where(['project_status'=>$project_status,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();
    
        }elseif( $project_status != 'NULL' && $project_stage != 'NULL' && $country == 'All Countries'){

            $projects = Project::where(['project_status'=> $project_status,'project_stage'=>$project_stage])->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }elseif( $project_status != 'NULL' && $project_stage != 'NULL' && $country != 'All Countries'){

            $projects = Project::where(['project_status'=> $project_status,'project_stage'=>$project_stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status == 'NULL' && $project_stage  == 'NULL' && $country == 'All Countries'){
            
            $projects = Project::where('team_id', $team_id)->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status == 'NULL' && $project_stage  == 'NULL' && $country != 'All Countries'){

            $projects = Project::where(['team_id'=>$team_id,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status == 'NULL' && $project_stage != 'NULL' && $country == 'All Countries'){

            $projects = Project::where(['project_stage'=>$project_stage])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status == 'NULL' && $project_stage != 'NULL' && $country != 'All Countries'){

            $projects = Project::where(['project_stage'=>$project_stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status != 'NULL' && $project_stage  == 'NULL' && $country == 'All Countries'){

            $projects = Project::where(['project_status'=>$project_status])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status != 'NULL' && $project_stage == 'NULL' && $country != 'All Countries'){

            $projects = Project::where(['project_status'=>$project_status,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();

        }elseif( $project_status != 'NULL' && $project_stage != 'NULL' && $country == 'All Countries'){

            $projects = Project::where(['project_status'=>$project_status,'project_stage'=>$project_stage])->whereBetween('created_at', [$start_date, $stopDate])->get();
        
        }
        else{
            $projects = Project::where(['project_status'=>$project_status,'project_stage'=>$project_stage,'country'=>$country])->whereBetween('created_at', [$start_date, $stopDate])->get();
        }

        $results = [];

        foreach($projects as $data){
            array_push($results,[
                'id'=>$data->id,
                'name'=>$data->opportunity_name,
                'om_number'=>$data->om_number,
                'project_status'=>$data->type,
                'country'=>$data->country,
                'project_stage'=>$data->sales_stage,
                'revenue'=>$data->revenue,
                'external_deadline' => $data->external_deadline,
                'internal_deadline' => $data->internal_deadline,
            ]); 
        }
        
        return  $results;
    }
}