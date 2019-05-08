@extends('layouts.app')
    @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mx-auto">Opportunities</h3>
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
                                <td>{{$proposal['underpreparation']}}</td>
                                <td>{{$proposal['underreview']}}</td>
                                <td>{{$proposal['submitted']}}</td>
                                <td>{{$proposal['notsubmitted']}}</td>
                                <td>{{$proposal['dropped']}}</td>
                                <td>{{$proposal['closedlost']}}</td>
                                <td>{{$proposal['closedwon']}}</td>
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
                                <td>{{$eoi['underpreparation']}}</td>
                                <td>{{$eoi['underreview']}}</td>
                                <td>{{$eoi['submitted']}}</td>
                                <td>{{$eoi['notsubmitted']}}</td>
                                <td>{{$eoi['dropped']}}</td>
                                <td>{{$eoi['closedlost']}}</td>
                                <td>{{$eoi['closedwon']}}</td>
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
                <h3 class="mx-auto">Projects</h3>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <caption>Projects</caption>
                        <thead class="bg-primary">
                            <tr>
                            <th>Teams</th>
                            <th>Inception</th>
                            <th>Planning</th>
                            <th>Execution</th>
                            <th>Evaluation</th>
                            <th>Completion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)       
                            <tr>
                                <th scope="row">{{$project['team']}}</th>
                                <td>{{$project['inception']}}</td>
                                <td>{{$project['planning']}}</td>
                                <td>{{$project['execution']}}</td>
                                <td>{{$project['evaluation']}}</td>
                                <td>{{$project['completion']}}</td>
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