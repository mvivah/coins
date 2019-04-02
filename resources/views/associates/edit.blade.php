@extends('layouts.app')
    @section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/associates">Associates</a></li>
            <li class="breadcrumb-item" aria-current="page">{{$associate->associate_name}}</li>
        </ol>
    </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card shadow-lg">
                <div class="modal-body">
                    <form class="form-group" id="editAssociateForm" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-5    ">
                                <label>Fullname:</label>
                            <input type="text" name="associate_name" value="{{$associate->associate_name}}"  class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>Gender:</label>
                                <select type="text" name="associate_gender" value="{{$associate->associate_gender}}" class="form-control">
                                    <option >-- Select --</option>
                                    <option value="Female" >Female</option>
                                    <option value="Male" >Male</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label>Email:</label>
                                <input type="text" name="associate_email" value="{{$associate->associate_email}}" class="form-control">
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Country:</label>
                                    <input list="assocCountry" name="associate_country" value="{{$associate->associate_country}}"  class="form-control">
                                    <datalist id="assocCountry">
                                            {{ getCountry() }}                                   
                                    </datalist>
                                </div>
                                <div class="col-md-4">
                                    <label>Mobile Phone:</label>
                                    <input type="text" name="associate_phone" value="{{$associate->associate_phone}}"  class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label>Office Phone:</label>
                                    <input type="text" name="associate_phone1" value="{{$associate->associate_phone1}}"  class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Area of Expertise:</label>
                                    <select name="associate_expertise" value="{{$associate->associate_expertise}}" class="form-control" onchange="getSpecilization(this.value)">
                                            <option>-- Choose --</option>
                                            @foreach(App\Expertise::all() as  $expertise)
                                            <option value="{{$expertise->id}}">{{$expertise->field_name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Specialization:</label>
                                    <select type="text" name="associate_specialization" value="{{$associate->associate_specialization}}" class="form-control associate_specialization">
                                            <option>-- Choose --</option>   
                                        </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Experience (Years):</label>
                                    <input type="number" name="associate_experience" value="{{$associate->associate_experience}}" class="form-control">
                                    <input type="hidden" id="associateId">
                                </div>
                                <div class="col-md-4">
                                    <label>Date Enrolled:</label>
                                    <input type="date" name="newdate_enrolled" value="{{$associate->date_enrolled}}" class="form-control">
                                </div>          
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" style="float:right" class="btn btn-outline-danger"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>

@endsection