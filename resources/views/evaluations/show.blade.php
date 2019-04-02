@extends('layouts.app')
    @section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/contacts">Contacts</a></li>
            <li class="breadcrumb-item" aria-current="page">{{$contact->contact_name}}</li>
        </ol>
    </nav>
    <div class="py-3 bg-light">
            <div class="container-fluid">
    <div class="card shadow">
        <div class="card-body">
            {{$contact->contactCountry}}
        </div>
        <hr>
        <small>Written on: {{$contact->created_at}}</small>
    </div>
    @endsection