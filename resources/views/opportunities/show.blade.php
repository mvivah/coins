@extends('layouts.app')
    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/opportunities">Opportunities</a></li>
                <li class="breadcrumb-item" aria-current="page">{{$opportunity->opportunity_name}}</li>
            </ol>
        </nav>
    <?php
        $disabled = false
    ?>
    @if($opportunity->sales_stage=='Dropped'||$opportunity->sales_stage=='Closed Lost'||$opportunity->sales_stage=='Closed Lost'||$opportunity->sales_stage=='Closed Lost')
    <?php
        $disabled=true;
    ?>
    @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-2 shadow-sm">
                        <ol class="list-group">
                            <li class="list-group-item list-group-item-action active">
                                Consultants
                                <a href="#" class="btn btn-sm btn-outline-light {{($disabled? 'disabled':'')}}" id="opportunity_user" data-id="{{ $opportunity->id}}" style="float:right;" title="Assign Consultants">
                                Add
                                </a>
                            </li>
                            @foreach($opportunity->users as $consultant)
                                <li class="list-group-item list-group-item-action responsible_users" id="{{ $consultant->id }}">{{ $consultant->name }} <span data-token="{{ csrf_token() }}" data-source="Opportunity" class="fa fa-times text-danger delConsultant" id="{{ $consultant->id }}" title="Remove Consultant" style="float:right"></span></li>
                            @endforeach                                  
                        </ol>
                    </div>

                    <div class="card mb-2 shadow-sm">
                        <ol class="list-group">
                            <li class="list-group-item list-group-item-action active">
                                Documents
                                <a href="#" class="btn btn-sm btn-outline-light {{($disabled? 'disabled':'')}}" data-name="{{ $opportunity->opportunity_name}}" data-owner="opportunity_id" data-id="{{ $opportunity->id}}" id="opportunity_document" style="float:right;" title="Add Document">
                                Add
                                </a>
                            </li>
                            @foreach($opportunity->documents as $document)
                                <li class="list-group-item list-group-item-action">{{ $document->document_url }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                            @endforeach                                  
                        </ol>
                    </div>

                    <div class="card mb-2 shadow-sm">
                        <ol class="list-group">
                            <li class="list-group-item list-group-item-action active">
                                Derivelables
                                <a href="#" class="btn btn-sm btn-outline-light {{($disabled? 'disabled':'')}}" data-id="{{ $opportunity->id}}" id="add_opportunity_deliverable" style="float:right;" title="Add Deliverable">
                                    Add
                                </a>
                            </li>
                            @foreach($opportunity->deliverables as $deliverable)
                                <li class="list-group-item list-group-item-action">{{ $deliverable->deliverable_name }}
                                    @if($deliverable->deliverable_status !='Done' || $deliverable->deliverable_status !='Completed')
                                    <div class="btn-group float-right">
                                        <i class="fa fa-plus text-success {{($disabled? 'disabled':'')}} opportunity_task" id="{{ $deliverable->id}}" title="Add Task"></i> 
                                        <i class="fa fa-edit text-primary edit_opportunity_deliverable pl-2" id="{{ $deliverable->id}}" title="Edit Deliverable"></i> 
                                        <i class="fa fa-times text-danger delete_opportunity_deliverable pl-2" id="{{ $deliverable->id}}" data-token="{{ csrf_token() }}" data-source="Opportunity" title="Delete Deliverable"></i>
                                        <i class="fa fa-chevron-right text-dark opportunity_taskview pl-3" id="{{ $deliverable->id}}" title="View Tasks"></i> 
                                    </div>
                                    @else
                                    <span class="badge badge-success">Done</span>
                                    @endif
                                </li>
                            @endforeach                                  
                        </ol>
                    </div>

                </div>

                <div class="col-md-9">
                    <div class="btn-group mb-2">
                        <a href="#" id="editOpportunity"  data-id="{{$opportunity->id}}" class="btn btn-outline-primary {{($disabled? 'disabled':'')}}" title="Edit Opportunity" aria-disabled="true">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="#" id="opportunity_evaluation" data-id="{{ $opportunity->id}}" class="btn btn-outline-primary" title="Add Comment">
                            <i class="fa fa-comment"></i> Comment
                        </a>
                        <a href="#" id="opportunity_evaluation" data-id="{{$opportunity->id}}" class="btn btn-outline-danger {{($disabled? 'disabled':'')}}" title="Opportunity Evaluation">
                            <i class="fas fa-clock"></i> Evaluation
                        </a>
                        <a href="#" class="btn btn-outline-dark" id="printOpportunity" title="Print">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>

                    <div id="opportunity_preview">
                        <div class="card">
                            <div class="card-header">
                                <strong>{{$opportunity->opportunity_name}}</strong>

                                <span class="float-right"> <strong>{{$opportunity->om_number}}</strong></span>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-sm-8">
                                        <div>
                                            <strong>{{$opportunity->contact->account_name}}</strong>
                                        </div>
                                        <div>{{$opportunity->contact->full_address}}</div>
                                        <div>{{$opportunity->contact->contact_person}}</div>
                                        <div>Country: {{$opportunity->country}}</div>
                                        <div>Email: {{$opportunity->contact->contact_email}}</div>
                                        <div>Phone: {{$opportunity->contact->contact_phone}}</div>
                                        <div>Funder: {{$opportunity->funder}}</div>
                                        <div>Opportunity Type: {{$opportunity->type}}</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <h6 class="mb-2"><strong>{{$opportunity->team->team_code}} - {{$opportunity->team->team_name}}</strong></h6>
                                        <div>
                                        
                                        </div>
                                        <div>Internal Deadline: {{$opportunity->internal_deadline}}</div>
                                        <div>External Deadline: {{$opportunity->external_deadline}}</div>
                                        <div class="mt-2">Sales Stage: <strong>{{$opportunity->sales_stage}}</strong></div>
                                    </div>
                                </div>
                                  
                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tasks</th>
                                                <th class="right">Deliverable</th>
                                                <th>Status</th>
                                                <th class="right">Responsible Persons</th>
                                                <th class="center">Users</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($opportunity->deliverables as $deliverable)
                                            @foreach($deliverable->tasks as $task)
                                            <tr>
                                                <td class="left strong">{{$task->task_name}}</td>
                                                <td class="right">{{$task->deliverable->deliverable_name}}</td>
                                                <td class="left">{{$task->task_status}}</td>
                                                <td class="right">
                                                        @foreach($task->users as $user)
                                                        {{$user->name}},
                                                        @endforeach
                                                </td>
                                                <td class="center">{{$task->users->count()}}</td>

                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                  <div class="row">
                                  <div class="col-lg-4 col-sm-5">
                                  
                                  </div>
                                  
                                  <div class="col-lg-4 col-sm-5 ml-auto">
                                  <table class="table table-clear">
                                  <tbody>
                                  <tr>
                                  <td class="left">
                                  <strong>Deliverables</strong>
                                  </td>
                                  <td class="right">{{$opportunity->deliverables->count()}}</td>
                                  </tr>
                                  <tr>
                                  <td class="left">
                                  <strong>Probability</strong>
                                  </td>
                                <td class="right">{{$opportunity->probability}}%</td>
                                  </tr>
                                  <tr>
                                  <td class="left">
                                  <strong>Total Revenue</strong>
                                  </td>
                                  <td class="right">
                                  <strong>${{$opportunity->revenue}}</strong>
                                  </td>
                                  </tr>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
</div>
</div>
@endsection