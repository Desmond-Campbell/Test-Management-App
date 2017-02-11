<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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

Route::group(['domain' => '{domain}.' . env('APP_DOMAIN'), 'middleware' => [/*'web', 'forceSSL'*/]], function ($domain) {

	$host = explode( '.', arg( $_SERVER, 'HTTP_HOST' ) );

	if ( count( $host ) == 2 ) {

		header( "Location: http://www." . env( 'APP_DOMAIN' ) );
		die;

	}

	$domain = $host[0];
	$www_host = "http://my." . env( 'APP_DOMAIN' );
	$www_redirect = $www_host . '/login?then=' . base64_encode( 'http://' . arg( $_SERVER, 'HTTP_HOST' ) . arg( $_SERVER, 'REQUEST_URI' ) );
	$www_network_redirect = $www_host . '/networks';

	$console = App::runningInConsole();

	if ( !$console ) {

		if ( count( $host ) == 2 ) {

			http_die( [ 
								'url' => "$www_redirect", 
								'identifier' => "invalid_host_count-2", 
								'message' => ___( 'We were unable to find the network you requested.' ) 
								] 
						);

		}

		if ( count( $host ) == 3 && \App\Networks::invalidDomain( $domain ) ) {

			http_die( [ 
								'url' => "$www_host", 
								'identifier' => "invalid_domain (2)", 
								'message' => ___( 'We were unable to find the network you requested.' ) 
								] 
						);

		}

		if ( count( $host ) != 3 ) {

			http_die( [ 
								'url' => "$www_host", 
								'identifier' => "invalid_host_count-!3", 
								'message' => ___( 'We were unable to find the network you requested.' ) 
								] 
						);

		}

		$network = DB::table( 'networks' )->where( 'domain', $domain )->first();

		if ( !$network ) {

			http_die( [ 
								'url' => "$www_host", 
								'identifier' => "invalid_domain_no_network_found", 
								'message' => ___( 'We were unable to find the network you requested.' ) 
								] 
						);

		} else {

			$database = env( 'NETWORK_DATABASE_PREFIX' ) . str_pad( $network->id, 10, "0", STR_PAD_LEFT );

		}

		if ( env( 'MULTI_TENANCY_MODE' ) == 'true' ) {

	      App::bind('network', function( $app ) use ( $database ) {

	          $connection = [];
	          $connection['driver'] = env( 'DB_CONNECTION' );
	          $connection['host'] = env( 'DB_HOST' );
	          $connection['port'] = env( 'DB_PORT' );
	          $connection['database'] = "$database";
	          $connection['username'] = env( 'DB_USERNAME' );
	          $connection['password'] = env( 'DB_PASSWORD' );

	          Config::set( "database.connections.$database", $connection );
	          
	      });

	      App::make( 'network', $database );
	      Config::set( 'database.default', $database );

	  }

	  try { 

	  	DB::table('users')->find(1); 

	  }

	  catch(Exception $e) { 

	  	if ( $e->getCode() == '1049' ) {

	  		http_die( [ 
								'url' => "$www_host", 
								'identifier' => "invalid_domain_no_database", 
								'message' => ___( 'We were unable to load the network you requested, due to a system error.' ) 
								] 
						);
	  	
	  	}

	  }

	  /* Cookie check */

		$login_redir = true;
		$network_redir = true;
		$cookie = arg( $_COOKIE, config( 'session.global_cookie' ) );

		if ( $cookie ) { 
		
			$crumbs = explode( '.', $cookie );

			if ( count( $crumbs ) == 4 ) {

				$login_redir = false;

				$sso_id = (int) $crumbs[2];

				$user = DB::table( 'users' )->where( 'sso_id', $sso_id )->first();

				if ( $user ) {

					$network_redir = false;

				}

			} 

		}

		if ( $login_redir ) {

    	http_die( [ 
								'url' => "$www_host", 
								'identifier' => "invalid_cookie", 
								'message' => ___( 'We were unable to log you into the network you requested, due to an authentication error.' ) 
								] 
						);

		}

		if ( $network_redir ) {

    	http_die( [ 
								'url' => "$www_network_redirect", 
								'identifier' => "no_access", 
								'message' => ___( 'We were unable to log you into the network you requested, due to an authentication error.' ) 
								] 
						);

		}

	  /* End cookie check */

	  // Police

			Route::get('/police/project/{project_id}/check', 'PoliceController@quickCheck');
			Route::get('/police/network/check', 'PoliceController@quickCheck');

		// General

			Route::get('/template', 'TemplateController@index');

		// Search

			Route::get('/projects/{project_id}/search', 'SearchController@index');
			Route::get('/projects/{project_id}/o/{object_type}/{id}', 'SearchController@getObject');

		// Projects

			Route::get('/', 'ProjectController@index');
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
			Route::get('/projects/{project_id}/tests/{id}/get-batches', 'TestController@getBatches');
			Route::post('/projects/{project_id}/tests/{id}/start-batch', 'TestController@startBatch');
			Route::post('/projects/{project_id}/tests/{id}/stop-batch/{batch_id}', 'TestController@stopBatch');
			Route::get('/projects/{project_id}/tests/{id}/batch/{batch_id}/get-activity', 'TestController@getTestActivity');
			Route::get('/projects/{project_id}/tests/{id}/get-testers', 'TestController@getTesters');
			Route::post('/projects/{project_id}/tests/create', 'TestController@createTest');
			Route::get('/projects/{project_id}/tests/{id}/batch/{batch_id}/launch', 'TestController@launchTest');
			Route::get('/projects/{project_id}/tests/{id}/batches', 'TestController@testBatches');
			Route::post('/projects/{project_id}/tests/{id}/update', 'TestController@updateTest');
			Route::post('/projects/{project_id}/tests/{id}/update-cases', 'TestController@updateTestCases');
			Route::post('/projects/{project_id}/tests/{id}/update-testers', 'TestController@updateTesters');
			Route::post('/projects/{project_id}/tests/{id}/update-schedule', 'TestController@updateSchedule');
			Route::get('/projects/{project_id}/tests/{id}/batch/{batch_id}/{result_type}-results', 'TestController@getResultsAggregated');
			Route::get('/projects/{project_id}/tests/{id}/results/{batch_id}', 'TestController@batchResults');
			Route::get('/projects/{project_id}/tests/{id}/results/get-{result_type}', 'TestController@getResultsAggregated');
			Route::get('/projects/{project_id}/tests/{id}/get-results', 'TestController@getResultsAggregated');
			Route::get('/projects/{project_id}/tests/{id}/batch/{batch_id}/activity/{activity_id}/step/{step_id}/new-issue', 'TestController@newIssue');
			Route::post('/projects/{project_id}/tests/{id}/batch/{batch_id}/activity/{activity_id}/step/{step_id}/create-issue', 'TestController@createIssue');
			Route::post('/projects/{project_id}/tests/{id}/batch/{batch_id}/activity/{activity_id}/step/{step_id}/{advance_type}-step', 'TestController@nextStep');

		// Suites

			Route::get('/projects/{project_id}/suites', 'SuiteController@index');
			Route::get('/projects/{project_id}/suites/new', 'SuiteController@newSuite');
			Route::post('/projects/{project_id}/suites/create', 'SuiteController@createSuite');
			Route::get('/projects/{project_id}/suites/{suite_id}/edit', 'SuiteController@editSuite');
			Route::post('/projects/{project_id}/suites/{suite_id}/update', 'SuiteController@updateSuite');
			Route::delete('/projects/{project_id}/suites/{suite_id}/delete', 'SuiteController@deleteSuite');
			Route::get('/projects/{project_id}/suites/{suite_id}/get', 'SuiteController@getSuite');
			Route::get('/projects/{project_id}/suites/{suite_id}/new-scenario', 'SuiteController@newScenario');
			Route::post('/projects/{project_id}/suites/{suite_id}/create-scenario', 'SuiteController@createScenario');
			Route::get('/projects/{project_id}/suites/{suite_id}/edit-scenario/{scenario_id}', 'SuiteController@editScenario');
			Route::get('/projects/{project_id}/suites/{suite_id}/scenario/{scenario_id}/get-files', 'SuiteController@getScenarioFiles');
			Route::delete('/projects/{project_id}/suites/{suite_id}/scenario/{scenario_id}/file/{file_id}/delete', 'SuiteController@deleteScenarioFile');
			Route::delete('/projects/{project_id}/suites/{suite_id}/delete-scenario/{scenario_id}', 'SuiteController@deleteScenario');
			Route::post('/projects/{project_id}/suites/{suite_id}/update-scenario/{scenario_id}', 'SuiteController@updateScenario');
			Route::post('/projects/{project_id}/suites/{suite_id}/scenario/{scenario_id}/upload-file', 'SuiteController@uploadScenarioFile');
			Route::get('/projects/{project_id}/suites/{suite_id}/get-scenarios', 'SuiteController@getScenarios');
			Route::get('/projects/{project_id}/suites/{suite_id}/get-scenario/{id}', 'SuiteController@getScenario');
			Route::get('/projects/{project_id}/suites/{suite_id}/get-cases/{scenario_id}', 'SuiteController@getCases');
			Route::get('/projects/{project_id}/suites/{suite_id}/get-case/{id}', 'SuiteController@getCase');
			Route::get('/projects/{project_id}/suites/{suite_id}/edit-case/{id}', 'SuiteController@editCase');
			Route::post('/projects/{project_id}/suites/{suite_id}/update-case/{id}', 'SuiteController@updateCase');
			Route::delete('/projects/{project_id}/suites/{suite_id}/scenario/{scenario_id}/delete-case/{id}', 'SuiteController@deleteCase');
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

		// Network

			Route::get('/network/people', 'NetworkController@people');

			// Lists

			Route::get( '/lists/{slug}/f:{format}', 'ListController@getList' );

		}

});
