<!-- Extend Main layout -->

@extends('layouts.app')
    @section('content')
        @if(Gate::check('isAdmin') || Gate::check('isDirector'))
		    <a href="#" class="btn btn-outline-danger mb-2 btn-sm" data-toggle="modal" data-target="#addUser"><i class="fas fa-user-plus"></i> Add User</a>
	    @endif
        <table class="table table-sm table-striped tabledata">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Team</th>
                    <th>Title</th>
                    <th>Status</th>
                    @if(Gate::check('isAdmin'))
                    <th>Actions</th>
                @else
                @endif
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->staffId}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->mobilePhone}}</td>
                <td>{{$user->team->team_code}}</td>
                <td>{{$user->title->name}}</td>
                <td>{{$user->userStatus}}</td>
                @if(Gate::check('isAdmin'))
                <td>
                    <a href="/users/{{$user->id}}"><i class="fa fa-eye" title="View user"></i></a>
                    <a href="#"><i class="fa fa-edit editUser" id="{{$user->id}}" title="Edit user"></i></a>
                </td>
            @else
            @endif
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection