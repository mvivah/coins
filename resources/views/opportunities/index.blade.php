@extends('layouts.app')
	@section('content')
		<div class="row">
			<div class="col-md-12 mb-2 shadow-sm">
					<button class="btn btn-outline-danger mb-2 btn-xs" id="create_opportunity" style="@if(Gate::check('isConsultant'))	display:none @endif">
						<i class="fa fa-cart-plus"></i> Create Opportunity
					</button>
				<form id="opportunitiesFilterForm">
					@csrf
					<div class="form-row">
						<div class="col-md-2">
							<label>Teams:</label>
							<select class="custom-select mr-sm-2" name="opportunityTeam" id="opportunityTeam">
								<option value="">-Select Team-</option>
								@foreach(App\Team::all() as  $team)
								<option value="{{$team->id}}">{{$team->team_code}}</option>
								@endforeach 
								<option value="0">All Teams</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>Types:</label>
							<select class="custom-select mr-sm-2" name="opportunityType" id="opportunityType">
								<option value="">-Select Type-</option>
								<option value="EOI">EOI</option>
								<option value="Proposal">Proposal</option>
								<option value="Pre-Qualification">Pre-Qualification</option>
								<option value="NULL">All Types</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>Stages:</label>
							<select class="custom-select mr-sm-2" name="opportunityStage" id="opportunityStage">
								<option value="">-Select Stage-</option>
								<option value="Under Qualification">Qualification</option>
								<option value="Under Preparation">Preparation</option>
								<option value="Under Review">Review</option>
								<option value="Submitted">Submitted</option>
								<option value="Not Submitted">Not Submitted</option>
								<option value="Dropped">Dropped</option>
								<option value="Closed Lost">Lost</option>
								<option value="Closed Won">Won</option>
								<option value="NULL">All Stages</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>Countries:</label>
							<input list="oppCountry" name="opportunityCountry" id="opportunityCountry"  class="form-control">
							<datalist id="oppCountry">
								{{ getCountry() }}                             
							</datalist>
						</div>
						<div class="col-md-2">
							<label>Start Period:</label>
							<input type="date" name="opportunityStart" id="opportunityStart" class="form-control" required>
						</div>
						<div class="col-md-2">
							<label>End Period:</label>
							<input type="date" name="opportunityEnd" id="opportunityEnd" class="form-control" required>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="btn-group mx-auto">
							<button type="button" id="opportunityFilter" class="btn btn-outline-success mb-2">Search <i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h5 id="summaries"></h5>
				<div id="records-list">
						<button type="button" class="btn btn-outline-success" id="export_opportunities" style="float:right; display:none">Export <i class="fa fa-file-excel"></i></button>
				</div>
				<!-- Loader here -->
				<div id="loading">
					<img src="{{ asset("/files/loader.gif") }}" class="mx-auto d-block">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="card-body">
					{!! $opportunity_stage->container() !!}
					{!! $opportunity_stage->script() !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					{!! $opportunity_team->container() !!}
					{!! $opportunity_team->script() !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-hover tabledata" >
					<thead>
						<tr>
							<th>OM</th>
							<th>Opportunity Name</th>
							<th>Country</th>											
							<th>Team</th>
							<th>Type</th>
							<th>Sales Stage</th>
							<th>Internal Deadline</th>
						</tr>
					</thead>
					<tbody>
						@foreach($opportunities as $opportunity)
						<tr>
							<td>
								@if(Gate::check('isAdmin') || Gate::check('isDirector'))
								<a href="/opportunities/{{$opportunity->id}}" class="text-primary" title="View Opportunity">{{$opportunity->om_number}}</a>
								@else
								{{$opportunity->om_number}}
								@endif
							</td>
							<td>{{$opportunity->opportunity_name}}</td>
							<td>{{$opportunity->country}}</td>
							<td>{{$opportunity->team->team_code}}</td>
							<td>{{$opportunity->type}}</td>
							<td>{{$opportunity->sales_stage}}</td>
							<td>{{$opportunity->internal_deadline}}</td>
						</tr>
						@endforeach				
					</tbody>
				</table>
			</div>
		</div>
@endSection