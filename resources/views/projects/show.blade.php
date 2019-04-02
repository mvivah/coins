@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/projects">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$project->opportunity->opportunity_name}} - <strong>{{$project->opportunity->om_number}}</strong></li>
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <ol class="list-group">
                    <li class="list-group-item list-group-item-action bg-info text-white">
                    Consultants <span class="badge badge-danger">{{ $project->users->count() }}</span>
                    <a href="#"  class="btn btn-sm btn-outline-light" data-id="{{ $project->id}}" id="user-project" style="float:right;" title="Assign Consultants">
                    Add
                    </a>
                    </li>
                    @foreach($project->users as $consultant)
                        <li class="list-group-item list-group-item-action consultants" id="{{ $consultant->id }}">{{ $consultant->name }} <span id="{{ $consultant->id }}" data-source="Project" class="fa fa-times text-danger delConsultant" style="float:right"></span></li>
                    @endforeach
                </ol>
              <br>
                <ol class="list-group">
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
                <br>
                <ol class="list-group">
                    <li class="list-group-item list-group-item-action bg-info text-white">
                        Documents <span class="badge badge-danger">{{ $project->documents->count() }}</span>
                        <button  class="btn btn-sm btn-outline-light " data-name="{{ $project->opportunity->opportunity_name}}" data-owner="project_id" data-id="{{ $project->id}}" id="project-document" style="float:right;">
                        Add
                        </button>
                    </li>
                    @foreach($project->documents as $document)
                        <li class="list-group-item list-group-item-action">{{ $document->document_url }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                    @endforeach                                  
                </ol>  
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <p>Current stage: {{$project->project_stage}}</p>
                        <p>Status: {{$project->project_status}}</p>
                        <p>Closure date: {{$project->completion_date}}</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <a href="#" class="btn btn-sm btn-outline-primary" id="editProject" data-id="{{$project->id}}" title="Edit Project">Edit</a>
                            <a href="#" class="btn btn-sm btn-outline-primary" id="addDeliverable" data-id="{{$project->id}}" title="Add Deliverables">Add</a>
                            <a href="#" class="btn btn-sm btn-outline-danger" id="projecEtvaluation" data-id="{{ $project->id}}" data-model="Project" title="Project Evaluation">Evaluate</a>
                        </div>
                    </div>
                </div>
                <div class="row" id="deliverableBody">                       
                    @foreach($project->deliverables as $deliverable)
                        <div class="col-md-6 mb-1">
                            <div class="list-group">
                                <li class="list-group-item list-group-item-action"><strong>{{ $deliverable->deliverable_name}}</strong> - Deadline: {{ $deliverable->deliverable_complition}}
                                    <div class="btn-group btn-group-sm" role="group" style="float:right">              
                                        <a href="#" class="btn btn-outline-danger fa fa-list addTasks" id="{{$deliverable->id}}" title="Add Tasks"></a>
                                            <button type="button" class="btn btn-outline-danger dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item editDeliverable" id="{{$deliverable->id}}"> Edit</a>
                                        <a class="dropdown-item delDeliverable" id="{{$deliverable->id}}"> Delete</a>
                                        </div>         
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