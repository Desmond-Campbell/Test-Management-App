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
Route::get('/projects/{id}/dashboard', 'ProjectController@dashboard');
Route::get('/projects/{id}/details', 'ProjectController@details');
	Route::post('/projects/{id}/details/update', 'ProjectController@detailsUpdate');
Route::get('/projects/{project_id}/requirements', 'RequirementController@index');

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

Route::get('/projects/{project_id}/team', 'TeamController@index');

Route::get('/', function () {
    return view('welcome');
});

// Lists

Route::get( '/lists/{slug}/f:{format}', 'ListController@getList' );

