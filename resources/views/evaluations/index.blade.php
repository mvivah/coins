
@extends('layouts.app')

<!-- Add Custom content Section-->

    @section('content')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Meats</li>
            </ol>
        </nav>
        <div class="py-3 bg-light">
            <div class="container-fluid">
                <table id="meats_table" class="table table-striped">
                    <tr>
                        <td>
                            <form class="form-group" action="{{url('storeEvaluations')}}" method="POST" autocomplete="off">
                                @csrf      
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Activity Description</label>
                                        <textarea type="text" name="activity_desc" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Intended Objectives</label>
                                        <textarea type="text" name="intended_objective" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Strengths demonstrated</label>
                                        <textarea type="text" name="strength_demonstrated" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Improvement Points</label>
                                        <textarea type="text" name="improvement_points" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Personal Rating</label><br />
                                        <input type="radio" name="personal_rating" class="radio-label" value="5" required>5
                                        <input type="radio" name="personal_rating" class="radio-label" value="4" required>4
                                        <input type="radio" name="personal_rating" class="radio-label" value="3" required>3
                                        <input type="radio" name="personal_rating" class="radio-label" value="2" required>2
                                        <input type="radio" name="personal_rating" class="radio-label" value="1" required>1
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <button class="btn btn-outline-success btn-sm" type="submit"><i class="fa fa-plus"></i> Add</button>
                                    </div>       
                                </div>
                            </form>
                        </td>
                    </tr>
                    @if($evaluations->count()>0)
                        @foreach ($evaluations as $evaluation)
                        <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-2">
                                    {{$evaluation->activity_desc}}
                                </div>
                                <div class="col-md-2">
                                    {{$evaluation->intended_objective}}
                                </div>
                                <div class="col-md-2">
                                    {{$evaluation->strength_demonstrated}}
                                </div>
                                <div class="col-md-2">
                                    {{$evaluation->improvement_points}}
                                </div>
                                <div class="col-md-2">
                                    {{$evaluation->personal_rating}}
                                </div>
                            </div>
                        </td>
                    </tr>
                        @endforeach
                    @endif
                </table>

        <form action="{{url('storeQuestions')}}" method="POST" id="answersForm">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <col width="250">
                    <col width="15">
                    <col width="80">
                    @foreach($categories as $category)
                        <thead>
                            <th>{{$category->categoryName}}</th>
                            <th>Response</th>
                            <th>Response Explanation</th>
                        </thead>
                        <?php $questionNumber = 0; ?>
                        @foreach($category->questions as $question)   
                            @php
                                $questionNumber += 1;
                            @endphp
                            <tr id="{{str_replace(' ','_',strtolower($category->categoryName))}}_question_{{$questionNumber}}">
                                <td>
                                    {{$question->name}}
                                    <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                </td>            
                                <td>
                                    <input type="radio"
                                    name="response[{{$question->id}}]"
                                    class="radio-label" value="Yes" onclick="doAgree(this.parentNode.nextElementSibling);"> Yes
                                    
                                    <input type="radio" 
                                    name="response[{{$question->id}}]"
                                    class="radio-label" value="No" onclick="doDisagree(this.parentNode.nextElementSibling);"> No
                                </td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
            <div class="btn-group" role="group" aria-label="Basic example" style="float:right">
                <button type="button" class="btn btn-outline-danger"><i class="fa fa-arrow-circle-left"></i> Back</button>
                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-save"></i> Proceed <i class="fa fa-arrow-circle-right"></i></button>
            </div>                                 
        </form>
    </div>
</div>

    <!-- End of page content -->
    @endsection
    <!-- Add Custom Page content -->