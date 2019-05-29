
@extends('layouts.app')

<!-- Add Custom content Section-->

    @section('content')
        <div class="py-3 bg-light">
                <div class="container-fluid">
                <div class="row">
                <div class="col-md-12">
                <table class="table table-sm table-stripped dat">
            <thead><tr><th>Fullname</th><th>Email</th><th>Phone</th><th>Country</th><th>Expertise</th><th>Experience</th><th>Actions</th></tr><thead>
            @foreach($documents as $document)
            <tbody>
                <tr>
                    <td>{{$document->document_url}}</td>
                    <td>{{$document->documentEmail}}</td>
                    <td>{{$document->documentPhone}}</td>
                    <td>{{$document->documentCountry}}</td>
                    <td>{{$document->documentExpertise}}</td>
                    <td>{{$document->documentExperience}} Years</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="/documents/{{$document->id}}" class="btn btn-outline-danger btn-sm viewdocument" title="View document"><i class="fa fa-eye"></i></a>
                            <a href="#" id="{{$document->id}}" class="btn btn-outline-primary btn-sm editdocument" title="Edit document"><i class="fa fa-edit"></i></a>
                            <a href="#" id="{{$document->id}}" class="btn btn-outline-secondary btn-sm getCV" title="Download CV"><i class="fa fa-download"></i></a>
                            <a href="#" id="{{$document->id}}" class="btn btn-outline-danger btn-sm deldocument" title="Delete document"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @endsection