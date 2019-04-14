@extends('layouts.app')
    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/users">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
            </ol>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <table class="table table-sm">
                        <tr><td>Name: </td><td>{{$user->name}}</td></tr>
                        <tr><td>Staff Id: </td><td>{{$user->staffId}}</td></tr>
                        <tr><td>Gender: </td><td>{{$user->gender}}</td></tr>
                        <tr><td>Email: </td><td>{{$user->email}}</td></tr>
                        <tr><td>Phone: </td><td>{{$user->mobilePhone}}</td></tr>
                        <tr><td>Alternative: </td><td>{{$user->alternativePhone}}</td></tr>
                        <tr><td>Team: </td><td>{{$user->team->team_code}}</td></tr>
                        <tr><td>Role: </td><td>{{$user->role->role_name}}</td></tr>
                        <tr><td>Reports To: </td><td>{{$user->reportsTo}}</td></tr>
                        @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                        <tr>
                            <td>
                                <a href="#" id="editUser" data-id="{{$user->id}}" class="btn btn-outline-danger btn-block" title="Edit Profile"><i class="fa fa-edit"></i> Edit</a>
                            </td>
                            <td>
                                <a href="#" data-id="{{$user->id}}" data-team="{{$user->team->id}}" id="assess_user" class="btn btn-outline-secondary" title="Assess User"><i class="fa fa-edit"></i> Assessment</a>
                            </td>
                        </tr>
                        @endif
                    </table>
                    <ul class="list-group mt-2">
                        <li class="list-group-item active"><h5>Opportunities <span class="badge badge-light text-danger">{{Auth::user()->opportunities->count()}}</span></h5></li>
                        @foreach(Auth::user()->opportunities as $opportunity)
                        <li class="list-group-item">
                            <a href="/opportunities/{{$opportunity->id}}" style="text-decoration:none;">{{ str_limit($opportunity->opportunity_name, $limit = 30, $end = '...') }}</a>
                        </li>
                        @endforeach
                        <a href="/opportunities" class="list-group-item d-flex w-100 flex-row-reverse"><small class="text-muted">View All</small></a>
                    </ul>

                    <ul class="list-group mt-2">
                        <li class="list-group-item">
                            <h5>Projects <span class="badge badge-light text-danger">{{Auth::user()->projects->count()}}</span></h5>
                        </li>
                        @foreach(Auth::user()->projects as $project)
                        <li class="list-group-item">
                            <a href="/projects/{{$project->id}}" style="text-decoration:none;">{{ str_limit($project->opportunity->opportunity_name, $limit = 30, $end = '...') }}</a>
                        </li>
                        @endforeach
                        <a href="/projects" class="list-group-item"><small class="text-muted" style="float:right;">View All</small></a>
                    </ul>

                    <ul class="list-group mt-2">
                        <li class="list-group-item text-success">
                            <h5>Tasks <span class="badge badge-light text-danger">{{Auth::user()->tasks->count()}}</span></h5>
                        </li>
                        @foreach(Auth::user()->tasks as $task)
                        <li class="list-group-item">
                            <a href="/tasks/{{$task->id}}" style="text-decoration:none;">{{ str_limit($task->task_name, $limit = 30, $end = '...') }}</a>
                            <div class="btn-group float-right">
                                <i class="fa fa-edit text-success edit_user_task pl-2" id="{{ $task->id}}" title="Edit Task"></i> 
                                <i class="far fa-calendar-check text-danger add_task_timesheet pl-2" id="{{$task->id}}" title="Add Timesheet"></i>
                            </div>
                        </li>
                        @endforeach
                        <a href="/tasks" class="list-group-item"><small class="text-muted" style="float:right;">View All</small></a>
                    </ul>
               </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body shadow-sm">
                                <i class="fas fa-plus-circle text-primary mb-2" id="requestLeave" data-user="{{$user->id}}" style="float:right;" title="Book Leave"></i>
                                <strong>Leave Summaries</strong>
                                    <table class="table table-striped table-sm">
                                        <tr><td colspan="2" class="text-center"><strong>Period:</strong> {{date('M - Y')}}</td></tr>
                                        @foreach($user->leaves as $leave)
                                        <tr><td>{{$leave->leavesetting->leave_type}}</td><td><b>{{$leave->duration}}</b></td></tr>
                                        @endforeach
                                        <tr><td><b>Time Away</b></td><td><b>{{$absent}} days</b></td></tr>
                                    </table>  
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="card-body shadow-sm">
                                <i class="fas fa-plus-circle text-primary mb-2" id="workTime" data-user="{{$user->id}}" style="float:right;" title="Add Timesheet"></i>
                                <strong>Timesheets</strong>
                                <table class="table table-striped table-sm">
                                        <tr><td colspan="2" class="text-center"><strong>Period:</strong> {{date('M - Y')}}</td></tr>
                                    @foreach($user->tasks as $task)
                                        <tr><td>{{$task->beneficiary}}</td><td><b>{{$task->duration}}</b></td></tr>
                                    @endforeach
                                    <tr><td><b>Total Worked</b></td><td><b>{{$worked}} Hours</b></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Leave Requests</h5>
                                </div>
                                <div class="card-body" id="leavesBody">
                                    @if(count($leaves)>0)
                                    <table class="table table-sm dat">
                                        <thead>
                                            <tr>
                                                <th scope="col">Leave Type</th>
                                                <th scope="col">Starting</th>
                                                <th scope="col">Ending</th>
                                                <th scope="col">Duration</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Modified</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leaves as $leave)
                                                <tr>
                                                    <td>{{$leave->leavesetting->leave_type}}</td>
                                                    <td>{{$leave->start_date}}</td>
                                                    <td>{{$leave->end_date}}</td>
                                                    <td>{{$leave->duration}} Days</td>
                                                    <td>{{$leave->leave_status}}</td>
                                                    <td>{{$leave->start_date}}</td>
                                                    <td>
                                                    <a href="#"><i class="fa fa-edit text-secondary" id="editLeave" data-id="{{$leave->id}}" title="Edit Leave"></i></a>
                                                    <a href="#"><i class="fa fa-times text-danger" id="delLeve" data-id="{{$leave->id}}" title="Cancel Leave"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <h4>No records found</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Timesheets</h5>
                                </div>
                                <div class="card-body" id="timesheetBody">
                                    @if($user->tasks->count()>0)
                                        <table class="table table-sm  table-hover dat2">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Task</th>
                                                    <th scope="col">Duration</th>
                                                    <th scope="col">Beneficiary</th>
                                                    <th scope="col">Service Line</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @foreach($user->tasks as $task)
                                            <tr>
                                                <td><a href="#" class="btn btn-sm btn-danger reviewTimesheet" id="{{$task->id}}">{{$task->activity_date}}</a></td>
                                                <td>{{$task->task_name}}</td>
                                                <td>{{$task->duration}} Hours</td>
                                                <td>{{$task->beneficiary}}</td>
                                                <td>{{$task->service_id}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                    @else
                                        <h4>No records found</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
