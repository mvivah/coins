@extends('layouts.app')

<!-- Add Custom content Section-->

    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Support</li>
            </ol>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-primary">How can we help you?</h1>

                </div>
                <div class="col-md-5">
                    <h2 class="text-primary">Share your feedback:</h2>
                    @if($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    <form class="form-group mx-auto" id="feedBackForm">
                        @csrf
                        <input type="hidden" name="name" value="{{Auth::user()->name}}">
                        <input type="hidden" name="email" value="{{Auth::user()->email}}">
                        <div class="form-row">
                            <label for="subject">Subject:</label>
                            <input type="text" class="form-control" name="subject" id="subject">
                        </div>
                        <div class="form-row">
                            <label for="subject">Message:</label>
                            <textarea type="text" class="form-control" name="message_body" id="message_body" rows="6"></textarea>
                        </div>
                        <div class="form-row mt-2">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection