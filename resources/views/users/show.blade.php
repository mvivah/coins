@extends('layouts.app')
    @section('content')
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-body">
                            <i class="fas fa-plus-circle text-primary mb-2" id="requestLeave" data-user="{{$user->id}}" style="float:right;" title="Book Leave"></i>
                            <strong>Leave</strong>
                            <table class="table table-striped table-sm">
                                <tr><td colspan="2" class="text-center"><strong>Period:</strong> {{date('M - Y')}}</td></tr>
                                @foreach($user->leaves as $leave)
                                <tr><td>{{$leave->leavesetting->leave_type}}</td><td><b>{{$leave->duration}}</b></td></tr>
                                @endforeach
                                <tr><td><b>Time Away</b></td><td><b>{{$absent}} days</b></td></tr>
                            </table>  
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <i class="fas fa-plus-circle text-primary mb-2" data-id="{{$user->id}}" data-team="{{$user->team->id}}" id="assess_user" style="float:right;" title="Book Leave"></i>
                            <strong>Assessment</strong>
                            <table class="table table-striped table-sm">
                                <tr><td colspan="2" class="text-center"><strong>Period:</strong> {{date('M - Y')}}</td></tr>
                                @foreach($assessments as $assessmen)
                                <tr><td>{{$assessmen->category}}</td><td><b>{{$assessmen->score+0}} %</b></td></tr>
                                @endforeach
                            </table>  
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <i class="fas fa-plus-circle text-primary mb-2" id="workTime" data-user="{{$user->id}}" style="float:right;" title="Add Timesheet"></i>
                            <strong>Timesheet</strong>
                            <table class="table table-striped table-sm">
                                    <tr><td colspan="2" class="text-center"><strong>Period:</strong> {{date('M - Y')}}</td></tr>
                                @foreach($timesummary as $task)
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
                                @if(count($leaves)>1)
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaves as $leave)
                                            <tr>
                                                <td>{{$leave->leave_type}} Leave</td>
                                                <td>{{$leave->leave_start}}</td>
                                                <td>{{$leave->leave_end}}</td>
                                                <td>{{$leave->duration}} Days</td>
                                                <td>{{$leave->leave_status}}</td>
                                                <td>
                                                <a href="#"><i class="fa fa-edit text-secondary" id="editLeave" data-id="{{$leave->id}}" title="Edit Leave"></i></a>
                                                <a href="#"><i class="fa fa-times text-danger" id="delLeve" data-id="{{$leave->id}}" title="Cancel Leave"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="mx-auto">No Leave records...</p>
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
                            <div class="card-body">
                                @if($timesheets->count()>0)
                                    <table class="table table-sm tabledata">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Activity Description</th>
                                                <th>Duration</th>
                                                <th>Beneficiary</th>
                                                <th>Service Line</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($timesheets as $timesheet)
                                        <tr>
                                            <td>{{$timesheet->activity_date}}</td>
                                            <td>{{$timesheet->activity_description}}</td>
                                            <td>{{$timesheet->duration}} Hours</td>
                                            <td>{{$timesheet->beneficiary}}</td>
                                            <td>{{$timesheet->serviceline->service_name}}</td>
                                            <td><a href="#"><i class="fa fa-edit editTimesheet" id="{{$timesheet->id}}" title="Edit"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                @else
                                    <p>No timesheet records...</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-dark bg-light shadow">
                    <div class="card-body pd-1">
                        <div class="row">
                            <div class="col-sm-4 mx-auto">
                                <i class="fas fa-6x fa-user-tie"></i>
                                <br />
                                <button id="editUser" data-id="{{$user->id}}" class="btn btn-outline-danger btn-block mt-3 btn-xs" title="Edit Profile" style="@if(Gate::check('isConsultant'))display:none @endif"><i class="fa fa-edit"></i> Edit</button>
                            </div>
                            <div class="col-sm-8">
                                <h5>{{$user->name}}</h5>
                                <p>{{$user->staffId}}</p>
                                <p><i class="fa fa-envelope"></i> {{$user->email}}</p>
                                <p><i class="fa fa-phone"></i> {{$user->mobilePhone}}</p>
                                <p><i class="fa fa-phone"></i> {{$user->alternativePhone}}<p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p><i class="fa fa-home" title="Team"></i> {{$user->team->team_code}}</p>
                                <p><i class="fa fa-user-tie" title="Title"></i> {{$user->title->name}}</p>
                                <p><i class="fas fa-user-cog" title="Reports to"></i> {{$user->reportsTo}}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group mt-2">
                    <li class="list-group-item">
                        <h5>Tasks <span class="badge badge-light text-danger">{{$user->tasks->count()}}</span></h5>
                    </li>
                    @foreach($user->tasks as $task)
                    <li class="list-group-item">
                        @if($task->pivot->task_status !='Done' || $task->pivot->task_status !='Completed'|| $task->pivot->task_status !='Canceled')
                        {{ str_limit($task->task_name, $limit = 30, $end = '...') }}
                        <div class="btn-group float-right">
                            <i class="fa fa-edit text-success edit_user_task pl-2" id="{{ $task->id}}" title="Edit Task"></i>
                            <span class="badge badge-success">{{$task->pivot->task_status}}</span>
                            <i class="far fa-calendar-check text-danger add_task_timesheet pl-2" id="{{$task->id}}" title="Add Timesheet"></i>
                        </div>
                        @else

                        @endif 
                    </li>
                    @endforeach
                </ul>
                <ul class="list-group mt-2">
                    <li class="list-group-item active"><h5>Opportunities <span class="badge badge-light text-danger">{{$user->opportunities->count()}}</span></h5></li>
                    @foreach($user->opportunities as $opportunity)
                    <li class="list-group-item">
                        <a href="/opportunities/{{$opportunity->id}}" style="text-decoration:none;">{{ str_limit($opportunity->opportunity_name, $limit = 30, $end = '...') }}</a>
                    </li>
                    @endforeach
                    <a href="/opportunities" class="list-group-item d-flex w-100 flex-row-reverse"><small class="text-muted">View All</small></a>
                </ul>

                <ul class="list-group mt-2">
                    <li class="list-group-item">
                        <h5>Projects <span class="badge badge-light text-danger">{{$user->projects->count()}}</span></h5>
                    </li>
                    @foreach($user->projects as $project)
                    <li class="list-group-item">
                        <a href="/projects/{{$project->id}}" style="text-decoration:none;">{{ str_limit($project->opportunity->opportunity_name, $limit = 30, $end = '...') }}</a>
                    </li>
                    @endforeach
                    <a href="/projects" class="list-group-item"><small class="text-muted" style="float:right;">View All</small></a>
                </ul>
            </div>
        </div>

    @endsection
