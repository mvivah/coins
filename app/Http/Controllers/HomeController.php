<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Page;
use App\Title;
use App\Team;
use App\TaskUser;
use App\Leave;
use App\Leavesetting;
use App\User;
use App\Project;
use App\Contact;
use App\Opportunity;
use App\Associate;
use App\Holiday;
use App\Serviceline;
use App\Leaveforward;
use App\Evaluation;
use App\Expertise;
use App\Deliverable;
use App\Target;
use Carbon\Carbon;
use App\Charts\CoinChart;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;
use Gate;
use PDF;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $streams = DB::SELECT("SELECT u.name,o.id, o.opportunity_name,o.revenue,o.created_at,c.account_name
                                FROM users u JOIN opportunities o ON o.created_by = u.id
                                JOIN contacts c ON o.contact_id = c.id 
                                ORDER BY o.id DESC LIMIT 5");
        foreach ($streams as $stream){
            $timeframe = Carbon::parse($stream->created_at)->diffForHumans();
        }

        $users = User::all();
        $contacts = contact::all();
        $opportunities = Opportunity::all();
        $projects = Project::all();

        $oppStage= DB::table('opportunities')
                            ->selectRaw("count('id') as opportunitiesdone,sales_stage") 
                            ->groupBy("sales_stage")
                            ->get();
        $oppStatus= DB::table('opportunities')
                            ->selectRaw("count('id') as opportunitiesdone,type" )
                            ->groupBy("type")
                            ->get();

        $oppTeam= Opportunity::selectRaw("count('id') as opportunitiesdone,teams.team_code as team")
                            ->join('teams', 'opportunities.team_id', '=', 'teams.id')
                            ->groupBy("teams.team_code")
                            ->get();
        
        $oppCountry= DB::table('opportunities')
                            ->selectRaw("count('id') as opportunitiesdone,country" )
                            ->groupBy("country")
                            ->get();
                                
        //Prjects per stage
        $project_stages = DB::table('projects')->selectRaw("count('id') as currentProjects,project_stage" )->groupBy("project_stage")->get();
        
        //Team Composition
        $composition = DB::SELECT("SELECT count(*) as total,t.team_code FROM users u JOIN teams t ON u.team_id=t.id WHERE u.userStatus='Active' GROUP BY team_code");
        
        //User Login Tracker
        $addedUsers = User::where(DB::raw("(DATE_FORMAT(lastLogin,'%Y'))"),date('Y'))->get();
        $today_users = User::whereDate('lastLogin', today())->count();
        $yesterday_users = User::whereDate('lastLogin', today()->subDays(1))->count();
        $users_2_days_ago = User::whereDate('lastLogin', today()->subDays(2))->count();
        $users_3_days_ago = User::whereDate('lastLogin', today()->subDays(3))->count();
        $users_4_days_ago = User::whereDate('lastLogin', today()->subDays(4))->count();
        $users_5_days_ago = User::whereDate('lastLogin', today()->subDays(5))->count();
        
        //Opportunities per stage
        $stageData = [];
        $stageLables = [];
        foreach($oppStage as $data){
            array_push($stageData,[
                 $data->opportunitiesdone
            ]); 
            array_push($stageLables,[
                $data->sales_stage
           ]);
        }

        //Opportunities per type

        $statusData = [];
        $statusLables = [];
        foreach($oppStatus as $data){
            array_push($statusData,[
                 $data->opportunitiesdone
            ]); 
            array_push($statusLables,[
                $data->type
           ]);
        }

        //Opportunities per team

        $teamData = [];
        $teamLables = [];
        foreach($oppTeam as $data){
            array_push($teamData,[
                 $data->opportunitiesdone
            ]); 
            array_push($teamLables,[
                $data->team
           ]);
        }

        //Opportunities per Country

        $countryData = [];
        $countryLables = [];
        foreach($oppCountry as $data){
            array_push($countryData,[
                 $data->opportunitiesdone
            ]); 
            array_push($countryLables,[
                $data->country
           ]);
        }

        //Projects per stage

        $projectData = [];
        $projectLables = [];
        
        foreach($project_stages as $data){
            array_push($projectData,[
                 $data->currentProjects
            ]); 
            array_push($projectLables,[
                $data->project_stage
           ]);
        }

          
        //Staff members per team
        $userData = [];
        $lables = [];

        foreach($composition as $data){
            array_push($userData,[
                 $data->total
            ]); 
            array_push($lables,[
                $data->team_code
           ]);
        }

        /**
         * Rendering Charts
         */

        //Opportunities
        $opportunityStage = new CoinChart;
        $opportunityStage->labels($stageLables);
        $colors = ['#2C3E50','#196F3D','#7DCEA0','#D1F2EB','#E8DAEF','#C0392B','#76D7C4','#117864','#E67E22','#AF7AC5'];
        $opps = $opportunityStage->dataset('Opportunities per Stage', 'bar',$stageData);
        $opps->backgroundColor($colors);

        $opportunityStatus = new CoinChart;
        $opportunityStatus->labels($statusLables);
        $colors = ['#AF7AC5','#E67E22','#D5DBDB','#C0392B','#76D7C4','#117864','#E67E22','#7DCEA0','#D1F2EB','#E8DAEF'];
        $opps = $opportunityStatus->dataset('Opportunities per Status', 'doughnut',$statusData);
        $opps->backgroundColor($colors);
        
        $opportunityTeam = new CoinChart;
        $opportunityTeam->labels($teamLables);
        $opportunityTeam->title('Opportunities per team');
        $colors = ['#C0392B','#76D7C4','#117864','#E67E22','#AF7AC5','#D5F5E3','#D5DBDB','#7DCEA0','#D1F2EB','#E8DAEF'];
        $opps = $opportunityTeam->dataset('Group by Team', 'pie',$teamData);
        $opps->backgroundColor($colors);

        $opportunityCountry = new CoinChart;
        $opportunityCountry->labels($countryLables);
        $colors = ['#C0392B','#76D7C4','#117864','#E67E22','#AF7AC5','#D5F5E3','#D5DBDB','#7DCEA0','#D1F2EB','#E8DAEF'];
        $opps = $opportunityCountry->dataset('Opportunities per Country', 'bar',$countryData);
        $opps->backgroundColor($colors);



        $userChart = new CoinChart;
        $userChart->labels(['5 days ago','4 days ago','3 days ago','2 days ago', 'Yesterday', 'Today']);
        $activity = $userChart->dataset('User Activity','line', [$users_5_days_ago,$users_4_days_ago,$users_3_days_ago,$users_2_days_ago, $yesterday_users, $today_users]);
        $colors = ['#943126','#D5DBDB','#7DCEA0','#D1F2EB','#2471A3'];
        $activity->backgroundColor($colors);
        
        $teamChart = new CoinChart;
        $teamChart->title('Team Composition');
        
        $teams = $teamChart->dataset('Consultants', 'pie', $userData);
        $teamChart->labels($lables);
        $colors = ['#85C1E9','#76D7C4','#F4D03F','#E67E22','#AF7AC5','#943126','#0000FF','#7DCEA0','#D1F2EB','#17a2b8'];
        $teams->backgroundColor($colors);
        
        //Project Chart
        $projectChart = new CoinChart;
        $projectChart->labels($projectLables);
        $colors = ['#117864','#E67E22','#AF7AC5','#D5F5E3','#D5DBDB','#7DCEA0','#D1F2EB','#E8DAEF','#C0392B','#76D7C4'];
        $opps = $projectChart->dataset('Projects per Stage', 'bar',$projectData);
        $opps->backgroundColor($colors);

        return view('pages.home',compact(
            'projects','teams','streams',
            'opportunities','users',
            'contacts','userChart',
            'teamChart','projectChart',
            'opportunityTeam',
            'opportunityStage',
            'opportunityStatus',
            'opportunityCountry',
        ));
    }

    public function admin(){
        if(Gate::check('isAdmin') || Gate::check('isDirector')){

            $leaveforwards = Leaveforward::join('users','leaveforwards.user_id','=','users.id')
                                        ->get(['users.name','leaveforwards.days_forwarded','leaveforwards.days_taken','leaveforwards.days_left']);
            $titles = Title::all();
            $teams = Team::all();
            $expertises = Expertise::all();
            $timesheets = TaskUser::all();
            $deliverables = Deliverable::all();
            $leaves = Leave::where('leaves.leave_status', '!=', 'Confirmed')
                            ->where('leaves.leave_status', '!=', 'Denied')
                            ->join('users', 'leaves.user_id', '=', 'users.id')
                            ->where('users.team_id', '=', Auth::user()->team_id)
                            ->get();
            $associates = Associate::all();
            $holidays = Holiday::all();
            $servicelines = Serviceline::all();
            $leavesettings = Leavesetting::all();
            $evaluations = Evaluation::all();
            $targets = Target::all();
            return view('pages.admin',compact('targets','titles','teams','timesheets','leaves','associates','holidays','servicelines','leavesettings','expertises','evaluations','leaveforwards','deliverables'));
        }else{
            abort(404);
        }
    }

    public function makeSummary($type,$period){
        $teams = Team::all();
        $sales_stages = ['Closed Lost','Closed Won','Under Preparation','Under Review','Submitted','Not submitted','Dropped'];      
        $total = [];
        $index = 0;
        foreach($teams as $team ):
            $total[$index]['team'] = $team->team_code;
            foreach($sales_stages as $sales_stage):
                if( $period == NULL ):
                    $opportunities = Opportunity::where(['team_id'=> $team->id,'type'=>$type,'sales_stage'=>$sales_stage])->get();
                else:
                    $dateE = Carbon::now();
                    if($period = 'current_month'):
                        $dateS = Carbon::now()->startOfMonth();
                    elseif($period = 'current_quater'):
                        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
                    elseif($period = 'current_year'):
                        $dateS = $dateE->copy()->startOfYear();
                    endif;
                    $opportunities = Opportunity::where(['team_id'=> $team->id,'type'=>$type,'sales_stage'=>$sales_stage])
                                                    ->whereBetween('updated_at',[$dateS,$dateE])
                                                    ->get();

                endif;
                $sales_stage = strtolower(implode(explode(' ',$sales_stage),''));
                $total[$index][$sales_stage] = $opportunities->count();
            endforeach;
            $index +=1;
        endforeach;
        return $total;
    }

    public function projectSummary ($period){
        $teams = Team::all();
        $project_stages = ['Initiation','Inception','Planning','Execution','Evaluation','Completion','Dropped'];
        $total = [];
        $index = 0;
        foreach($teams as $team ):
            $total[$index]['team'] = $team->team_code;
            foreach($project_stages as $project_stage):
                if( $period == NULL ):
                    $projects = Project::where(['opportunities.team_id'=> $team->id,'projects.project_stage'=>$project_stage])
                    ->join('opportunities', 'projects.opportunity_id', '=', 'opportunities.id')
                    ->get();
                else:
                    $dateE = Carbon::now();
                    if($period = 'current_month'):
                        $dateS = Carbon::now()->startOfMonth();
                    elseif($period = 'current_quater'):
                        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
                    elseif($period = 'current_year'):
                        $dateS = $dateE->copy()->startOfYear();
                    endif;
                    $projects = Project::where(['opportunities.team_id'=> $team->id,'projects.project_stage'=>$project_stage])
                                        ->join('opportunities', 'projects.opportunity_id', '=', 'opportunities.id')
                                        ->whereBetween('projects.updated_at',[$dateS,$dateE])
                                        ->get();

                endif;
                $project_stage = strtolower(implode(explode(' ',$project_stage),''));
                $total[$index][$project_stage] = $projects->count();
            endforeach;
            $index +=1;
        endforeach;
        return $total;
    }

    public function display($period = NULL){
        $proposals = $this->makeSummary('Proposal',$period);
        $eois = $this->makeSummary('EOI',$period);
        $prequalifications = $this->makeSummary('Pre-Qualification',$period);
        $projects = $this->projectSummary($period);
        return view('pages.summaries', compact('proposals','eois','prequalifications','projects'));
    }

    public function prepare(Request $request){
        $tableName = $request->tableName;
        $whereData = [];
        array_push($whereData,[
            'team_id' => $request->team_id,
            'sales_stage' => $request->sales_stage,
            'type' => $request->type,
            'country' => $request->country,
        ]);

        $searchStart = $request->starting_date." 00:00:00";
        $searchEnd = $request->ending_date." 00:00:00";

        $results = DB::table($tableName)
                    ->selectRaw("count('id') as $tableName" )
                    ->where($whereData)
                    ->whereBetween('created_at', [$searchStart, $searchEnd])
                    ->groupBy($request->team_id)
                    ->get();
        return $results;
    }

    public function support(){
        return view('pages.support');
    }

    public function showUser(User $user){
        $year = $month = today();
        $user = User::findOrFail($user->id);
        $leaves = Leave::select('leavesettings.leave_type','leaves.leave_start','leaves.leave_end','leavesetting_id','leaves.leave_status','leaves.leave_detail', DB::raw("SUM(leaves.duration) as duration"))
                    ->join('leavesettings','leaves.leavesetting_id','=','leavesettings.id')
                    ->whereYear('leaves.leave_start', '=', $month)
                    ->whereYear('leaves.created_at', '=', $month)
                    ->where('leaves.user_id', $user->id)
                    ->get();
        $absent = $leaves->sum('duration');

        //Timesheet
        $opportunities = DB::table('users')
                    ->join('task_user', 'task_user.user_id', '=', 'users.id')
                    ->join('tasks', 'task_user.task_id', '=', 'tasks.id')
                    ->join('deliverable_opportunity', 'tasks.deliverable_id', '=', 'deliverable_opportunity.deliverable_id')
                    ->join('opportunities', 'deliverable_opportunity.opportunity_id', '=', 'opportunities.id')
                    ->orderBy("opportunities.opportunity_name")
                    ->where('task_user.user_id', $user->id)
                    ->get();

        $timesummary = Timesheet::select('beneficiary', DB::raw("SUM(duration) as duration"))
                                ->whereMonth('activity_date',now())
                                ->where(['user_id'=>$user->id])
                                ->groupBy('beneficiary')->get();

        $worked = $timesummary->sum('duration');
        $timesheets = Timesheet::where(['user_id'=>$user->id])->whereMonth('activity_date',now())->get();
        
        

        $assessments = Assessment::selectRaw("targets.target_category AS category,assessments.assessment_score/targets.target_value*100 AS score")
                                ->join('targets', 'assessments.target_id', '=', 'targets.id')
                                ->where(['assessments.user_id'=>$user->id])
                                ->groupBy('targets.target_category')
                                ->get();
        return view('pages.home',compact('user','leaves','timesummary','timesheets','assessments','opportunities','worked','absent'));
    }

    public function sendMessage(Request $request){

        $this->validate($request,[
            "name"   => "required",
            "email"   => "required|email",
            "subject"   => "required",
            "message_body"   => "required",
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message_body' => $request->message_body,
        ];

        $recipient = "vmugisha@ahcul.com";

        Mail::to($recipient)->send(new FeedbackMail($data));
        return ['Your message has been sent!'];

    }
}