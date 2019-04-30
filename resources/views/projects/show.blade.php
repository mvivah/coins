@extends('layouts.app')
@section('content')
    <?php
        $disabled = false
    ?>
    @if($project->project_status=='Completed'||$project->project_status=='Done')
    <?php
        $disabled=true;
    ?>
    @endif
        <div class="row">
            <div class="col-md-3">
                <ol class="list-group mb-2">
                    <li class="list-group-item list-group-item-action bg-primary text-white">
                    Consultants <span class="badge badge-danger">{{ $project->users->count() }}</span>
                    <a href="#"  class="btn btn-sm btn-outline-light" data-id="{{ $project->id}}" id="user-project" style="float:right;" title="Assign Consultants">
                    Add
                    </a>
                    </li>
                    @foreach($project->users as $user)
                        <li class="list-group-item list-group-item-action responsible_users" id="{{ $user->id }}">{{ $user->name }}
                            <div class="btn-group" style="float:right">
                                @if( $user->pivot->availability != 1 )
                                <button id="{{$user->id}}" class="btn btn-outline-danger btn-xs staffCheckins {{($disabled? 'disabled':'')}}" title="Checkin">
                                    Off
                                </button>
                                @else
                                <button id="{{$user->id}}" class="btn btn-outline-success btn-xs staffCheckouts{{($disabled? 'disabled':'')}}" title="Checkout">
                                    On
                                </button>
                                @endif
                                <button class="btn btn-outline-dark btn-xs user_logs" id="{{$user->id}}" title="Print Logs">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="btn btn-xs btn-outline-danger project_staffdel" data-token="{{ csrf_token() }}" id="{{ $user->id }}">
                                    <i  class="fa fa-times text-danger" style="float:right"></i>
                                </button>
                            </div>
                        </li>
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
                            <div class="btn-group" style="float:right">
                                @if( $associate->pivot->availability != 1 )
                                <button id="{{$associate->id}}" class="btn btn-outline-danger btn-xs staffCheckins {{($disabled? 'disabled':'')}}" title="Checkin">
                                    Off
                                </button>
                                @else
                                <button id="{{$associate->id}}" class="btn btn-outline-success btn-xs staffCheckouts{{($disabled? 'disabled':'')}}" title="Checkout">
                                    On
                                </button>
                                @endif
                                <button class="btn btn-outline-dark btn-xs associate_logs" id="{{$associate->id}}" title="Print Logs">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="btn btn-xs btn-outline-danger removeAssociate" data-token="{{ csrf_token() }}" id="{{ $associate->id }}">
                                    <i  class="fa fa-times text-danger" style="float:right"></i>
                                </button>                
                            </div>
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
                    <li class="list-group-item list-group-item-action bg-secondary text-white">
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
                <div class="btn-group mb-2 opp">
                    <button id="editProject"  data-id="{{$project->id}}" class="btn btn-outline-primary {{($disabled? 'disabled':'')}}" title="Edit Project" aria-disabled="true">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button id="project_comment" data-id="{{ $project->id}}" class="btn btn-outline-primary" title="Add Comments">
                        <i class="fa fa-comment"></i> Comments
                    </button>
                    <button id="project_evaluation" data-id="{{$project->id}}" class="btn btn-outline-danger {{($disabled? 'disabled':'')}}" title="Project Evaluation">
                        <i class="fas fa-clock"></i> Evaluations
                    </button>
                    <button class="btn btn-outline-dark" id="printProject" title="Print Project">
                        <i class="fas fa-print"></i> Print
                    </button>
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
                                            <th>Deliverable</th>
                                            <th>Status</th>
                                            <th>Due date</th>
                                            <th>Progress</th>
                                            <th>Users</th>
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
                                            <td>
                                                @foreach($project_tasks as $task)
                                                {{$task->task_name}}
                                                @endforeach
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
                                        @foreach($project_tasks as $task)
                                            <tr>
                                                <td>
                                                    <strong>{{$task->task_name}}</strong>
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
                              <td>{{$project->deliverables->count()}}</td>
                              </tr>
                              <tr>
                              <td>
                              <strong>Probability</strong>
                              </td>
                            <td>{{$project->opportunity->probability}}%</td>
                              </tr>
                              <tr>
                              <td>
                              <strong>Total Revenue</strong>
                              </td>
                              <td>
                              <strong>${{$project->opportunity->revenue}}</strong>
                              </td>
                              </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th><i class="far fa-user"></i> Associate</th>
                                        <th>Status</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->associates as $associate)
                                        <tr>
                                            <td>{{ $associate->associate_name }}</td>
                                            <td>
                                                @if( $associate->pivot->availability != 1 )
                                                <button id="{{$associate->id}}" class="btn btn-outline-danger btn-xs {{($disabled? 'disabled':'')}}" title="Checkin">
                                                    Off
                                                </button>
                                                @else
                                                <button id="{{$associate->id}}" class="btn btn-outline-success btn-xs {{($disabled? 'disabled':'')}}" title="Checkout">
                                                    On
                                                </button>
                                                @endif
                                            </td>
                                        <td>{{$associate->pivot->notes}}</td>
                                        </tr>
                                    @endforeach
                                    @foreach($project->users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            @if( $user->pivot->availability != 1 )
                                            <button id="{{$user->id}}" class="btn btn-outline-danger btn-xs {{($disabled? 'disabled':'')}}" title="Checkin">
                                                Off
                                            </button>
                                            @else
                                            <button id="{{$user->id}}" class="btn btn-outline-success btn-xs {{($disabled? 'disabled':'')}}" title="Checkout">
                                                On
                                            </button>
                                            @endif
                                        </td>
                                    <td>{{$user->pivot->notes}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection