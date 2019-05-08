{{-- Errors --}}

<div class="modal fade" id="warn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white text-center">
                <h5 class="modal-title" id="error_title">Please Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="warningMessage">

            </div>
            <div class="modal-footer" id="error_footer">
                <button type="button" class="btn btn-outline-danger btn-sm" id="deleteBtn" data-token="{{ csrf_token() }}">Delete</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{--Messages--}}
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-group" autocomplete="off">
                <div class="modal-header" id="message_header">
                    <h4 class="modal-title" id="message_title">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body" id="message_body">
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>   
        </div>
    </div>
</div>


{{-- Teams --}}
<div class="modal fade" id="addTeams">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="team_form_heading">Create Team</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form autocomplete="off" id="teamsForm">
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label>Team Name:</label>
                        <input type="text" class="form-control" name="team_name" id="team_name">
                        <input type="hidden" name="team_id" id="team_id">
                    </div>
                </div>
                <div class="row">
                <div class="col-md-3">
                        <label>Team Code:</label>
                        <input type="text" class="form-control" name="team_code" id="team_code">
                    </div>
                <div class="col-md-6">
                <label>Team Leader:</label>
                <select name="team_leader" id="team_leader" class="form-control">
                    <option value="0" selected disabled>-- Choose --</option>
                    @foreach(App\User::all() as  $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach                                   
                </select>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
            </div>
        </form>       
    </div>
</div>
</div>

{{-- User Roles --}}
<div class="modal fade" id="addRole">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rolesForm" autocomplete="off" class="form-group">
                <div class="modal-header">
                    <h4 class="modal-title" id="roles_form_heading">Add Role</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label>Role Name:</label>
                            <input type="text" class="form-control" name="role_name" id="role_name">
                            <input type="hidden" name="role_id" id="role_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Description:</label>
                            <input type="text" class="form-control" name="role_description" id="role_description">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="roleBtn" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>  
        </div>
    </div>
</div>

{{--Opportunities--}}
<div class="modal fade" id="add_opportunity" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-group" id="opportunityForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title" id="opportunity_title">Create Opportunity</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="opportunity_id" id="opportunity_id">
                    <div class="form-row">
                        <label for="opportunity_name">Opportunity Name:</label>
                        <textarea name="opportunity_name" id="opportunity_name" class="form-control" rows="2"  placeholder="Enter opportunity"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="contacts">Contact Name</label>
                                <input type="select-one" autocomplete="off" id="thisContact" class="form-control" placeholder="Type contact name here...">
                            <select id="selectedContact" class="form-control" placeholder="Select a contact..." tabindex="1"></select>
                            <input type="hidden" name="contact_id" id="the_contact_id">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputCountry">Country</label>
                            <input list="countryList" name="country" id="country" class="form-control">
                            <datalist id="countryList">
                                {{ getCountry()}}                                                                          
                            </datalist>
                        </div> 
                    </div>      
                    <div class="form-row ">
                        <div class="form-group col-md-7">
                            <label for="inputProject">Funder</label>
                            <input type="text" class="form-control" name="funder" id="funder" placeholder="Enter Funder's name" value="{{old('funder')}}">
                        </div>
                        <div class="form-group col-md-2">
                                <label for="assigned_team">Team </label>
                                <select name="team_id" id="assignedTeam" class="form-control">
                                    <option value="" disabled selected>-- Choose Team--</option>
                                    @foreach(App\Team::all() as  $team)
                                        <option value="{{$team->id}}">{{$team->team_code}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputType">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="" disabled selected>-- Choose Type--</option>
                                @foreach(['Pre-Qualification', 'EOI', 'Proposal'] as $value =>$type)
                                <option value="{{ $type }}">{{ $type }} </option>
                                @endforeach
                            </select>
                        </div>                               
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputRef">Revenue (USD)</label>
                            <input type="number" class="form-control" name="revenue" id="revenue" placeholder="Revenue">
                        </div>                   
                        <div class="form-group col-md-4">
                            <label for="source">Leads Source</label>
                            <select id="lead_source"  name="lead_source" class="form-control">
                                <option value="" disabled selected>-- Choose Leads Source--</option>
                                @foreach(['Cold call', 'Existing customer', 'Self Generated', 'Employee', 'Partner', 'Public Relations', 'Direct Mail', 'Conference', 'Trade Show', 'website', 'word of mouth', 'Email', 'Compaign', 'other'] as $value)
                                <option value="{{$value}}">{{$value}}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sales_stage">Sales Stage</label>
                            <select name="sales_stage" id="sales_stage" class="form-control">
                                <option value="" disabled selected>-- Choose Stage--</option>
                                @foreach(['Under Qualification','Under Preparation','Under Review','Submitted','Not Submitted','Did Not Persue','Dropped','Closed Won','Closed Lost'] as $value =>$sales_stage)
                                <option value="{{ $sales_stage }}">{{ $sales_stage }} </option>
                                @endforeach
                            </select>
                        </div>                      
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="internal_deadline">Internal Deadline</label>
                            <input type="date" name = "internal_deadline" id="internal_deadline" class="form-control" >
                        </div>
                        <div class="form-group col-md-4">
                                <label for="external_deadline">External Deadline</label>
                                <input type="date" name="external_deadline" id="external_deadline" class="form-control">  
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Probability">Probability(%)</label>
                            <input type="number" name="probability" id="probability" class="form-control"  placeholder="Probability %">
                        </div>                                          
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{-- Timesheets --}}
<div class="modal fade bs-example" id="addTimesheet" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <form autocomplete="off" id="timesheetForm">
            <div class="modal-header">
            <h4 class="modal-title" id="timesheet_title">Timesheet</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>           
            <div class="modal-body">
                @csrf
                <input type="hidden" name="timesheet_id" id="timesheet_id">
                <input type="hidden" name="task_id" id="the_task_id">
                <div class="row">
                    <div class="col-md-6">
                        <label>Beneficiary:</label>
                        <select name="beneficiary" id="beneficiary" class="form-control">
                            <option value="0" selected disabled>- Select Beneficiary -</option>
                            <option value="Business Development">Business Development</option>
                            <option value="Opportunities">Opportunities and Projects</option>
                            <option value="Administration">Administration</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <label>Service Line:</label>
                        <select name="serviceline_id" id="the_serviceline" class="form-control" >
                            <option>- Select Service Line -</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label>Select Date:</label>
                        <input type="date" name="activity_date[]" id="activity_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Time taken (Hours):</label>
                        <input type="number" name="duration[]" id="duration" min="1" max="18" maxlength="2" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Add:</label>
                        <button type="button" id="addhours" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Add</button>
                    </div>
                </div>
                <div id="hours_row"></div>
                <div class="row">
                    <div class="col-md-12">
                    <label>Description:</label>
                        <textarea name="activity_description" id="activity_description" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>  
        </div>
    </form>   
</div>
</div>
</div>


{{-- Bid Scores --}}
<div class="modal fade bs-example-modal-lg" id="addScore" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form autocomplete="off" id="scoresForm">
                <div class="modal-header">
                    <h4 class="modal-title">Opportunity Bid Scores</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="opportunity_id" id="this_opportunity_id">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Bid opening date:</label><br>
                            <div class="input-group mb-3">
                                <input type="date" name="opening_date" id="opening_date" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>             
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Bidding Details</label>
                            <table class="table table-bordered table-sm" id="scores_table">
                                <thead>
                                    <tr>
                                    <th scope="col">Name of the Firm</th>
                                    <th scope="col">Technical (%)</th>
                                    <th scope="col">Financial (%)</th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td><input type="text" name="firm_name[]" id="firm_name" class="form-control"></td>
                                    <td><input type="number" name="technical_score[]" id="technical_score" class="form-control"></td>
                                    <td><input type="number" name="financial_score[]" id="financial_score" class="form-control"></td>
                                    <td><button  type="button" id="add_score" name="firm" class="btn btn-outline-primary btn-sm">Add</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Register Users --}}
<div class="modal fade bd-example-modal-lg" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="form-group" id="userForm" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">User Registration</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <fieldset>
                        <legend>Biodata</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Staff ID Number</label>
                                <input type="text" name="staffId" id="staffId"  class="form-control" placeholder="AHC/000/00" maxlength="10">
                                <input type="hidden" id="user_id" name="user_id">
                            </div>
                            <div class="col-md-4">
                                <label>Staff name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Staff Name">
                            </div>
                            <div class="col-md-4">
                                <label>Gender</label>
                                <br>
                                <select type="text" name="gender" id="gender" class="form-control">
                                    <option >-- Select --</option>
                                    <option value="Female" >Female</option>
                                    <option value="Male" >Male</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="email">
                            </div>
                            <div class="col-md-3">
                                <label>Mobile Phone</label>
                                <input type="text" name="mobilePhone" id="mobilePhone" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Alternative Phone</label>
                                <input type="text" name="alternativePhone" id="alternativePhone" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                    <div id="user_login">
                    <fieldset>
                        <legend>Login Information</legend>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                    </fieldset>
                    </div>
                    <fieldset>
                        <legend>Other Details</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Team</label>
                                <select name="user_team_id" id="user_team_id" class="form-control">                            
                                    <option>Choose...</option>
                                    @foreach(App\Team::all() as  $team)
                                    <option value="{{$team->id}}">{{$team->team_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Role</label>
                                <select name="role_id"  id="the_role_id" class="form-control">                            
                                    <option>Choose...</option>
                                    @foreach(App\Role::all() as  $role)
                                    <option value="{{$role->id}}">{{$role->role_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Access Level</label>
                                <select name="level_id"  id="level_id" class="form-control">                            
                                    <option>-- Choose --</option>
                                    @foreach(App\Level::all() as  $level)
                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Reporting to</label>
                                <select name="reportsTo" id="reportsTo" class="form-control">
                                    <option value="" disabled selected>-- Choose --</option>
                                    @foreach(App\User::all() as  $user)
                                    <option value="{{$user->name}}">{{$user->name}}</option>
                                    @endforeach                                   
                                </select>
                            </div>
                        </div>
                    <input type="hidden" name="userStatus" id="userStatus"  value="Inactive">
                </fieldset>        
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

{{-- Associate Registration --}}
<div class="modal fade" id="addAssociate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-group" id="associateRegister" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Add Associate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-5    ">
                            <label>Fullname:</label>
                            <input type="text" name="associate_name" id="associate_name"  class="form-control">
                            <input type="hidden" name="associate_id" id="associate_id">
                        </div>
                        <div class="col-md-2">
                            <label>Gender:</label>
                            <select type="text" name="associate_gender" id="associate_gender" class="form-control">
                                <option >-- Select --</option>
                                <option value="Female" >Female</option>
                                <option value="Male" >Male</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Email:</label>
                            <input type="text" name="associate_email" id="associate_email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Country:</label>
                            <input list="assocCountry" name="associate_country" id="associate_country"  class="form-control">
                            <datalist id="assocCountry">
                                    {{ getCountry() }}                                   
                            </datalist>
                        </div>
                        <div class="col-md-3">
                            <label>Mobile Phone:</label>
                            <input type="text" name="associate_phone" id="associate_phone"  class="form-control">
                        </div>
                        <div class="col-md-3">
                                <label>Office Phone:</label>
                                <input type="text" name="associate_phone1" id="associate_phone1"  class="form-control">
                            </div>
                            <div class="col-md-3">
                                    <label>Date Enrolled:</label>
                                    <input type="date" name="date_enrolled" id="date_enrolled" class="form-control">
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Expertise:</label>
                            <select name="associate_expertise" id="associate_expertise" class="form-control getSpecilization">
                                <option>-- Choose --</option>
                                @foreach(App\Expertise::all() as  $expertise)
                                <option value="{{$expertise->id}}">{{$expertise->field_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                                <label>Specialization:</label>
                                <select type="text" name="associate_specialization" id="associate_specialization" class="form-control">
                                    <option>-- Choose --</option>
                                    
                                </select>
                            </div>
                        <div class="col-md-4">
                            <label>Years of Experience:</label>
                            <input type="number" name="associate_experience" id="associate_experience" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="associate_btn" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Assign Associate --}}
<div class="modal fade" id="pickAssociate" tabindex="-1"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <form id="associateForm" autocomplete="off">
            <div class="modal-header text-center">
                <h4 class="modal-title ">Assign Associate</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="projectAssociate" id="projectAssociate">
                        <label>Associate Name</label>
                        <select name="associate_id" id="associates_id" class="form-control">
                            @foreach(App\Associate::all() as $associate)
                            <option value="{{ $associate->id }}">{{ $associate->associate_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-outline-primary btn-sm">Save</button>
                </div>
            </form>
        </div>   
    </div>
</div>
</div>

{{-- Remove Associate --}}
<div class="modal fade" id="removeAssociate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white text-center">
                <h5 class="modal-title">Associate Evaluation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-row" id="associateAssessmentForm" autocomplete="off">
                    <div class="col-md-12">
                        <input type="hidden" name="associate_id" id="the_associate">
                        <p>What is your rating for this associate in the following areas?</p>
                        <ul class="list-group">
                            <li class="list-group-item">Adherence 
                                <div style="float:right">
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="5">5
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="4">4
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="3">3
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="2">2
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="1">1
                                </div>
                            </li>
                            <li class="list-group-item">Reporting
                                <div style="float:right">
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="5">5
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="4">4
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="3">3
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="2">2
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="1">1
                                </div>
                            </li>
                            <li class="list-group-item">Delivery on terms of reference
                                <div style="float:right">
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="5">5
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="4">4
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="3">3
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="2">2
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="1">1
                                </div>
                            </li>
                            <li class="list-group-item">Quality of Service
                                <div style="float:right">
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="5">5
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="4">4
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="3">3
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="2">2
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="1">1
                                </div>
                            </li>
                            <li class="list-group-item">Communication
                                <div style="float:right">
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="5">5
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="4">4
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="3">3
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="2">2
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="1">1
                                </div>
                            </li>
                            <li class="list-group-item">Knowledge gap
                                <div style="float:right">
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="5">5
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="4">4
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="3">3
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="2">2
                                    <input type="radio" name="personal_rating[]" class="radio-label" value="1">1
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger btn-sm" data-token="{{ csrf_token() }}"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>

{{-- Assign Cosultant --}}
<div class="modal fade" id="addConsultant" tabindex="-1"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <form id="consultantForm" class="form-group" autocomplete="off">
        <div class="modal-header text-center">
            <h4 class="modal-title ">Assign Consultant</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <label>Select Consultants</label>
                    <div class="form-group mb-3">
                        <input type="hidden" name="opportunity_id" id="the_opportunity_id">
                        <input type="hidden" name="project_id" id="project_id">
                        <select class="form-control" id="the_user_id" name="user_id">
                            <option value="" disabled selected>Choose consultant</option>
                            @foreach(App\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-outline-primary btn-sm" id="saveConsultant">Submit</button>
        </div>
    </form>
    </div>
    </div>   
</div>

{{-- Assign Task --}}
<div class="modal fade" tabindex="-1" id="addTask" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <form id="taskForm" autocomplete="off">
        <div class="modal-header">
            <h5 class="modal-title" id="task_title">Assign Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
            @csrf
            <input type="hidden" name="deliverable_id" id="the_deliverable">
            <input type="hidden" name="task_id" id="task_id">
            <div class="row">
                <div class="col-md-12">
                    <label>Task Name</label>
                    <input type="text" class="form-control" name="task_name" id="task_name">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Deadline</label>
                    <input type="date" name="task_deadline" id="task_deadline" class="form-control" >
                </div>
                <div class="col-md-6">
                    <label>Task Status</label>
                    <select class="form-control" name="task_status" id="task_status">
                        <option value="Not Started">Not Started</option>
                        <option value="Working on it">Working on it</option>
                        <option value="Done">Done</option>
                        <option value="Canceled">Canceled</option>
                    </select>
                </div>
            </div>
            <div class="row" id="staff_assignment">
                <div class="col-md-6">
                    <label>Assigned Consultants</label>
                    <select id="taskStaff" name="user_id[]" class="form-control" multiple>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
        </div>
    </form>
    </div>
</div>
</div>
</div>
        
{{-- Public Holidays --}}
<div class="modal fade" id="publicDays" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <form class="form-group" id="holidaysForm" autocomplete="off">
        <div class="modal-header">
        <h5 class="modal-title">Add Holiday</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
                @csrf
            <div class="row">
                <div class="col-md-7">
                    <label>Holiday:</label>
                    <input type="text" name="holiday" id="holiday"  class="form-control">
                    <input type="hidden" name="holiday_id" id="holiday_id">
                </div>

                <div class="col-md-5">
                    <label>Date:</label>
                    <input type="date" name="holiday_date" id="holiday_date" class="form-control">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
        </div>
    </form>
</div>
</div>
</div>

{{-- Service Lines --}}
<div class="modal fade" id="addServiceLine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <form class="form-group"  id="servicelinesForm" autocomplete="off">
        <div class="modal-header">
            <h4 class="modal-title" id="servicelines_form_heading">Add Service Line</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <label>Beneficiary:</label>
                    <select type="text" name="service_beneficiary" id="service_beneficiary" class="form-control">
                        <option value="" disabled selected> - Choose - </option>
                        <option value="Business Development"> Business Development </option>
                        <option value="Opportunities">Opportunities</option>
                        <option value="Administration">Administration</option>
                    </select>
                    <input type="hidden" name="serviceline_id" id="serviceline_id">
                </div>
                <div class="col-md-4">
                    <label>Service Code:</label>
                    <input type="number" name="service_code" id="service_code"  class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Service line:</label>
                    <input type="text" name="service_name" id="service_name" class="form-control">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
        </div>
    </form>
</div>
</div>
</div>

{{--Leave Request--}}
<div class="modal fade" id="addleave" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="leaveForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">Leave Request</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="leave_id" id="leave_id">
                    <input type="hidden" name="user_id" id="booked_for">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Leave Type</label>
                            <select class="form-control" name="the_leavesetting" id="the_leavesetting">
                                @foreach(App\Leavesetting::all() as  $leavesetting)
                                <option value="{{$leavesetting->id}}" data-type="{{$leavesetting->leave_type}}">{{$leavesetting->leave_type}} Leave</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Start Date</label>
                            <input type="date" name="leave_start" id="leave_start" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>End Date</label>
                            <input type="date" name="leave_end" id="leave_end" class="form-control"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Request Details</label>
                            <textarea type="text" name="leave_detail" id="leave_detail" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-outline-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Leave Settings --}}
<div class="modal fade" id="leaveSetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Leave Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-group" id="leaveSettingForm" autocomplete="off">
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label>Leave type:</label>
                    <select class="form-control" name="leave_type" id="leave_type">
                        <option class="form-control" value="Annual">Annual Leave</option>
                        <option class="form-control" value="Compassionate">Compassionate Leave</option>
                        <option class="form-control" value="Sick">Sick Leave</option>
                        <option class="form-control" value="Maternity">Maternity Leave</option>
                        <option class="form-control" value="Paternity">Paternity Leave</option>
                        <option class="form-control" value="Study">Study Leave</option>
                    </select>
                    <input type="hidden" name="leavesetting_id" id="leavesetting_id">
                </div>
                <div class="col-md-3">
                    <label>Annual Lot:</label>
                    <input type="number" name="annual_lot" id="annual_lot" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Bookable:</label>
                    <input type="number" name="bookable_days" id="bookable_days" class="form-control">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
        </div>
    </form>
    </div>
    </div>
</div>

{{-- Deliverables --}}
<div class="modal fade" id="add_deliverables" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliverable_title">Create Deliverable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group" id="deliverablesForm" autocomplete="off">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="deliverable_id" id="deliverable_id">
                    <input type="hidden" name="opportunity_id" id="the_opportunity">
                    <input type="hidden" name="project_id" id="the_project_id">
                    <div class="row" id="create_deliverables">
                        <div class="col-md-6">
                            <label>Deliverable Type:</label>
                            <br><input type="radio" name="deliverable_type" class="radio-label" value="Opportunity" checked> Opportunity &nbsp;<input type="radio" name="deliverable_type" class="radio-label" value="Project">Project
                        </div>
                        <div class="col-md-6">
                            <label>Deliverable Name:</label>
                            <input type="text" name="deliverable_name"  id="deliverable_name_project" class="form-control">
                        </div>
                    </div>
                    <div class="row" id="use_deliverables">
                        <div class="col-md-5">
                            <label>Select Deliverables:</label>
                            <select name="deliverable_id"  id="deliverable_ids" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status:</label>
                            <select type="text" name="deliverable_status" id="deliverable_status" class="form-control">
                                <option value="" disabled selected>Choose Status</option>
                                <option value="Not Started">Not Started</option>
                                <option value="Working on it">Working on it</option>
                                <option value="Done">Done</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Completion:</label>
                            <input type="date"  name="deliverable_completion" id="deliverable_completion" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Contacts Modal --}}
<div class="modal fade bs-example-modal-lg" id="addContact" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-group" id="contactsForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">Add Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label>Account Name:</label>
                            <input type="text" name="account_name"  id="account_name" class="form-control">
                            <input type="hidden" name="contact_id" id="contact_id">                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Full Address:</label>
                            <textarea name="full_address"  id="full_address" class="form-control" rows="3"></textarea>                            
                        </div>
                        <div class="col-md-6">
                            <label>Alternate Address</label>
                            <textarea name="alternate_address"  id="alternate_address" class="form-control" rows="3"></textarea>  
                        </div>
                    </div>
                <br>
                <fieldset>
                    <legend>Contact Details</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Contact Person</label>
                            <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Fullname">
                        </div>
                        <div class="col-md-4">
                            <label>Email</label>
                            <input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="email">
                        </div>                                            
                        <div class="col-md-4">
                            <label>Mobile Phone</label>
                            <input type="text" name="contact_phone" id="contact_phone" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Alternative Contact </label>
                            <input type="text" name="alternative_person" id="alternative_person" class="form-control" placeholder="Fullname">
                        </div>
                        <div class="col-md-4">
                            <label>Email</label>
                            <input type="email" name="alternative_person_email" id="alternative_person_email" class="form-control" placeholder="email">
                        </div>                                            
                        <div class="col-md-4">
                            <label>Mobile Phone</label>
                            <input type="text" name="alternative_person_phone" id="alternative_person_phone" class="form-control">
                        </div>
                    </div>
                </fieldset>                   
            </div>
            {{-- Modal footer --}}
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary btn-sm" id="saveContact">Save</button>  
            </div>
        </form>
        </div>
    </div>
</div>

{{-- Add Expertise --}}         
<div class="modal fade" id="addExpertise" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-group" autocomplete="off" id="expertiseForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="expertise_form_heading">Add Expertise</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <label>Field Name:</label>
                            <input type="text" name="field_name" id="field_name" class="form-control">
                            <input type="hidden" name="expertise_id" id="expertise_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Description:</label>
                            <input type="text" name="field_description" id="field_description" class="form-control">
                        </div>
                    </div>              
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{-- Add Specialization--}}      
<div class="modal fade" id="addSpecialization" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-group" autocomplete="off" id="specializationForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="specialization_title">Add Specialization</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="expertise_id" id="the_expertise">
                    <input type="hidden" name="specialization_id" id="specialization_id">
                    <div class="row">
                        <div class="col-md-10" >
                            <input type="text" name="specialization[]" id="specialization" class="form-control" placeholder="Specilaization">
                        </div>
                        <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-sm" id="addSpecials">Add</button>
                        </div>
                    </div>
                    <div id="specials_row"></div>              
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{--Documents--}}
<div class="modal fade bs-example-modal-lg" id="addDocument" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{url('documents')}}" method="POST" enctype="multipart/form-data" id="documentsForm" autocomplete="off">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-paperclip"></i> Attachments</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="owner_id">
                        <input type="hidden" id="fileName">
                        <div class="col-md-4"> 
                            <label for="document_type">Document Type: </label>
                            <select class="form-control {{ $errors->has('document_type') ? ' is-invalid' : '' }}" name="document_type"  id="document_type" required>
                                <option value="" disabled selected>- Choose -</option>
                                <option value="Tenders">Tender</option>
                                <option value="Proposals">Proposal</option>
                                <option value="Reports">Report</option>
                                <option value="cvs">CV</option>
                                <option value="Transcripts">Transcript</option>
                                <option value="RFPs">RFP</option>
                            </select>
                        </div>
                        <div class="col-md-8"> 
                            <label for="document">Attach File: </label>
                            <input type="file" class="form-control {{ $errors->has('document') ? ' is-invalid' : '' }}" name="document"  id="document" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> 
                            <label for="file_description">Description: </label>
                            <input class="form-control {{ $errors->has('file_description') ? ' is-invalid' : '' }}" name="file_description"  id="file_description" required>
                            
                        </div>
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{-- Edit Project --}}
<div class="modal fade" id="edit_Project" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form class="form-group" id="editProjectForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">Update Project</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4"> 
                            <label for="project_status">Project Status: </label>
                            <select name="project_status" id="project_status" class="form-control">
                                <option value="Open">Open</option>
                                <option value="Paused">Paused</option>
                                <option value="Closed">Closed</option>
                            <select>
                        </div>
                        <div class="col-md-8">
                            <label for="project_stage">Project Stage: </label>
                            <select name="project_stage" id="project_stage" class="form-control">
                                <option value="Initiation">Initiation</option>
                                <option value="Inception">Inception</option>
                                <option value="Planning">Planning</option>
                                <option value="Execution">Execution</option>
                                <option value="Evaluation">Evaluation</option>
                                <option value="Completion">Completion</option>
                            <select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <label for="start_date">Start Date: </label>
                            <input type="date" name="initiation_date" id="initiation_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="project_stage">Completion Date: </label>
                            <input type="date" name="completion_date" id="completion_date" class="form-control">
                            <input type="hidden" id="projectid">
                        </div>
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm" id="project_update_btn">Update</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{--Comments--}}
<div class="modal fade" id="addComments" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form class="form-group" id="commentsForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title" id="comment_title">Add Comment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="comment_id" id="comment_id">
                            <input type="hidden" name="commentable_type" id="commentable_type">
                            <input type="hidden" name="commentable_id" id="commentable_id">
                            <label for="comment">Comment</label>
                            <textarea name="comment_body" id="comment_body" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>
    
{{--Evaluation--}}
<div class="modal fade" id="addEvaluations" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-group" id="evaluationForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title" id="evaluation_title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="evaluationable_type" id="evaluationable_type">
                    <input type="hidden" name="evaluationable_id" id="evaluationable_id">
                    <input type="hidden" name="evaluation_id" id="evaluation_id">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Exceptional_tasks">Exceptional Tasks</label>
                            <textarea name="exceptional_tasks" id="exceptional_tasks" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Results_achieved">Results Achieved</label>
                            <textarea name="results_achieved" id="results_achieved" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="challenges_faced">Challenges Faced</label>
                            <textarea name="challenges_faced" id="challenges_faced" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="improvement_plans">Improvement Plan (Actions to improve performance)</label>
                            <textarea name="improvement_plans" id="improvement_plans" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{--Leave Carried Forward--}}
<div class="modal fade" id="addLeaveforward" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-group" id="forwardedLeaveForm" autocomplete="off">
                <div class="modal-header">
                <h4 class="modal-title">Leave carried forward from {{date('Y')-1}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="previous_year" id="previous_year" value="{{date('Y')-1}}">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Staff:</label>
                            <select type="text" class="form-control" name="user_id" id="forwarding_user">
                                @foreach(App\User::all() as  $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach                                     
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Days:</label>
                            <input type="number" class="form-control" name="days_forwarded" id="days_forwarded" max="21" min="1" maxlength="2">
                            <input type="hidden" id="leaveforward_id">
                        </div>
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm" id="saveForwardedLeave">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{--User Assessment--}}
<div class="modal fade bs-example-modal-lg" id="staffAssessment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-group" id="assessmentForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">Staff Assessment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="user_id" id="consultant_id">
                    <input type="hidden" name="assessment_period" id="assessment_period">
                    <div class="row" id="assessment_page">
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>

{{--Team Targets--}}
<div class="modal fade" id="addTargets" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-group" id="targetsForm" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title" id="targets_heading">Performance Targets</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>           
                {{-- Modal body --}}
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="target_id" id="target_id">
                    <div class="row">
                        <div class="col-md-9">
                            <label for="target_category">Category</label>
                            <select type="text" name="target_category" id="target_category" class="form-control">
                                <option value="" disabled selected> -Select Category- </option>
                                <option value="Technical performance- Quantitative">Technical performance- Quantitative</option>
                                <option value="Technical Performance-Qualitative">Technical Performance-Qualitative</option>
                                <option value="Business Development">Business Development</option>
                                <option value="Personnel Development">Personnel Development</option>
                                <option value="Team Development and Management">Team Development</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="target_period">Period</label>
                        <input type="number" name="target_period" id="target_period" value="{{date('Y')}}" min="{{date('Y')}}" max="{{date('Y')}}" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="target_name">Target name</label>
                        <input type="text" name="target_name" id="target_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="target_team">Teams</label>
                            <select type="text" class="form-control" name="team_id[]" id="target_team" multiple>
                                @foreach(App\Team::all() as  $team)
                                <option value="{{$team->id}}">{{$team->team_code}}</option>
                                @endforeach                                     
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="target_value">Value</label>
                            <input type="number" name="target_value" id="target_value" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="assessable">Assessable</label>
                            <br />
                            <input type="radio" name="assessable" class="radio-label" value="1">True
                            <input type="radio" name="assessable" class="radio-label" value="0" checked>False
                        </div>
                    </div>
                </div>
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>   
        </div>
    </div>
</div>