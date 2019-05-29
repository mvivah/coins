@extends('layouts.app')
    @section('content')
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card-body">
              <table class="table table-sm">
                <tr><td>Account Name:</td><td>{{$contact->account_name}}</td></tr>
                <tr><td>Full address:</td><td>{{$contact->full_address}}</td></tr>
                <tr><td>Alternative address:</td><td>{{$contact->alternate_address}}</td></tr>
                <tr><td>Contcat Person:</td><td>{{$contact->contact_person}}</td></tr>
                <tr><td>Contcat Email:</td><td>{{$contact->contact_email}}</td></tr>
                <tr><td>Contcat Phone:</td><td>{{$contact->contact_phone}}</td></tr>
              </table>
              @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                <a href="#" id="{{$contact->id}}" class="btn btn-outline-primary btn-sm editContact" title="Edit contact">
                  <i class="fa fa-edit"></i> Edit
                </a>
              @endif
            </div>
          </div>
          <div class="col-md-9">
            <div class="row">
                @if($contact->opportunities->count()>0)
                @foreach($contact->opportunities as $opportunity)
                <div class="col-md-4">
                  <div class="card mb-4">
                    <div class="card-body">
                    <p class="card-text">{{ $opportunity->opportunity_name}}</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <a href="/opportunities/{{$opportunity->id}}" class="btn btn-sm btn-outline-secondary">View</a>
                          @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                          <a href="/opportunities/{{$opportunity->id}}/edit" class="btn btn-sm btn-outline-secondary">Edit</a>
                          @endif
                        </div>
                        <small class="text-muted">
                          {{
                            Carbon\Carbon::parse($opportunity->created_at)->diffForHumans()
                          }}
                          </small>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                @else
                @endif
              </div>
          </div>
      </div>
    </div>
@endsection