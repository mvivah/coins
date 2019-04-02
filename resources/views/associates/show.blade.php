@extends('layouts.app')
    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/associates">Associates</a></li>
                <li class="breadcrumb-item" aria-current="page">{{$associate->associate_name}}</li>
            </ol>
        </nav>
        <div class="py-3 bg-light">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-4 shadow-sm">
                        <ol class="list-group">
                            <li class="list-group-item list-group-item-action active">
                                Documents <span class="badge badge-danger">{{ $associate->documents->count() }}</span>
                                <button  class="btn btn-sm btn-outline-light addDocument" data-owner="associate_id" id="{{ $associate->id}}" style="float:right;" title="Add Documents" onclick="addDocument(this.id)">
                                <i class="fa fa-plus"></i> Add
                                </button>
                            </li>
                            @foreach($associate->documents as $document)
                                <li class="list-group-item list-group-item-action">{{ $document->name }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                            @endforeach                         plus         
                        </ol>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <ol class="list-group">
                            <li class="list-group-item list-group-item-action active">
                                Documents <span class="badge badge-danger">{{ $associate->documents->count() }}</span>
                                <a  class="btn btn-sm btn-outline-light {{($disabled? 'disabled':'')}}" data-name="{{ $associate->opportunity_name}}" data-owner="opportunity_id" data-id="{{ $associate->id}}" id="opportunity-document" style="float:right;" title="Add Document">
                                Add
                                </a>
                            </li>
                            @foreach($associate->documents as $document)
                                <li class="list-group-item list-group-item-action">{{ $document->document_url }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                            @endforeach                                  
                        </ol>
                    </div>
                </div>
                
                <div class="col-md-9">
                    <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        @can('isAdmin'||'isDirector')
                        <div class="btn-group" style="float:right">
                            <a href="{{$associate->id}}/edit" class="btn btn-outline-primary btn-sm" title="Edit Associate"><i class="fa fa-edit-2"></i></a>
                            <a href="#" id="{{$associate->id}}" class="btn btn-outline-danger btn-sm evalAssociate" title="Evaluate Associate"><i class="fa fa-edit"></i></a>
                        </div>
                        @endcan
                        <p><b>Client:</b> {{$associate->associate_name}}</p>
                            <p><b>Country:</b> {{$associate->country}}</p>
                            <p><b>Funded By:</b> {{$associate->funder}}</p>
                            <p><b>Revenue:</b> {{$associate->revenue}}</p>
                            <p><b>Currencey: </b>{{$associate->currency}}</p>
                            <p><b>Sales Stage:</b> {{$associate->sales_stage}}</p>
                            <p><b>Status:</b> {{$associate->salesStatus}}</p>
                            <p><b>Close Date:</b> {{$associate->external_deadline}}</p>
                            <p><b>Internal Deadline:</b> {{$associate->internal_deadline}}</p>
                            <p><b>Probability:</b> {{$associate->probability}}</p>
                            <p><b>Reference Number:</b> {{$associate->reference_number}}</p>
                            <p><b>Partners: </b> {{$associate->partners}}</p>
                            <p><b>Description</b> {{$associate->description}}</p>
                        <small class="text-muted">Created on: {{$associate->created_at}}</small>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>

    @endsection