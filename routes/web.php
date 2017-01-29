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

// Projects

	Route::get('/projects', 'ProjectController@index');
	Route::get('/projects/new', 'ProjectController@new');
	Route::post('/projects/create', 'ProjectController@create');
	Route::get('/projects/{id}/get-sections', 'ProjectController@getSections');
	Route::get('/projects/{id}/get-requirement-sections', 'ProjectController@getRequirementSections');
	Route::get('/projects/{id}', 'ProjectController@dashboard');
	Route::get('/projects/{id}/activities', 'ProjectController@getActivities');
	Route::get('/projects/{id}/dashboard', 'ProjectController@dashboard');
	Route::get('/projects/{id}/details', 'ProjectController@details');
	Route::post('/projects/{id}/details/update', 'ProjectController@detailsUpdate');
	Route::get('/projects/{project_id}/requirements', 'RequirementController@index');

// Team

	Route::get('/projects/{project_id}/team', 'TeamController@index');
	Route::get('/projects/{project_id}/team/members', 'TeamController@index');
	Route::get('/projects/{project_id}/team/{member_id}/get-roles', 'TeamController@getRoles');
	Route::post('/projects/{project_id}/team/{member_id}/save-roles', 'TeamController@saveRoles');
	Route::get('/projects/{project_id}/team/{member_id}/get-overrides', 'TeamController@getOverrides');
	Route::post('/projects/{project_id}/team/{member_id}/save-overrides', 'TeamController@saveOverrides');
	Route::get('/projects/{project_id}/team/{member_id}/get-restrictions', 'TeamController@getRestrictions');
	Route::post('/projects/{project_id}/team/{member_id}/save-restrictions', 'TeamController@saveRestrictions');
	Route::get('/projects/{project_id}/team/{member_id}/get-member', 'TeamController@getMember');
	Route::get('/projects/{project_id}/team/{member_id}/edit-access', 'TeamController@editAccess');
	Route::get('/projects/{project_id}/team/new-member', 'TeamController@newMember');
	Route::post('/projects/{project_id}/team/create-member', 'TeamController@createMember');

// Team > Roles

	Route::get('/projects/{project_id}/team/roles', 'TeamController@roles');
	Route::get('/projects/{project_id}/team/new-role', 'TeamController@newRole');
	Route::get('/projects/{project_id}/team/{role_id}/get-role', 'TeamController@getRole');
	Route::post('/projects/{project_id}/team/create-role', 'TeamController@createRole');
	Route::get('/projects/{project_id}/team/{role_id}/get-permissions', 'TeamController@getPermissions');
	Route::get('/projects/{project_id}/team/{role_id}/edit-role', 'TeamController@editRole');
	Route::post('/projects/{project_id}/team/{role_id}/save-role', 'TeamController@saveRole');
	Route::post('/projects/{project_id}/team/{role_id}/save-permissions', 'TeamController@savePermissions');

// Cases

	Route::get('/projects/{project_id}/cases', 'CaseController@index');
	Route::get('/projects/{project_id}/cases/new', 'CaseController@new');
	Route::post('/projects/{project_id}/cases/create', 'CaseController@create');
	Route::get('/projects/{project_id}/cases/{id}/get', 'CaseController@get');
	Route::get('/projects/{project_id}/cases/{id}/edit', 'CaseController@edit');
	Route::post('/projects/{project_id}/cases/{id}/update', 'CaseController@update');
	Route::post('/projects/{project_id}/cases/{id}/copy', 'CaseController@copy');
	Route::delete('/projects/{project_id}/cases/{id}/delete', 'CaseController@delete');
	Route::get('/projects/{project_id}/cases/import', 'CaseController@import');
	Route::post('/projects/{project_id}/cases/import', 'CaseController@createBulk');

// Requirements

	Route::get('/projects/{project_id}/requirements', 'RequirementController@index');
	Route::get('/projects/{project_id}/requirements/new', 'RequirementController@new');
	Route::post('/projects/{project_id}/requirements/create', 'RequirementController@create');
	Route::get('/projects/{project_id}/requirements/{id}/get', 'RequirementController@get');
	Route::get('/projects/{project_id}/requirements/{id}/edit', 'RequirementController@edit');
	Route::post('/projects/{project_id}/requirements/{id}/update', 'RequirementController@update');
	Route::post('/projects/{project_id}/requirements/{id}/copy', 'RequirementController@copy');
	Route::delete('/projects/{project_id}/requirements/{id}/delete', 'RequirementController@delete');
	Route::get('/projects/{project_id}/requirements/import', 'RequirementController@import');
	Route::post('/projects/{project_id}/requirements/import', 'RequirementController@createBulk');

// Organisation

Route::get('/organisation/people', 'OrganisationController@people');

Route::get('/', function () {
    return view('welcome');
});

// Lists

Route::get( '/lists/{slug}/f:{format}', 'ListController@getList' );
