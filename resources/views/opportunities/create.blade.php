
@extends('layouts.app')

<!-- Add Custom content Section-->

    @section('content')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/opportunities">Opportunities</a></li>
            <li class="breadcrumb-item active" aria-current="page">New Opportunity</li>
        </ol>
        <div class="py-3 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                    <form method="POST" action="{{url('opportunities')}}" class="form-group" id="opportunityForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <label for="opportunity_name">Opportunity Name:</label>
                        <textarea name="opportunity_name" id="opportunity_name" class="form-control" rows="2"  placeholder="Enter opportunity"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="contacts">Contact Name</label>
                            <div class="input-group">                                                   
                                <div class="input-group-prepend">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" data-toggle="modal" title="Add New" data-target="#addContact" class="btn btn-outline-secondary  dropdown-toggle-split" aria-expanded="false">
                                        <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="select-one" autocomplete="off" id="thisContact" class="form-control" placeholder="Type contact name here...">
                            </div>
                            <select id="selectedContact" class="form-control" placeholder="Select a contact..." tabindex="1"></select>
                            <input type="hidden" name="contact_id" id="the_contact_id">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputCountry">Country</label>
                            <input list="countryList" name="country" id="country" class="form-control">
                            <datalist id="countryList">
                                {{ getCountry()}}                                                                          
                            </datalist>
                        </div> 
                    </div>      
                    <div class="form-row ">
                        <div class="form-group col-md-7">
                            <label for="inputProject">Funder</label>
                            <input type="text" class="form-control" name="funder" id="funder" placeholder="Enter Funder's name" value="{{old('funder')}}">
                        </div>
                        <div class="form-group col-md-2">
                                <label for="inputTeam">Team </label>
                                <select name="team_id" id="assignedTeam" class="form-control">
                                    <option>-- Choose --</option>
                                    @foreach(App\Team::all() as  $team)
                                        <option value="{{$team->id}}">{{$team->team_code}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputType">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option>-- Choose --</option>
                                @foreach(['Pre-Qualification', 'EOI', 'Proposal'] as $value =>$type)
                                <option value="{{ $type }}">{{ $type }} </option>
                                @endforeach
                            </select>
                        </div>                               
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputRef">Revenue (USD)</label>
                            <input type="number" class="form-control" name="revenue" id="revenue" placeholder="Revenue">
                        </div>                   
                        <div class="form-group col-md-4">
                            <label for="source">Leads Source</label>
                            <select id="lead_source"  name="lead_source" class="form-control">
                                <option>-- Choose --</option>
                                @foreach(['Cold call', 'Existing customer', 'Self Generated', 'Employee', 'Partner', 'Public Relations', 'Direct Mail', 'Conference', 'Trade Show', 'website', 'word of mouth', 'Email', 'Compaign', 'other'] as $value)
                                <option value="{{$value}}">{{$value}}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sales_stage">Sales Stage</label>
                            <select name="sales_stage" id="sales_stage" class="form-control">
                                <option>-- Choose --</option>
                                @foreach(['Qualification','Preparation','Review'] as $value =>$sales_stage)
                                <option value="{{ $sales_stage }}">{{ $sales_stage }} </option>
                                @endforeach
                            </select>
                        </div>                      
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="external_deadline">Expected Close Date</label>
                            <input type="date" name="external_deadline" id="external_deadline" class="form-control">  
                        </div>
                        <div class="form-group col-md-4">
                            <label for="internal_deadline">Internal Deadline</label>
                            <input type="date" name = "internal_deadline" id="internal_deadline" class="form-control" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Probability">Probability(%)</label>
                            <input type="number" name="probability" id="probability" class="form-control"  placeholder="Probability %">
                        </div>                                          
                    </div>
                    <div class="form-row d-flex flex-row-reverse">
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        &nbsp;
                        <button type="submit" class="btn btn-danger" id="saveOpportunity"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of page content -->
@endsection
<!-- Add Custom Page content -->