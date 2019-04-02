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
                    <div class="card mb-4 shadow-sm">
                        <ol class="list-group">
                            <li class="list-group-item list-group-item-action active">
                                Consultants <span class="badge badge-danger">{{ $opportunity->users->count() }}</span>
                                <a  class="btn btn-sm btn-outline-light Opportunity {{($disabled? 'disabled':'')}}" id="user-opportunity" data-id="{{ $opportunity->id}}" style="float:right;" title="Assign Consultants">
                                Add
                                </a>
                            </li>
                            @foreach($opportunity->users as $consultant)
                                <li class="list-group-item list-group-item-action">{{ $consultant->name }} <span data-token="{{ csrf_token() }}" data-item="Opportunity" class="fa fa-times text-danger removeConsultant" id="{{ $consultant->id }}" title="Remove Consultant" style="float:right"></span></li>
                            @endforeach                                  
                        </ol>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <ol class="list-group">
                            <li class="list-group-item list-group-item-action active">
                                Documents <span class="badge badge-danger">{{ $opportunity->documents->count() }}</span>
                                <a  class="btn btn-sm btn-outline-light {{($disabled? 'disabled':'')}}" data-name="{{ $opportunity->opportunity_name}}" data-owner="opportunity_id" data-id="{{ $opportunity->id}}" id="opportunity-document" style="float:right;" title="Add Document">
                                Add
                                </a>
                            </li>
                            @foreach($opportunity->documents as $document)
                                <li class="list-group-item list-group-item-action">{{ $document->document_url }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                            @endforeach                                  
                        </ol>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card mb-2 shadow-sm">
                        <div class="card-body">
                                <div class="btn-group" role="group" aria-label="Basic example" style="float:right">
                                    <a href="{{$opportunity->id}}/edit" id="{{$opportunity->id}}" class="btn btn-outline-primary btn-sm {{($disabled? 'disabled':'')}}" title="Edit Opportunity" aria-disabled="true">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a  class="btn btn-sm btn-outline-danger evaluation {{($disabled? 'disabled':'')}}" id="{{ $opportunity->id}}" data-model="Opportunity" style="float:right;" title="Opportunity Evaluation">
                                        <i class="fa fa-layout"></i> Evaluation
                                    </a>
                                </div>
                            <p><strong>Client:</strong> {{$opportunity->contact->account_name}}</p>
                            <p><strong>Country:</strong> {{$opportunity->country}}</p>
                            <p><strong>Funder:</strong> {{$opportunity->funder}}</p>
                            <div class="row">
                                <p><strong>Type:</strong> {{$opportunity->type}}</p>
                                <p><strong>Sales Stage:</strong> {{$opportunity->sales_stage}}</p>
                                <p><strong>Close Date:</strong> {{$opportunity->external_deadline}}</p>
                                <p><strong>Internal Deadline:</strong> {{$opportunity->internal_deadline}}</p>
                                <p><strong>Revenue:</strong>{{$opportunity->revenue}} <strong>USD</strong></p>
                                <p><strong>Assigned Team:</strong> {{$opportunity->team->team_name}} - <strong>{{$opportunity->team->team_code}}</strong></p>
                                <p><strong>Probability:</strong> {{$opportunity->probability}}</p>     
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2 shadow-sm">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <th>Responsible Person</th>
                                    <th>Task</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @foreach($opportunity->users as $consultant)
                                        <tr>
                                            <td>
                                                {{$consultant->name}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <button  class="btn btn-sm btn-outline-success comment" id="{{ $opportunity->id}}" data-model="Opportunity" style="float:right;" title="Add Comments">
                                <i class="fa fa-message-square"></i> Comments
                            </button>
                            <p>The comments go here...</p>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

    @endsection