const http = new DataSource();
const THISDAY = new Date();
const THISMONTH = THISDAY.getMonth();
const THISYEAR = THISDAY.getFullYear();

const GET_DAY_NAME = (dt)=>{
    const DAYS = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    return DAYS[dt.getDay()];
};

const GET_MONTH_NAME = (dt)=>{
    const MONTHS = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
    return MONTHS[dt.getMonth()];
};

let FIELD_IDS = [];
let ERROR_COUNT = 0

try{
    //Save contacts
    document.getElementById('contactsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const CONTACT_INDEX = document.getElementById('contact_id');
        const CONTACT_ID = (CONTACT_INDEX == null)? null:CONTACT_INDEX.value;
        FIELD_IDS = ['account_name','full_address','contact_person','contact_email','contact_phone'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( CONTACT_ID != null ){
                http.put(`/contacts/${CONTACT_ID}`,formData)
                .then( data => {
                    console.log(data)
                    $('#contactsForm')[0].reset();
                    $('#addContact').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{
                http.post('/contacts',formData)
                .then( data =>{
                    console.log(data)
                    $('#contactsForm')[0].reset();
                    $('#addContact').modal('hide');
                    location.reload();
                })
                .catch( err => console.error(err) );
            }
        }
    });

}
catch(e){

}

try{
    //Edit contact
    document.querySelector('.editContact').addEventListener('click', e =>{
        let id = e.target.id;
        http.get(`/contacts/${id}/edit`)
        .then( data =>{
            document.getElementById('account_name').value = data.account_name;
            document.getElementById('full_address').value = data.full_address;
            document.getElementById('alternate_address').value = data.alternate_address;
            document.getElementById('contact_person').value = data.contact_person;
            document.getElementById('contact_email').value = data.contact_email;
            document.getElementById('contact_phone').value = data.contact_phone;
            document.getElementById('alternative_person').value = data.alternative_person;
            document.getElementById('alternative_person_email').value = data.alternative_person_email;
            document.getElementById('alternative_person_phone').value = data.alternative_person_phone;
            document.getElementById('contact_id').value = data.id;
            $('#addContact').modal('show');
        })
        .catch( err => console.error(err) );
    });
}
catch(e){

}
try{
    //Opportunities
    document.getElementById('opportunityForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = ['opportunity_name','the_contact_id','country','funder','type','revenue','lead_source','sales_stage','external_deadline','internal_deadline','probability'];
        
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){

            let formData = new FormData(this);

            http.post('/opportunities',formData)
            .then( data =>{
                showAlert(data.message,'success');
                //location.reload();
            })
            .catch(err=>{
                console.error(err);
            })
        }
    })
 
    //Search for contacts
    document.getElementById('thisContact').addEventListener('keyup', e =>{
        let account_name = document.getElementById('thisContact').value;
        e.preventDefault();
        if(account_name ==''||account_name == undefined){
            document.getElementById('selectedContact').style.display = 'none';
            return false;
        }
        else{
            let formData = new FormData();
            let options = [];
            formData.append('account_name', account_name)
            http.post('/listContacts',formData)
            .then( data =>{
                if(data.length == 0){
                    options.push(`<option value="0">No Contacts found...</option>`);
                    document.getElementById("selectedContact").innerHTML = options;
                }else{
                    data.forEach( contact =>{
                        options.push( `<option data-name="${contact.account_name}" value="${contact.id}">${contact.account_name}</option>` );
                    })
                    document.getElementById("selectedContact").innerHTML = `<option value="">-Select Contact-</option>${options}`;
                }
                document.getElementById('selectedContact').style.display = 'block';
            })
            .catch(err=>{
                console.error(err);
            })
        }
    });

    document.getElementById('selectedContact').addEventListener('change', (e) => {
        let selectedContact = document.getElementById('selectedContact');
        let options = e.target.children;

        for( let i = 0; i < options.length; i++ ){
            if (options[i].value == selectedContact.value){
                document.getElementById('thisContact').value = options[i].dataset.name;
            }
        }

        document.getElementById('the_contact_id').value = selectedContact.value;
        document.getElementById('selectedContact').style.display = 'none';
    })
}
catch(e){

}
try{
    document.getElementById('create_opportunity').addEventListener('click', e =>{
        http.get('/getcontacts')
        .then( data =>{
            if(data.length != 0){

            }else{
                showErrorModal(`You need contscts before creating an opportunity`);
            }
        })
        .catch( e =>{
            console.error(e)
        })
    });

    document.getElementById('opportunityFilter').addEventListener('click', e =>{
        e.preventDefault();
        document.getElementById('summaries').innerText = ``;
        elementRemove(`sorted_opportunities`);
        FIELD_IDS = ['opportunityTeam','opportunityType','opportunityStage','opportunityCountry','opportunityStart','opportunityEnd'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let opportunitiesFilterForm = document.getElementById('opportunitiesFilterForm');
            document.getElementById('records-list').style.display = 'none';
            document.getElementById('loading').style.display = 'block';
            setTimeout(calculateResults('filterOpportunities',opportunitiesFilterForm),1000);
        }
    })

    // Save score
    document.getElementById('saveScore').addEventListener('click', e => {
        e.preventDefault();
        let saveScore = document.getElementById('saveScore');
        let formData = new FormData(saveScore);

        http.post('/scores',formData)
        .then( () => {
            $('#scoresForm')[0].reset();
            $('#addScore').modal('hide');
            location.reload();
        })
        .catch( err => console.error(err));
    });

    //Details for sales stages
    document.getElementById('newSalesStatus').addEventListener('change', () =>{
        let opportunity = document.getElementById('forScore').value
        let omn = document.getElementById('omn').value
        if(this.value=='Not Submitted' || this.value=='Dropped' || this.value=='Did Not Persue'){
            document.getElementById('opportunity').value = opportunity;
            document.getElementById('opportunity').value = this.value;
            $('#addReason').modal('show');
        }
        else if(this.value=='Closed Lost'){
            document.getElementById('opportunity').value = opportunity;
            document.getElementById('omnumber').value = omn;
            $('#addScore').modal('show');
        }
        else{

        }
    });

    //Add document to opportunity
    station = (document.getElementById('project-document'))? document.getElementById('project-document') : document.getElementById('opportunity-document');
    station.addEventListener('click', e =>{
        getDocument(e);
    });

    let opportunityExport = document.getElementById('export_opportunities');
    console.log(opportunityExport);
    opportunityExport.addEventListener('click', e =>{
        alert('hi...')
        console.log(e)
    })
}
catch(e){
    console.log(e)
}

try{
    //Assign consultant to Opportunities
    document.getElementById('user-opportunity').addEventListener('click', e => {
        let id = e.target.dataset.id;
        openConsultation('the_opportunity_id',id);
    });

    //Assign Consultant
    document.getElementById('saveConsultant').addEventListener('click', e =>{
        e.preventDefault();
        let consultantForm = document.getElementById('consultantForm');
        assignUser(consultantForm,'/opportunityUser');
        $('#addConsultant').modal('hide');

    });
    
    //Remove Consultant
    document.querySelectorAll('.delConsultant').forEach(element => {
        element.addEventListener('click', e =>{
            console.log(e.target)
            let id =  e.target.id;
            let item =  e.target.dataset.item;
            confirmDelete(id,item);
        });
    });
    
    document.getElementById('deleteBtn').addEventListener('click', () =>{
        let item = document.getElementById('item-delete').dataset.record;
        let id = document.getElementById('item-delete').value;
        let source = (item == 'Opportunity')? `/removeConsultant/${id}` : `/unassignConsultant/${id}`;
        deleteItem(source);
    });
}
catch(e){

}

try{
    //Edit project
    document.getElementById('editProject').addEventListener('click', e =>{
        let id = e.target.dataset.id;
        http.get(`/projects/${id}/edit`)
        .then(data =>{
            document.getElementById('project_stage').value = data.project_stage;
            document.getElementById('project_status').value = data.project_status;
            document.getElementById('initiation_date').value = data.initiation_date;
            document.getElementById('completion_date').value = data.completion_date;
            document.getElementById('projectid').value = data.id;
            $('#edit_Project').modal('show');
        } )
        .catch( err => console.error(err) )
    });

    //Update project
    document.getElementById('editProjectForm').addEventListener('submit', function(e){
        e.preventDefault();

        FIELD_IDS = ['project_stage','project_status','initiation_date','completion_date'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);

        if( validateForm === 0 ){
            let id = document.getElementById('projectid').value;
            let formData = new FormData(this);
            http.post(`/projects/${id}`,formData)
            .then( data => {
                console.log(data.message)
                $('#edit_Project').modal('hide');
                $('#editProjectForm')[0].reset();
                location.reload();
            })
            .catch( err => console.error(err) );
        }else{
            console.log(validateForm)
        }
    });
    
    // Assign consultant to projects
    document.getElementById('user-project').addEventListener('click', e => {
        let id = e.target.dataset.id;
        openConsultation('project_id',id);
    });

    document.getElementById('saveConsultant').addEventListener('click', function(e){
        e.preventDefault();
        let consultantForm = document.getElementById('consultantForm');
        assignUser(consultantForm,'/projectUser');
        $('#addConsultant').modal('hide');

    });

    //Add document project
    let station = (document.getElementById('project-document'))? document.getElementById('project-document') : document.getElementById('opportunity-document');
    station.addEventListener('click', e =>{
        getDocument(e);
    });

    //Assign Associates to project
    document.getElementById('assignAssociate').addEventListener('click', e =>{
        let id = e.target.dataset.id;
        document.getElementById('projectAssociate').value = id;
        $('#pickAssociate').modal('show');
    });

    //Remove Associate
    document.getElementById('removeAssociate').addEventListener('click', e =>{
        confirmDelete(e.target.id)
    });

    document.getElementById('deleteBtn').addEventListener('click', () =>{
        console.log('Deleting....')
    });
    // Add Deliverable
    document.getElementById('deliverablesForm').addEventListener('submit', function(e){
        e.preventDefault();
        const DELIVERABLE_INDEX = document.getElementById('deliverable_id');
        const DELIVERABLE_ID = (DELIVERABLE_INDEX == null)? null:DELIVERABLE_INDEX.value;
        FIELD_IDS = ['deliverable_name','deliverable_status','deliverable_complition'];

        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( DELIVERABLE_ID !=null ){
                http.put(`/deliverables/${DELIVERABLE_ID}`,formData)
                .then( () => {
                    $('#deliverablesForm')[0].reset();
                    $('#newDeliverable').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{ 
                http.post('/deliverables',formData)
                .then( () => {
                    $('#deliverablesForm')[0].reset();
                    $('#newDeliverable').modal('hide');
                    location.reload();
                })
                .catch( err => console.error(err) );
            }
        }
    });
    
    //Edit Deliverable
    document.querySelectorAll('.editDeliverable').forEach( editDeliverable => {
        editDeliverable.addEventListener('click', e =>{ 
            let id = e.target.id;
            http.get(`/deliverables/${id}/edit`)
            .then(data =>{
                document.getElementById('deliverable_name').value = data.deliverable_name;
                document.getElementById('deliverable_status').value = data.deliverable_status;
                document.getElementById('deliverable_complition').value = data.deliverable_complition;
                document.getElementById('projectDeliverable').value = data.project_id;
                document.getElementById('deliverable_id').value = data.id;
                $('#newDeliverable').modal('show');
            })
            .catch( err => console.error(err) );
        });
    });
        
    //Add Deliverable
    document.getElementById('addDeliverable').addEventListener('click', e => {
        let id = e.target.dataset.id;
        document.getElementById('projectDeliverable').value = id;
        $('#newDeliverable').modal('show');
    });

    //Project Evaluation
    document.getElementById('projecEtvaluation').addEventListener('click', e =>{
        let id = e.target.dataset.id;
        let theModel = e.target.dataset.model;
        doEvaluation(id,theModel);
    })

    //Save tasks 
    document.getElementById('taskForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = ['task_name','task_deadline','task_status','taskStaff'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            http.post('/tasks',formData)
            .then( data => {

                $('#taskForm')[0].reset();
                $('#addTask').modal('hide');
                location.reload();
            })
            .catch( err => console.error(err) );
    
        }else{
            console.log(validateForm)
        }

    });
    
    //Edit Task
    document.querySelectorAll('.editTask').forEach( editDeliverable => {
        editDeliverable.addEventListener('click', e =>{ 
            let id = e.target.id;
            let options = [];
            http.get(`/tasks/${id}/edit`)
            .then( data => {

                document.getElementById("the_serviceline").innerHTML = options;
                document.getElementById('task_name').value = data.task_name;
                document.getElementById('task_deadline').value = data.task_deadline;
                document.getElementById('task_status').value = data.task_status;
                document.getElementById('task_id').value = data.id;
                document.getElementById("taskUsers").style.display = 'none';
                document.getElementById('task_id').innerText = 'Update Task';
                $('#addTask').modal('show');
            })
            .catch( err => console.error(err) );
        });
    });

  document.querySelectorAll('.taskDetail').forEach(task=>{
    task.addEventListener('click', e =>{
        e.preventDefault()
        showTaskDetails(e)
    })
  })
   
}
catch(e){

}

try{
    document.getElementById('projectFilter-btn').addEventListener('click', e =>{
        e.preventDefault();
        document.getElementById('projectSummaries').innerText = ``;
        elementRemove(`sorted_projects`);
        FIELD_IDS = ['project-status','project-stage','project-country','initiation-date','completion-date','searchRange'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let projectsFilterForm = document.getElementById('projectsFilterForm');
            document.getElementById('project-records').style.display = 'none';
            document.getElementById('loading').style.display = 'block';
            setTimeout(calculateResults('filterProjects',projectsFilterForm),1000);
        }
    })
}
catch(e){

}

try{
    //Add associate
    document.getElementById('associatesForm').addEventListener('submit', function(e){
        e.preventDefault();
        const ASSOCIATE_INDEX = document.getElementById('associate_id');
        const ASSOCIATE_ID = (ASSOCIATE_INDEX == null)? null:ASSOCIATE_INDEX.value;
        FIELD_IDS = ['associate_name','associate_gender','associate_email','associate_country','associate_phone','date_enrolled','associate_expertise','associate_specialization','associate_experience'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( ASSOCIATE_ID !=null ){
                http.put(`/associates/${ASSOCIATE_ID}`,formData)
                .then( () => {
                    $('#associateForm')[0].reset();
                    $('#addAssociate').modal('hide');
                } )
                .catch( err => console.error(err) );
            }
            else{ 
                http.post('/associates',formData)
                .then( () => {
                    $('#associateForm')[0].reset();
                    $('#addAssociate').modal('hide');
                })
                .catch( err => console.error(err) );
                
            }
        }
    });

    // Associate specialization
    document.getElementById('associate_expertise').addEventListener('change', e =>{
        let expertise = e.target.value;
        let formData = new FormData();
        let options = [];
        formData.append('expertise',expertise);
        http.post('/getSpecilization',formData)
        .then( result => {
            if(result.length == 0){
                options.push(`<option value="0">No Specializations found...</option>`);
                showErrorModal(`The are no records for the selected expertise`);
                document.getElementById('associate_btn').setAttribute('disabled','disabled');
            }else{
                result.forEach( data =>{
                options.push( `<option value="${data.id}">${data.specialization}</option>` );
                document.getElementById('associate_btn').removeAttribute('disabled','disabled');
                })
            }
            document.getElementById("associate_specialization").innerHTML = options;
        })
        .catch( err => console.error(err) );
    });

    document.querySelector('.editAssociate').addEventListener('click', e =>{
        let id = e.target.id;
        http.get(`/associates/${id}/edit`)
        .then( data =>{
            document.getElementById('associate_name').value = data.associate_name;
            document.getElementById('associate_gender').value = data.associate_gender;
            document.getElementById('associate_email').value = data.associate_email;
            document.getElementById('associate_country').value = data.associate_country;
            document.getElementById('associate_phone').value = data.associate_phone;
            document.getElementById('associate_phone1').value = data.associate_phone1;
            document.getElementById('date_enrolled').value = data.date_enrolled;
            document.getElementById('associate_expertise').value = data.associate_expertise;
            document.getElementById('associate_specialization').value = data.associate_specialization;
            document.getElementById('associate_experience').value = data.associate_experience;
            document.getElementById('associate_id').value = data.id;
            $('#addAssociate').modal('show');
        })
        .catch( err => console.error(err) );
    });
}
catch(e){
    //console.log(e)
}

try{
    //Staff Assessment
    document.getElementById('assess-user').addEventListener('click', e => {
        const {dataset : URL_PARAMS } = e.target
        const id = URL_PARAMS.id;
        const teamId = URL_PARAMS.team;
        let inputs = [];
        http.get(`/targets/${teamId}`)
        .then( data => {
            data.forEach( record => {
                const TARGET_NAME = record.name.split(' ').join('_').toLowerCase();
                const TARGET_ID = record.id;
                inputs.push( `<div class="col-md-4">
                    <label for="${TARGET_NAME}">${record.name}</label>
                    <input type="number" class="form-control dynamic-field" name="${TARGET_ID}" id="${TARGET_NAME}" min="1" max="5">
                    </div>`
                );
            })
            document.getElementById('assessment-page').innerHTML = inputs;
        })
        .catch( err => console.error(err) );

        document.getElementById('consultant_id').value = id;
        document.getElementById('assessment_period').value = `${GET_MONTH_NAME(THISDAY)}-${THISYEAR}`;

        $('#staffAssessment').modal('show');
    })

    //Save Assessment
    document.getElementById('assessmentForm').addEventListener('submit', function(e){
        e.preventDefault();
        let formElements = toArray(document.getElementById("assessmentForm").elements);
        let FIELDS = [];
        formElements.forEach(element =>{
            if(element.classList.contains('dynamic-field')){
                FIELDS.push(element.id);
            }
        })
        let validateForm = validateDynamic(FIELDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            http.post('/assessments',formData)
            .then( (data) => {
                console.log(data)
                $('#staffAssessment').modal('hide');
                $('#assessmentForm')[0].reset();
                //location.reload();
            })
            .catch( err => console.error(err) );
        }
    })

    //Add timesheet informantion
    document.querySelectorAll('.addToTimesheet').forEach(element => {
        element.addEventListener('click', e =>{
            let options = [];
            let omNumber =  e.target.id;
            let theBenefactor =  e.target.dataset.owner;
            document.querySelector('input[name=om_number]').value = omNumber;
            let selectList = document.getElementById('beneficiary').options;
            for (let option of selectList) {
                if(option.value == 'Business Development'||option.value == 'Administration'){
                    option.remove()
                }
            }
            document.getElementById('beneficiary').value = theBenefactor;
            let formData = new FormData();
            formData.append('beneficiary','Opportunities')
            http.post('/getServicelines',formData)
            .then( data => {
                if(data == null){
                    options.push(`<option value="0">No Records...</option>`);
                }else{
                    data.forEach( serviceline =>{
                        options.push( `<option value="${serviceline.id}">${serviceline.service_name}</option>` );
                    })
                }
                document.getElementById("the_serviceline").innerHTML = options;
                $('#addTimesheet').modal('show');
            })    
            .catch( err => console.error(err) );
        });
    });

    //Add other worktime
    document.getElementById('workTime').addEventListener('click', e =>{
        let selectList = document.getElementById('beneficiary').options;
        for (let option of selectList) {
            if(option.value == 'Opportunities'){
               option.remove()
            }
        }
        $('#addTimesheet').modal('show');
    })

    //Timesheet beneficiary
    document.getElementById('beneficiary').addEventListener('change', e =>{
        let beneficiary = e.target.value;
        let formData = new FormData();
        let options = [];
        formData.append('beneficiary',beneficiary)
        http.post('/getServicelines',formData)
        .then( data => { 
            if(data == null){
                options.push(`<option value="0">No Records...</option>`);
            }else{
                data.forEach( serviceline =>{

                    options.push( `<option value="${serviceline.id}">${serviceline.service_name}</option>` );

                })
            }
            document.getElementById("the_serviceline").innerHTML = options;
        })    
        .catch( err => console.error(err) );
    });
}
catch(e){
    
}

try{
    //Request Leave
    document.getElementById('requestLeave').addEventListener('click', (e) =>{
        const PUBLIC_HOLIDAYS = [];
        const THIS_USER = e.target.dataset.user;
        //holidays object
        http.get('/holidays')
        .then( data => {
            data.forEach((object) =>{
                let savedHolidays = new Date(object.holiday_date);
                let savedMonth = GET_MONTH_NAME(new Date(object.holiday_date));
                let savedDate = savedHolidays.getDate();
                let actualHoliday = `${THISYEAR}-${savedMonth}-${savedDate}`;
                PUBLIC_HOLIDAYS.push(actualHoliday);
            });
        })
        .catch( err => console.error(err) );
        //leave options object
        http.get('/leavesettings')
        .then( LEAVE_OPTIONS => {
            console.log(LEAVE_OPTIONS)
        })
        .catch( err => console.error(err) );
        //forwarded leave object
        http.get(`/leaveforwards/${THIS_USER}`)
        .then( FORWARDED_LEAVE => {
            console.log(FORWARDED_LEAVE)
        })
        .catch( err => console.error(err) );
        $('#addleave').modal('show');
    });

    document.getElementById('leaveForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = ['leavesetting_id','leaveStart','leaveStop','leave_detail']
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let leaveStart = document.getElementById('leaveStart').value;
            console.log(leaveStart)
            let start = new Date(leaveStart);
            let startTime= start.getTime();//Returns the number of milliseconds since midnight Jan 1 1970, and a specified date
            let firstDate = start.getDate();//Returns the day of the month (from 1-31)
            let startMonth = GET_MONTH_NAME(start);//Returns the name of the month (from January-December)
        
            //End date
            let leaveStop = document.getElementById('leaveStop').value;
            let stop = new Date(leaveStop);
            let stopTime = stop.getTime();
                
            //Calculating the leave duration excluding weekends
            let diffDays = Math.round(Math.abs((stopTime - startTime)/(ONEDAY)));
            console.log(diffDays)
            let lists = [];
            let listbooked = [];

            //loop through the selected days to make an array of days(names)
            for(let i=0; i<=diffDays; i++){
                let currentDate = firstDate++;
                let nextName = GET_DAY_NAME(new Date(`${currentDate}/${startMonth}/${THISYEAR}`));
                let bookedDates = `${THISYEAR}-${startMonth}-${currentDate}`;
                //Make an array of booked days(Names)
                lists.push(nextName);
                //Make an array of booked dates
                listbooked.push(bookedDates);
            }

            let max = diffDays+1;
            if(lists.length == max){

                //The function to determine the occurance of weekends from the booked days
                let getOccurrence = (array, value) =>{
                    let count = 0;
                    array.forEach((v) => (v === value && count++));
                    return count;
                }

                //Skipping saturdays and sundays
                let noSunday = getOccurrence(lists, 'Sunday');
                let noSaturday = getOccurrence(lists, 'Saturday');
                let except  = noSunday + noSaturday;
                let booked = max - except;
                // Save the duration in session storage
                sessionStorage.setItem('booked',booked);
            }

            if(PUBLIC_HOLIDAYS.length == data.length){
                let booked = parseInt(sessionStorage.getItem('booked'));
                let matched = [];
                listbooked.forEach((date1)=>PUBLIC_HOLIDAYS.forEach((date2)=>{
                    if( date1 === date2 ){
                        matched.push(date1);
                    }
                }));
                let matchingDays = matched.length;
                let actualLeave = booked - matchingDays;
                // Save the duration in session storage
                sessionStorage.setItem('actual',actualLeave);
            }

            http.get('/leavesettings')
            .then( data => {
                let leave_types = [];
                leave_types.push(data.id)
                let leave_type = document.getElementById('leavesetting_id').value;
                let leaveDuration  = sessionStorage.getItem('actual');
                let leaveBookable = data.bookable_days;
                leave_type.forEach(() =>{
                    if(leaveDuration>leaveBookable){
                        return false;
                    }
                });
            })
            .catch( err => console.error(err) );

            http.get('/leaveforwards')
            .then( data => console.log(data) )
            .catch( err => console.error(err) );

            let formData = new FormData();
            formData.append('leavesetting_id',document.getElementById('leavesetting_id').value)
            formData.append('start_date', document.querySelector('input[name=leaveStart]').value)
            formData.append('end_date',document.querySelector('input[name=leaveStop]').value)
            formData.append('leave_detail', document.getElementById('leave_detail').value)
            formData.append('duration', sessionStorage.getItem('actual'))
            formData.append('leave_status', document.querySelector('input[name=leave_status]').value)
            http.post('/leaves',formData)
            .then( data => console.log(data) )
            .catch( err => console.error(err) );
            
        }
    });

    //Delete Leave
    document.getElementById('delLeve').addEventListener('click', e =>{
        confirmDelete(e.target.dataset.id);
    });
    document.getElementById('deleteBtn').addEventListener('click', ()=>{
        let item = document.getElementById('item-delete');
        deleteItem(`leaves/${id}`);
    });
}
catch(e){

}
    //Assign Tasks
    document.querySelectorAll('.addTasks').forEach( addTask=>{
        addTask.addEventListener('click', e => {
            let id = e.target.id;
            let patch ='';
            //Get Consultants
            let consultantsList = document.querySelectorAll('.consultants');
            consultantsList = Array.from(consultantsList)
            consultantsList.forEach(consultant => {
                patch += `<option value="${consultant.id}">${consultant.textContent}</option>`;     
            });

            //Get Associates
            let associatesList = document.querySelectorAll('.associates');
            associatesList = Array.from(associatesList)
            associatesList.forEach(associate => {
                patch += `<option value="${associate.id}">${associate.textContent}</option>`;     
            });
            
            document.getElementById('taskStaff').innerHTML = patch;
            
            document.getElementById('the_deliverable').value = id;
            $('#addTask').modal('show');
        });
    })

try{
    let editButtons = '';
    //Add Leavesettings
    document.getElementById('leaveSettingForm').addEventListener('submit', function(e){
        e.preventDefault();
        const LEAVESETTING_INDEX = document.getElementById('leavesetting_id');
        const LEAVESETTING_ID = (LEAVESETTING_INDEX == null)? null:LEAVESETTING_INDEX.value;

        FIELD_IDS = ['leave_type','annual_lot','bookable_days'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( LEAVESETTING_ID !=null ){
                http.put(`/leavesettings/${LEAVESETTING_ID}`,formData)
                .then( () => {
                    $('#leaveSettingForm')[0].reset();
                    $('#leaveSetting').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{  
                http.post('/leavesettings',formData)
                .then( data => {
                    $('#leaveSettingForm')[0].reset();
                    $('#leaveSetting').modal('hide');
                    location.reload();
                })
                .catch( err => console.error(err) );
            }
        }
    });

    //Edit Leave Settings
    editButtons = document.querySelectorAll('.editLeavesetting');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            let id =  e.target.id;
            http.get(`/leavesettings/${id}/edit`)
            .then(data =>{
                document.getElementById('leave_type').value = data.leave_type;
                document.getElementById('annual_lot').value = data.annual_lot;
                document.getElementById('bookable_days').value = data.bookable_days;
                document.getElementById('leavesetting_id').value = data.id;
                $('#leaveSetting').modal('show');
            })
            .catch( err => console.error(err) );
        });
    });

    //Leave Carried forward
    document.getElementById('saveForwardedLeave').addEventListener('click', e => {
        e.preventDefault();
        FIELD_IDS = ['forwarded']
    });


     //Add Service Line
     document.getElementById('servicelinesForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const SERVICELINE_INDEX = document.getElementById('serviceline_id');
        const SERVICELINE_ID = (SERVICELINE_INDEX == null)? null:SERVICELINE_INDEX.value;
        FIELD_IDS = ['service_beneficiary','serviceline_id','service_code','service_name'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( SERVICELINE_ID !=null ){
                http.put(`/servicelines/${SERVICELINE_ID}`,formData)
                .then( () => {
                    $('#servicelinesForm')[0].reset();
                    $('#serviceLine').modal('hide');
                    location.reload()
                } )
                .catch( err => console.error(err) );
            }
            else{ 
                http.post('/servicelines',formData)
                .then( () => {
                    $('#servicelinesForm')[0].reset();
                    $('#serviceLine').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
        }
    });

    //Edit service line
    editButtons = document.querySelectorAll('.editService');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            let id = e.target.id;
            http.get(`/servicelines/${id}/edit`)
            .then( data =>{
                document.getElementById('service_beneficiary').value = data.beneficiary;
                document.getElementById('service_code').value = data.service_code;
                document.getElementById('service_name').value = data.service_name;
                document.getElementById('serviceline_id').value = id;
                document.getElementById('servicelines_form_heading').innerText = 'Update Serviceline';
                $('#addServiceLine').modal('show');
            })
        .catch( err => console.error(err) );
        });
    });

    // Delete service line
    document.getElementById('delService').addEventListener('click', e =>{
        let id = e.target.dataset.id;
       confirmDelete(id)
    });
    document.getElementById('deleteBtn').addEventListener('click', ()=>{
        let url = `servicelines/${id}/delete`;
        processDelete(url);
    });
    
    //Add Holidays
    document.getElementById('holidaysForm').addEventListener('submit', function(e){

        e.preventDefault();
        const HOLIDAY_INDEX = document.getElementById('holiday_id');
        const HOLIDAY_ID = (HOLIDAY_INDEX == null)? null:HOLIDAY_INDEX.value;

        FIELD_IDS = ['holiday','holiday_date'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            
            if( HOLIDAY_ID !=null ){
                http.put(`/holidays/${HOLIDAY_ID}`,formData)
                .then( () => {
                    $('#holidaysForm')[0].reset();
                    $('#publicDays').modal('hide');
                } )
                .catch( err => console.error(err) );
            }
            else{
                http.post('/holidays',formData)
                .then( () => {
                    $('#holidaysForm')[0].reset();
                    $('#publicDays').modal('hide');
                    document.getElementById('holidaysBody').load(location.href + ' #holidaysBody');
                } )
                .catch( err => console.error(err) );
            } 
        }
    });

    //Edit Holidays
    editButtons = document.querySelectorAll('.editHoliday');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            let id = e.target.id;
            http.get(`/holidays/${id}/edit`)
            .then( data => {
                document.getElementById('holiday').value = data.holiday;
                document.getElementById('holiday_date').value = data.holiday_date;
                document.getElementById('holiday_id').value = data.id;
                $('#publicDays').modal('show');
            })
            .catch( err => console.error(err) );
        })
    });

    //Add Roles
    document.getElementById('rolesForm').addEventListener('submit', function(e){
        e.preventDefault();
        const ROLE_INDEX = document.getElementById('role_id');
        const ROLE_ID = (ROLE_INDEX == null)? null:ROLE_INDEX.value;
        FIELD_IDS = ['role_id','role_name','role_description'];

        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( ROLE_ID !=null ){
                http.put(`/roles/${ROLE_ID}`,formData)
                .then( () => {
                    $('#rolesForm')[0].reset();
                    $('#addRole').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{
                http.post('/roles',formData)
                .then( () => {
                    $('#rolesForm')[0].reset();
                    $('#addRole').modal('hide');
                    location.reload();
                })
                .catch( err => console.error(err) );
            }
        }
    });

   //Edit role
   editButtons = document.querySelectorAll('.editRole');
   editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            let id = e.target.id;
            http.get(`/roles/${id}/edit`)
                .then( data => {
                document.getElementById('role_name').value = data.role_name;
                document.getElementById('role_description').value = data.role_description;
                document.getElementById('role_id').value = data.id;
                document.getElementById('roles_form_heading').innerText = 'Update Role';
                $('#addRole').modal('show');
            } )
            .catch( err => console.error(err) );
        });
    });

    //Add Team

    document.getElementById('teamsForm').addEventListener('submit', function(e){
        e.preventDefault();
        const TEAM_INDEX = document.getElementById('team_id');
        const TEAM_ID = (TEAM_INDEX == null)? null:TEAM_INDEX.value;
        FIELD_IDS = ['team_name','team_code','team_leader'];

        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( TEAM_ID !=null ){
                http.put(`/teams/${TEAM_ID}`,formData)
                .then( () => {
                    $('#teamsForm')[0].reset();
                    $('#addTeams').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{   
                http.post('/teams',formData)
                .then( () => {
                    $('#teamsForm')[0].reset();
                    $('#addTeams').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
        }
    });

    //Edit team
    editButtons = document.querySelectorAll('.editTeam');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            e.preventDefault();
            let id = e.target.id;
            http.get(`/teams/${id}/edit`)
            .then( data =>{
                document.getElementById('team_name').value = data.team_name;
                document.getElementById('team_code').value = data.team_code;
                document.getElementById('team_leader').value = data.team_leader;
                document.getElementById('team_id').value = data.id;
                document.getElementById('team_form_heading').innerText = 'Update team';     
                $('#addTeams').modal('show');
            } )
            .catch( err => console.error(err) );
        });
    })

    //Associate Expertise
    document.getElementById('expertiseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const EXPERTISE_INDEX = document.getElementById('expertise_id');
        const EXPERTISE_ID = (EXPERTISE_INDEX == null)? null:EXPERTISE_INDEX.value;
        FIELD_IDS = ['field_name','field_description'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);

        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( EXPERTISE_ID !=null ){
                http.put(`/expertise/${EXPERTISE_ID}`,formData)
                .then( () => {
                    $('#expertiseForm')[0].reset();
                    $('#addExpertise').modal('hide');
                } )
                .catch( err => console.error(err) );
            }
            else{
                http.post('/expertise',formData)
                .then( data => {            
                    $('#expertiseForm')[0].reset();
                    $('#addExpertise').modal('hide');
                    location.reload();
                })
                .catch( err => console.error(err) );
            }
        }
    });

    //Edit Expertise
    editButtons = document.querySelectorAll('.editExpertise');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            let id = e.target.id;
            http.get(`/expertise/${id}/edit`)
            .then( data =>{
                document.getElementById('field_name').value = data.field_name;
                document.getElementById('field_description').value = data.field_description;
                document.getElementById('expertise_id').value = data.id;
                document.getElementById('expertise_form_heading').innerText = 'Update Expertise';     
                $('#addExpertise').modal('show');
            })
            .catch( err => console.error(err) );
        });
    })

    // Associate specialization
    document.querySelectorAll('.addSpecialization').forEach( specialization => {
        specialization.addEventListener('click', e =>{
            document.getElementById('the_expertise').value = e.target.id;
            $('#addSpecialization').modal('show');
        });
    })

    document.querySelectorAll('.btn_remove').forEach( btn_remove => {
        btn_remove.addEventListener('click', e =>{
            console.log(e)
            e.preventDefault;
            let btnId = e.target.id;
            console.log(btnId)
            removeRow(btnId);
        })
    })

    document.getElementById('specializationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        FIELD_IDS = ['the_expertise','specialization'];
        const SPECIALIZATION_INDEX = document.getElementById('specialization_id');
        const SPECIALIZATION_ID = (SPECIALIZATION_INDEX == null)? null:SPECIALIZATION_INDEX.value;
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( SPECIALIZATION_ID !=null ){
                http.put(`/specialization/${SPECIALIZATION_ID}`,formData)
                .then( () => {
                    $('#specializationForm')[0].reset();
                    $('#addSpecialization').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{ 
                http.post('/specialization',formData)
                .then( data => {
                    console.log(data);

                    $('#specializationForm')[0].reset()
                    $('#addSpecialization').modal('hide')
                location.reload();
                })
                .catch( err => console.error(err) );
            }
        }
    });

    //Update specialization
    document.querySelectorAll('.editSpecialization').forEach( editSpecialization =>{
        editSpecialization.addEventListener('click', e =>{
            http.get(`/specialization/${e.target.id}/edit`)
            .then( data =>{
                document.getElementById('the_expertise').value = data.expertise_id;
                document.getElementById('specialization').value = data.specialization;
                document.getElementById('specialization_id').value = data.id;
                document.getElementById('specialization_title').innerText = 'Update Specialization';     
                $('#addSpecialization').modal('show');
            })
            .catch( err => console.error(err) );
        })
    })
    document.getElementById('targetsForm').addEventListener('submit', function(e){
        e.preventDefault();
        const TARGET_INDEX = document.getElementById('target_id');
        const TARGET_ID = (TARGET_INDEX == null)? null:TARGET_INDEX.value;
        FIELD_IDS = ['target_category','target_name','target_value','target_team','target_period'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( TARGET_ID !=null ){
                http.put(`/targets/${TARGET_ID}`,formData)
                .then( (data) => {
                    console.log(data)
                    $('#targetsForm')[0].reset();
                    $('#addTargets').modal('hide');
                    location.reload()
                } )
                .catch( err => console.error(err) );
            }
            else{ 
                http.post('/targets',formData)
                .then( (data) => {
                    console.log(data)
                    $('#targetsForm')[0].reset();
                    $('#addTargets').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
        }
    })

    //Edit Targets
    editButtons = document.querySelectorAll('.editTargets');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            let id = e.target.id;
            http.get(`/targets/${id}/edit`)
            .then( data =>{
                document.getElementById('target_category').value = data.target_category;
                document.getElementById('target_name').value = data.target_name;
                document.getElementById('target_value').value = data.target_value;
                document.getElementById('target_id').value = id;
                document.getElementById('targets_heading').innerText = 'Update Target';
                $('#addTargets').modal('show');
            })
        .catch( err => console.error(err) );
        });
    });
  
    //Confirm Leave Request
    document.getElementById('acceptLeave').addEventListener('click', e =>{
        let id =  e.target.dataset.id;
        let formData = new FormData()
        formData.append('status','Confirmed')
        http.put(`/leaves/${id}`,formData)
        .then( data => console.log(data) )
        .catch( err => console.error(err) );
    });

    //Reject Leave Request
    document.getElementById('denyLeave').addEventListener('click', e =>{
        let id =  e.target.dataset.id;
        let formData = new FormData()
        formData.append('status','Denied')
        http.put(`/leaves/${id}`,formData)
        .then( data => console.log(data) )
        .catch( err => console.error(err) );
    });
}
catch(e){

}

try{
    //Add Timesheet
    document.getElementById('timesheetForm').addEventListener('submit', function(e){
        e.preventDefault();
        const TIMESHEET_INDEX = document.getElementById('timesheet_id');
        const TIMESHEET_ID = (TIMESHEET_INDEX == null)? null:TIMESHEET_INDEX.value;
        FIELD_IDS = ['beneficiary','the_serviceline','activity_date','duration','activity_description'];

        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);

            if( TIMESHEET_ID !=null ){
                http.put(`/timesheets/${TIMESHEET_ID}`,formData)
                .then( () => {
                    $('#timesheetForm')[0].reset();
                    $('#addTimesheet').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{ 
                http.post('/timesheets',formData)
                .then( () => {
                    $('#timesheetForm')[0].reset();
                    $('#addTimesheet').modal('hide');
                    location.reload();
                })
                .catch( err => console.error(err) );
            }
        }
    });

    //Edit Timesheet
    let reviewTimesheets = document.querySelectorAll('.reviewTimesheet');
    reviewTimesheets.forEach( reviewTimesheet =>{
        reviewTimesheet.addEventListener('click', e =>{
            let id =  e.target.id;
            http.get(`/timesheets/${id}/edit`)
            .then(data =>{
                if(data.om_number != null || data.om_number != undefined){
                    document.getElementById('OMField').value = data.om_number;
                    document.getElementById('OMField').setAttribute('required','required');
                    document.getElementById('omNum').style.display = 'block';   
                }else{
                    document.getElementById('omNum').style.display = 'none';
                    document.querySelector('input[name=om_number]').value=='None';
                }
                let options = [];
                http.get(`/servicelines/${data.serviceline_id}/edit`)
                .then( data => { 
                    if(data == null){
                        // options.push(`<option value="0">No Records...</option>`);
                    }else{
                        options.push( `<option value="${data.id}">${data.service_name}</option>` );
                    }
                    document.getElementById("the_serviceline").innerHTML = options;
                })    
                document.getElementById('beneficiary').value = data.beneficiary;
                document.getElementById('activity_date').value = data.activity_date;
                document.getElementById('duration').value = data.duration;
                document.getElementById('OMField').value = data.om_number;
                document.getElementById('activity_description').value = data.activity_description;
                document.getElementById('timesheet_id').value = data.id;
                $('#addTimesheet').modal('show');
            })
            .catch( err => console.error(err) );
        });

    })

    //Add users
    document.getElementById('userForm').addEventListener('submit', function(e){
        e.preventDefault();
        const USER_INDEX = document.getElementById('user_id');
        const USER_ID = (USER_INDEX == null)? null:USER_INDEX.value;
        FIELD_IDS = USER_INDEX==null? ['saffId','name','gender','email','password','password-confirm','mobilePhone','alternativePhone','user_team_id','the_role_id','level_id','reportsTo','userStatus']:['saffId','name','gender','email','mobilePhone','alternativePhone','user_team_id','the_role_id','level_id','reportsTo','userStatus'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( USER_ID !=null ){
                http.put(`/users/${USER_ID}`,formData)
                .then( () => {
                    $('#teamsForm')[0].reset();
                    $('#addTeams').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
            else{  
                http.post('/users',formData)
                .then( () => document.getElementById('usersBody').load(location.href + ' #usersBody'))
                .catch( err => console.error(err) );;
            }
        }
    });

    //Edit User
    document.getElementById('editUser').addEventListener('click', e => {
        let id = e.target.dataset.id;
        http.get(`/users/${id}/edit`)
        .then(data =>{
            document.getElementById('staffId').value = data.staffId;
            document.getElementById('name').value = data.name;
            document.getElementById('gender').value = data.gender;
            document.getElementById('email').value = data.email;
            document.getElementById('mobilePhone').value = data.mobilePhone;
            document.getElementById('alternativePhone').value = data.alternativePhone;
            document.getElementById('user_team_id').value = data.team_id;
            document.getElementById('the_role_id').value = data.role_id;
            document.getElementById('level_id').value = data.level_id;
            document.getElementById('reportsTo').value = data.reportsTo;
            document.getElementById('userStatus').value = data.userStatus;
            document.getElementById('user_id').value = data.id;
            document.getElementById('user_login').style.display = 'none';
            $('#addUser').modal('show');
        }).catch(err=>{
            console.error(err);
        })
    });

    //Update User
    document.getElementById('editUserForm').addEventListener('submit', function(e){

        e.preventDefault();
        FIELD_IDS = ['newStaffId','newName','newGender','newEmail','newMobilePhone','newAlternativePhone','newTeam','newRole','newAccessLevel','newReportsTo','newUserStatus'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){

	        let id = document.getElementById('userId').value;
            let formData = new FormData(this);
            http.post(`/users/${id}`,formData)
            .then(() => {
                showAlert('User Updated','success');
                $('#userEdit').modal('hide');
                $('#editUserForm')[0].reset();
                location.reload();
            });
	    }

    });
}
catch(e){

}

try{
    // Comments CRUD
    document.querySelector('.comment').addEventListener('click', e =>{
        const comment = document.querySelector('.comment');
        const theModel = comment.dataset.model;
        document.getElementById('commentable_id').value = e.target.id;
        document.getElementById('commentable').value = theModel;
        document.querySelector('.modal-title').innerText = `${theModel} Comments`;
        $('#addComments').modal('show');
    });

    // document.getElementById('commentsForm').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     const COMMENT_INDEX = document.getElementById('comment_id');
    //     const COMMENT_ID = (COMMENT_INDEX == null)? null:COMMENT_INDEX.value;
    //     FIELD_IDS = ['comment_body','commentable','commentable_id'];
    //     let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
    //     if( validateForm === 0 ){
    //         let formData = new FormData(this);
    //         if( COMMENT_ID != null ){
    //             http.put(`/comments/${COMMENT_ID}`,formData)
    //             .then( (data) => {
    //                 console.log(data)
    //                 $('#commentsForm')[0].reset();
    //                 $('#addComments').modal('hide');
    //             } )
    //             .catch( err => console.error(err) );
    //         }
    //         else{   
    //             http.post('/comments',formData)
    //             .then( data =>{
    //                 console.log(data)
    //                 $('#commentsForm')[0].reset()
    //                 $('#addComments').modal('hide')
    //                 location.reload();
    //             })
    //             .catch( err => console.error(err) );
    //         }
    //     }
    // });

    document.getElementById('evaluationForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = [];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            http.post('/evaluations',formData)
            .then( data =>{
                $('#evaluationForm')[0].reset();
                $('#addEvaluations').modal('hide');
                location.reload();
            })
            .catch( err => console.error(err) );
        }
    })

}catch(e){
    
}


try{
    document.getElementById('forwardedLeaveForm').addEventListener('submit', function(e){
        e.preventDefault()
        const LEAVEFORWAD_INDEX = document.getElementById('leaveforward_id');
        const LEAVEFORWAD_ID = (LEAVEFORWAD_INDEX == null)? null:LEAVEFORWAD_INDEX.value;
        FIELD_IDS = ['forwarding_user','days_forwarded'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( LEAVEFORWAD_ID !=null ){
                http.put(`/leaveforwards/${LEAVEFORWAD_ID}`,formData)
                .then( (data) => {
                    console.log(data)
                    $('#forwardedLeaveForm')[0].reset();
                    $('#addLeaveforward').modal('hide');
                    location.reload()
                } )
                .catch( err => console.error(err) );
            }
            else{ 
                http.post('/leaveforwards',formData)
                .then( (data) => {
                    console.log(data)
                    $('#forwardedLeaveForm')[0].reset();
                    $('#addLeaveforward').modal('hide');
                    location.reload();
                } )
                .catch( err => console.error(err) );
            }
        }
    })
}
catch(e){
    console.log(e)
}

try{
    document.getElementById('tableName').addEventListener('change', e =>{
        let tableName = e.target.value;
        if(tableName =='users'){
            document.getElementById('columnList').innerHTML = `<option value="firstname">Firstname</option><option value="lastname">Lastname</option><option value="gender">Gender</option><option value="team">Team</option><option value="email">Email</option><option value="created_at">Date Registered</option>`; 
        }
        else if(tableName =='opportunities'){
            document.getElementById('columnList').innerHTML = `<option value="type">Type</option><option value="sales_stage">Sales Stage</option><option value="funder">Funder</option><option value="country">Country</option><option value="assignedTeam">Team</option><option value="lead_source">Lead Source</option><option value="internal_deadline">Internal Deadline</option><option value="external_deadline">External Deadline</option><option value="probability">Probability</option>`;  
        }
        else if(tableName =='projects'){
            document.getElementById('columnList').innerHTML = `<option value="stage">Project Stage</option><option value="start_date">Start Date</option><option value="start_date">Closure Date</option><option value="status">Status</option>`; 
        }
        else if(tableName ==''||tableName ==undefined){
            document.getElementById('columnList').innerHTML = ``; 
        }
    })
}
catch(e){

}

try{
    document.getElementById('feedBackForm').addEventListener('submit',function(e){
        e.preventDefault()
        FIELD_IDS = ['subject','message_body'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            http.post('/support',formData)
            .then( (data) => {
                $('#feedBackForm')[0].reset();
                console.log(data)
            } )
            .catch( err => console.error(err) );
        }
        else{
            console.log(validateForm)
        }
    })
}
catch(e){

}

let exportExcel = (tableId, filename=NULL)=>{
    let downloadLink;
    let dataType = 'application/vnd.ms-excel';
    let tableSelect = document.getElementById(tableId);
    let tableHTML = tableSelect.outerHTML.replace(/ /g, '%20')
    filename = filename?filename+'.xls':'coins_data.xls';
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob){
        let blob = new Blob(['\ufeff',tableHTML],{
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob,filename);
    }else{
        downloadLink.href = 'data:' +dataType+','+tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
  }

let assignUser = (form,url) => {
    FIELD_IDS = ['the_user_id'];
    let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
    if( validateForm === 0 ){
        let formData = new FormData(form);
        http.post(url,formData)
        .then( data =>{
            location.reload()
            console.log(data);
        })
        .catch( err => console.error(err) );
    }
    else{
        console.log('Validation error')
    }
}

let confirmDelete = (id,item) =>{

    document.getElementById('warningMessage').innerHTML = `Are you sure you want to delete this?<input type="hidden" id="item-delete" value="${id}" data-record="${item}">`;
    $('#warn').modal('show');
}

let deleteItem = (url) =>{
    http.delete(url)
    .then(()=>{
        $('#warn').modal('hide');
        location.reload();
    })
    .catch( err => console.error(err) );
}

let elementAdd = (parentID, position, element ) => {
    const PARENT = document.getElementById( parentID )
    if (PARENT != null ) PARENT.insertAdjacentHTML(position, element)
}

let elementRemove = elementID => {
    const ELEMENT = document.getElementById( elementID )
    if( ELEMENT != null ) ELEMENT.parentNode.removeChild( ELEMENT )
}

let markerAttach = elementID => {
    const ELEMENT = document.getElementById(elementID)
    if( ELEMENT != null ) ELEMENT.classList.add('error-marker')
}

let markerDetach = elementID => {
    const ELEMENT = document.getElementById(elementID)
    if( ELEMENT != null ) ELEMENT.classList.remove('error-marker')
}

let calculateResults = (url,formId) =>{
    let formData = new FormData(formId);
    for(let i = 0; i < FIELD_IDS.length; i++ ) {
        formData.append(document.getElementById( FIELD_IDS[i] ).name, document.getElementById( FIELD_IDS[i] ).value);
    }
    http.post(`/${url}`,formData)
    .then(data =>{
        recordsHTML = '';
        if( data.length > 0 ) {
            recordsHTML += `<table id="sorted_opportunities" class="table table-bordered table-sm">
            <thead class="bg-success text-white"><tr><td>OM Number</td><td>Name</td><td>Type</td><td>Stage</td><td>Revenue</td></tr></thead><tbody>`
            for(let i=0; i<data.length; i++){
                recordsHTML += `<tr><td>
                <a href="/opportunities/${data[i].id}" class="text-primary" title="View Opportunity">${data[i].om_number}</a></td><td>${data[i].name}</td><td>${data[i].type}</td><td>${data[i].sales_stage}</td><td>${data[i].revenue}</td></tr>`
            }
            recordsHTML += `<tbody></table>`;
            document.getElementById('summaries').innerHTML = `Total records - ${data.length}`;
            elementAdd( 'records-list', 'beforeend', recordsHTML )
        }
        else {
            document.getElementById('summaries').innerText = `No records found`;
        }
        document.getElementById('export_opportunities').style.display = 'block';
        document.getElementById('records-list').style.display = 'block';
        document.getElementById('loading').style.display = 'none';

    })
    .catch( err => console.error(err) );
}

let openConsultation = (workstation,id) => {
    document.getElementById(workstation).value = id;
    $('#addConsultant').modal('show');
}

let getDocument = (e) => {
    let id = e.target.dataset.id;
    let theOwner = e.target.dataset.owner;
    let theName = e.target.dataset.name;
    document.getElementById('owner_id').setAttribute('name', theOwner);
    document.getElementById('owner_id').value = id;
    document.getElementById('fileName').setAttribute('name', 'fileName');
    document.getElementById('fileName').value = theName;
    $('#addDocument').modal('show');
}

let backendValidation = data =>{
    json = JSON.parse(data.responseText);
    const errors = json.errors;
    const firstItem = Object.keys(errors)[0];
    const firstItemDom = document.getElementById(firstItem);
    const firstErrorMessage = errors[firstItem][0];

    // Remove all error messages
    const errorMessages = document.querySelectorAll('.text-danger');
    errorMessages.forEach((Element)=>Element.textContent = '');

    firstItemDom.insertAdjacentHTML('afterend',`<div class="text-danger">${firstErrorMessage}</div>`);

    //Clear form controls without errors
    const formControls = document.querySelectorAll('.form-control');
    formControls.forEach((Element) =>Element.classList.remove('border', 'border-danger'));
    //Highlight the form control with the error
    firstItemDom.classList.add('border', 'border-danger');
    return false;
}

let UIValidate = (FIELD_IDS,ERROR_COUNT) =>{

    for(let i = 0; i < FIELD_IDS.length; i++ ) {

        elementRemove(`error-${FIELD_IDS[i]}`)

        if( document.getElementById( FIELD_IDS[i] ) != null &&  document.getElementById( FIELD_IDS[i] ).value == '' ) {
            ERROR_COUNT++
            elementAdd(FIELD_IDS[i],'afterend',`<p id="error-${FIELD_IDS[i]}" class="text-danger">Required!</p>`);
            markerAttach(FIELD_IDS[i]);
            

        } else {

            elementRemove( `error-${FIELD_IDS[i]}` )
            markerDetach( FIELD_IDS[i] )
        }
    }
    return ERROR_COUNT
}

let  toArray = obj =>{
    let array = [];
    for (let i = obj.length >>> 0; i--;) { 
      array[i] = obj[i];
    }
    return array;
}

let validateDynamic = (FIELDS,ERROR_COUNT) =>{

    for(let i = 0; i < FIELDS.length; i++ ) {

        elementRemove(`error-${FIELDS[i]}`)

        if( document.getElementById( FIELDS[i] ) != null &&  document.getElementById( FIELDS[i] ).value == '' ) {
            ERROR_COUNT++
            elementAdd(FIELDS[i],'afterend',`<p id="error-${FIELDS[i]}" class="text-danger">Required!</p>`);
            markerAttach(FIELDS[i]);
            

        } else {

            elementRemove( `error-${FIELDS[i]}` )
            markerDetach( FIELDS[i] )
        }
    }
    return ERROR_COUNT
}

let showTaskDetails = (e) =>{
    if(e.target.classList.contains('taskDetail')){
    console.log(e.target.parentNode.parentNode.siblings)
    }
}
let showAlert = (className,message) =>{
    console.log(message)
    const div = document.createElement('div');
    div.className = `alert ${className}`;
    div.appendChild(document.createTextNode(message));
    const notice  = document.getElementById('notices');
    //const form  = document.querySelector('#book-form');
    notice.innerHTML = div;
    //notice.insertBefore(div,form);
    setTimeout(function(){
        document.querySelector('.alert').remove();
    },2000)
}

let doEvaluation = (id,theModel) =>{
    document.getElementById('evaluationable_id').value = id;
    document.getElementById('evaluationable_type').value = theModel;
    document.getElementById('evaluation_title').innerText = `${theModel} Evaluation`;
    $('#addEvaluations').modal('show');
};

let removeRow = (id) =>{
    document.getElementById(`row${id}`).remove();
}

let showErrorModal = (message) =>{
    document.getElementById('warningMessage').innerText = message;
    document.getElementById('error_title').innerText = `Error`;
    document.getElementById("warn").style.zIndex = "9999";
    $('#messageModal').modal('show');
}

let showSuccessModal = (message) =>{
    document.getElementById('message_header').innerText = message;
    document.getElementById('message_title').innerText = message;
    document.getElementById('message_body').innerText = message;
    document.getElementById('error_title').innerText = `Error`;
    document.getElementById("messageModal").style.zIndex = "9999";
    $('#messageModal').modal('show');
}