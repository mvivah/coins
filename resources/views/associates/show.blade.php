@extends('layouts.app')
    @section('content')
    <div class="row">
        <div class="col-md-8">
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
        <div class="col-md-4">
            <div class="card text-dark shadow">
                <div class="card-body pd-1">
                    <div class="row">
                        <div class="col-sm-4 mx-auto">
                            <i class="fas fa-6x fa-user-tie"></i>
                            <br />
                            <button id="editAssociate" data-id="{{$associate->id}}" class="btn btn-xs btn-outline-danger btn-block mt-3" title="Edit Profile" style="@if(Gate::check('isConsultant'))display:none @endif"><i class="fa fa-edit"></i> Edit</button>
                        </div>
                        <div class="col-sm-8">
                            <h5>{{$associate->name}}</h5>
                            <p>{{$associate->staffId}}</p>
                            <p><i class="fa fa-envelope"></i> {{$associate->email}}</p>
                            <p><i class="fa fa-phone"></i> {{$associate->mobilePhone}}</p>
                            <p><i class="fa fa-phone"></i> {{$associate->alternativePhone}}<p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p><i class="fa fa-home" title="Team"></i> {{$associate->team}}</p>
                            <p><i class="fa fa-user-tie" title="Title"></i> {{$associate->role}}</p>
                            <p><i class="fas fa-user-cog" title="Reports to"></i> {{$associate->reportsTo}}<p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4 shadow">
                <ol class="list-group">
                    <li class="list-group-item list-group-item-action active">
                        Documents <span class="badge badge-danger">{{ $associate->documents->count() }}</span>
                        <a  class="btn btn-sm btn-outline-light" data-id="{{ $associate->id}}" id="associate_document" style="float:right;" title="Add Document">
                        Add
                        </a>
                    </li>
                    @foreach($associate->documents as $document)
                        <li class="list-group-item list-group-item-action">{{ $document->document_url }} <span id="{{ $document->id }}" class="fa fa-times text-danger" style="float:right"></span></li>
                    @endforeach                                  
                </ol>
            </div>
        </div>
    </div>
    @endsection