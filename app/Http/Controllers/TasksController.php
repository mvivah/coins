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
            'task_status' => $data['task_status'],
            'created_by'=>Auth::user()->id
        ]);
        
        foreach($request->user_id as $key => $value) {
            $data = [
                'task_id'=>$task->id,
                'user_id' => $request->user_id[$key],
                'created_at'=>now()
            ];
        TaskUser::insert($data);
        }
        Notification::send($task->users, new taskAssigned($task));
        return ['Task added successfully'];
    }

    public function edit(Task $task)
    {
        return Task::where(['tasks.id'=>$task->id])->join('task_user', 'tasks.id', '=', 'task_user.task_id')->get();
    }

    public function update(TaskUser $taskuser, Request $request)
    {
        $data = $request->validate([
            'task_id'=>'required',
            'task_status'=>'required',
        ]);

        $taskuser->update(['task_status'=>$data['task_status'],'updated_by'=>Auth::user()->id]);
        return ['Task updated successfully'];
    }
}
