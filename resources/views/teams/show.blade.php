@extends('layouts.app')
    @section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">Teams</li>
            <li class="breadcrumb-item active" aria-current="page">{{$team->team_name}}</li>
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="row">
            @foreach($users as $user)
                <div class="col-md-3 col-sm-6 col-xs-12 mb-2">
                    <div class="card text-dark bg-light h-100 shadow">
                        <div class="card-body pd-1">
                            <div class="row">
                                <div class="col-sm-4 mx-auto">
                                    <i class="fas fa-6x fa-user-tie"></i>
                                    <br>
                                    <div class="text-center rounded-circle border  border-primary mt-3"><span class="fa-2x">95</span></div>
                                </div>
                                <div class="col-sm-8">
                                    <h5>{{$user->name}}</h5>
                                    <table class="table table-sm">
                                        @foreach($user->assessments as $assessment)
                                        <tr><td>{{ str_limit($assessment->category, $limit = 10, $end = '...')}}</td><td>{{$assessment->score+0}}</td></tr>
                                        @endforeach
                                        {{-- @foreach($user->scores as $score)
                                        <tr><td>{{$score->category}}</td><td>{{$score->grade}}</td></tr>
                                        @endforeach --}}
                                    </table>
                                </div>
                            </div>
                            <div class="row p-0">
                                <div class="col-sm-4 mx-auto">
                                    <a href="/users/{{$user->id}}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <h5 class="mx-auto"> Team Opportunities</h5>
                    @foreach ($team->opportunities as $opportunity)
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection