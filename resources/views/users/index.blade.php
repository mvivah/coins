<!-- Extend Main layout -->

@extends('layouts.app')
    @section('content')
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Users</li>
    </ol>
    </nav>
    <div class="container-fluid">
        @if(Gate::check('isAdmin') || Gate::check('isDirector'))
		    <a href="#" class="btn btn-outline-danger mb-2" data-toggle="modal" data-target="#addUser"><i class="fas fa-user-circle"></i> Add User</a>
	    @endif
        <div class="table-responsive">
            <table class="table table-sm table-striped dat">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Team</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>@can('isAdmin')
                        <td><a href="/users/{{$user->id}}" class="text-primary" title="View Profile">{{$user->staffId}}</a></td>
                    @endcan
                    @cannot('isAdmin')
                        <td>{{$user->staffId}}</td>
                    @endcannot
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->mobilePhone}}</td>
                    <td>{{$user->team->team_code}}</td>
                    <td>{{$user->role->role_name}}</td>
                    <td>{{$user->userStatus}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection