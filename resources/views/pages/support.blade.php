@extends('layouts.app')
    @section('content')
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-primary">FAQs</h1>
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#systemAccess" aria-expanded="true" aria-controls="systemAccess">
                            <i class="fas fa-angle-right"></i> 
                            </button>
                            System Access
                        </div>
                        <div id="systemAccess" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <ol>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fas fa-angle-right"></i>
                            </button>
                            Opportunities
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <ol>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fas fa-angle-right"></i>
                                </button>
                                Projects
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <ol>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#leaveSection" aria-expanded="false" aria-controls="leaveSection">
                                    <i class="fas fa-angle-right"></i>
                                </button>
                                Leave
                            </div>
                            <div id="leaveSection" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <ol>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                </ol>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#meatSection" aria-expanded="false" aria-controls="meatSection">
                                        <i class="fas fa-angle-right"></i>
                                    </button>
                                    Performance Evaluation
                                </h5>
                            </div>
                            <div id="meatSection" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <ol>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                    <li>MySQL is a database management system.</li>
                                </ol>
                            </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-5">
                <h2 class="text-primary">Feedback</h2>
                <p>In case you are unable to get help from the <strong>FAQs</strong>, or you need any other system realated assistance, please contact your <strong>line manager</strong> or send us your query through <strong>this form</strong> and we will get back to you <strong>as soon as possible</strong>.</p>
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
    @endsection