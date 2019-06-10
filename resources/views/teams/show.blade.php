@extends('layouts.app')
    @section('content')
    <div class="row">
        @foreach($users as $user)
            <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
                <div class="card text-dark bg-light h-100 shadow-sm">
                    <div class="card-body pd-1">
                        <div class="row">
                            <div class="col-sm-4 mx-auto">
                                <i class="fas fa-6x fa-user-tie"></i>
                                <br>
                            </div>
                            <div class="col-sm-8">
                                <h5>{{$user->name}}</h5>
                                <div class="text-center rounded-circle  border-primary">
                                    <span class="fa-2x">95%</span>
                                </div>
                            </div>
                        </div>
                        <div class="row p-0">
                            <div class="col-md-12">
                                <table class="table table-sm">
                                    <?php
                                    $scores = [];
                                    ?>
                                    @foreach($user->assessments as $assessment)
                                    <?php
                                    
                                    ?>
                                    <tr><td>{{$assessment->category}}</td><td>{{$assessment->score+0}}</td></tr>
                                    @endforeach
                                    {{-- @foreach($user->scores as $score)
                                    <tr><td>{{$score->category}}</td><td>{{$score->grade}}</td></tr>
                                    @endforeach --}}
                                </table>
                            </div>
                        </div>
                        <div class="row p-0">
                            <div class="col-sm-4 mx-auto">
                                <a href="/users/{{$user->id}}" class="btn btn-primary btn-xs">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($team->opportunities->count()>0)
    <div class="row">
        <div class="col-md-12 mt-2 mb-2">
            <h4 class="mx-auto">Team Opportunities</h4>
            <div class="table-responsive">
                <table class="table table-hover dat" >
                    <thead>
                        <tr>
                            <th>Opportunity Name</th>
                            <th>Country</th>											
                            <th>Type</th>
                            <th>Sales Stage</th>
                            <th>Internal Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($team->opportunities as $opportunity)
                        <tr>
                            <td><a href="/opportunities/{{$opportunity->id}}" class="text-primary" title="View Opportunity">{{$opportunity->opportunity_name}}</a></td>
                            <td>{{$opportunity->country}}</td>
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
    @else
    @endif
@endsection