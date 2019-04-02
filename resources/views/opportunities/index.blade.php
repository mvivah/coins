@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Opportunities</li>
	</ol>
</nav>
<div class="container-fluid">
	@if(Gate::check('isAdmin') || Gate::check('isDirector'))
		<a href="#" class="btn btn-danger btn-sm mb-2" id="create_opportunity"><i class="fa fa-plus"></i> Create Opportunity</a>
	@endif
	<div class="row">
		<div class="col-md-12 p-3 mb-3 shadow-lg rounded">
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
							<option value="Qualification">Qualification</option>
							<option value="Preparation">Preparation</option>
							<option value="Review">Review</option>
							<option value="Submitted">Submitted</option>
							<option value="Not Submitted">Not Submitted</option>
							<option value="Dropped">Dropped</option>
							<option value="Lost">Lost</option>
							<option value="Won">Won</option>
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
						<button type="button" id="opportunityFilter" class="btn btn-outline-success">Search <i class="fa fa-search"></i></button>
					</div>
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
			<div class="table-responsive">
				<table class="table table-sm table-bordered table-striped">
					<caption>Proposals</caption>
					<thead class="bg-primary text-white">
							<tr>
							<td>Teams</td>
							<td>Preparation</td>
							<td>Review</td>
							<td>Submitted</td>
							<td>Not Submitted</td>
							<td>Dropped</td>
							<td>Lost</td>
							<td>Won</td>
							</tr>
						</thead>
					<tbody>
						@foreach($proposals as $proposal)       
						<tr>
							<th scope="row">{{$proposal['team']}}</td>
							<td>{{$proposal['underpreparation']}}</td>
							<td>{{$proposal['underreview']}}</td>
							<td>{{$proposal['submitted']}}</td>
							<td>{{$proposal['notsubmitted']}}</td>
							<td>{{$proposal['dropped']}}</td>
							<td>{{$proposal['lost']}}</td>
							<td>{{$proposal['won']}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-6">
			<div class="table-responsive">
				<table class="table table-sm table-bordered table-striped">
					<caption>EOIs</caption>
					<thead class="bg-success text-white">
						<tr>
						<td>Teams</td>
						<td>Preparation</td>
						<td>Review</td>
						<td>Submitted</td>
						<td>Not Submitted</td>
						<td>Dropped</td>
						<td>Lost</td>
						<td>Won</td>
						</tr>
					</thead>
					<tbody>
						@foreach($eois as $eoi)       
						<tr>
							<th scope="row">{{$eoi['team']}}</th>
							<td>{{$eoi['underpreparation']}}</td>
							<td>{{$eoi['underreview']}}</td>
							<td>{{$eoi['submitted']}}</td>
							<td>{{$eoi['notsubmitted']}}</td>
							<td>{{$eoi['dropped']}}</td>
							<td>{{$eoi['lost']}}</td>
							<td>{{$eoi['won']}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="table-responsive">
				<table class="table table-sm table-bordered table-striped">
					<caption>Pre-Qualifications</caption>
					<thead class="bg-secondary text-white">
						<tr>
						<td>Teams</td>
						<td>Preparation</td>
						<td>Review</td>
						<td>Submitted</td>
						<td>Not Submitted</td>
						<td>Dropped</td>
						</tr>
					</thead>
					<tbody>
						@foreach($prequalifications as $prequalification)       
						<tr>
							<th scope="row">{{$prequalification['team']}}</th>
							<td>{{$prequalification['underpreparation']}}</td>
							<td>{{$prequalification['underreview']}}</td>
							<td>{{$prequalification['submitted']}}</td>
							<td>{{$prequalification['notsubmitted']}}</td>
							<td>{{$prequalification['dropped']}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<br />
	<div class="row">
		<div class="table-responsive">
			<table class="table table-hover dat" >
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
						<td><a href="/opportunities/{{$opportunity->id}}" class="text-primary" title="View Opportunity">{{$opportunity->om_number}}</a></td>
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
</div>
@endSection