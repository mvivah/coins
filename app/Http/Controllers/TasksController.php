<?php

namespace App\Http\Controllers;
use App\Task;
use App\User;
use App\TaskUser;
use Illuminate\Http\Request;
use App\Notifications\TaskAssigned;
use App\Notifications\task_status;
use Session;
use Auth;
use Notification;
class TasksController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        //validate the received data
        $data = $request->validate([
            'beneficiary'=>'required',
            'serviceline_id'=>'required',
            'task_id'=>'required',
            'activity_date'=>'required',
            'duration'=>'required',
            'activity_description'=>'required'
        ]);
            
        foreach($request->activity_date as $key => $value) {
            $data = array(
                'user_id'=>Auth::user()->id,
                'beneficiary' => $request->beneficiary,
                'serviceline_id' => $request->serviceline_id,
                'task_id' => $request->task_id,
                'activity_date' =>  $request->activity_date[$key],
                'duration' =>  $request->duration[$key],
                'activity_description' => $request->activity_description,
                'created_at'=>now()
            );
            TaskUser::insert($data); 
        }
        return ['Your record was added!'];
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'deliverable_id'=>'required',
            'task_name'=>'required',
            'task_status'=>'required',
            'task_deadline'=>'required',
            'user_id'=>'required',
        ]);
        //save the validated data
        $task = Task::create([
            'deliverable_id' => $data['deliverable_id'],
            'task_name'=>$data['task_name'],
            'task_deadline' => $data['task_deadline'],
            'task_status' => $data['task_status'],
            'created_by'=>Auth::user()->id
        ]);
        
        foreach($request->user_id as $key => $value) {
            $data = [
                'task_id'=>$task->id,
                'user_id' => $request->user_id[$key],
                'created_by'=>Auth::user()->id,
                'created_at'=>now()
            ];
        TaskUser::insert($data);
        }
        Notification::send($task->users, new taskAssigned($task));

        return ['success'=>'Task added successfully'];
    }

    public function show(Request $request,TaskUser $taskuser)
    {
     
        $data = $request->validate([
            'serviceline_id'=>'required',
            'beneficiary'=>'required',
            'activity_date'=>'required|date|before:tomorrow|after:lastmonth',
            'duration'=>'required',
            'task_id'=>'required',
            'activity_description'=>'required'
        ]);
        
        foreach($request->activity_date as $key => $value) {
            $data = array(
                'user_id'=>Auth::user()->id,
                'serviceline_id' => $request->serviceline_id,
                'beneficiary' => $request->beneficiary,
                'task_id' => $request->task_id,
                'activity_date' =>  $request->activity_date[$key],
                'duration' =>  $request->duration[$key],
                'activity_description' => $request->activity_description,
                'updated_at'=>now()
            );
            $taskuser->update($data); 
        }
        return ['Timesheet updated successfully'];
    }

    public function edit(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Task $task)
    {
        //validate the received data
        $data = $request->validate([
            "newtask_name"    => "required",
            "newDeadline"  => "required|date",
            'newtask_status'=>'required',
        ]);
        //save the validated data
        $task->update([
            'task_name' => $data['newtask_name'],
            'deadline' => $data['newDeadline'],
            'completed' => $data['newtask_status'],
            'updated_by'=>Auth::user()->id
        ]);
        return $request;
    }

    public function completeTask(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->update(request()->validate(
            [
                'completed'=>'required',
                'updated_by'=>Auth::user()->id
            ]));
        return $task;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
