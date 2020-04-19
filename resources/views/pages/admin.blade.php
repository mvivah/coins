@extends('layouts.app')
    @section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Reports</h3>
                <div class="tabbable-panel">
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs ">
                            <li class="active">
                                <a href="#tab_default_1" data-toggle="tab">Company or Individual </a>
                            </li>
                            <li>
                                <a href="#tab_default_2" data-toggle="tab">Report title & Category </a>
                            </li>
                            <li>
                                <a href="#tab_default_3" data-toggle="tab">Your Reports </a>
                            </li>
                            <li>
                                <a href="#tab_default_4" data-toggle="tab">Documents </a>
                            </li>
                            <li>
                                <a href="#tab_default_5" data-toggle="tab">T&C </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_default_1">
                                <p>Tab 1.</p>
                                <p>lorem</p>
                                </div>
                            <div class="tab-pane" id="tab_default_2">
                                <p>Tab 2.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                            <div class="tab-pane" id="tab_default_3">
                                <p>Tab 3.</p>
                                <p>Consectetur deleniti quisquam natus eius commodi.</p>
                            </div>
                            <div class="tab-pane" id="tab_default_4">
                                <p>Tab 4.</p>
                                <p>Consectetur deleniti quisquam natus eius commodi.</p>
                            </div>
                            <div class="tab-pane" id="tab_default_5">
                                <p>Tab 5.</p>
                                <p>Consectetur deleniti quisquam natus eius commodi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <a href="#"><i class="fas fa-plus-circle text-primary icon-lg" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addTeams" title="Add Teams"></i></a>
                        <h5>Teams</h5>
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
                                                    <a href="#" id="{{$team->id}}" class="btn btn-sm btn-outline-secondary editTeam">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addTargets" title="Add Targets"></i></a>
                        <h5>Team Targets</h5>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addTitle" title="Add titles"></i></a>
                        @if($titles->count()<1)
                            <p>No User titles found...</p>
                        @else
                            <div class="table-responsive" id="titlesBody">
                                <table class="table table-sm table-striped">
                                    <thead><th>Titles</th><th>Description</th><th>Users</th><th>Actions</th></thead>
                                    <tbody>
                                        @foreach($titles as $title)
                                            <tr>
                                                <td>{{$title->name}}</td>
                                                <td>{{$title->description}}</td>
                                                <td>{{$title->users->count()}}</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-edit editTitle" id="{{$title->id}}"></i></a>
                                                    <a href="#"><i class="fa fa-trash-alt text-danger" id="delTitle" data-id="{{$title->id}}"></i></a>
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
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addServiceLine" title="Add Service Lines"></i></a>
                        @if($servicelines->count()<1)
                            <p>No Servicelines found...</p>
                            @else
                            <div class="table-responsive" id="serviceLinesBody">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <th>Beneficiary</th>
                                        <th>Service Line</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                            @foreach($servicelines as $serviceline)
                                        <tr>
                                            <td>{{$serviceline->beneficiary}}</td>
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
            <div class="col-md-6">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#createdeliverable" title="Create Deliverables"></i></a>
                            @if($deliverables->count()<1)
                            <p>No deliverables found...</p>
                            @else
                            <div class="table-responsive" id="deliverablesBody">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <th>Type</th>
                                        <th>Deliverable Name</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                            @foreach($deliverables as $deliverable)
                                        <tr>
                                            <td>{{$deliverable->deliverable_type}}</td>
                                            <td>{{$deliverable->deliverable_name}}</td>
                                            <td>
                                                <a href="#"><i class="fa fa-edit editDeliverable" id="{{$deliverable->id}}"></i></a>
                                                <a href="#"><i class="fa fa-trash-alt text-danger" id="delDeliverable" data-id="{{$deliverable->id}}"></i></a>
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

        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <h5>Unconfirmed Leave</h5>
                        @if($leaves->count()<1)
                            <p>No records found...</p>
                        @else
                            <div class="table-responsive mt-2" id="leaveSettingsBody">
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
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <h5>Leave Carried Forward</h5>
                            <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#addLeaveforward" title="Leave Crried Forward"></i></a>
                        <div class="table-responsive mt-2" id="leaveforwardsBody">
                            @if($leaveforwards->count()<1)
                            <p>No records found...</p>
                            @else
                            <table class="table table-sm  table-striped">
                                <thead><th>Name</th><th>Forwarded</th><th>Taken</th><th>Left</th><th></th></thead>
                                    <tbody>
                                        @foreach($leaveforwards as $leaveforward)
                                        <tr>
                                            <td>{{$leaveforward->name}}</td><td>{{$leaveforward->days_forwarded}}</td><td>{{$leaveforward->days_taken}}</td><td>{{$leaveforward->days_left}}</td>
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
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <h5>Public Holidays</h5>
                            <span>
                                <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#publicDays" title="Add Holidays"></i></a>
                            </span>
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
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <h5>Leave Types</h5>
                            <span>
                                <a href="#"><i class="fas fa-plus-circle text-primary mb-2" aria-hidden="true" style="float:right;" data-toggle="modal" data-target="#leaveSetting" title="Add Leave Options"></i></a>
                            </span>
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
@endsection
