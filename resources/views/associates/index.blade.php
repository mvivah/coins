@extends('layouts.app')
@section('content')
    @can('isAdmin')
    <button class="btn btn-outline-danger m-2 btn-xs" data-toggle="modal" data-target="#addAssociate"><i class="fas fa-user-graduate"></i> Add Associates</button>
    @endcan
    <div class="table-responsive">
        <table class="table table-sm table-hover dat">
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Specialization</th>
                    <th>Experience</th>
                </tr>
            </thead>
            <tbody>
                @foreach($associates as $associate)
                <tr>
                    <td><a href="/associates/{{$associate->id}}" class="text-primary" title="View Associate">{{$associate->associate_name}}</a></td>
                    <td>{{$associate->associate_email}}</td>
                    <td>{{$associate->associate_phone}}</td>
                    <td>{{$associate->associate_country}}</td>
                    <td>{{$associate->associate_expertise}}</td>
                    <td>{{$associate->associate_experience}} Years</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection