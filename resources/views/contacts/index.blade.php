@extends('layouts.app')
    @section('content')
    <div class="row">
        <div class="col-md-12">
            @can('isAdmin')
            <button class="btn btn-outline-danger mb-2 btn-xs" data-toggle="modal" data-target="#addContact"><i class="fas fa-users-cog"></i> Add contacts</button>
            @endcan
            <div class="table-responsive">
                <table class="table table-sm table-hover dat">
                    <thead>
                        <tr>
                            <th>Contact Name</th>
                            <th>Full Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td><a href="/contacts/{{$contact->id}}" class="text-primary" title="View contact">{{$contact->account_name}}</a></td>
                            <td>{{$contact->full_address}}</td>
                            <td>{{$contact->contact_email}}</td>
                            <td>{{$contact->contact_phone}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection