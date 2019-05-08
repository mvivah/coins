<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Leave;
use App\TaskUser;
use App\Timesheet;
use App\Assessment;
use Auth;
use DB;
use Gate;
use Session;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'staffId' => 'required|string|max:10',
            'name' => 'required|string|max:20',
            'gender' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'mobilePhone' => 'required|string|max:20',
            'alternativePhone' => 'required|string|max:20',
            'team_id' => 'required|integer|max:50',
            'role_id' => 'required|integer|max:2',
            'level_id' => 'required|integer|max:2',
            'reportsTo' => 'required|string',
            'userStatus' => 'required|string|max:20',
        ]);
    }
    
    public function store(Request $data)
    {
        User::create([
            'staffId' => $data['staffId'],
            'name' => $data['name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobilePhone' => $data['mobilePhone'],
            'alternativePhone' => $data['alternativePhone'],
            'team_id' => $data['team_id'],
            'role_id' => $data['role_id'],
            'level_id' => $data['level_id'],
            'reportsTo' => $data['reportsTo'],
            'userStatus' => $data['userStatus'],
            'created_by'=>Auth::user()->id
            ]);
        return ['User added succesfully'];
    }

    public function show(User $user)
    {
        $year = $month = today();
        $user = User::findOrFail($user->id);
        $leaves = Leave::select('leaves.leave_start','leaves.leave_end','leavesetting_id','leaves.leave_status','leaves.leave_detail', DB::raw("SUM(leaves.duration) as duration"),'leavesettings.leave_type',)
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
        return view('users.show',compact('user','leaves','timesummary','timesheets','assessments','opportunities','worked','absent'));
    }
    /*
    * Custom search engine
    */

    public function search(Request $request)
    {
        $users = User::where('name','LIKE','%'.$request->search."%")
                    ->orWhere('email','LIKE','%'.$request->search."%")
                    ->get();
        if($users)
        { 
            foreach ($users as $key=> $user) {
                $output = $user->name;
                return $output;
            }
        }else{
            return $request;
        }
    }
        
    function getUsers(){
        $llusers = User::pluck('name');
        for($i=0; $i<sizeof($llusers); $i++)
        {
            echo '<option value="'.$llusers[$i].'">';
        }
        unset($llusers);
    }


    public function edit(User $user)
    {
        return User::findOrFail($user->id);
    }

    public function update(Request $request, User $user)
    {
         //validate the received data
         $data = $request->validate([
            'staffId' => 'required|string|max:10',
            'name' => 'required|string|max:20',
            'gender' => 'required|string|max:10',
            'email' => 'required|string|email|max:255',
            'mobilePhone' => 'required|string|max:20',
            'alternativePhone' => 'required|string|max:20',
            'user_team_id' => 'required|integer|max:50',
            'role_id' => 'required|integer',
            'level_id' => 'required|integer',
            'reportsTo' => 'required|string',
            'userStatus' => 'nullable|string|max:20',
        ]);

        //save the validated data
        $user->update(
            ['staffId' => $data['staffId'],
            'name' => $data['name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'mobilePhone' => $data['mobilePhone'],
            'alternativePhone' => $data['alternativePhone'],
            'team_id' => $data['user_team_id'],
            'role_id' => $data['role_id'],
            'level_id' => $data['level_id'],
            'reportsTo' => $data['reportsTo'],
            'userStatus' => $data['userStatus'],
            'updated_by'=>Auth::user()->id
        ]);
        
        return['User Updated Successfully'];
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
