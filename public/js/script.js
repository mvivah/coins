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
let ERROR_COUNT = 0;
let station;

//Contacts
try{
    document.getElementById('contactsForm').addEventListener('submit', function(e){
        e.preventDefault();
        const CONTACT_INDEX = document.getElementById('contact_id');
        const CONTACT_ID = (CONTACT_INDEX === null)? null:CONTACT_INDEX.value;
        FIELD_IDS = ['account_name','contact_country','full_address','contact_person','contact_email','contact_phone'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( CONTACT_ID !== null ){
                console.log(`The contact id ${CONTACT_ID}`);
                axios.post(`/contacts/${CONTACT_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#contactsForm')[0].reset();
                    $('#addContact').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
                
            }
            else{
                axios.post('/contacts',formData)
                .then( response => {
                    $('#contactsForm')[0].reset();
                    $('#addContact').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

    //Edit contact
    document.querySelectorAll('.editContact').forEach(element =>{
        element.addEventListener('click', e =>{
            axios.get(`/contacts/${e.target.id}/edit`)
            .then( response => {
                data = response.data;
                document.getElementById('account_name').value = data.account_name;
                document.getElementById('contact_country').value = data.country;
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
            .catch( error => console.log(error) );
        });
    });

    //Add opportunity for contact
    document.querySelectorAll('.contactOpportunity').forEach(element =>{
        element.addEventListener('click', e =>{
            axios.get(`/contacts/${e.target.id}/edit`)
            .then( response =>{
                data = response.data;
                if(data.length !== 0){
                    document.getElementById('thisContact').value = data.account_name;
                    document.getElementById('thisContact').setAttribute('readonly','readonly');
                    document.getElementById('country').value = data.country;
                    document.getElementById('country').setAttribute('readonly','readonly');
                    document.getElementById('the_contact_id').value = data.id;
                    $('#add_opportunity').modal('show');
                }else{
                    showAlert('error',`No contacts found...`);
                    location.reload();
                }
            })
            .catch( e =>{
                console.error(e);
            });
        });
    });
}
catch(e){

}

try{
    //Save Opportunity
    document.getElementById('opportunityForm').addEventListener('submit', function(e){
        e.preventDefault();
        const OPPORTUNITY_INDEX = document.getElementById('opportunity_id');
        const OPPORTUNITY_ID = (OPPORTUNITY_INDEX === null)? null:OPPORTUNITY_INDEX.value;
        FIELD_IDS = ['opportunity_name','the_contact_id','country','funder','type','revenue','lead_source','sales_stage','external_deadline','internal_deadline','probability'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){

            let formData = new FormData(this);
            if( OPPORTUNITY_ID !== null ){
                axios.post(`/opportunities/${OPPORTUNITY_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#opportunityForm')[0].reset();
                    $('#add_opportunity').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{
                axios.post('/opportunities',formData)
                .then( response=>{
                    $('#opportunityForm')[0].reset();
                    $('#add_opportunity').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch(err=>{
                    console.error(err);
                });
            }
        }
    });

    //Edit Opportunity

    document.getElementById('editOpportunity').addEventListener('click', e =>{
        axios.get(`/opportunities/${e.target.dataset.id}/edit`)
        .then( response=>{
            data = response.data;
            document.getElementById('opportunity_name').value = data.opportunity_name;
            document.getElementById('the_contact_id').value = data.contact_id;
            document.getElementById('thisContact').value = data[0];
            document.getElementById('country').value = data.country;
            document.getElementById('funder').value = data.funder;
            document.getElementById('type').value = data.type;
            document.getElementById('assignedTeam').value = data.team_id;
            document.getElementById('revenue').value = data.revenue;
            document.getElementById('lead_source').value = data.lead_source;
            document.getElementById('sales_stage').value = data.sales_stage;
            document.getElementById('external_deadline').value = data.external_deadline;
            document.getElementById('internal_deadline').value = data.internal_deadline;
            document.getElementById('probability').value = data.probability;
            document.getElementById('opportunity_id').value = data.id;
            $('#add_opportunity').modal('show');
        } )
        .catch( error => console.error(err) )
    });
    
    //Opportunity Bid Score
    document.getElementById('opportunity_bid_scores').addEventListener('click',e => {
        document.getElementById('this_opportunity_id').value = e.target.dataset.id;
        $('#addScore').modal('show');
    })

    // Save Bid Score
    document.getElementById('scoresForm').addEventListener('submit', function(e){
        e.preventDefault();
        const SCORE_INDEX = document.getElementById('score_id');
        const SCORE_ID = (SCORE_INDEX == null)? null:SCORE_INDEX.value;
        FIELD_IDS = ['opening_date','technical_score','financial_score'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( SCORE_ID != null ){
                axios.post(`/scores/${SCORE_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#scoresForm')[0].reset();
                    $('#addScore').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{
                axios.post('/scores',formData)
                .then( response => {
                    $('#scoresForm')[0].reset();
                    $('#addScore').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => console.error(error));
            }
        }
    });

    //Add Opportunity Task
    document.querySelectorAll('.opportunity_task').forEach(element =>{
        element.addEventListener('click', e =>{
            e.preventDefault();
            assignTask(e.target.id);
        })
    });

    //Save Opportunity Tasks 
    document.getElementById('taskForm').addEventListener('submit', function(e){
        e.preventDefault()
        saveTask(['task_name','task_deadline','task_status','taskStaff']);
    });

    //Edit Opportunity Tasks

    //Add Opportunity Deliverable
    document.getElementById('add_opportunity_deliverable').addEventListener('click', e =>{
        e.preventDefault();
        loadDeliverables(e.target.dataset.id,'Opportunity');

    });

    //Edit Opportunity Deliverable
    document.querySelectorAll('.edit_opportunity_deliverable').forEach(element => {
        element.addEventListener('click', e =>{
            e.preventDefault();
            pickDeliverable(e.target.id,e.target.parentNode.parentNode.innerText,'Opportunity','Edit');
        })
    });

    //Save Opportunity Deliverable
    document.getElementById('deliverablesForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = ['the_opportunity','deliverable_ids','deliverable_status','deliverable_completion'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            storeDeliverable(FIELD_IDS);
        }
    });

    //Deleted Deliverable
    document.querySelectorAll('.delete_opportunity_deliverable').forEach(element => {
        element.addEventListener('click', e =>{
            e.preventDefault();
            deliverableDelete(e.target.id);
        })
    });
    
    //View Opportunity Tasks
    document.querySelectorAll('.opportunity_taskview').forEach(element => {
        element.addEventListener('click', e =>{
            e.preventDefault();
            revealTask(e.target.id);
        })
    });

   // Print Opportunity
    document.getElementById('printOpportunity').addEventListener('click', e =>{
        e.preventDefault();
        previewContent('opportunity_preview');
    });

    //Add document to opportunity
    station = (document.getElementById('project_document'))? document.getElementById('project_document') : document.getElementById('opportunity_document');
    station.addEventListener('click', e =>{
        getDocument(e);
    });

    //Assign consultant to Opportunities
    document.getElementById('opportunity_user').addEventListener('click', e => {
        openConsultation('the_opportunity_id',e.target.dataset.id);
    });

    //Assign Consultant
    document.getElementById('saveConsultant').addEventListener('click', e =>{
        e.preventDefault();
        let consultantForm = document.getElementById('consultantForm');
        assignUser(consultantForm,'/opportunityUser');
    });

    //Remove Consultant
    document.querySelectorAll('.delConsultant').forEach(element => {
        element.addEventListener('click', e =>{
            confirmDelete(e.target.id,e.target.dataset.item);
        });
    });

    document.getElementById('deleteBtn').addEventListener('click', () =>{
        let item = document.getElementById('item-delete').dataset.record;
        let source = (item == 'Opportunity')? `/removeConsultant/${document.getElementById('item-delete').value}` : `/unassignConsultant/${id}`;
        deleteItem(source);
    });

    //Add opportunity comments
    document.getElementById('opportunity_comment').addEventListener('click', e =>{
        createComment(e.target.dataset.id,'Opportunity');
    });
   
    //Save opportunity comments
    document.getElementById('commentsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveComment(document.getElementById('commentsForm'));
    });

    //Add opportunity evaluation
    document.getElementById('opportunity_evaluation').addEventListener('click', e =>{
        e.preventDefault()
        doEvaluation(e.target.dataset.id,'Opportunity');
    })

    //Save opportunity evaluation
    document.getElementById('evaluationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveEvaluation(document.getElementById('evaluationForm'));
    });
}
catch(err){

}
try{
    document.getElementById('create_opportunity').addEventListener('click', e =>{
        axios.get('/getcontacts')
        .then( response =>{
            data = response.data
            if(data.length != 0){
                $('#add_opportunity').modal('show');
            }else{
                showAlert('error',`No contacts found...`);
                location.reload()
            }
        })
        .catch( e =>{
            console.error(e)
        })
    });

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
            axios.post('/listContacts',formData)
            .then( response => {
                data = response.data
                if(data.length == 0){
                    options.push(`<option value="0" disabled selected>No Contacts found...</option>`);
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

    //Filter Opportunities
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
            setTimeout(calculateResults('filterOpportunities',opportunitiesFilterForm,'export_opportunities'),1000);
        }
    })

    let opportunityExport = document.getElementById('export_opportunities');
    opportunityExport.addEventListener('click', e =>{
        exportExcel('sorted_opportunities','sorted_opportunities');
        e.preventDefault();
    })

    //Comfirm teamleaders
    document.getElementById('assignedTeam').addEventListener('change', e =>{
        axios.get(`/getteamleader/${e.target.value}`)
        .then( response => {
            data = response.data
            if( data.length == 0){
                showAlert('error',`This team has no Teamleader`);
                $('#add_opportunity').modal('hide');
                location.reload()
                return false;
            }else{

            }
        })
        .catch( e =>{
            console.error(e)
        })
    });
}
catch(e){

}


try{
    //Edit project
    document.getElementById('editProject').addEventListener('click', e =>{
        axios.get(`/projects/${e.target.dataset.id}/edit`)
        .then( response => {
            data = response.data
            document.getElementById('project_stage').value = data.project_stage;
            document.getElementById('project_status').value = data.project_status;
            document.getElementById('initiation_date').value = data.initiation_date;
            document.getElementById('completion_date').value = data.completion_date;
            document.getElementById('projectid').value = data.id;
            $('#edit_Project').modal('show');
        } )
        .catch( error => console.error(err) )
    });

    //Update project
    document.getElementById('editProjectForm').addEventListener('submit', function(e){
        e.preventDefault();

        FIELD_IDS = ['project_stage','project_status','initiation_date','completion_date'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);

        if( validateForm === 0 ){
            let formData = new FormData(this);
            axios.post(`/projects/${document.getElementById('projectid').value}`,formData)
            .then( response => {
                $('#edit_Project').modal('hide');
                $('#editProjectForm')[0].reset();
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors) );
        }else{
            console.log(validateForm)
        }
    });
    
    // Assign consultant to projects
    document.getElementById('user-project').addEventListener('click', e => {
        openConsultation('project_id',e.target.dataset.id);
    });

    document.getElementById('saveConsultant').addEventListener('click', function(e){
        e.preventDefault();
        let consultantForm = document.getElementById('consultantForm');
        assignUser(consultantForm,'/projectUser');
    });

    //Add document project
    station = (document.getElementById('project_document'))? document.getElementById('project_document') : document.getElementById('opportunity_document');
    station.addEventListener('click', e =>{
        getDocument(e);
    });

    //Assign Associates to project
    document.getElementById('assignAssociate').addEventListener('click', e =>{
        axios.get('/getassociates')
        .then( response => {
            data = response.data
            if(data.length != 0){
                document.getElementById('projectAssociate').value = e.target.dataset.id;
                $('#pickAssociate').modal('show');
            }else{
                showAlert('error',`No associates available`);
                location.reload()
            }
        })
        .catch( e =>{
            console.error(e)
        })
    });

    //Save Associates for a project
    document.getElementById('associateForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = ['projectAssociate','associates_id'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            axios.post(`/projectassociates`,formData)
            .then( response => {
                $('#pickAssociate').modal('hide');
                $('#associateForm')[0].reset();
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors) );
        }else{
            console.log(validateForm)
        }
    });

    //Associate logbook
    document.querySelectorAll('.staffCheckins').forEach(element =>{
        element.addEventListener('click', e =>{
            changeAvailability(element);
        })
    });

    //Remove Associate
    document.querySelectorAll('.removeAssociate').forEach(element =>{
        element.addEventListener('click',e =>{
            confirmDelete(e.target.id)
        })
    });

    document.getElementById('deleteBtn').addEventListener('click', () =>{
        console.log('Deleting....')
    });

    //Add Project Deliverable
    document.getElementById('add_project_deliverable').addEventListener('click', e => {
        e.preventDefault();
        loadDeliverables(e.target.dataset.id,'Project');
    });

    //Save Project Deliverable
    document.getElementById('deliverablesForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = ['the_project_id','deliverable_ids','deliverable_status','deliverable_completion'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            storeDeliverable(FIELD_IDS);
        }
    });

    //Edit Project Deliverable
    document.querySelectorAll('.edit_project_deliverable').forEach( editDeliverable => {
        editDeliverable.addEventListener('click', e =>{ 
            e.preventDefault();
            pickDeliverable(e.target.id,e.target.parentNode.parentNode.innerText,'Project','Edit');
        });
    });
        
    //Project Evaluation
    document.getElementById('project_evaluation').addEventListener('click', e =>{
        doEvaluation(e.target.dataset.id,'Project');
    })

    //Save Project evaluation
    document.getElementById('evaluationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveEvaluation(document.getElementById('evaluationForm'));
    });

    //Add Project tasks
    document.querySelectorAll('.project_task').forEach(element =>{
        element.addEventListener('click', e =>{
            e.preventDefault();
            assignTask(e.target.id);
        })
    });

    //Save Project tasks 
    document.getElementById('taskForm').addEventListener('submit', function(e){
        saveTask(['task_name','task_deadline','task_status','taskStaff']);
    });

    //Show Project tasks
    document.querySelectorAll('.project_taskview').forEach(element => {
        element.addEventListener('click', e =>{
            e.preventDefault();
            revealTask(e.target.id);
        })
    });
   
  document.getElementById('printProject').addEventListener('click', e =>{
    e.preventDefault()
    previewContent('project_preview');
  });
  document.getElementById('printProject').addEventListener('click', e =>{
    e.preventDefault()
    previewContent('project_preview');
  });
  document.getElementById('printProject').addEventListener('click', e =>{
    e.preventDefault()
    previewContent('project_preview');
  });
}
catch(err){

}

try{
    document.getElementById('projectFilter-btn').addEventListener('click', e =>{
        e.preventDefault();
        document.getElementById('summaries').innerText = ``;
        elementRemove(`sorted_projects`);
        FIELD_IDS = ['project-status','project-stage','project-country','initiation-date','completion-date','searchRange'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let projectsFilterForm = document.getElementById('projectsFilterForm');
            document.getElementById('records-list').style.display = 'none';
            document.getElementById('loading').style.display = 'block';
            setTimeout(calculateResults('filterProjects',projectsFilterForm,'export_projects'),1000);
        }
    })
}
catch(e){

}

try{
    //Add associate
    document.getElementById('associateRegister').addEventListener('submit', function(e){
        e.preventDefault();
        const ASSOCIATE_INDEX = document.getElementById('associate_id');
        const ASSOCIATE_ID = (ASSOCIATE_INDEX == null)? null:ASSOCIATE_INDEX.value;
        FIELD_IDS = ['associate_name','associate_gender','associate_email','associate_country','associate_phone','date_enrolled','associate_expertise','associate_specialization','associate_experience'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( ASSOCIATE_ID != null ){
                axios.post(`/associates/${ASSOCIATE_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#associateRegister')[0].reset();
                    $('#addAssociate').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{ 
                axios.post('/associates',formData)
                .then( response => {
                    $('#associateRegister')[0].reset();
                    $('#addAssociate').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );
                
            }
        }
    });

    // Associate specialization
    document.getElementById('associate_expertise').addEventListener('change', e =>{
        let expertise = e.target.value;
        let formData = new FormData();
        let options = [];
        formData.append('expertise',expertise);
        axios.post('/getSpecilization',formData)
        .then( response => {
            data = response.data
            if(data.length == 0){
                options.push(`<option value="0" disabled selected>No Specializations found...</option>`);
                showAlert('error',`No specializations for the selected expertise...`);
                document.getElementById('associate_btn').setAttribute('disabled','disabled');
            }else{
                data.forEach( result =>{
                options.push( `<option value="${result.id}">${result.specialization}</option>` );
                document.getElementById('associate_btn').removeAttribute('disabled','disabled');
                })
            }
            document.getElementById("associate_specialization").innerHTML = options;
        })
        .catch( error => backendValidation(error.response.data.errors) );
    });

    document.querySelector('#editAssociate').addEventListener('click', e =>{
        axios.get(`/associates/${e.target.dataset.id}/edit`)
        .then( response => {
            data = response.data
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
        .catch( error => backendValidation(error.response.data.errors) );
    });
}
catch(err){
}

try{
    //User Profile

    //Staff Assessment
    document.getElementById('assess_user').addEventListener('click', e => {
        const {dataset : URL_PARAMS } = e.target
        const id = URL_PARAMS.id;
        const teamId = URL_PARAMS.team;
        let inputs = [];
        axios.get(`/targets/${teamId}`)
        .then( response => {
            data = response.data
            if(data.length ==0){
                showAlert('error','There are not tagerts to assess');
                return false;
            }else{
                data.forEach( record => {
                    const TARGET_NAME = record.name.split(' ').join('_').toLowerCase();
                    const TARGET_ID = record.id;
                    inputs.push( `<div class="col-md-4">
                        <label for="${TARGET_NAME}">${record.name}</label>
                        <input type="number" class="form-control dynamic-field" name="${TARGET_ID}" id="${TARGET_NAME}" min="1" max="5">
                        </div>`
                    );
                })
                document.getElementById('assessment_page').innerHTML = inputs;
                document.getElementById('consultant_id').value = id;
                document.getElementById('assessment_period').value = `${GET_MONTH_NAME(THISDAY)}-${THISYEAR}`;
        
                $('#staffAssessment').modal('show');
            }
        })
        .catch( error => backendValidation(error.response.data.errors) );


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
            axios.post('/assessments',formData)
            .then( response => {
                $('#staffAssessment').modal('hide');
                $('#assessmentForm')[0].reset();
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors) );
        }
    })

    //Edit user task
    document.querySelectorAll('.edit_user_task').forEach(element => {
        element.addEventListener('click', e =>{
            axios.get(`/tasks/${e.target.id}/edit`)
            .then( response => {
                data = response.data[0]
                document.getElementById('task_name').value = data.task_name;
                document.getElementById('task_name').setAttribute('readonly','readonly');
                document.getElementById('task_status').value = data.task_status;
                document.getElementById('task_deadline').value = data.task_deadline;
                document.getElementById('task_deadline').setAttribute('readonly','readonly');
                document.getElementById('task_id').value = data.task_id
                document.getElementById('staff_assignment').style.display = 'none';
                document.getElementById('task_title').innerText = 'Update Task';
                $('#addTask').modal('show');
            })
            .catch( error => console.log(error.message) );
        });
    });
    
    //Save update
    document.getElementById('taskForm').addEventListener('submit', function(e){
        e.preventDefault();
        saveTask(['task_name','task_deadline','task_status']);
    })

    //Add user timesheet
    document.querySelectorAll('.add_task_timesheet').forEach( element => {
        element.addEventListener('click', e =>{
            let options = [];
            document.querySelector('#the_task_id').value = e.target.id;
            let selectList = document.getElementById('beneficiary').options;
            for (let option of selectList) {
                if(option.value == 'Business Development'||option.value == 'Administration'){
                    option.remove()
                }
            }
            document.getElementById('beneficiary').value = 'Opportunities';
            let formData = new FormData();
            formData.append('beneficiary','Opportunities')
            axios.post('/getServicelines',formData)
            .then( response => {
                data = response.data
                if(data == null){
                    options.push(`<option value="0" disabled selected>No Records...</option>`);
                }else{
                    data.forEach( serviceline =>{
                        options.push( `<option value="${serviceline.id}" selected>${serviceline.service_name}</option>` );
                    })
                }
                document.getElementById("the_serviceline").innerHTML = options;
                $('#addTimesheet').modal('show');
            })    
            .catch( error => backendValidation(error.response.data.errors) );
        });
    });

    //Save Timesheet
    document.getElementById('timesheetForm').addEventListener('submit', function(e){
        e.preventDefault();
        const TIMESHEET_INDEX = document.getElementsByName('timesheet_id');
        const TIMESHEET_ID = (TIMESHEET_INDEX == null)? null:TIMESHEET_INDEX.value;
        FIELD_IDS = ['beneficiary','the_serviceline','activity_date','duration','activity_description'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( TIMESHEET_ID != null){
                axios.post(`/timesheets/${TIMESHEET_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#timesheetForm')[0].reset();
                    $('#addTimesheet').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors));
            }
            else{ 
                axios.post('/timesheets',formData)
                .then( response => {
                    $('#timesheetForm')[0].reset();
                    $('#addTimesheet').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

    //Edit Timesheet
    let reviewTimesheets = document.querySelectorAll('.reviewTimesheet');
    reviewTimesheets.forEach( reviewTimesheet =>{
        reviewTimesheet.addEventListener('click', e =>{
            axios.get(`/taskusers/${e.target.id}/edit`)
            .then( response =>{
                data = response.data
                if(data.om_number != null || data.om_number != undefined){
                    document.getElementById('OMField').value = data.om_number;
                    document.getElementById('OMField').setAttribute('required','required');
                    document.getElementById('omNum').style.display = 'block';   
                }else{
                    document.getElementById('omNum').style.display = 'none';
                    document.querySelector('input[name=om_number]').value=='None';
                }
                let options = [];
                axios.get(`/servicelines/${data.serviceline_id}/edit`)
                .then( response => {
                    data = response.data
                    if(data == null){
                        options.push(`<option value="0" disabled selected>No Records found...</option>`);
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
                document.getElementById('task_user_id').value = data.id;
                $('#addTimesheet').modal('show');
            })
            .catch( error => backendValidation(error.response.data.errors) );
        });

    })

    //Edit User
    document.getElementById('editUser').addEventListener('click', e => {
        axios.get(`/users/${e.target.dataset.id}/edit`)
        .then( response => {
            data = response.data
            document.getElementById('staffId').value = data.staffId;
            document.getElementById('name').value = data.name;
            document.getElementById('gender').value = data.gender;
            document.getElementById('email').value = data.email;
            document.getElementById('mobilePhone').value = data.mobilePhone;
            document.getElementById('alternativePhone').value = data.alternativePhone;
            document.getElementById('user_team_id').value = data.team_id;
            document.getElementById('the_title_id').value = data.title_id;
            document.getElementById('role_id').value = data.role_id;
            document.getElementById('reportsTo').value = data.reportsTo;
            document.getElementById('userStatus').value = data.userStatus;
            document.getElementById('user_id').value = data.id;
            document.getElementById('user_login').style.display = 'none';
            $('#addUser').modal('show');
        }).catch(error => console.error(error))
    });

    //Request Leave
    document.getElementById('requestLeave').addEventListener('click', (e) =>{
        document.getElementById('booked_for').value = e.target.dataset.user
        $('#addleave').modal('show');
    });

    document.getElementById('leaveForm').addEventListener('submit', function(e){
        e.preventDefault();
        const LEAVE_INDEX = document.getElementsByName('leave_id');
        const LEAVE_ID = (LEAVE_INDEX == null)? null:LEAVE_INDEX.value;
        FIELD_IDS = ['the_leavesetting','leave_start','leave_end','leave_detail']
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        let sel = document.getElementById('the_leavesetting');
        let selected = sel.options[sel.selectedIndex];
        let leaveType = selected.getAttribute('data-type');
        
        if( validateForm === 0 ){
            let formData = new FormData(this);
            formData.append('leaveType',leaveType);
            if( LEAVE_ID != null){
                axios.post(`/leaves/${LEAVE_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#leaveForm')[0].reset();
                    $('#addleave').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors));
            }
            else{
                axios.post('/leaves',formData)
                .then( response =>{
                    data = response.data
                    console.log(data)
                    $('#leaveForm')[0].reset();
                    $('#addleave').modal('hide');
                    // showAlert('success',data);
                    // location.reload()
                })
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

   //Add worktime
    document.getElementById('workTime').addEventListener('click', e =>{
        let selectList = document.getElementById('beneficiary').options;
        for (let option of selectList) {
            if(option.value == 'Opportunities'){
               option.remove()
            }
        }
        $('#addTimesheet').modal('show');
    })
    
    //Edit User timesheet
    document.querySelectorAll('.editTimesheet').forEach( timesheet => {
        timesheet.addEventListener('click', e =>{
            e.preventDefault();
            axios.get(`/timesheets/${e.target.id}/edit`)
                .then( response => {
                    data = response.data
                    document.getElementById('timesheet_id').value = data.id;
                    document.getElementById('the_task_id').value = data.task_id;
                    document.getElementById('beneficiary').value = data.beneficiary;
                    document.getElementById('the_serviceline').value = data.serviceline_id;
                    document.getElementById('activity_date').value = data.activity_date;
                    document.getElementById('duration').value = data.duration;
                    document.getElementById('activity_description').value = data.activity_description;
                    document.getElementById('timesheet_title').innerText = 'Update Timesheet';
                $('#addTimesheet').modal('show');
            })
            .catch(error=>console.log(error))
        })
    })
    //Timesheet beneficiary
    document.getElementById('beneficiary').addEventListener('change', e =>{
        let beneficiary = e.target.value;
        let formData = new FormData();
        let options = [];
        formData.append('beneficiary',beneficiary)
        axios.post('/getServicelines',formData)
        .then( response => {
            data = response.data
            if(data == null){
                options.push(`<option value="0" disabled selected>No Records...</option>`);
            }else{
                data.forEach( serviceline =>{

                    options.push( `<option value="${serviceline.id}">${serviceline.service_name}</option>` );

                })
            }
            document.getElementById("the_serviceline").innerHTML = options;
        })    
        .catch( error => backendValidation(error.response.data.errors) );
    });

}
catch(err){

}

try{
    //Admin section

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
            if( LEAVESETTING_ID != null ){
                axios.post(`/leavesettings/${LEAVESETTING_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    data = response.data
                    $('#leaveSettingForm')[0].reset();
                    $('#leaveSetting').modal('hide');
                    showAlert('success',data);
                    location.reload()
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{  
                axios.post('/leavesettings',formData)
                .then( response => {
                    $('#leaveSettingForm')[0].reset();
                    $('#leaveSetting').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

    //Edit Leave Settings
    editButtons = document.querySelectorAll('.editLeavesetting');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            axios.get(`/leavesettings/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('leave_type').value = data.leave_type;
                document.getElementById('annual_lot').value = data.annual_lot;
                document.getElementById('bookable_days').value = data.bookable_days;
                document.getElementById('leavesetting_id').value = data.id;
                $('#leaveSetting').modal('show');
            })
            .catch( error => backendValidation(error.response.data.errors) );
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
            if( SERVICELINE_ID != null ){
                axios.post(`/servicelines/${SERVICELINE_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    data = response.data
                    $('#servicelinesForm')[0].reset();
                    $('#serviceLine').modal('hide');
                    showAlert('success',data);
                    location.reload()
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{ 
                axios.post('/servicelines',formData)
                .then( response => {
                    $('#servicelinesForm')[0].reset();
                    $('#serviceLine').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

    //Edit service line
    editButtons = document.querySelectorAll('.editService');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            axios.get(`/servicelines/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('service_beneficiary').value = data.beneficiary;
                document.getElementById('service_code').value = data.service_code;
                document.getElementById('service_name').value = data.service_name;
                document.getElementById('serviceline_id').value = id;
                document.getElementById('servicelines_form_heading').innerText = 'Update Serviceline';
                $('#addServiceLine').modal('show');
            })
        .catch( error => backendValidation(error.response.data.errors) );
        });
    });

    // Delete service line
    document.getElementById('delService').addEventListener('click', e =>{
       confirmDelete(e.target.dataset.id)
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
            
            if( HOLIDAY_ID != null ){
                axios.post(`/holidays/${HOLIDAY_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#holidaysForm')[0].reset();
                    $('#publicDays').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{
                axios.post('/holidays',formData)
                .then( response => {
                    $('#holidaysForm')[0].reset();
                    $('#publicDays').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            } 
        }
    });

    //Edit Holidays
    editButtons = document.querySelectorAll('.editHoliday');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            axios.get(`/holidays/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('holiday').value = data.holiday;
                document.getElementById('holiday_date').value = data.holiday_date;
                document.getElementById('holiday_id').value = data.id;
                $('#publicDays').modal('show');
            })
            .catch( error => backendValidation(error.response.data.errors) );
        })
    });

    //Add titles
    document.getElementById('titlesForm').addEventListener('submit', function(e){
        e.preventDefault();
        const title_INDEX = document.getElementById('title_id');
        const title_ID = (title_INDEX == null)? null:title_INDEX.value;
        FIELD_IDS = ['title_id','title_name','description'];

        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( title_ID != null ){
                axios.post(`/titles/${title_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#titlesForm')[0].reset();
                    $('#addtitle').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{
                axios.post('/titles',formData)
                .then( response => {
                    $('#titlesForm')[0].reset();
                    $('#addtitle').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

   //Edit title
   editButtons = document.querySelectorAll('.edittitle');
   editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            axios.get(`/titles/${e.target.id}/edit`)
                .then( response => {
                data = response.data
                document.getElementById('title_name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('title_id').value = data.id;
                document.getElementById('titles_form_heading').innerText = 'Update title';
                $('#addtitle').modal('show');
            } )
            .catch( error => backendValidation(error.response.data.errors) );
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
            if( TEAM_ID != null ){
                axios.post(`/teams/${TEAM_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#teamsForm')[0].reset();
                    $('#addTeams').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{   
                axios.post('/teams',formData)
                .then( response => {
                    $('#teamsForm')[0].reset();
                    $('#addTeams').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

    //Edit team
    editButtons = document.querySelectorAll('.editTeam');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            e.preventDefault();
            axios.get(`/teams/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('team_name').value = data.team_name;
                document.getElementById('team_code').value = data.team_code;
                document.getElementById('team_leader').value = data.team_leader;
                document.getElementById('team_leader').setAttribute('selected','selected');
                document.getElementById('team_id').value = data.id;
                document.getElementById('team_form_heading').innerText = 'Update team';     
                $('#addTeams').modal('show');
            } )
            .catch( error => backendValidation(error.response.data.errors) );
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
            if( EXPERTISE_ID != null ){
                axios.post(`/expertise/${EXPERTISE_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#expertiseForm')[0].reset();
                    $('#addExpertise').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{
                axios.post('/expertise',formData)
                .then( response => {          
                    $('#expertiseForm')[0].reset();
                    $('#addExpertise').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

    //Edit Expertise
    editButtons = document.querySelectorAll('.editExpertise');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            axios.get(`/expertise/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('field_name').value = data.field_name;
                document.getElementById('field_description').value = data.field_description;
                document.getElementById('expertise_id').value = data.id;
                document.getElementById('expertise_form_heading').innerText = 'Update Expertise';     
                $('#addExpertise').modal('show');
            })
            .catch( error => backendValidation(error.response.data.errors) );
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

    document.getElementById('specializationForm').addEventListener('submit', function(e){
        e.preventDefault();
        FIELD_IDS = ['the_expertise','specialization'];
        const SPECIALIZATION_INDEX = document.getElementById('specialization_id');
        const SPECIALIZATION_ID = (SPECIALIZATION_INDEX == null)? null:SPECIALIZATION_INDEX.value;
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( SPECIALIZATION_ID != null ){
                axios.post(`/specialization/${SPECIALIZATION_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#specializationForm')[0].reset();
                    $('#addSpecialization').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{ 
                axios.post('/specialization',formData)
                .then( response => {
                    $('#specializationForm')[0].reset()
                    $('#addSpecialization').modal('hide')
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    });

    //Update specialization
    document.querySelectorAll('.editSpecialization').forEach( editSpecialization =>{
        editSpecialization.addEventListener('click', e =>{
            axios.get(`/specialization/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('the_expertise').value = data.expertise_id;
                document.getElementById('specialization').value = data.specialization;
                document.getElementById('specialization_id').value = data.id;
                document.getElementById('specialization_title').innerText = 'Update Specialization';     
                $('#addSpecialization').modal('show');
            })
            .catch( error => backendValidation(error.response.data.errors) );
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
            if( TARGET_ID != null ){
                axios.post(`/targets/${TARGET_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#targetsForm')[0].reset();
                    $('#addTargets').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{ 
                axios.post('/targets',formData)
                .then( response => {
                    $('#targetsForm')[0].reset();
                    $('#addTargets').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    })

    //Edit Targets
    editButtons = document.querySelectorAll('.editTargets');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            axios.get(`/targets/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('target_category').value = data.target_category;
                document.getElementById('target_name').value = data.target_name;
                document.getElementById('target_value').value = data.target_value;
                document.getElementById('target_id').value = e.target.id;
                document.getElementById('targets_heading').innerText = 'Update Target';
                $('#addTargets').modal('show');
            })
            .catch( error => {
                console.log(error)
            });
        });
    });

    //Leave carried forward
    document.getElementById('saveForwardedLeave').addEventListener('click', function(e){
        e.preventDefault()
        const LEAVEFORWAD_INDEX = document.getElementById('leaveforward_id');
        const LEAVEFORWAD_ID = (LEAVEFORWAD_INDEX == null)? null:LEAVEFORWAD_INDEX.value;
        FIELD_IDS = ['forwarding_user','days_forwarded'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(document.getElementById('forwardedLeaveForm'));
            if( LEAVEFORWAD_ID != null ){
                axios.post(`/leaveforwards/${LEAVEFORWAD_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#forwardedLeaveForm')[0].reset();
                    $('#addLeaveforward').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
            else{ 
                axios.post('/leaveforwards',formData)
                .then( response => {
                    $('#forwardedLeaveForm')[0].reset();
                    $('#addLeaveforward').modal('hide');
                    showAlert('success',response.data);
                    location.reload();
                } )
                .catch( error => backendValidation(error.response.data.errors) );
            }
        }
    })
    // //Confirm Leave Request
    // document.getElementById('acceptLeave').addEventListener('click', e =>{
    //     let formData = new FormData()
    //     formData.append('status','Confirmed')
    //     axios.post(`/leaves/${e.target.dataset.id}`,formData,{
    //         method: 'PUT'
    //     })
    //     .then( response =>{
    //         showAlert('success',response.data);
    //         location.reload()
    //     })
    //     .catch( error => backendValidation(error.response.data.errors) );
    // });

    // //Reject Leave Request
    // document.getElementById('denyLeave').addEventListener('click', e =>{
    //     let formData = new FormData()
    //     formData.append('status','Denied')
    //     axios.post(`/leaves/${e.target.dataset.id}`,formData,{
    //         method: 'PUT'
    //     })
    //     .then( response =>{
    //         showAlert('success',response.data);
    //         location.reload();
    //     })
    //     .catch( error => backendValidation(error.response.data.errors) );
    // });

    // //Delete Leave
    // document.getElementById('delLeve').addEventListener('click', e =>{
    //     confirmDelete(e.target.dataset.id);
    // });
    
    // document.getElementById('deleteBtn').addEventListener('click', ()=>{
    //     let item = document.getElementById('item-delete');
    //     deleteItem(`leaves/${id}`);
    // });


}
catch(err){

}

try{
    //Add users
    document.getElementById('userForm').addEventListener('submit', function(e){
        e.preventDefault();
        const USER_INDEX = document.getElementById('user_id');
        const USER_ID = (USER_INDEX == null)? null:USER_INDEX.value;
        FIELD_IDS = USER_INDEX== null? ['saffId','name','gender','email','password','password-confirm','mobilePhone','alternativePhone','user_team_id','the_title_id','role_id','reportsTo','userStatus']:['saffId','name','gender','email','mobilePhone','alternativePhone','user_team_id','the_title_id','role_id','reportsTo','userStatus'];
        let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
        if( validateForm === 0 ){
            let formData = new FormData(this);
            if( USER_ID != null ){
                axios.post(`/users/${USER_ID}`,formData,{
                    method: 'PUT'
                })
                .then( response => {
                    $('#teamsForm')[0].reset();
                    $('#addTeams').modal('hide');
                    showAlert('success',response.data);
                    location.reload()
                } )
                .catch( error =>backendValidation(error.response.data.errors));
            }
            else{
                axios.post('/users',formData)
                .then( response =>{
                    showAlert('success',response.data);
                    location.reload();
                })
                .catch( error => backendValidation(error.response.data.errors) );;
            }
        }
    });
}
catch(err){

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
            axios.post('/support',formData)
            .then( response => {
                $('#feedBackForm')[0].reset();
                showAlert('success',response.data);
                location.reload();
            } )
            .catch( error => backendValidation(error.response.data.errors) );
        }
        else{
            console.log(validateForm)
        }
    })
}
catch(e){

}

let exportExcel = (tableId, filename= null)=>{
    let downloadLink;
    let dataType = 'application/vnd.ms-excel';
    let tableSelect = document.getElementById(tableId);
    let tableHTML = tableSelect.outerHTML.replace(/ /g, '%20')
    filename = filename?filename+'.xls':'AH_Consulting.xls';
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
        axios.post(url,formData)
        .then( response => {
            $('#consultantForm')[0].reset();
            $('#addConsultant').modal('hide');
            showAlert('success',response.data);
            location.reload();
        })
        .catch( error => backendValidation(error.response.data.errors) );
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
    axios.delete(url)
    .then(response => {
        showAlert('success',response.data);
        location.reload();
    })
    .catch( error => backendValidation(error.response.data.errors) );
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

let calculateResults = (url,formId,exportBtn) =>{
    let formData = new FormData(formId);
    for(let i = 0; i < FIELD_IDS.length; i++ ) {
        formData.append(document.getElementById( FIELD_IDS[i] ).name, document.getElementById( FIELD_IDS[i] ).value);
    }
    axios.post(`/${url}`,formData)
    .then( response => {
        data = response.data
        recordsHTML = '';
        if( data.length > 0 ) {
            recordsHTML += `<table id="sorted_opportunities" class="table table-bordered table-sm">
            <thead class="bg-success text-white"><tr><td>OM Number</td><td>Name</td><td>Type</td><td>Stage</td><td>Country</td><td>Revenue</td></tr></thead><tbody>`
            for(let i=0; i<data.length; i++){
                recordsHTML += `<tr><td>
                <a href="/opportunities/${data[i].id}" class="text-primary" title="View Opportunity">${data[i].om_number}</a></td><td>${data[i].name}</td><td>${data[i].type}</td><td>${data[i].sales_stage}</td><td>${data[i].country}</td><td>${data[i].revenue}</td></tr>`
            }
            recordsHTML += `<tbody></table>`;
            document.getElementById('summaries').innerHTML = `Total records - ${data.length}`;
            elementAdd( 'records-list', 'beforeend', recordsHTML );
            document.getElementById(exportBtn).style.display = 'block';
        }
        else {
            document.getElementById('summaries').innerText = `No records found`;
            document.getElementById(exportBtn).style.display = 'none';
        }
        document.getElementById('records-list').style.display = 'block';
        document.getElementById('loading').style.display = 'none';

    })
    .catch( error => {
        console.log(error)
        //backendValidation(error.response.data.errors)
    });
}

let openConsultation = (workstation,id) => {
    document.getElementById(workstation).value = id;
    $('#addConsultant').modal('show');
}

let getDocument = (e) => {
    document.getElementById('owner_id').setAttribute('name', e.target.dataset.owner);
    document.getElementById('owner_id').value = e.target.dataset.id;
    document.getElementById('fileName').setAttribute('name', 'fileName');
    document.getElementById('fileName').value = e.target.dataset.name;
    $('#addDocument').modal('show');
}

let backendValidation = response => {

    Object.keys(response).forEach( item => {

        const itemDom = document.getElementById(item);
        const errorMessage = response[item];
        const errorMessages = document.querySelectorAll('.text-danger');
        errorMessages.forEach((Element)=>Element.textContent = '');
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach((Element) =>Element.classList.remove('border', 'border-danger'));
        itemDom.classList.add('border', 'border-danger');
        itemDom.insertAdjacentHTML('afterend',`<div class="text-danger">${errorMessage}</div>`);

    });
    
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

let doEvaluation = (id,modal) =>{
    document.getElementById('evaluationable_id').value = id;
    document.getElementById('evaluationable_type').value = `App\\${modal}`;
    document.getElementById('evaluation_title').innerText = `${modal} Evaluation`;
    $('#addEvaluations').modal('show');
};

let saveEvaluation = (formId) =>{
    FIELD_IDS = ['evaluationForm','results_achieved','challenges_faced','improvement_plans'];
       let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
    if( validateForm === 0 ){
        let formData = new FormData(formId);
        axios.post('/evaluations',formData)
        .then( response => {
            $('#evaluationForm')[0].reset();
            $('#addEvaluations').modal('hide');
            location.reload();
            showAlert('success',response.data);
        })
        .catch( error => backendValidation(error.response.data.errors) );
    }
}

let removeRow = (id) =>{
    document.getElementById(`row${id}`).remove();
}

let clearAlert = () =>{
    let currentAlert = document.querySelector('.alert');
    if(currentAlert){
        currentAlert.remove()
    }
}

let showAlert = (cls, msgInfo) =>{
    clearAlert();
    let className = (cls == 'error')? 'alert alert-danger':'alert alert-success';
    let div = document.createElement('div');
    div.className =className;
    div.appendChild(document.createTextNode(msgInfo));
    let notices = document.getElementById('notices');
    let noticesPoint = document.getElementById('noticesPoint');
    notices.insertBefore(div,noticesPoint);
    //Alert timeout
    setTimeout(()=>{
        clearAlert();
    },3000)
}

let previewContent = (el) =>{
    let restorePage = document.body.innerHTML;
    let printContent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printContent;
    window.print()
    document.body.innerHTML = restorePage;
}

let assignTask = id =>{
    let patch ='';
    let consultantsList = document.querySelectorAll('.responsible_users');
    consultantsList = Array.from(consultantsList)
    if(consultantsList.length == 0){
        showAlert('error','There are no consultants for this task');
        return false;
    }else{
        consultantsList.forEach(consultant => {
            patch += `<option value="${consultant.id}">${consultant.textContent}</option>`;     
        });
    }
    
    //Get Associates
    let associatesList = document.querySelectorAll('.associates');
    associatesList = Array.from(associatesList)
    associatesList.forEach(associate => {
        patch += `<option value="${associate.id}">${associate.textContent}</option>`;     
    });
    
    document.getElementById('taskStaff').innerHTML = patch;
    document.getElementById('the_deliverable').value = id;
    $('#addTask').modal('show');

}

let saveTask = (FIELD_IDS) =>{
    const TASK_INDEX = document.getElementById('task_id');
    const TASK_ID = (TASK_INDEX == null)? null:TASK_INDEX.value;
    let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
    if( validateForm === 0 ){
        let formData = new FormData(document.getElementById('taskForm'));
        if( TASK_ID !== null && TASK_ID !== ''){
            axios.post(`/tasks/${TASK_ID}`,formData,{
                method: 'PUT'
            })
            .then( response => {
                $('#taskForm')[0].reset();
                $('#addTask').modal('hide');
                showAlert('success',response.data);
                location.reload();
            } )
            .catch( error => backendValidation(error.response.data.errors) );
        }
        else{
            axios.post('/tasks',formData)
            .then( response => {
                $('#taskForm')[0].reset();
                $('#addTask').modal('hide');
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors) );

        }
    }else{
        console.log(validateForm)
    }
}

let revealTask = id =>{
    console.log(id)
}

let loadDeliverables = (id,searchtype) =>{

    let options = [];
    let deliverable_type = ( searchtype == 'Opportunity' )? 'Opportunity' : 'Project';
    let formData = new FormData();
    formData.append('deliverable_type', deliverable_type);
    axios.post('/pickdeliverables',formData)
    .then( response => {
        data = response.data
        if(data.length == 0){
            options.push(`<option value="0" disabled selected>No Contacts found...</option>`);
            document.getElementById("deliverable_ids").innerHTML = options;
        }else{
            data.forEach( deliverable =>{
                options.push( `<option data-name="${deliverable.deliverable_name}" value="${deliverable.id}">${deliverable.deliverable_name}</option>` );
            })
            document.getElementById("deliverable_ids").innerHTML = options;
        }

        if(deliverable_type == 'Opportunity'){
            document.getElementById("the_opportunity").value = id;
        }else{
            document.getElementById("the_project_id").value = id;
        }

        document.getElementById("create_deliverables").style.display = 'none';

        $('#add_deliverables').modal('show');
    })

}

let pickDeliverable = (id,deliverableName,searchtype) =>{

    let options = [];
    let deliverable_type = ( searchtype == 'Opportunity' )? 'Opportunity' : 'Project';
    let formData = new FormData();
    formData.append('deliverable_type', deliverable_type);
    formData.append('id', id);
    axios.post('/pickdeliverables',formData)
    .then( response => {
        data = response.data
        if(data.length == 0){

        }else{
            data.forEach( deliverable =>{
                
                if(deliverable_type == 'Opportunity'){
                    document.getElementById("the_opportunity").value = deliverable.deliverable_id;
                }else{
                    document.getElementById("the_project_id").value = deliverable.deliverable_id;
                }
                document.getElementById("deliverable_id").value = deliverable.id;
                options.push(`<option value="${deliverable.deliverable_id}">${deliverableName}</option>`);
                document.getElementById("deliverable_ids").innerHTML = options;
                document.getElementById("deliverable_status").value = deliverable.deliverable_status;
                document.getElementById("deliverable_completion").value = deliverable.deliverable_completion;
                document.getElementById("deliverable_title").innerText = 'Update Deliverable';
                document.getElementById("create_deliverables").style.display = 'none';
                $('#add_deliverables').modal('show');
            })
        }
    })

}

let storeDeliverable = (FIELD_IDS) =>{

    let the_opportunity_id = document.getElementById('the_opportunity').value;
    const DELIVERABLE_INDEX = document.getElementById('deliverable_id');
    const DELIVERABLE_ID = (DELIVERABLE_INDEX == null)? null:DELIVERABLE_INDEX.value;
    let formData = new FormData();
    
    FIELD_IDS.forEach( FIELD_ID => {
        formData.append( document.getElementById(FIELD_ID).name,document.getElementById(FIELD_ID).value)
    })

    if( DELIVERABLE_ID == null || DELIVERABLE_ID == ''){

        if( the_opportunity_id != null ){
            axios.post('/deliverableopportunities',formData)
            .then( response =>{
                $('#deliverablesForm')[0].reset();
                $('#add_deliverables').modal('hide');
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors));
        }else{
            axios.post(`/deliverableprojects`,formData)
            .then( response => {
                $('#deliverablesForm')[0].reset();
                $('#add_deliverables').modal('hide');
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors));
        }
    }
    else{
        if( the_opportunity_id!= null ){
            axios.post(`/deliverableopportunities/${DELIVERABLE_ID}`,formData,{
                method: 'PUT'
            })
            .then( response => {
                console.log(response)
                $('#deliverablesForm')[0].reset();
                $('#add_deliverables').modal('hide');
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors) );
        }
        else{
            axios.post(`/projectdeliverables/${DELIVERABLE_ID}`,formData,{
                method: 'PUT'
            })
            .then( response => {
                $('#deliverablesForm')[0].reset();
                $('#add_deliverables').modal('hide');
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors) );
        }
    }

}

let deliverableDelete = id =>{
    console.log(id)
}

let createComment = (id,modal) =>{

    document.getElementById('commentable_id').value = id;
    document.getElementById('commentable_type').value = `App\\${modal}`;
    document.getElementById('comment_title').innerText = `${modal} Comments`;
    $('#addComments').modal('show');

}

let saveComment = (formId) =>{
    const COMMENT_INDEX = document.getElementById('comment_id');
    const COMMENT_ID = (COMMENT_INDEX == null)? null:COMMENT_INDEX.value;
    FIELD_IDS = ['comment_body','commentable_type','commentable_id'];
    let validateForm = UIValidate(FIELD_IDS,ERROR_COUNT);
    if( validateForm === 0 ){
        let formData = new FormData(formId);
        if( COMMENT_ID != null ){
            axios.post(`/comments/${COMMENT_ID}`,formData,{
                method: 'PUT'
            })
            .then( response => {
                $('#commentsForm')[0].reset();
                $('#addComments').modal('hide');
                showAlert('success',response.data);
                location.reload();
            } )
            .catch( error => backendValidation(error.response.data.errors) );
        }
        else{   
            axios.post('/comments',formData)
            .then( response => {
                $('#commentsForm')[0].reset()
                $('#addComments').modal('hide')
                showAlert('success',response.data);
                location.reload();
            })
            .catch( error => backendValidation(error.response.data.errors) );
        }
    }
}

let changeAvailability = (element) =>{

    element.classList.remove()
    element.classList.add()
    let formData = new FormData();
    formData.append('today',THISDAY);
    axios.post('/logs',formData)
    .then( response => {
        console.log(response)
        //showAlert('success',response.data);
        //location.reload();
    })
    .catch( error => backendValidation(error.response.data.errors) );
}

let pageRouter = ( HTML_PAGE_ID ) => {
    document.querySelectorAll( '.page' ).forEach( PAGE => PAGE.style.display = 'none' )
    if( document.getElementById(HTML_PAGE_ID) != null ) document.getElementById(HTML_PAGE_ID).style.display = 'block'
}