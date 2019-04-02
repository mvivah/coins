@extends('layouts.app')
    @section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reports</li>
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <caption>Proposals</caption>
                        <thead class="bg-primary">
                            <tr>
                            <th>Teams</th>
                            <th>Preparation</th>
                            <th>Review</th>
                            <th>Submitted</th>
                            <th>Not Submitted</th>
                            <th>Dropped</th>
                            <th>Closed Lost</th>
                            <th>Won</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $proposal)       
                            <tr>
                                <th scope="row">{{$proposal['team']}}</th>
                                <td>{{$proposal['preparation']}}</td>
                                <td>{{$proposal['review']}}</td>
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
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <caption>EOIs</caption>
                        <thead class="bg-primary">
                            <tr>
                            <th>Teams</th>
                            <th>Preparation</th>
                            <th>Review</th>
                            <th>Submitted</th>
                            <th>Not Submitted</th>
                            <th>Dropped</th>
                            <th>Closed Lost</th>
                            <th>Won</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eois as $eoi)       
                            <tr>
                                <th scope="row">{{$eoi['team']}}</th>
                                <td>{{$eoi['preparation']}}</td>
                                <td>{{$eoi['review']}}</td>
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

                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <caption>Pre-Qualifications</caption>
                        <thead class="bg-primary">
                            <tr>
                            <th>Teams</th>
                            <th>Preparation</th>
                            <th>Review</th>
                            <th>Submitted</th>
                            <th>Not Submitted</th>
                            <th>Dropped</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prequalifications as $prequalification)       
                            <tr>
                                <th scope="row">{{$prequalification['team']}}</th>
                                <td>{{$prequalification['preparation']}}</td>
                                <td>{{$prequalification['review']}}</td>
                                <td>{{$prequalification['submitted']}}</td>
                                <td>{{$prequalification['notsubmitted']}}</td>
                                <td>{{$prequalification['dropped']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>         

<!-- End of page content -->
    @endsection

<!-- Add Custom Page content -->