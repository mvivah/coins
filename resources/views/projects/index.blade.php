@extends('layouts.app')
  @section('content')
    <div class="row">
        <div class="col-md-12 p-3 mb-3 shadow-sm rounded">
            <form id="projectsFilterForm">
                @csrf
                <div class="form-row">
                    <div class="col-md-2">
                        <label>Types:</label>
                        <select class="custom-select mr-sm-2" name="project_status" id="project-status">
                            <option value="">-Select Status-</option>
                            <option value="Running">Running</option>
                            <option value="Completed">Completed</option>
                            <option value="Paused">Paused</option>
                            <option value="Terminated">Terminated</option>
                            <option value="NULL">All Statuses</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Stages:</label>
                        <select class="custom-select mr-sm-2" name="project_stage" id="project-stage">
                            <option value="">-Select Stage-</option>
                            <option value="Initiation">Initiation</option>
                            <option value="Planning">Planning</option>
                            <option value="Development">Development</option>
                            <option value="Testing">Testing</option>
                            <option value="Completion">Completion</option>
                            <option value="NULL">All Stages</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Initiation Date:</label>
                        <input type="date" name="initiation_date" id="initiation-date" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Completion date:</label>
                        <input type="date" name="completion_date" id="completion-date" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Country:</label>
                        <input list="projectCountry" name="projectCountry" id="project-country"  class="form-control">
                        <datalist id="projectCountry">
                            {{ getCountry() }}                             
                        </datalist>
                    </div>
                    <div class="col-md-2">
                        <label>Search range:</label>
                        <select name="searchRange" id="searchRange"  class="form-control">
                            <option value="7">1 Week Ago</option>
                            <option value="15">2 Weeks Ago</option>
                            <option value="30">1 Month Ago</option>
                            <option value="60">2 Months Ago</option>
                            <option value="90">3 Months Ago</option>
                            <option value="120">4 Months Ago</option>
                        </select>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <button type="button" id="projectFilter-btn"  class="btn btn-primary btn-xs mx-auto">Search <i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5 id="summaries"></h5>
            <div id="records-list">
                <button type="button" class="btn btn-outline-primary" id="export_projects" style="float:right; display:none">Export <i class="fa fa-file-excel"></i></button>
            </div>
            <!-- Loader here -->
            <div id="loading">
                <img src="{{ asset("/files/loader.gif") }}" class="mx-auto d-block">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-sm table-hover dat">
            <thead>
                <tr>
                <th>OM Number</th>
                <th>Project Name</th>
                <th>Funder</th>
                <th>Status</th>
                <th>Stage</th>
                </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                <td><a href="/projects/{{$project->id}}" class="text-primary viewProject" title="View Project">{{$project->opportunity->om_number}}</a></td>
                <td>{{$project->opportunity->opportunity_name}}</td>
                <td>{{$project->opportunity->funder}}</td>
                <td>{{ $project->project_status }}</td>
                <td>{{ $project->project_stage }}</td>
                </tr>
            @endforeach   
            </tbody>
        </table>
        </div>
    </div>
@endsection