<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/admin', 'HomeController@admin');
Route::get('/support', 'HomeController@support');
Route::post('/support', 'HomeController@sendMessage');
Route::get('/reports', 'HomeController@display')->name('reports');

Route::post('/reports', 'HomeController@prepare')->name('reports');
Route::resource('/contacts', 'ContactsController');
Route::post('/contacts/{contact}', 'ContactsController@update');
Route::get('getcontacts','ContactsController@getcontacts')->name('getcontacts');
Route::post('/listContacts', 'ContactsController@listContacts')->name('listContacts');

//Routing everything about opportunities
Route::resource('opportunities', 'OpportunitiesController');
Route::get('/getOpportunity/{opportunity}', 'OpportunitiesController@getOpportunity')->name('getOpportunity');
Route::post('/opportunityUser', 'OpportunitiesController@addConsultants')->name('opportunityUser');
Route::delete('/removeConsultant/{id}','OpportunitiesController@removeConsultant')->name('removeConsultant');
Route::post('/filterOpportunities','OpportunitiesController@filterOpportunities')->name('filterOpportunities');

//Routing everything about projects
Route::resource('/projects', 'ProjectsController');
Route::post('/projects/{project}', 'ProjectsController@update');
Route::post('/createProject','ProjectsController@createProject')->name('createProject');
Route::post('/projectUser', 'ProjectsController@addConsultants')->name('projectUser');
Route::post('/projectassociates', 'ProjectsController@addAssociates')->name('addAssociates');
Route::get('/getproject/{project}', 'ProjectsController@getproject')->name('getproject');
Route::delete('/unassignConsultant/{id}', 'ProjectsController@removeConsultant')->name('unassignConsultant');
Route::post('/filterProjects','ProjectsController@filterProjects')->name('filterProjects');

//Routing everything about tasks
Route::resource('tasks', 'TasksController');
Route::get('/tasks/{task}/users','TasksController@tastUsers')->name('tastUsers');
//Routing everything about partner firms
Route::resource('/partners', 'PartnersController');
//Routing everything about leaves
Route::resource('/leaves', 'LeavesController');
Route::get('/delLeave/{leave}','LeavesController@destroy')->name('delLeave');
//Routing everything about leaves settings
Route::resource('/leavesettings', 'LeavesettingsController');
Route::post('/leavesettings/{leavesetting}', 'LeavesettingsController@update')->name('targets');
//Routing everything about scores
Route::resource('/scores', 'ScoresController');

//Routing everything about teams
Route::resource('/teams', 'TeamsController');
Route::get('/myteam', 'TeamsController@myteam');
Route::post('/teams/{team}', 'TeamsController@update')->name('targets');

//Routing everything about timesheets
Route::resource('/timesheets', 'TimesheetsController');
Route::post('/timesheets/{timesheet}', 'TimesheetsController@update');
Route::resource('/evaluations','EvaluationsController');
Route::post('/saveResponses','TimesheetsController@saveResponses')->name('saveResponses');
// //Routing everything about timesheet Categories
// Route::resource('timesheetCategory', 'timesheetcategories');
//Routing everything about roles
Route::resource('/roles', 'RolesController');
Route::post('/roles/{role}', 'RolesController@update');
//Routing everything about holidays
Route::resource('/holidays', 'HolidaysController');
Route::post('/holidays/{holiday}', 'HolidaysController@update');
//Routing everything about servicelines
Route::resource('/servicelines', 'ServicelinesController');
Route::post('/servicelines/{serviceline}', 'ServicelinesController@update');
Route::post('/getServicelines', 'ServicelinesController@getServicelines')->name('getServicelines');

//Routing everything about documents
Route::resource('/documents', 'DocumentsController');

//Routing everything about deliverables
Route::resource('/deliverables', 'DeliverablesController');
Route::post('/deliverables/{deliverable}', 'DeliverablesController@update');
//Routing everything about expertise
Route::resource('/expertise', 'ExpertiseController');
Route::post('/expertise/{expertise}', 'ExpertiseController@update');

//Routing everything about associate specializations
Route::resource('/specialization', 'SpecializationsController');
Route::post('/specialization/{specialization}', 'SpecializationsController@update');
Route::post('/getSpecilization','SpecializationsController@getSpecilization')->name('getSpecilization');

//Routing everything about users
Route::resource('/users', 'UsersController');
Route::post('/users/{user}', 'UsersController@update');
Route::get('/updateProfile','UsersController@updateProfile')->name('updateProfile');

//User Live Search
Route::get('/search', 'UsersController@search');
Route::resource('/associates', 'AssociatesController');
Route::get('/getAssociate/{associate}', 'AssociatesController@getAssociate')->name('getAssociate');
//Routing everything about comments
Route::resource('/comments', 'CommentsController');
Route::post('/comments/{comment}', 'CommentsController@update');

/*
*Reports Route
*
*/

Route::get('/export_excel','OpportunitiesController@excel')->name('export_excel');
Route::get('/generatepdf','PDFController@index');

//Routing everything about targets
Route::resource('/targets', 'TargetsController');
Route::post('/targets/{target}', 'TargetsController@update');

Route::resource('/leaveforwards','LeaveforwardsController');

//Routing everything about assessments
Route::resource('/assessments', 'AssessmentsController');

Route::get('/send/send_feedback', 'HomeController@sendFeedback');
