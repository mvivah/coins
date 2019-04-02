<!-- Extend Main layout -->

@extends('layouts.app')

<!-- Add Custom content Section-->

    @section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Admin</li>
        </ol>
    </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="teams-tab" data-toggle="tab" href="#teams" role="tab" aria-controls="teams" aria-selected="false">Teams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="roles-tab" data-toggle="tab" href="#roles" role="tab" aria-controls="roles" aria-selected="false">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="servicelines-tab" data-toggle="tab" href="#servicelines" role="tab" aria-controls="servicelines" aria-selected="false">Service Lines</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="leaveSettings-tab" data-toggle="tab" href="#leaveSettings" role="tab" aria-controls="leaveSettings" aria-selected="false">Leave Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="associate_expertise-tab" data-toggle="tab" href="#associate_expertise" role="tab" aria-controls="associate_expertise" aria-selected="false">Associate Expertise</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">                 
                        <div class="tab-pane fade show active" id="teams" role="tabpanel" aria-labelledby="teams-tab">
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="card-body">
                                        <a href="#"><i class="fas fa-plus-circle text-primary icon-lg" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addTeams" title="Add Teams"></i></a>
                                        Teams
                                        @if($teams->count()<1)
                                            <p>No teams found...</p>
                                        @else
                                            <div class="row">
                                                @foreach(App\Team::all() as $team)
                                                    <div class="col-md-4">
                                                        <div class="card-body">
                                                            <p class="card-text"><a href="teams/{{$team->id}}"><strong>{{$team->team_code}}</strong></a></p>
                                                            <strong class="text-muted">Members: {{$team->users->count()}}</strong>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="btn-group">
                                                                <a href="teams/{{$team->id}}" class="btn btn-sm btn-outline-secondary" title="View Team">View</a>
                                                                <button type="button" id="{{$team->id}}" class="btn btn-sm btn-outline-secondary editTeam">Edit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                            </div> 
                            <div class="col-md-6">
                                    <div class="card-body">
                                        <a href="#"><i class="fas fa-plus-circle text-primary" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addTargets" title="Add Targets"></i></a>
                                        Team Targets
                                        @if(count($targets)>0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Period</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Value</th>
                                                    <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($targets as $target)
                                                    <tr>
                                                        <td>{{$target->target_period}}</td>
                                                        <td>{{$target->target_name}}</td>
                                                        <td>{{$target->target_value}}</td>
                                                        <td>
                                                            <a href="#"><i class="fa fa-edit text-primary editTargets" id="{{$target->id}}" title="Edit Target"></i></a>
                                                            <a href="#"><i class="fa fa-trash-alt text-danger deleteTargets" id="{{$target->id}}" title="Delete Target"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                    <p>No records found...</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="card-body">
                                    <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addRole" title="Add roles"></i></a>
                                    @if($roles->count()<1)
                                        <p>No User roles found...</p>
                                    @else
                                        <div class="table-responsive" id="rolesBody">
                                            <table class="table table-sm table-striped">
                                                    <thead><th>Roles</th><th>Description</th><th>Users</th><th>Actions</th></thead>
                                                <tbody>
                                                @foreach($roles as $role)
                                                    <tr>
                                                        <td>{{$role->role_name}}</td>
                                                        <td>{{$role->role_description}}</td>
                                                        <td>{{$role->users->count()}}</td>
                                                        <td>
                                                            <a href="#"><i class="fa fa-edit editRole" id="{{$role->id}}"></i></a>
                                                            <a href="#"><i class="fa fa-trash-alt text-danger" id="delRole" data-id="{{$role->id}}"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>  
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="servicelines" role="tabpanel" aria-labelledby="servicelines-tab">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="card-body">
                                    <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addServiceLine" title="Add Service Lines"></i></a>
                                    <div class="card-body">
                                        @if($servicelines->count()<1)
                                        <p>No Servicelines found...</p>
                                        @else
                                        <div class="table-responsive" id="serviceLinesBody">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <th>Beneficiary</th>
                                                    <th>Service Code</th>
                                                    <th>Service Line</th>
                                                    <th></th>
                                                </thead>                   
                                                <tbody>
                                                        @foreach($servicelines as $serviceline)
                                                    <tr>
                                                        <td>{{$serviceline->beneficiary}}</td>
                                                        <td>{{$serviceline->service_code}}</td>
                                                        <td>{{$serviceline->service_name}}</td>
                                                        <td>
                                                            <a href="#"><i class="fa fa-edit editService" id="{{$serviceline->id}}"></i></a>
                                                            <a href="#"><i class="fa fa-trash-alt text-danger" id="delService" data-id="{{$serviceline->id}}"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>                                 
                                            </table>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="leaveSettings" role="tabpanel" aria-labelledby="leaveSettings-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h5>Unconfirmed Leave</h5>
                                        <div class="table-responsive mt-2" id="leaveSettingsBody">
                                            @if($leaves->count()<1)
                                            <p>No records found...</p>
                                            @else
                                            <table class="table table-sm  table-striped">
                                                <thead><th>Leave Type</th><th>Annual Lot</th><th>Bookable</th><th></th></thead>
                                                    <tbody>
                                                        @foreach($leaves as $leave)
                                                        <tr>
                                                            <td>{{$leave->leave_type}} Leave</td><td>{{$leave->annual_lot}}</td><td>{{$leave->bookable_days}}</td>
                                                            <td>
                                                                <a href="#"><i class="fa fa-edit editLeave" id="{{$leave->id}}"></i></a>
                                                                <a href="#"><i class="fa fa-trash-alt text-danger delLeave" id="{{$leave->id}}"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h5>
                                            Leave Carried Forward
                                            <a href="#"><i class="fas fa-plus-circle text-primary" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addLeaveforward" title="Leave Crried Forward"></i></a>
                                        </h5>
                                        <div class="table-responsive mt-2" id="leaveforwardsBody">
                                            @if($leaveforwards->count()<1)
                                            <p>No records found...</p>
                                            @else
                                            <table class="table table-sm  table-striped">
                                                <thead><th>Leave Type</th><th>Annual Lot</th><th>Bookable</th><th></th></thead>
                                                    <tbody>
                                                        @foreach($leaveforwards as $leaveforward)
                                                        <tr>
                                                            <td>{{$leaveforward->leave_type}} Leave</td><td>{{$leaveforward->annual_lot}}</td><td>{{$leaveforward->bookable_days}}</td>
                                                            <td>
                                                                <a href="#"><i class="fa fa-edit editLeaveforward" id="{{$leaveforward->id}}"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h5>
                                            Public Holidays
                                            <a href="#"><i class="fas fa-plus-circle text-primary" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#publicDays" title="Add Holidays"></i></a>
                                        </h5>
                                        <div class="table-responsive mt-2" id="holidaysBody">
                                                @if($holidays->count()<1)
                                                <p>No holidays found...</p>
                                                @else
                                            <table class="table table-sm  table-striped">
                                                <thead><th>Holiday</th><th>Date</th><th>Actions</th></thead>
                                                    <tbody>
                                                        @foreach($holidays as $holiday)
                                                        <tr>
                                                            <td>{{$holiday->holiday}}</td><td>{{$holiday->holiday_date}}</td>
                                                            <td>
                                                                <a href="#"><i class="fa fa-edit editHoliday" id="{{$holiday->id}}" title="Edit Holiday"></i></a>
                                                                <a href="#"><i class="fa fa-trash-alt text-danger delHoliday" id="{{$holiday->id}}" title="Delete Holiday"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="card-body">
                                        <h5>
                                            Leave Types
                                            <a href="#"><i class="fas fa-plus-circle text-primary" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#leaveSetting" title="Add Leave Options"></i></a>
                                        </h5>
                                        <div class="table-responsive" id="leaveSettingsBody">
                                            @if($leavesettings->count()<1)
                                            <p>No records found...</p>
                                            @else
                                            <table class="table table-sm  table-striped">
                                                <thead><th>Leave Type</th><th>Annual Lot</th><th>Bookable</th><th></th></thead>
                                                    <tbody>
                                                        @foreach($leavesettings as $leavesetting)
                                                        <tr>
                                                            <td>{{$leavesetting->leave_type}} Leave</td><td>{{$leavesetting->annual_lot}}</td><td>{{$leavesetting->bookable_days}}</td>
                                                            <td>
                                                                <a href="#"><i class="fa fa-edit editLeavesetting" id="{{$leavesetting->id}}"></i></a>
                                                                <a href="#"><i class="fa fa-trash-alt text-danger delLeavesetting" id="{{$leavesetting->id}}"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="associate_expertise" role="tabpanel" aria-labelledby="associate_expertise-tab">
                            <br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#"><i class="fas fa-plus-circle text-primary mb-2" style="float:right; size:3x;" aria-hidden="true"  data-toggle="modal" data-target="#addExpertise" title="Add Expertise"></i></a>
                            </div>
                        </div>
                        <div class="row">
                                @if($expertises->count()<1)
                                <p>No records found...</p>
                                @else
                                    @foreach($expertises as $expertise)
                                    <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
                                        <div class="card text-dark bg-light h-100 shadow">
                                            <div class="card-body pd-1">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <h6>
                                                            {{$expertise->field_name}}
                                                            <span class="fas fa-plus-circle text-primary addSpecialization" id="{{$expertise->id}}" title="Add Specialization" style="float:right;"></span>
                                                        </h6>

                                                    </div>
                                                    <div class="col-md-12">
                                                        @if($expertise->specializations->count()<1)
                                                        <p>No records found...</p>
                                                        @else
                                                        @foreach($expertise->specializations as $specialization)               
                                                            <li class="list-group-item btn-sm">{{ $specialization->specialization}}
                                                                <div class="btn-group" style="float:right">
                                                                <a href="#"><i class="fa fa-edit editSpecialization" id="{{$specialization->id}}"></i></a>
                                                                <a href="#"><i class="fa fa-trash-alt text-danger delSpecialization" id="{{$specialization->id}}"></i></a>
                                                                </div>
                                                            </li>         
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End of page content -->
    @endsection
<!-- Add Custom Page content -->