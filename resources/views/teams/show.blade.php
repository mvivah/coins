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
                                        <tr><td>{{$assessment->category}}</td><td>{{$assessment->score}}</td></tr>
                                        @endforeach
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
        {{-- <div class="row">
            <div class="col-md-12">
                    <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td colspan="16">
                                    <form>
                                        <div class="form-row">
                                            <div class="col">
                                                <select type="text" class="form-control">
                                                    <option value=""> -Select Name- </option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select type="text" class="form-control">
                                                    <option value=""> -Select Opportunity- </option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select type="text" class="form-control">
                                                    <option value=""> -Select Period- </option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="submit" class="btn btn-outline-danger" value="Filter">
                                            </div>
                                        </div>
                                        </form>
                                    </td>
                                </tr>
                            </thead>
                            <tr class="bg-danger text-white">
                                <th>Staff Name</th>
                                <th colspan="5">Proposals</th>
                                <th colspan="5">EOIs</th>
                                <th colspan="5">Pre-Qualifications</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Identified</td>
                                <td>Qualified</td>
                                <td>Prepared</td>
                                <td>Submitted</td>
                                <td>Successful</td>
                                <td>Identified</td>
                                <td>Qualified</td>
                                <td>Prepared</td>
                                <td>Submitted</td>
                                <td>Successful</td>
                                <td>Identified</td>
                                <td>Qualified</td>
                                <td>Prepared</td>
                                <td>Submitted</td>
                                <td>Successful</td>
                            </tr>
                            <tbody>
                                @foreach($summary as $record)       
                                <tr>
                                    <th>{{$record['user']}}</th>

                                    <th>{{$record['Proposal']['identified']}}</th>
                                    <th>{{$record['Proposal']['qualified']}}</th>
                                    <th>{{$record['Proposal']['prepared']}}</th>
                                    <th>{{$record['Proposal']['submitted']}}</th>
                                    <th>{{$record['Proposal']['won']}}</th>
                                    <th>{{$record['EOI']['identified']}}</th>
                                    <th>{{$record['EOI']['qualified']}}</th>
                                    <th>{{$record['EOI']['prepared']}}</th>
                                    <th>{{$record['EOI']['submitted']}}</th>
                                    <th>{{$record['EOI']['won']}}</th>
                                    <th>{{$record['Pre-Qualification']['identified']}}</th>
                                    <th>{{$record['Pre-Qualification']['qualified']}}</th>
                                    <th>{{$record['Pre-Qualification']['prepared']}}</th>
                                    <th>{{$record['Pre-Qualification']['submitted']}}</th>
                                    <th>{{$record['Pre-Qualification']['won']}}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
            </div>
        </div> --}}

    </div>
</div>
@endsection