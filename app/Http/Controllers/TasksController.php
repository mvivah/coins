<?php

namespace App\Http\Controllers;
use App\Task;
use App\User;
use App\TaskUser;
use App\Deliverable;
use App\Timesheet;
use Illuminate\Http\Request;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskCompleted;
use Session;
use Auth;
use Notification;
class TasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return abort(404);

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'deliverable_id'=>'required',
            'task_name'=>'required',
            'task_status'=>'required',
            'task_deadline'=>'date|after:tomorrow',
        ]);

        $task = Task::create([
            'deliverable_id' => $data['deliverable_id'],
            'task_name'=>$data['task_name'],
            'task_deadline' => $data['task_deadline'],
            'created_by'=>Auth::user()->id
        ]);
        
        foreach($request->user_id as $key => $value) {
            $data = [
                'task_id'=>$task->id,
                'user_id' => $request->user_id[$key],
                'task_status' => $request->task_status,
                'created_at'=>now()
            ];
        TaskUser::insert($data);
        }
        Notification::send($task->users, new taskAssigned($task));
        return ['Task added successfully'];
    }

    public function edit(Task $task)
    {
        return $task;
    }

    public function update(Task $task, Request $request)
    {
        //validate the received data
        $data = $request->validate([
            'task_name'    => 'required',
            'task_deadline'  => 'required|date|after_or_equal:tomorrow',
            'task_status'=>'required',
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
