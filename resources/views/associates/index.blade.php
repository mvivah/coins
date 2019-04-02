@extends('layouts.app')
    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Associates</li>
            </ol>
        </nav>
        <div class="container-fluid">
            @can('isAdmin')
            <button class="btn btn-outline-danger mb-2" data-toggle="modal" data-target="#addAssociate"><i class="fas fa-user-graduate"></i> Add Associates</button>
            @endcan

            <div class="table-responsive">
                <table class="table table-sm table-hover dat">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Expertise</th>
                            <th>Specialization</th>
                            <th>Experience</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($associates as $associate)
                        <tr>
                            <td><a href="associates/{{$associate->uuid}}" class="text-primary" title="View Associate">{{$associate->associate_name}}</a></td>
                            <td>{{$associate->associate_email}}</td>
                            <td>{{$associate->associate_phone}}</td>
                            <td>{{$associate->associate_country}}</td>
                            <td>{{$associate->associate_expertise}}</td>
                            <td>{{$associate->associate_expertise}}</td>
                            <td>{{$associate->associate_experience}} Years</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection