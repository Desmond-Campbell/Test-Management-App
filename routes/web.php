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

// Police

Route::get('/police/project/{project_id}/check', 'PoliceController@quickCheck');
Route::get('/police/organisation/check', 'PoliceController@quickCheck');

// General

Route::get('/template', 'TemplateController@index');

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
	Route::post('/projects/{project_id}/team/{member_id}/remove-member', 'TeamController@removeMember');

// Team > Roles

	Route::get('/projects/{project_id}/team/roles', 'TeamController@roles');
	Route::get('/projects/{project_id}/team/new-role', 'TeamController@newRole');
	Route::get('/projects/{project_id}/team/{role_id}/get-role', 'TeamController@getRole');
	Route::post('/projects/{project_id}/team/create-role', 'TeamController@createRole');
	Route::get('/projects/{project_id}/team/{role_id}/get-permissions', 'TeamController@getPermissions');
	Route::get('/projects/{project_id}/team/{role_id}/edit-role', 'TeamController@editRole');
	Route::post('/projects/{project_id}/team/{role_id}/save-role', 'TeamController@saveRole');
	Route::post('/projects/{project_id}/team/{role_id}/save-permissions', 'TeamController@savePermissions');

// Tests

	Route::get('/projects/{project_id}/tests', 'TestController@index');
	Route::get('/projects/{project_id}/tests/{id}/get-bundle', 'TestController@getBundle');
	Route::get('/projects/{project_id}/tests/{id}', 'TestController@overview');
	Route::get('/projects/{project_id}/tests/{id}/get', 'TestController@getTest');
	Route::get('/projects/{project_id}/tests/{id}/get-activity', 'TestController@getTestActivity');
	Route::get('/projects/{project_id}/tests/{id}/get-testers', 'TestController@getTesters');
	Route::post('/projects/{project_id}/tests/create', 'TestController@createTest');
	Route::get('/projects/{project_id}/tests/{id}/launch', 'TestController@launchTest');
	Route::post('/projects/{project_id}/tests/{id}/update', 'TestController@updateTest');
	Route::post('/projects/{project_id}/tests/{id}/update-cases', 'TestController@updateTestCases');
	Route::post('/projects/{project_id}/tests/{id}/update-testers', 'TestController@updateTesters');
	Route::post('/projects/{project_id}/tests/{id}/update-schedule', 'TestController@updateSchedule');
	Route::get('/projects/{project_id}/tests/{id}/activity/{activity_id}/step/{step_id}/new-issue', 'TestController@newIssue');
	Route::post('/projects/{project_id}/tests/{id}/activity/{activity_id}/step/{step_id}/create-issue', 'TestController@createIssue');
	Route::post('/projects/{project_id}/tests/{id}/activity/{activity_id}/step/{step_id}/{advance_type}-step', 'TestController@nextStep');

// Suites

	Route::get('/projects/{project_id}/suites', 'SuiteController@index');
	Route::get('/projects/{project_id}/suites/new', 'SuiteController@newSuite');
	Route::post('/projects/{project_id}/suites/create', 'SuiteController@createSuite');
	Route::get('/projects/{project_id}/suites/{suite_id}/manage', 'SuiteController@manageSuite');
	Route::post('/projects/{project_id}/suites/{suite_id}/update', 'SuiteController@updateSuite');
	Route::delete('/projects/{project_id}/suites/{suite_id}/delete', 'SuiteController@deleteSuite');
	Route::get('/projects/{project_id}/suites/{suite_id}/get', 'SuiteController@getSuite');
	Route::get('/projects/{project_id}/suites/{suite_id}/new-scenario', 'SuiteController@newScenario');
	Route::post('/projects/{project_id}/suites/{suite_id}/create-scenario', 'SuiteController@createScenario');
	Route::get('/projects/{project_id}/suites/{suite_id}/edit-scenario/{scenario_id}', 'SuiteController@editScenario');
	Route::post('/projects/{project_id}/suites/{suite_id}/update-scenario/{scenario_id}', 'SuiteController@updateScenario');
	Route::get('/projects/{project_id}/suites/{suite_id}/get-scenarios', 'SuiteController@getScenarios');
	Route::get('/projects/{project_id}/suites/{suite_id}/get-scenario/{id}', 'SuiteController@getScenario');
	Route::get('/projects/{project_id}/suites/{suite_id}/get-cases/{scenario_id}', 'SuiteController@getCases');
	Route::get('/projects/{project_id}/suites/{suite_id}/get-case/{id}', 'SuiteController@getCase');
	Route::get('/projects/{project_id}/suites/{suite_id}/edit-case/{id}', 'SuiteController@editCase');
	Route::post('/projects/{project_id}/suites/{suite_id}/update-case/{id}', 'SuiteController@updateCase');
	Route::get('/projects/{project_id}/suites/{suite_id}/new-case/{scenario_id}', 'SuiteController@newCase');
	Route::post('/projects/{project_id}/suites/{suite_id}/create-case/{scenario_id}', 'SuiteController@createCase');
	Route::get('/projects/{project_id}/suites/{suite_id}/get-steps/{case_id}', 'SuiteController@getSteps');
	Route::post('/projects/{project_id}/suites/{suite_id}/save-steps/{case_id}', 'SuiteController@saveSteps');

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
