@extends('layouts.app')

<!-- Add Custom content Section-->

    @section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Competitor Scores</li>
        </ol>
    </nav>
    <div class="py-3 bg-light">
            <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                <div class="card-header">
                    Competitor Scores
                </div>
                {{-- {{dd($scores)}} --}}
                <div class="card-body">
                    @if(count($scores)>0)
                        @foreach($scores as $score)
                        <table>
                            <tr><td colspan="2"><b>Opportunity Name</b></td><td>{{$score->opportunity->opportunity_name}}</td><td colspan="2"><b>Opening date:<b></td><td>{{$score->opening_date}}</td></tr>
                            <tr><td>Firmname:</td><td>Technical Score:</td><td>Financial Score:</td></tr>
                            <tr><td>{{$score->firm_name}}</td><td>{{$score->technical_score}}</td><td>{{$score->financial_score}}</td></tr>
                        </table>
                        @endforeach
                    @else
                        <p>No scores found</p>
                    @endif
                </div>
                </div>  
            </div>
        </div>
    @endsection