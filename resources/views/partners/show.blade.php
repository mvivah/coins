@extends('layouts.app')
    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/partners">partners</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$partner->name}}</li>
            </ol>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <table class="table table-sm">
                        <tr><td>Name: </td><td>{{$partner->name}}</td></tr>
                        <tr><td>Staff Id: </td><td>{{$partner->staffId}}</td></tr>
                        <tr><td>Gender: </td><td>{{$partner->gender}}</td></tr>
                        <tr><td>Email: </td><td>{{$partner->email}}</td></tr>
                        <tr><td>Phone: </td><td>{{$partner->mobilePhone}}</td></tr>
                        <tr><td>Alternative: </td><td>{{$partner->alternativePhone}}</td></tr>
                        <tr><td>Team: </td><td>{{$partner->team->team_code}}</td></tr>
                        <tr><td>Role: </td><td>{{$partner->role->role_name}}</td></tr>
                        <tr><td>Reports To: </td><td>{{$partner->reportsTo}}</td></tr>
                        @can('isAdmin')
                        <tr>
                            <td>
                                <a href="#" id="editpartner" data-id="{{$partner->id}}" class="btn btn-outline-danger btn-block" title="Edit Profile"><i class="fa fa-edit"></i> Edit</a>
                            </td>
                            <td>
                            <a href="#" data-id="{{$partner->id}}" data-team="{{$partner->team->id}}" id="assess-partner" class="btn btn-outline-secondary btn-block" title="Assess partner"><i class="fa fa-edit"></i> Assessment</a>
                            </td>
                        </tr>
                        @endcan
                    </table>
                    <ul class="list-group mt-2">
                        <li class="list-group-item active"><h5>My Opportunities <span class="badge badge-light text-danger">{{Auth::partner()->opportunities->count()}}</span></h5></li>
                        @foreach(Auth::partner()->opportunities as $opportunity)
                        <li class="list-group-item">
                            <a href="/opportunities/{{$opportunity->id}}" style="text-decoration:none;">{{ str_limit($opportunity->opportunity_name, $limit = 30, $end = '...') }}</a>
                            <a href="#"><span id="{{ $opportunity->om_number }}" class="fas fa-business-time text-success addToTimesheet" style="float:right"></span></a>
                        </li>
                        @endforeach
                        <a href="/opportunities" class="list-group-item d-flex w-100 flex-row-reverse"><small class="text-muted">View All</small></a>
                    </ul>

                    <ul class="list-group mt-2">
                        <li class="list-group-item"><h5>My Projects <span class="badge badge-light text-danger">{{Auth::partner()->projects->count()}}</span></h5></li>
                        @foreach(Auth::partner()->projects as $project)
                        <li class="list-group-item">
                            <a href="/projects/{{$project->id}}" style="text-decoration:none;">{{ str_limit($project->opportunity->opportunity_name, $limit = 30, $end = '...') }}</a>
                            <a href="#"><span id="{{ $project->opportunity->om_number }}" class="fas fa-business-time text-success addToTimesheet" style="float:right"></span></a>
                        </li>
                        @endforeach
                        <a href="/projects" class="list-group-item"><small class="text-muted" style="float:right;">View All</small></a>
                    </ul>

                    <ul class="list-group mt-2">
                        <li class="list-group-item text-success"><h5>My Tasks <span class="badge badge-light text-danger">{{Auth::partner()->tasks->count()}}</span></h5></li>
                        @foreach(Auth::partner()->tasks as $task)
                        <li class="list-group-item">
                            <a href="/tasks/{{$task->id}}" style="text-decoration:none;">{{ str_limit($task->task_name, $limit = 30, $end = '...') }}</a>
                        </li>
                        @endforeach
                        <a href="/tasks" class="list-group-item"><small class="text-muted" style="float:right;">View All</small></a>
                    </ul>
               </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-danger bg-white">
                                    <strong>Leave Summary</strong>
                                    <button class="btn btn-outline-danger btn-sm" id="requestLeave" data-partner="{{Auth::partner()->id}}" style="float:right;">Request <i class="far fa-calendar-plus"></i></button>  
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr><td class="text-center"><b>{{date('M - Y')}}</b></td><td></td></tr>
                                        @foreach($leaves as $leave)
                                        <tr><td>{{$leave->leavesetting->leave_type}}</td><td><b>{{$leave->duration}}</b></td></tr>
                                        @endforeach
                                        <tr><td><b>Time Away</b></td><td><b>{{$absent}} days</b></td></tr>
                                    </table>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-primary">
                                    <strong>Timesheet</strong>
                                    <button class="btn btn-outline-primary btn-sm" id="workTime" style="float:right;">Record <i class="far fa-calendar-plus"></i></button> 
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr><td class="text-center"><b>{{date('M - Y')}}</b></td><td></td></tr>
                                        @foreach($timesheets as $timesheet)
                                        <tr><td>{{$timesheet->beneficiary}}</td><td><b>{{$timesheet->duration}}</b></td></tr>
                                        @endforeach
                                        <tr><td><b>Total Worked</b></td><td><b>{{$worked}} Hours</b></td></tr>
                                    </table>
                                </div>
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
                                    <h5>My Timesheets</h5>
                                </div>
                                <div class="card-body" id="timesheetBody">
                                    @if(count($timesheets)>0)
                                        <table class="table table-sm  table-hover dat2">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Duration</th>
                                                    <th scope="col">Beneficiary</th>
                                                    <th scope="col">Service Line</th>
                                                    <th scope="col">OM Number</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @foreach($timesheets as $timesheet)
                                            <tr>
                                                <td><a href="#" class="btn btn-sm btn-danger reviewTimesheet" id="{{$timesheet->id}}">{{$timesheet->activity_date}}</a></td>
                                                <td>{{$timesheet->duration}} Hours</td>
                                                <td>{{$timesheet->beneficiary}}</td>
                                                <td>{{$timesheet->serviceline->service_name}}</td>
                                                <td>{{$timesheet->om_number}}</td>
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
