<?php

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
			$data = [];

			$data['options'] = '{
														"data":
														[
															{
																"id": 1,
																"option_key": "network_id",
																"option_value": "1",
																"created_at": "2017-02-11 07:23:43",
																"updated_at": "2017-02-11 07:23:43"
															},
															{
																"id": 2,
																"option_key": "network_name",
																"option_value": "Demo Network",
																"created_at": "2017-02-11 07:24:18",
																"updated_at": "2017-02-11 07:24:18"
															}
														]
													}';

			$data['users'] = '{
													"data":
													[
														{
															"id": 1,
															"name": "Vladimir Polochek",
															"email": "",
															"password": "",
															"sso_id": 1,
															"is_network_owner": 1,
															"permissions_include": "[\"network_owner\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														},
														{
															"id": 2,
															"name": "Dimitri Lebedeev",
															"email": "",
															"password": "",
															"sso_id": 2,
															"is_network_owner": 0,
															"permissions_include": "[\"view_people\",\"view_projects\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														},
														{
															"id": 3,
															"name": "Gladys Truman",
															"email": "",
															"password": "",
															"sso_id": 3,
															"is_network_owner": 0,
															"permissions_include": "[\"view_projects\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														},
														{
															"id": 4,
															"name": "Nasine Bulochev",
															"email": "",
															"password": "",
															"sso_id": 4,
															"is_network_owner": 0,
															"permissions_include": "[\"view_projects\",\"create_projects\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														},
														{
															"id": 5,
															"name": "Justin Denton",
															"email": "",
															"password": "",
															"sso_id": 5,
															"is_network_owner": 0,
															"permissions_include": "[\"view_people\",\"view_projects\",\"create_projects\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														}
													]
												}';

			$data['projects'] = '';

			$data['search'] = '';

			$data['team_members'] = '';

			$data['team_roles'] = '';

			$data['activities'] = '';

			$data['test_activities'] = '';
			
			$data['test_batches'] = '';
			
			$data['test_cases'] = '';
			
			$data['test_issues'] = '';
			
			$data['test_scenarios'] = '';
			
			$data['test_steps'] = '';
			
			$data['test_suites'] = '';

			foreach ( $data as $table => $records ) {

				DB::table( $table )->truncate();

				print "\nTrying to seed $table.";

				$records = ( (array) json_decode( $records ) )['data'];

				foreach ( $records as $r ) {

					DB::table( $table )->insert( (array) $r );

				}

			}
    
    }

}
