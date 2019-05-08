@extends('layouts.app')
    @section('content')
    <?php
        $disabled = false
    ?>
    @if($opportunity->sales_stage=='Dropped'||$opportunity->sales_stage=='Closed Lost'||$opportunity->sales_stage=='Closed Lost'||$opportunity->sales_stage=='Closed Lost')
    <?php
        $disabled=true;
    ?>
    @endif
    <div class="row">
        <div class="col-md-8">
            <div class="btn-group mb-2 opp">
                @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                    <button id="editOpportunity"  data-id="{{$opportunity->id}}" class="btn btn-outline-primary {{($disabled? 'disabled':'')}}" title="Edit Opportunity" aria-disabled="true">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button id="opportunity_bid_scores" data-id="{{ $opportunity->id}}" class="btn btn-outline-dark" title="Add Bid Scores">
                        <i class="fa fa-bars"></i> Bids
                    </button>
                @endif
                <button id="opportunity_comment" data-id="{{ $opportunity->id}}" class="btn btn-outline-primary" title="Add Comment">
                    <i class="fa fa-comment"></i> Comments
                </button>
                <button id="opportunity_evaluation" data-id="{{$opportunity->id}}" class="btn btn-outline-danger {{($disabled? 'disabled':'')}}" title="Opportunity Evaluation">
                    <i class="fas fa-clock"></i> Evaluations
                </button>
                <button class="btn btn-outline-dark" id="printOpportunity" title="Print">
                    <i class="fas fa-print"></i> Print
                </button>
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
                                                <th>Deliverable</th>
                                                <th>Status</th>
                                                <th>Due date</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($deliverables as $deliverable)
                                            <tr>
                                                <td>{{$deliverable->deliverable_name}}</td>
                                                <td>{{$deliverable->deliverable_status}}</td>
                                                <td>{{$deliverable->deliverable_completion}}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: {{$deliverable->id}}%;" aria-valuenow="{{$deliverable->id}}" aria-valuemin="0" aria-valuemax="100">{{$deliverable->id}}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            <div class="row">
                                <div class="col-lg-4 col-sm-5 mr-auto">
                                    <table class="table table-clear">
                                        <tbody>
                                            @foreach($opportunity_tasks as $task)
                                                <tr>
                                                    <td>
                                                        <strong>{{$task->task_name}}</strong> From{{$task->deliverable->deliverable_name}}
                                                    </td>
                                                    <td>{{$task->task_status}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                  
                                  <div class="col-lg-4 col-sm-5 ml-auto">
                                  <table class="table table-clear">
                                  <tbody>
                                  <tr>
                                  <td>
                                  <strong>Deliverables</strong>
                                  </td>
                                  <td>{{$opportunity->deliverables->count()}}</td>
                                  </tr>
                                  <tr>
                                  <td>
                                  <strong>Probability</strong>
                                  </td>
                                <td>{{$opportunity->probability}}%</td>
                                  </tr>
                                  <tr>
                                  <td>
                                  <strong>Total Revenue</strong>
                                  </td>
                                  <td>
                                  <strong>${{$opportunity->revenue}}</strong>
                                  </td>
                                  </tr>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="list-group">
                                    <li class="list-group-item"><h3>Comments</h3></li>
                                    @foreach($opportunity->comments as $comment)
                                        <li class="list-group-item list-group-item-action flex-column align-items-start">
                                            <p class="mb-1">{{$comment->comment_body}}</p>
                                            <div class="d-flex w-100 flex-row-reverse">
                                            <small class="text-muted">
                                                {{$comment->user->name}} - 
                                                {{Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}
                                            </small>
                                            </div>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-md-4">
            <ol class="list-group mb-4 shadow">
                <li class="list-group-item list-group-item-action">
                    Consultants
                    @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                    <a href="#" class="btn btn-xs btn-outline-primary {{($disabled? 'disabled':'')}}" id="opportunity_user" data-id="{{ $opportunity->id}}" style="float:right;" title="Assign Consultants">
                    Add
                    </a>
                    @endif
                </li>
                @foreach($opportunity->users as $consultant)
                    <li class="list-group-item list-group-item-action responsible_users" id="{{ $consultant->id }}">{{ $consultant->name }} <span data-token="{{ csrf_token() }}" data-source="Opportunity" class="fa fa-times text-danger delConsultant" id="{{ $consultant->id }}" title="Remove Consultant" style="float:right"></span></li>
                @endforeach                                  
            </ol>
            <ol class="list-group mb-4 shadow">
                <li class="list-group-item list-group-item-action">
                    Documents
                    <a href="#" class="btn btn-xs btn-outline-primary {{($disabled? 'disabled':'')}}" data-name="{{ $opportunity->opportunity_name}}" data-owner="opportunity_id" data-id="{{ $opportunity->id}}" id="opportunity_document" style="float:right;" title="Add Document">
                    Add
                    </a>
                </li>
                @foreach($opportunity->documents as $document)
                    <li class="list-group-item list-group-item-action">{{ $document->document_url }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                @endforeach                                  
            </ol>
            <ol class="list-group mb-4 shadow">
                <li class="list-group-item list-group-item-action">
                    Derivelables
                    @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                    <a href="#" class="btn btn-xs btn-outline-primary {{($disabled? 'disabled':'')}}" data-id="{{ $opportunity->id}}" id="add_opportunity_deliverable" style="float:right;" title="Add Deliverable">
                        Add
                    </a>
                    @endif
                </li>
                @foreach($opportunity->deliverables as $deliverable)
                <li class="list-group-item list-group-item-action">{{ $deliverable->deliverable_name }}
                    @if($deliverable->deliverable_status !='Done' || $deliverable->deliverable_status !='Completed')
                    <div class="btn-group float-right">
                        @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                            <i class="fa fa-plus text-success {{($disabled? 'disabled':'')}} opportunity_task" id="{{ $deliverable->id}}" title="Add Task"></i> 
                            <i class="fa fa-edit text-primary edit_opportunity_deliverable pl-2" id="{{ $deliverable->id}}" title="Edit Deliverable"></i> 
                            <i class="fa fa-times text-danger delete_opportunity_deliverable pl-2" id="{{ $deliverable->id}}" data-token="{{ csrf_token() }}" data-source="Opportunity" title="Delete Deliverable"></i>
                        @endif
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
@endsection