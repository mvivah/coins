@extends('layouts.app')
    @section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/opportunities">Opportunities</a></li>
            <li class="breadcrumb-item" aria-current="page">{{$opportunity->opportunity_name}}</li>
        </ol>
    </nav>
        <div class="container-fluid">
            <div class="row">              
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-lg">
                    <div class="card-body">
                    <form action="{{ URL::to('opportunities/'.$opportunity->id)}}" autocomplete="off" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="opportunity">Opportunity Name:</label>
                                <input type="text" name="opportunity_name" class="form-control" value="{{$opportunity->opportunity_name}}">  
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputClient">Client Name</label>
                                    <input type="text" class="form-control" name="contact" id="newContact" value="{{$opportunity->contact->account_name}}" readonly>
                                    <input type="hidden" name="contact_id" id="newcontact_id" value="{{$opportunity->contact->id}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputCountry">Country</label>
                                    <input list="countryListEdit" name="country" value="{{$opportunity->country}}" class="form-control">
                                        <datalist id="countryListEdit">
                                            {{getCountry()}}                                                                        
                                        </datalist>
                                </div> 
                            </div>   
                            <div class="form-row ">
                                <div class="form-group col-md-7">
                                    <label for="funder">Funder</label>
                                    <input type="text" class="form-control" name="funder" value="{{$opportunity->funder}}">
                                </div>
                                <div class="form-group col-md-2">
                                        <label for="Team">Team </label>
                                        <select name="team_id" class="form-control">
                                            <option value="{{$opportunity->team->id}}">{{$opportunity->team->team_code}}</option>
                                            @foreach(App\Team::all() as  $team)
                                            <option value="{{$team->id}}">{{$team->team_code}}</option>
                                            @endforeach
                                        </select>     
                                    </div>
                                <div class="form-group col-md-3">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option value="{{$opportunity->type}}">{{$opportunity->type}}</option>
                                            @foreach(['Pre-Qualification', 'EOI', 'Proposal'] as $value =>$type)
                                            <option value="{{ $type }}">{{ $type }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="revenue">Revenue (USD)</label>
                                    <input type="number" class="form-control" name="revenue" value="{{$opportunity->revenue}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="source">Leads Source</label>
                                    <select  name="lead_source" class="form-control">
                                        <option value="{{$opportunity->lead_source}}">{{$opportunity->lead_source}}</option>
                                        @foreach(['Cold call', 'Existing customer', 'Self Generated', 'Employee', 'Partner', 'Public Relations', 'Direct Mail', 'Conference', 'Trade Show', 'website', 'word of mouth', 'Email', 'Compaign', 'other'] as $value)
                                        <option value="{{$value}}">{{$value}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sales_stage">Sales Stage</label>
                                    <select name="sales_stage" id="newsales_stage" class="form-control">
                                        <option value="{{$opportunity->sales_stage}}">{{$opportunity->sales_stage}}</option>
                                        @foreach(['Submitted','Not Submitted','Did Not Persue','Dropped','Won','Lost'] as $value =>$sales_stage)
                                        <option value="{{ $sales_stage }}">{{ $sales_stage }} </option>
                                        @endforeach
                                    </select>
                                <input type="hidden" id="forScore" value="{{$opportunity->id}}">
                                <input type="hidden" id="omn" value="{{$opportunity->om_number}}">
                                </div>                          
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="external_deadline">Expected Close Date</label>
                                    <input type="date" name="external_deadline" class="form-control" value="{{$opportunity->external_deadline}}">  
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="internal_deadline">Internal Deadline</label>
                                    <input type="date" class="form-control" name="internal_deadline" value="{{$opportunity->internal_deadline}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="probability">Probability(%)</label>
                                    <input type="number" class="form-control" name="probability" value="{{$opportunity->probability}}">
                                </div>                                                                       
                            </div>
                                <button type="submit" class="btn btn-outline-danger" style="float:right"><i class="fa fa-floppy"></i>Update Opportunity</button>                   
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection