@extends('layouts.app')
    @section('content')
    <div class="page" id="dashboard">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="card text-info">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="text-center">
                                <i class="fa fa-users fa-4x"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div><p class="card-category">Users</p> <span class="card-title"><strong>{{$users->count()}}</strong></span></div>
                            </div>   
                        </div> 
                        <a class="card-footer text-info small" href="/users">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fa fa-arrow-right-circle"></i>  
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="card text-success">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="text-center">
                                <i class="far fa-address-card fa-4x"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div>
                                    <p class="card-category">Contacts</p>
                                    <span class="card-title">
                                    <strong>{{$contacts->count()}}</strong>
                                    </span>
                                </div>
                            </div>   
                        </div> 
                        <a class="card-footer text-success small" href="/contacts">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fa fa-arrow-right-circle"></i> 
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="card text-danger">
                        <!----> <!----> 
                        <div class="card-body">
                            <div class="text-center">
                                <div class="text-center">
                                <i class="fas fa-cart-plus fa-4x"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div><p class="card-category">Opportunities</p> <span class="card-title"><strong>{{$opportunities->count()}}</strong></span></div>
                            </div>   
                        </div> 
                        <a class="card-footer text-danger small" href="/opportunities">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fa fa-arrow-right-circle"></i> 
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="card text-secondary">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="text-center">
                                <i class="fas fa-file-contract fa-4x"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div><p class="card-category">Projects</p> <span class="card-title"><strong>{{$projects->count()}}</strong></span></div>
                            </div>   
                        </div> 
                        <a class="card-footer text-secondary small" href="/projects">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fa fa-arrow-right-circle"></i> 
                            </span>
                        </a>
                    </div>
                </div>
                </div>
            <br>
                <div class="row">
                    <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            {!! $opportunityTeam->container() !!}
                            {!! $opportunityTeam->script() !!}
                        </div>
                    </div>         
                    </div>
                    <div class="col-md-6">
                        <div class="card">            
                        <div class="card-body">
                            {!! $projectChart->container() !!}
                            {!! $projectChart->script() !!}
                        </div>
                        </div>             
                    </div>
                </div>  
            </div>
            <div class="col-md-3">
            <div class="list-group">
                @foreach ($streams as $stream)
                <a href="/opportunities/{{$stream->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
                    <p class="mb-1"><strong>{{$stream->name}}</strong> added an opportunity {{ str_limit($stream->opportunity_name, $limit = 45, $end = '...') }} with <strong>{{$stream->account_name}}</strong> worth {{$stream->revenue}} USD</p>
                    <div class="d-flex w-100 flex-row-reverse">
                    <small class="text-muted">
                        {{
                        Carbon\Carbon::parse($stream->created_at)->diffForHumans()
                        }}
                    </small>
                    </div>
                </a>
                @endforeach
                <a href="/opportunities" class="list-group-item list-group-item-action flex-column align-items-start"><small class="text-muted" style="float:right;">View All</small></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                <div class="card-body">
                    {!! $teamChart->container() !!}
                    {!! $teamChart->script() !!}
                </div>
                </div>  
            </div>
            <div class="col-md-6">
                <div class="card">
                <div class="card-body">
                    {!! $userChart->container() !!}
                    {!! $userChart->script() !!}
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                <div class="card-body">
                    {!! $opportunityCountry->container() !!}
                    {!! $opportunityCountry->script() !!}
                </div>
                </div>  
            </div>
            <div class="col-md-4">
                <div class="card">
                <div class="card-body">
                    {!! $opportunityStage->container() !!}
                    {!! $opportunityStage->script() !!}
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                <div class="card-body">
                    {!! $opportunityStatus->container() !!}
                    {!! $opportunityStatus->script() !!}
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection