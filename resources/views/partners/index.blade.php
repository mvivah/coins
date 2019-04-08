<!-- Extend Main layout -->

@extends('layouts.app')
    @section('content')
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Partner Firms</li>
    </ol>
    </nav>
    <div class="container-fluid">
        @if(Gate::check('isAdmin') || Gate::check('isDirector'))
        <a href="#" class="btn btn-outline-danger mb-2" data-toggle="modal" data-target="#addpartner"><i class="fa fa-city"></i> Add Partner</a>
        @endif
        <div class="table-responsive">
            <table class="table table-sm table-striped dat">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($partners as $partner)
                <tr>
                    <td>{{$partner->name}}</td>
                    <td>{{$partner->email}}</td>
                    <td>{{$partner->mobilePhone}}</td>
                    <td>{{$partner->partnerStatus}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection