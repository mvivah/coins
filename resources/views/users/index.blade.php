<!-- Extend Main layout -->

@extends('layouts.app')
    @section('content')
        @if(Gate::check('isAdmin') || Gate::check('isDirector'))
		    <a href="#" class="btn btn-outline-danger mb-2 btn-xs" data-toggle="modal" data-target="#addUser"><i class="fas fa-user-plus"></i> Add User</a>
	    @endif
        <div class="table-responsive">
            <table class="table table-sm">
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
                <tr>@if(Gate::check('isAdmin'))
                        <td><a href="/users/{{$user->id}}" class="text-primary" title="View Profile">{{$user->staffId}}</a></td>
                    @else
                        <td>{{$user->staffId}}</td>
                    @endif
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