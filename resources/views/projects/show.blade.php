@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/projects">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$project->opportunity->opportunity_name}} - <strong>{{$project->opportunity->om_number}}</strong></li>
        </ol>
    </nav>
    <?php
        $disabled = false
    ?>
    @if($project->project_status=='Completed'||$project->project_status=='Done')
    <?php
        $disabled=true;
    ?>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <ol class="list-group mb-2">
                    <li class="list-group-item list-group-item-action bg-primary text-white">
                    Consultants <span class="badge badge-danger">{{ $project->users->count() }}</span>
                    <a href="#"  class="btn btn-sm btn-outline-light" data-id="{{ $project->id}}" id="user-project" style="float:right;" title="Assign Consultants">
                    Add
                    </a>
                    </li>
                    @foreach($project->users as $consultant)
                        <li class="list-group-item list-group-item-action responsible_users" id="{{ $consultant->id }}">{{ $consultant->name }} <span data-token="{{ csrf_token() }}" id="{{ $consultant->id }}" data-source="Project" class="fa fa-times text-danger delConsultant" style="float:right"></span></li>
                    @endforeach
                </ol>
                <ol class="list-group mb-2">
                    <li class="list-group-item list-group-item-action bg-secondary text-white">
                      Associates <span class="badge badge-danger">{{ $project->associates->count() }}</span>
                        <button class="btn btn-sm btn-outline-light" id="assignAssociate" data-id="{{ $project->id}}"  style="float:right;">
                            Add
                        </button>
                    </li>
                    @foreach($project->associates as $associate)
                        <li class="list-group-item list-group-item-action">{{ $associate->associate_name }}
                            <span id="removeAssociate" data-id="{{ $associate->id }}" data-token="{{ csrf_token() }}" data-source="Project" class="fa fa-times text-danger" style="float:right"></span>
                        </li>
                    @endforeach
                </ol>
                <ol class="list-group mb-2">
                    <li class="list-group-item list-group-item-action bg-primary text-white">
                        Documents <span class="badge badge-danger">{{ $project->documents->count() }}</span>
                        <button  class="btn btn-sm btn-outline-light " data-name="{{ $project->opportunity->opportunity_name}}" data-owner="project_id" data-id="{{ $project->id}}" id="project_document" style="float:right;">
                        Add
                        </button>
                    </li>
                    @foreach($project->documents as $document)
                        <li class="list-group-item list-group-item-action">{{ $document->document_url }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                    @endforeach                                  
                </ol>
                <ol class="list-group mb-2">
                    <li class="list-group-item list-group-item-action bg-primary text-white">
                        Deliverables <span class="badge badge-danger">{{ $project->deliverables->count() }}</span>
                        <button  class="btn btn-sm btn-outline-light" id="add_project_deliverable" data-id="{{$project->id}}" title="Add Deliverables" style="float:right;">
                        Add
                        </button>
                    </li>
                    @foreach($project->deliverables as $deliverable)
                    <li class="list-group-item list-group-item-action">{{ $deliverable->deliverable_name }}
                        @if($deliverable->deliverable_status =='Done')
                        <div class="badge badge-success float-right">Done</div>
                        @else
                        <div class="btn-group float-right">
                            <i class="fa fa-plus text-primary {{($disabled? 'disabled':'')}} project_task" id="{{ $deliverable->id}}" title="Add Task"></i>
                            <i class="fa fa-edit text-success edit_project_deliverable pl-2" id="{{ $deliverable->id}}" title="Edit Deliverable"></i> 
                            <i class="fa fa-times text-danger delete_project_deliverable pl-2" id="{{ $deliverable->id}}" title="Delete Deliverable"></i>
                            <i class="fa fa-chevron-right text-dark project_taskview pl-3" id="{{ $deliverable->id}}" title="View Tasks"></i>
                        </div>
                        @endif
                    </li>
                    <div class="list-group" style="display:none">
                            @foreach($deliverable->tasks as $task)
                            <li class="list-group-item list-group-item-action">{{ $task->task_name }}
                                @if($task->task_status == 'Completed'||$task->task_status == 'Done')
                                    <div class="badge badge-success float-right">Done</div>
                                @else
                                <div class="btn-group float-right">
                                    <i class="fa fa-edit text-success editTask pl-2" id="{{ $deliverable->id}}" title="Edit Task"></i> 
                                    <i class="fa fa-times text-danger task_delete pl-2" id="{{ $deliverable->id}}" id="{{ $task->id }}" data-token="{{ csrf_token() }}" data-target="Task" title="Delete Task"></i>
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </div>
                    @endforeach                                  
                </ol>  
            </div>
            <div class="col-md-9">
                    <div class="btn-group mb-2">
                        <a href="#" id="editProject"  data-id="{{$project->id}}" class="btn btn-outline-primary {{($disabled? 'disabled':'')}}" title="Edit Opportunity" aria-disabled="true">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="#" id="project_co" data-id="{{ $project->id}}" class="btn btn-outline-primary" title="Add Comment">
                            <i class="fa fa-comment"></i> Comment
                        </a>
                        <a href="#" id="project_evaluation" data-id="{{$project->id}}" class="btn btn-outline-danger {{($disabled? 'disabled':'')}}" title="Opportunity Evaluation">
                            <i class="fas fa-clock"></i> Evaluation
                        </a>
                        <a href="#" class="btn btn-outline-dark" id="printProject" title="Print">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                    <div id="project_preview">
                        <div class="card">
                            <div class="card-header">
                                <strong>{{$project->opportunity->opportunity_name}}</strong>
                                {{$project->completion_date}}
                                <span class="float-right"> <strong>Stage: </strong> {{$project->project_stage}}</span>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        <h6 class="mb-3">Status:</h6>
                                        <div>
                                            <strong>{{$project->project_status}}</strong>
                                        </div>
                                        <div>{{$project->stage}}</div>
                                        <div>{{$project->stage}}</div>
                                        <div>Email:{{$project->stage}}</div>
                                        <div>Phone: {{$project->stage}}</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <h6 class="mb-3">To:</h6>
                                        <div>
                                        <strong>Bob Mart</strong>
                                        </div>
                                        <div>Attn: Daniel Marek</div>
                                        <div>43-190 Mikolow, Poland</div>
                                        <div>Email: marek@daniel.com</div>
                                        <div>Phone: +48 123 456 789</div>
                                    </div>
                                </div>
                                    
                                <div class="table-responsive-sm">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tasks</th>
                                                    <th>Status</th>
                                                    <th class="right">Responsible</th>
                                                    <th class="center">Users</th>
                                                    <th class="right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($project->deliverables as $deliverable)
                                                @foreach($deliverable->tasks as $task)
                                                <tr>
                                                    <td class="left strong">{{$task->task_name}}</td>
                                                    <td class="left">{{$task->task_status}}</td>
                                                    <td class="right">
                                                            @foreach($task->users as $user)
                                                            {{$user->name}}
                                                            @endforeach
                                                    </td>
                                                    <td class="center">{{$task->users->count()}}</td>
                                                    <td class="right">$999,00</td>
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
                                    <strong>Subtotal</strong>
                                    </td>
                                    <td class="right">$8.497,00</td>
                                    </tr>
                                    <tr>
                                    <td class="left">
                                    <strong>Discount (20%)</strong>
                                    </td>
                                    <td class="right">$1,699,40</td>
                                    </tr>
                                    <tr>
                                    <td class="left">
                                    <strong>VAT (10%)</strong>
                                    </td>
                                    <td class="right">$679,76</td>
                                    </tr>
                                    <tr>
                                    <td class="left">
                                    <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                    <strong>$7.477,36</strong>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table> 
                                    </div>   
                                </div>     
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2" id="deliverableBody">                       
                    @foreach($project->deliverables as $deliverable)
                        <div class="col-md-6 mb-1">
                            <div class="list-group">
                                <li class="list-group-item list-group-item-action"><strong>{{ $deliverable->deliverable_name}}</strong> - Deadline: {{ $deliverable->deliverable_completion}}
                                    <div class="btn-group btn-group-sm" role="group" style="float:right">
                                        @if($deliverable->deliverable_status =='Done')
                                        @else              
                                        <i class="fa fa-edit text-primary editDeliverable" id="{{ $deliverable->id}}" title="Edit Deliverable"></i>
                                        @endif      
                                    </div>
                                </li>
                                <div class="list-group">
                                    @foreach($deliverable->tasks as $task)
                                        <li class="list-group-item list-group-item-action">
                                            <a href="#"><i class="far fa-folder text-dark taskDetail"></i></a> {{ $task->task_name}}
                                            <div class="btn-group btn-group-sm" style="float:right">
                                                @if($task->task_status == 'Completed')
                                                    <i class="fa fa-check icon-sm text-success editTask"></i>
                                                @else
                                                    <a href="#"><i class="far fa-edit icon-sm text-danger editTask" id="{{ $task->id}}" title="Edit Task"></i></a>
                                                @endif
                                            </div>
                                            @foreach($task->users as $consultant)
                                            <li class="list-group-item list-group-item-action asigned-users" style="display:none">{{ $consultant->name }} <span id="{{ $consultant->id }}" data-token="{{ csrf_token() }}" data-target="task" class="fa fa-times text-danger removeConsultant" title="Remove Consultant" style="float:right"></span></li>
                                            @endforeach
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endSection