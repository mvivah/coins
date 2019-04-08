<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Leave;
use App\Timesheet;
use Auth;
use DB;
use Gate;
use Session;

class UsersController extends Controller
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
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Profile page for a user who is logged in
    public function profile(){
        
        return view('pages.profile',compact('leaves','timesheets','worked','absent'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        User::create(
            ['staffId' => $data['staffId'],
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
            'created_by'=>Auth::user()->id]
        );
        return ['User added succesfully'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
   
        //Initualize  dates and months
        $year = $month = today();
        $user = User::findOrFail($id);
        $leaves = DB::table('leaves')
                    ->select('leavesetting_id','leave_status', DB::raw("SUM(duration) as duration"))
                    ->orderBy('created_at','desc')
                    ->whereYear('start_date', '=', $year)
                    ->whereYear('end_date', '=', $year)
                    ->where('user_id', $id)
                    ->groupBy('leavesetting_id','leave_status')
                    ->get();
        $absent = $leaves->sum('duration');

        //Timesheet
        $timesheets = Timesheet::where('user_id', $id)->get();
        $timesheets = DB::table('timesheets')
                    ->select(['beneficiary', DB::raw("SUM(duration) as duration")])
                    ->orderBy("created_at")
                    ->where('user_id', $id)
                    ->groupBy('beneficiary')
                    ->get();
        $worked = $timesheets->sum('duration');
        return view('users.show',compact('user','leaves','timesheets','worked','absent'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function edit(User $user)
    public function edit($id)
    {
        // $user = User::findOrFail($id);
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'team_id' => 'required|integer|max:50',
            'role_id' => 'required|integer',
            'level_id' => 'required|integer',
            'reportsTo' => 'required|string',
            'userStatus' => 'required|string|max:20',
        ]);

        //save the validated data
        $user->update(
            ['staffId' => $data['staffId'],
            'name' => $data['name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'mobilePhone' => $data['mobilePhone'],
            'alternativePhone' => $data['alternativePhone'],
            'team_id' => $data['team_id'],
            'role_id' => $data['role_id'],
            'level_id' => $data['level_id'],
            'reportsTo' => $data['reportsTo'],
            'userStatus' => $data['userStatus'],
            'updated_by'=>Auth::user()->id
        ]);
        
        return['User Updated Successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
