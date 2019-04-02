@extends('layouts.app')
    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">leaves</li>
            </ol>
        </nav>
        <div class="container-fluid">
            <p><a class="btn btn-danger btn-sm text-white" data-toggle="modal" data-target="#addleave"><i class="fa fa-plus"></i>Add leaves</a></p>
            <div class="table-responsive">
                <table class="table table-sm table-hover dat">
                    <thead>
                        <tr>
                            <th>leave Name</th>
                            <th>Country</th>
                            <th>Full Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>leave Person</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr>
                            <td><a href="/leaves/{{$leave->id}}" class="text-primary" title="View leave">{{$leave->account_name}}</a></td>
                            <td>{{$leave->leaveCountry}}</td>
                            <td>{{$leave->full_address}}</td>
                            <td>{{$leave->leaveEmail}}</td>
                            <td>{{$leave->leaveMobilePhone}}</td>
                            <td>{{$leave->leavePerson}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection