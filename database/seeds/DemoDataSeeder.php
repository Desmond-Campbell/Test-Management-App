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

			$data['general_options'] = '{
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
															"name": "Vladimir Owner",
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
															"name": "Justin Admin",
															"email": "",
															"password": "",
															"sso_id": 2,
															"is_network_owner": 0,
															"permissions_include": "[\"view_people\",\"view_projects\",\"view_all_projects\",\"create_project\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														},
														{
															"id": 3,
															"name": "Dimitri Project",
															"email": "",
															"password": "",
															"sso_id": 3,
															"is_network_owner": 0,
															"permissions_include": "[\"view_projects\",\"create_project\",\"view_all_projects\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														},
														{
															"id": 4,
															"name": "Nadine Supervisor",
															"email": "",
															"password": "",
															"sso_id": 4,
															"is_network_owner": 0,
															"permissions_include": "[\"view_people\",\"view_projects\",\"create_project\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														},
														{
															"id": 5,
															"name": "Gladys Tester",
															"email": "",
															"password": "",
															"sso_id": 5,
															"is_network_owner": 0,
															"permissions_include": "[\"view_projects\"]",
															"permissions_exclude": null,
															"created_at": "2017-02-11 06:25:40",
															"updated_at": "2017-02-11 06:25:40"
														}
													]
												}';

			$data['projects'] = '{
														"data":
														[
															{
																"id": 1,
																"title": "Online Currency Converter",
																"description": "This is a sample project to test an online currency converter web application.",
																"type": "Web Application",
																"colour": "#bacb06",
																"owner_id": 1,
																"user_id": 1,
																"default_section_id": 0,
																"default_requirement_section_id": 0,
																"status": 0,
																"created_at": "2017-02-11 12:57:30",
																"updated_at": "2017-02-11 12:58:50"
															}
														]
													}';

			$data['search'] = '{
													"data":
													[
														{
															"id": 1,
															"hash": "7fbd7c8fd7dc146cffeeb00fd075b271fe6061c1",
															"project_id": 1,
															"object_id": 1,
															"object_name": "Test Currency Conversion",
															"object_type": "test_suites",
															"keywords": "Test Currency Conversion This test will cover the conversion process",
															"status": 1,
															"created_at": "2017-02-11 12:59:59",
															"updated_at": "2017-02-11 13:00:01"
														},
														{
															"id": 2,
															"hash": "61bc3ab3bd319e12f929f487c3a058db581ce2ae",
															"project_id": 1,
															"object_id": 1,
															"object_name": "The conversion should be accessible and load with default currency.",
															"object_type": "test_scenarios",
															"keywords": "The conversion should be accessible and load with default currency",
															"status": 1,
															"created_at": "2017-02-11 13:00:34",
															"updated_at": "2017-02-11 13:01:01"
														},
														{
															"id": 3,
															"hash": "35c4fe4efcd6a82cc3cac969bb4dfeb2cb38ba6c",
															"project_id": 1,
															"object_id": 2,
															"object_name": "The user should be able to convert currency back and forth.",
															"object_type": "test_scenarios",
															"keywords": "The user should be able to convert currency back and forth",
															"status": 1,
															"created_at": "2017-02-11 13:01:15",
															"updated_at": "2017-02-11 13:26:01"
														},
														{
															"id": 4,
															"hash": "12b89430d17c683ef9a9f9d277bfad9cbf06ea82",
															"project_id": 1,
															"object_id": 3,
															"object_name": "The user should be able to save their currency conversion results.",
															"object_type": "test_scenarios",
															"keywords": "The user should be able to save their currency conversion results",
															"status": 1,
															"created_at": "2017-02-11 13:01:27",
															"updated_at": "2017-02-11 13:02:01"
														},
														{
															"id": 5,
															"hash": "91567b15d3c34e401814099309134c2102e316d8",
															"project_id": 1,
															"object_id": 2,
															"object_name": "Test conversion history",
															"object_type": "test_suites",
															"keywords": "Test conversion history the storage and retrieval of past conversions",
															"status": 1,
															"created_at": "2017-02-11 13:01:57",
															"updated_at": "2017-02-11 13:02:01"
														},
														{
															"id": 6,
															"hash": "05b813dc8343c52c55fec66bd49b1aecd3372c3f",
															"project_id": 1,
															"object_id": 4,
															"object_name": "The user should be able to access a list of past conversions.",
															"object_type": "test_scenarios",
															"keywords": "The user should be able to access a list of past conversions",
															"status": 1,
															"created_at": "2017-02-11 13:02:18",
															"updated_at": "2017-02-11 13:03:02"
														},
														{
															"id": 7,
															"hash": "b061dce296a44c5619a97915e1f926c4e1a22116",
															"project_id": 1,
															"object_id": 5,
															"object_name": "When selected, a past conversion should load all the parameters stored.",
															"object_type": "test_scenarios",
															"keywords": "When selected a past conversion should load all the parameters stored",
															"status": 1,
															"created_at": "2017-02-11 13:02:34",
															"updated_at": "2017-02-11 13:03:02"
														},
														{
															"id": 8,
															"hash": "def2ca137e884a3d007a7ce385506fd2ba4cde7e",
															"project_id": 1,
															"object_id": 6,
															"object_name": "When accessed, the past conversion should automatically convert the last amount used.",
															"object_type": "test_scenarios",
															"keywords": "When accessed the past conversion should automatically convert last amount used",
															"status": 1,
															"created_at": "2017-02-11 13:02:52",
															"updated_at": "2017-02-11 13:03:02"
														},
														{
															"id": 9,
															"hash": "dd3c50d46a060686b5b8b557679c277cd714ccec",
															"project_id": 1,
															"object_id": 1,
															"object_name": "Check that the page loads correctly, given the right address",
															"object_type": "test_cases",
															"keywords": "Check that the page loads correctly given right address This test fails if 1 or more element/s is/are missing from page passes with all elements in place",
															"status": 1,
															"created_at": "2017-02-11 13:24:18",
															"updated_at": "2017-02-11 13:39:01"
														},
														{
															"id": 10,
															"hash": "9d523eb433d410c535087a3c286a375ca1c3e803",
															"project_id": 1,
															"object_id": 2,
															"object_name": "Check that the page loads with the default currency.",
															"object_type": "test_cases",
															"keywords": "Check that the page loads with default currency This test fails if currency in app doesn\'t match your locale passes selected by matches",
															"status": 1,
															"created_at": "2017-02-11 13:24:35",
															"updated_at": "2017-02-11 13:40:02"
														},
														{
															"id": 11,
															"hash": "e5bf2c3cd58f1d36b086a907261cab4c1b0ce7b7",
															"project_id": 1,
															"object_id": 3,
															"object_name": "Change locale and check that the page loads with the correct default currency.",
															"object_type": "test_cases",
															"keywords": "Change locale and check that the page loads with correct default currency This test fails if new currency from settings doesn\'t cause a change to selected in app passes is matched by",
															"status": 1,
															"created_at": "2017-02-11 13:25:07",
															"updated_at": "2017-02-11 13:44:01"
														},
														{
															"id": 12,
															"hash": "e7e06feb295808665814faeb8b7be5fe23151b56",
															"project_id": 1,
															"object_id": 4,
															"object_name": "Check that the app can convert an amount from one currency to another.",
															"object_type": "test_cases",
															"keywords": "Check that the app can convert an amount from one currency to another This test fails if you\'re not able process entire conversion of into passes you are another currency",
															"status": 1,
															"created_at": "2017-02-11 13:26:22",
															"updated_at": "2017-02-11 13:48:01"
														},
														{
															"id": 13,
															"hash": "6d8a163a6a5389317a8db4280254f4c7368d2e92",
															"project_id": 1,
															"object_id": 5,
															"object_name": "Check that the app can convert back to the original currency.",
															"object_type": "test_cases",
															"keywords": "Check that the app can convert back to original currency This test fails if when you switch around values calculation presents different values from originals passes amounts switched are equal used in other direction",
															"status": 1,
															"created_at": "2017-02-11 13:26:40",
															"updated_at": "2017-02-11 13:50:02"
														},
														{
															"id": 15,
															"hash": "8fa56e51b45d03af9a288f9dd3c1e10ae2afdad0",
															"project_id": 1,
															"object_id": 7,
															"object_name": "Check that the app saves the current currency selection parameters.",
															"object_type": "test_cases",
															"keywords": "Check that the app saves current currency selection parameters",
															"status": 1,
															"created_at": "2017-02-11 13:27:22",
															"updated_at": "2017-02-11 13:28:02"
														},
														{
															"id": 16,
															"hash": "3f33df964f8c1d5600783df2431cc1846a9a855a",
															"project_id": 1,
															"object_id": 7,
															"object_name": "The user should be able to retrieve their previously saved currency parameters.",
															"object_type": "test_scenarios",
															"keywords": "The user should be able to retrieve their previously saved currency parameters",
															"status": 1,
															"created_at": "2017-02-11 13:27:58",
															"updated_at": "2017-02-11 13:28:02"
														},
														{
															"id": 17,
															"hash": "b5efb92f2dab4b988464fe2569810e645d6468bf",
															"project_id": 1,
															"object_id": 8,
															"object_name": "Check that the user can retrieve the last used currency parameters.",
															"object_type": "test_cases",
															"keywords": "Check that the user can retrieve last used currency parameters",
															"status": 1,
															"created_at": "2017-02-11 13:28:13",
															"updated_at": "2017-02-11 13:29:01"
														},
														{
															"id": 18,
															"hash": "e78c8fc378013d8f945951c9823623176565e1c6",
															"project_id": 1,
															"object_id": 9,
															"object_name": "After converting a few currencies, does the app present with historical conversions?",
															"object_type": "test_cases",
															"keywords": "After converting a few currencies does the app present with historical conversions?",
															"status": 1,
															"created_at": "2017-02-11 13:31:25",
															"updated_at": "2017-02-11 13:32:01"
														},
														{
															"id": 19,
															"hash": "911f533cee04996cc8f444a657bcbceb9bbd61f5",
															"project_id": 1,
															"object_id": 8,
															"object_name": "The user should be able to clear history.",
															"object_type": "test_scenarios",
															"keywords": "The user should be able to clear history",
															"status": 1,
															"created_at": "2017-02-11 13:31:39",
															"updated_at": "2017-02-11 13:32:01"
														},
														{
															"id": 20,
															"hash": "f21ac024d4c57d795c34a52abc79bca2ace79fdc",
															"project_id": 1,
															"object_id": 10,
															"object_name": "Check accessibility to clear button.",
															"object_type": "test_cases",
															"keywords": "Check accessibility to clear button",
															"status": 1,
															"created_at": "2017-02-11 13:32:37",
															"updated_at": "2017-02-11 13:33:02"
														},
														{
															"id": 21,
															"hash": "49d2fa263663bfd14bafc0de080a8d998dc624c8",
															"project_id": 1,
															"object_id": 11,
															"object_name": "Check that invoking the clear function clears the history",
															"object_type": "test_cases",
															"keywords": "Check that invoking the clear function clears history",
															"status": 1,
															"created_at": "2017-02-11 13:32:49",
															"updated_at": "2017-02-11 13:33:02"
														},
														{
															"id": 22,
															"hash": "be0869f51830cd672df773a83effcb5d5aaa0096",
															"project_id": 1,
															"object_id": 12,
															"object_name": "Access entries from the conversion history and check that the converted values appear",
															"object_type": "test_cases",
															"keywords": "Access entries from the conversion history and check that converted values appear",
															"status": 1,
															"created_at": "2017-02-11 13:33:16",
															"updated_at": "2017-02-11 13:34:01"
														},
														{
															"id": 23,
															"hash": "94270c1e477c8fc707c552c44ece12ebf229b23a",
															"project_id": 1,
															"object_id": 13,
															"object_name": "Access an entry from the history and check that the parameters are loaded",
															"object_type": "test_cases",
															"keywords": "Access an entry from the history and check that parameters are loaded",
															"status": 1,
															"created_at": "2017-02-11 13:33:37",
															"updated_at": "2017-02-11 13:34:01"
														}
													]
												}';

			$data['team_members'] = '{
																"data":
																[
																	{
																		"id": 1,
																		"project_id": 1,
																		"user_id": 1,
																		"user_type": 1,
																		"roles": "[1]",
																		"key_overrides": null,
																		"key_restrictions": null,
																		"is_removed": 0,
																		"created_at": "2017-02-11 12:57:30",
																		"updated_at": "2017-02-11 12:57:30"
																	},
																	{
																		"id": 2,
																		"project_id": 1,
																		"user_id": 2,
																		"user_type": 3,
																		"roles": "[2]",
																		"key_overrides": null,
																		"key_restrictions": null,
																		"is_removed": 0,
																		"created_at": "2017-02-11 13:13:01",
																		"updated_at": "2017-02-11 13:22:18"
																	},
																	{
																		"id": 3,
																		"project_id": 1,
																		"user_id": 3,
																		"user_type": 3,
																		"roles": "[3]",
																		"key_overrides": null,
																		"key_restrictions": null,
																		"is_removed": 0,
																		"created_at": "2017-02-11 13:23:00",
																		"updated_at": "2017-02-11 13:23:13"
																	},
																	{
																		"id": 4,
																		"project_id": 1,
																		"user_id": 4,
																		"user_type": 3,
																		"roles": "[4]",
																		"key_overrides": null,
																		"key_restrictions": null,
																		"is_removed": 0,
																		"created_at": "2017-02-11 13:23:01",
																		"updated_at": "2017-02-11 13:23:27"
																	},
																	{
																		"id": 5,
																		"project_id": 1,
																		"user_id": 5,
																		"user_type": 3,
																		"roles": "[5]",
																		"key_overrides": null,
																		"key_restrictions": null,
																		"is_removed": 0,
																		"created_at": "2017-02-11 13:13:07",
																		"updated_at": "2017-02-11 13:22:31"
																	}
																]
															}';

			$data['team_roles'] = '{
															"data":
															[
																{
																	"id": 1,
																	"is_owner": 0,
																	"project_id": 1,
																	"role_type": 1,
																	"name": "Owner",
																	"description": "Owner by default has all rights on the project and what is connected to it.",
																	"permissions": "[\"exclusive_access\"]",
																	"created_at": "2017-02-11 12:57:30",
																	"updated_at": "2017-02-11 12:57:30"
																},
																{
																	"id": 2,
																	"is_owner": 0,
																	"project_id": 1,
																	"role_type": 0,
																	"name": "Administrator",
																	"description": "A role subordinate to owner, with most privileges.",
																	"permissions": "[\"view_members\",\"view_member_restrictions\",\"update_member_overrides\",\"view_member_overrides\",\"view_member_roles\",\"view_member\",\"view_role_permissions\",\"view_role\",\"update_role\",\"create_role\",\"view_roles\",\"view_deleted_members\",\"view_properties\",\"view_all_activities\",\"view_activities\",\"view_dashboard\",\"view_details\",\"update_project\",\"exclusive_access\",\"update_all_projects\",\"view_suites\",\"view_all_suites\",\"create_suite\",\"update_suites\",\"delete_suite\",\"delete_all_suites\",\"copy_suite\",\"copy_all_suites\",\"create_scenario\",\"update_scenarios\",\"delete_scenario\",\"delete_all_scenarios\",\"create_case\",\"update_cases\",\"delete_case\",\"delete_all_cases\",\"view_scenarios\",\"view_all_scenarios\",\"view_cases\",\"view_all_cases\",\"tester\",\"view_tests\",\"edit_test\",\"view_batches\",\"start_batch\",\"stop_batch\",\"create_test\",\"view_test_results\",\"create_issue\",\"edit_member\",\"update_member\"]",
																	"created_at": "2017-02-11 13:15:10",
																	"updated_at": "2017-02-11 13:17:27"
																},
																{
																	"id": 3,
																	"is_owner": 0,
																	"project_id": 1,
																	"role_type": 0,
																	"name": "Project Administrator",
																	"description": "This role is subordinate to administrator and can only manage projects.",
																	"permissions": "[\"view_properties\",\"view_all_activities\",\"view_activities\",\"view_dashboard\",\"view_details\",\"update_project\",\"exclusive_access\",\"update_all_projects\",\"view_suites\",\"view_all_suites\",\"create_suite\",\"update_suites\",\"delete_suite\",\"delete_all_suites\",\"copy_suite\",\"copy_all_suites\",\"create_scenario\",\"update_scenarios\",\"delete_scenario\",\"delete_all_scenarios\",\"create_case\",\"update_cases\",\"delete_case\",\"delete_all_cases\",\"view_scenarios\",\"view_all_scenarios\",\"view_cases\",\"view_all_cases\",\"tester\",\"view_tests\",\"edit_test\",\"view_batches\",\"start_batch\",\"stop_batch\",\"create_test\",\"view_test_results\",\"create_issue\",\"view_deleted_members\"]",
																	"created_at": "2017-02-11 13:18:07",
																	"updated_at": "2017-02-11 13:18:34"
																},
																{
																	"id": 4,
																	"is_owner": 0,
																	"project_id": 1,
																	"role_type": 0,
																	"name": "Project Manager",
																	"description": "This role allows a user to manage their own projects.",
																	"permissions": "[\"view_properties\",\"view_activities\",\"view_dashboard\",\"view_details\",\"update_project\",\"exclusive_access\",\"view_suites\",\"create_suite\",\"update_suites\",\"delete_suite\",\"copy_suite\",\"copy_all_suites\",\"create_scenario\",\"update_scenarios\",\"delete_scenario\",\"create_case\",\"update_cases\",\"delete_case\",\"view_scenarios\",\"view_cases\",\"tester\",\"view_tests\",\"edit_test\",\"view_batches\",\"start_batch\",\"stop_batch\",\"create_test\",\"view_test_results\",\"create_issue\",\"view_deleted_members\"]",
																	"created_at": "2017-02-11 13:19:51",
																	"updated_at": "2017-02-11 13:20:33"
																},
																{
																	"id": 5,
																	"is_owner": 0,
																	"project_id": 1,
																	"role_type": 0,
																	"name": "Tester",
																	"description": "This user can only test projects.",
																	"permissions": "[\"view_activities\",\"view_dashboard\",\"view_details\",\"tester\",\"view_tests\",\"view_test_results\",\"create_issue\"]",
																	"created_at": "2017-02-11 13:13:33",
																	"updated_at": "2017-02-11 13:14:30"
																}
															]
														}';

			$data['activities'] = '{
															"data":
															[
																{
																	"id": 1,
																	"project_id": 1,
																	"object_type": "create_project",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"title\":\"Sample Project\"}",
																	"filter_hash": "dfec15a8861ead31b37c842af4c117a638d1bce4",
																	"status": 0,
																	"created_at": "2017-02-11 12:57:30",
																	"updated_at": "2017-02-11 12:57:30"
																},
																{
																	"id": 2,
																	"project_id": 1,
																	"object_type": "update_project",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"title\":{\"old\":\"Sample Project\",\"new\":\"Online Currency Converter\"},\"description\":{\"old\":null,\"new\":\"This is a sample project to test an online currency converter web application.\"},\"type\":{\"old\":\"Other\",\"new\":\"Web Application\"},\"colour\":{\"old\":null,\"new\":\"#bacb06\"}}",
																	"filter_hash": "2c39e1dd38610a4b146a91f19f372050e06c3cc0",
																	"status": 0,
																	"created_at": "2017-02-11 12:58:50",
																	"updated_at": "2017-02-11 12:58:50"
																},
																{
																	"id": 3,
																	"project_id": 1,
																	"object_type": "create_suite",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"name\":\"Test Currency Conversion\"}",
																	"filter_hash": "17df6930503646b01ae242d6330af2d57a01ae77",
																	"status": 0,
																	"created_at": "2017-02-11 12:59:59",
																	"updated_at": "2017-02-11 12:59:59"
																},
																{
																	"id": 4,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"name\":\"The conversion should be accessible and load with default currency.\",\"suite_id\":\"1\"}",
																	"filter_hash": "5f193a95060d563844eb8ee79608c97bab3ffd47",
																	"status": 0,
																	"created_at": "2017-02-11 13:00:34",
																	"updated_at": "2017-02-11 13:00:34"
																},
																{
																	"id": 5,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"name\":\"The user should be able to covert currency back and forth.\",\"suite_id\":\"1\"}",
																	"filter_hash": "74ae9a30a7dca231d3e25a3f2d136aac002d52fe",
																	"status": 0,
																	"created_at": "2017-02-11 13:01:15",
																	"updated_at": "2017-02-11 13:01:15"
																},
																{
																	"id": 6,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"name\":\"The user should be able to save their currency conversion results.\",\"suite_id\":\"1\"}",
																	"filter_hash": "e29ef4917bb4737f3a045b57135f298ea290917d",
																	"status": 0,
																	"created_at": "2017-02-11 13:01:27",
																	"updated_at": "2017-02-11 13:01:27"
																},
																{
																	"id": 7,
																	"project_id": 1,
																	"object_type": "create_suite",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"name\":\"Test conversion history\"}",
																	"filter_hash": "af3637320db87a6a71d3148bf6ae88f1ab78f634",
																	"status": 0,
																	"created_at": "2017-02-11 13:01:57",
																	"updated_at": "2017-02-11 13:01:57"
																},
																{
																	"id": 8,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"name\":\"The user should be able to access a list of past conversions.\",\"suite_id\":\"2\"}",
																	"filter_hash": "2ae808b9f4395db4aee86691b6c2f2c07b9da39d",
																	"status": 0,
																	"created_at": "2017-02-11 13:02:18",
																	"updated_at": "2017-02-11 13:02:18"
																},
																{
																	"id": 9,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"name\":\"When selected, a past conversion should load all the parameters stored.\",\"suite_id\":\"2\"}",
																	"filter_hash": "b49b5fe9b835625d7eb410704f9d1f5f59b37532",
																	"status": 0,
																	"created_at": "2017-02-11 13:02:34",
																	"updated_at": "2017-02-11 13:02:34"
																},
																{
																	"id": 10,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 6,
																	"user_id": 1,
																	"values": "{\"name\":\"When accessed, the past conversion should automatically convert the last amount used.\",\"suite_id\":\"2\"}",
																	"filter_hash": "a86fba59ed3eabc9bcda5e330e8be5fa3cfab4ed",
																	"status": 0,
																	"created_at": "2017-02-11 13:02:52",
																	"updated_at": "2017-02-11 13:02:52"
																},
																{
																	"id": 11,
																	"project_id": 1,
																	"object_type": "add_team_member",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"user_id\":2,\"name\":\"Justin Admin\"}",
																	"filter_hash": "6ece21fc02f55f68471baf4809e640c5a66d4df5",
																	"status": 0,
																	"created_at": "2017-02-11 13:13:01",
																	"updated_at": "2017-02-11 13:13:01"
																},
																{
																	"id": 12,
																	"project_id": 1,
																	"object_type": "add_team_member",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"user_id\":5,\"name\":\"Gladys Tester\"}",
																	"filter_hash": "6ece21fc02f55f68471baf4809e640c5a66d4df5",
																	"status": 0,
																	"created_at": "2017-02-11 13:13:07",
																	"updated_at": "2017-02-11 13:13:07"
																},
																{
																	"id": 13,
																	"project_id": 1,
																	"object_type": "create_role",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"name\":\"Tester\"}",
																	"filter_hash": "5998a734103e51039dffa14048f5476f876ee5b4",
																	"status": 0,
																	"created_at": "2017-02-11 13:13:33",
																	"updated_at": "2017-02-11 13:13:33"
																},
																{
																	"id": 14,
																	"project_id": 1,
																	"object_type": "update_role",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"name\":\"Tester\"}",
																	"filter_hash": "d5aa8628642e9af76cf32ce0db46c40aa0d98733",
																	"status": 0,
																	"created_at": "2017-02-11 13:14:30",
																	"updated_at": "2017-02-11 13:14:30"
																},
																{
																	"id": 15,
																	"project_id": 1,
																	"object_type": "create_role",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"name\":\"Project Managers\"}",
																	"filter_hash": "6abc9cd40adf84cfd34b5d0477e70aa84469929f",
																	"status": 0,
																	"created_at": "2017-02-11 13:15:10",
																	"updated_at": "2017-02-11 13:15:10"
																},
																{
																	"id": 16,
																	"project_id": 1,
																	"object_type": "update_role",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "[]",
																	"filter_hash": "fc5f74d1b6de6d0ef4773b7942e34a762672cd1c",
																	"status": 0,
																	"created_at": "2017-02-11 13:15:56",
																	"updated_at": "2017-02-11 13:15:56"
																},
																{
																	"id": 17,
																	"project_id": 1,
																	"object_type": "update_role",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"name\":\"Administrator\"}",
																	"filter_hash": "fc5f74d1b6de6d0ef4773b7942e34a762672cd1c",
																	"status": 0,
																	"created_at": "2017-02-11 13:17:27",
																	"updated_at": "2017-02-11 13:17:27"
																},
																{
																	"id": 18,
																	"project_id": 1,
																	"object_type": "create_role",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"name\":\"Project Administrator\"}",
																	"filter_hash": "3d8dd87ecdd36b9ab936aefc19bdf3406d044f3a",
																	"status": 0,
																	"created_at": "2017-02-11 13:18:07",
																	"updated_at": "2017-02-11 13:18:07"
																},
																{
																	"id": 19,
																	"project_id": 1,
																	"object_type": "update_role",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"name\":\"Project Administrator\"}",
																	"filter_hash": "7bb52dcd97ff8daa2a4ae1acd71cd3e216bd2373",
																	"status": 0,
																	"created_at": "2017-02-11 13:18:34",
																	"updated_at": "2017-02-11 13:18:34"
																},
																{
																	"id": 20,
																	"project_id": 1,
																	"object_type": "create_role",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"name\":\"Project Manager\"}",
																	"filter_hash": "f995881d8a6fe8602082e4aaeecd14f001b5def3",
																	"status": 0,
																	"created_at": "2017-02-11 13:19:51",
																	"updated_at": "2017-02-11 13:19:51"
																},
																{
																	"id": 21,
																	"project_id": 1,
																	"object_type": "update_role",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"name\":\"Project Manager\"}",
																	"filter_hash": "12cfccaaacaefd1064ab2665bca9856b3422ddab",
																	"status": 0,
																	"created_at": "2017-02-11 13:20:33",
																	"updated_at": "2017-02-11 13:20:33"
																},
																{
																	"id": 22,
																	"project_id": 1,
																	"object_type": "update_role",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"name\":\"Project Manager\"}",
																	"filter_hash": "12cfccaaacaefd1064ab2665bca9856b3422ddab",
																	"status": 0,
																	"created_at": "2017-02-11 13:21:34",
																	"updated_at": "2017-02-11 13:21:34"
																},
																{
																	"id": 23,
																	"project_id": 1,
																	"object_type": "update_member_roles",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"name\":\"Justin Admin\"}",
																	"filter_hash": "d56d5a635c72dcd49257818557a4d57b824ea003",
																	"status": 0,
																	"created_at": "2017-02-11 13:22:18",
																	"updated_at": "2017-02-11 13:22:18"
																},
																{
																	"id": 24,
																	"project_id": 1,
																	"object_type": "update_member_roles",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"name\":\"Gladys Tester\"}",
																	"filter_hash": "97b325d1f57e5c7032a1ad1f0ce83eac813dcb7c",
																	"status": 0,
																	"created_at": "2017-02-11 13:22:31",
																	"updated_at": "2017-02-11 13:22:31"
																},
																{
																	"id": 25,
																	"project_id": 1,
																	"object_type": "update_member_roles",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"name\":\"Gladys Tester\"}",
																	"filter_hash": "97b325d1f57e5c7032a1ad1f0ce83eac813dcb7c",
																	"status": 0,
																	"created_at": "2017-02-11 13:22:52",
																	"updated_at": "2017-02-11 13:22:52"
																},
																{
																	"id": 26,
																	"project_id": 1,
																	"object_type": "add_team_member",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"user_id\":3,\"name\":\"Dimitri Project\"}",
																	"filter_hash": "6ece21fc02f55f68471baf4809e640c5a66d4df5",
																	"status": 0,
																	"created_at": "2017-02-11 13:23:00",
																	"updated_at": "2017-02-11 13:23:00"
																},
																{
																	"id": 27,
																	"project_id": 1,
																	"object_type": "add_team_member",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"user_id\":4,\"name\":\"Nadine Supervisor\"}",
																	"filter_hash": "6ece21fc02f55f68471baf4809e640c5a66d4df5",
																	"status": 0,
																	"created_at": "2017-02-11 13:23:01",
																	"updated_at": "2017-02-11 13:23:01"
																},
																{
																	"id": 28,
																	"project_id": 1,
																	"object_type": "update_member_roles",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"name\":\"Dimitri Project\"}",
																	"filter_hash": "e19c4a6b795df26a818172c4bcacd6b27b276fdd",
																	"status": 0,
																	"created_at": "2017-02-11 13:23:13",
																	"updated_at": "2017-02-11 13:23:13"
																},
																{
																	"id": 29,
																	"project_id": 1,
																	"object_type": "update_member_roles",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"name\":\"Nadine Supervisor\"}",
																	"filter_hash": "186cbfc8b7ebdb7536d36c6c4f92a024600eff90",
																	"status": 0,
																	"created_at": "2017-02-11 13:23:27",
																	"updated_at": "2017-02-11 13:23:27"
																},
																{
																	"id": 30,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"name\":\"Check that the page loads correctly, given the right address.\"}",
																	"filter_hash": "158d4952346124b2290dd235bfd6a3b4e04facee",
																	"status": 0,
																	"created_at": "2017-02-11 13:24:18",
																	"updated_at": "2017-02-11 13:24:18"
																},
																{
																	"id": 31,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"name\":\"Check that the page loads with the default currency.\"}",
																	"filter_hash": "a4339a20a3de694ea63758a9facb1b98533238a9",
																	"status": 0,
																	"created_at": "2017-02-11 13:24:35",
																	"updated_at": "2017-02-11 13:24:35"
																},
																{
																	"id": 32,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"name\":\"Change locale and check that the page loads with the correct default currency.\",\"suite_id\":\"1\"}",
																	"filter_hash": "e741ebdc4990fcb70c98136d3511198844df71a9",
																	"status": 0,
																	"created_at": "2017-02-11 13:25:07",
																	"updated_at": "2017-02-11 13:25:07"
																},
																{
																	"id": 33,
																	"project_id": 1,
																	"object_type": "update_scenario",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"suite_id\":\"1\"}",
																	"filter_hash": "b964a7dde41125696afa3c96c0b60743c8128bfa",
																	"status": 0,
																	"created_at": "2017-02-11 13:25:22",
																	"updated_at": "2017-02-11 13:25:22"
																},
																{
																	"id": 34,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"name\":\"Check that the app can convert an amount from one currency to another.\",\"suite_id\":\"1\"}",
																	"filter_hash": "66b604935470829abab40b8cb9929970fdff9ea6",
																	"status": 0,
																	"created_at": "2017-02-11 13:26:22",
																	"updated_at": "2017-02-11 13:26:22"
																},
																{
																	"id": 35,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"name\":\"Check that the app can convert back to the original currency.\",\"suite_id\":\"1\"}",
																	"filter_hash": "6e715f2fbc5864d14cb066af3af630f36ebbfdea",
																	"status": 0,
																	"created_at": "2017-02-11 13:26:40",
																	"updated_at": "2017-02-11 13:26:40"
																},
																{
																	"id": 36,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 6,
																	"user_id": 1,
																	"values": "{\"name\":\"Does the conversion give the same result back and forth?\",\"suite_id\":\"1\"}",
																	"filter_hash": "b26828105f9a2c416fa7df0253ff60945d140a7f",
																	"status": 0,
																	"created_at": "2017-02-11 13:26:59",
																	"updated_at": "2017-02-11 13:26:59"
																},
																{
																	"id": 37,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 7,
																	"user_id": 1,
																	"values": "{\"name\":\"Check that the app saves the current currency selection parameters.\",\"suite_id\":\"1\"}",
																	"filter_hash": "1f3be40749834df547516724348cfcdee4adc09c",
																	"status": 0,
																	"created_at": "2017-02-11 13:27:22",
																	"updated_at": "2017-02-11 13:27:22"
																},
																{
																	"id": 38,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 7,
																	"user_id": 1,
																	"values": "{\"name\":\"The user should be able to retrieve their previously saved currency parameters.\",\"suite_id\":\"1\"}",
																	"filter_hash": "da0d18afb670bda9e07b50457cc1fc9fcd4bca43",
																	"status": 0,
																	"created_at": "2017-02-11 13:27:58",
																	"updated_at": "2017-02-11 13:27:58"
																},
																{
																	"id": 39,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 8,
																	"user_id": 1,
																	"values": "{\"name\":\"Check that the user can retrieve the last used currency parameters.\",\"suite_id\":\"1\"}",
																	"filter_hash": "f6bcf4c7830ebd16cd7e146d3ffc20edc1ca56a4",
																	"status": 0,
																	"created_at": "2017-02-11 13:28:13",
																	"updated_at": "2017-02-11 13:28:13"
																},
																{
																	"id": 40,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 9,
																	"user_id": 1,
																	"values": "{\"name\":\"After converting a few currencies, does the app present with historical conversions?\",\"suite_id\":\"2\"}",
																	"filter_hash": "4bb8e98593276aa34d76838ea31db0217d6e0f32",
																	"status": 0,
																	"created_at": "2017-02-11 13:31:25",
																	"updated_at": "2017-02-11 13:31:25"
																},
																{
																	"id": 41,
																	"project_id": 1,
																	"object_type": "create_scenario",
																	"object_id": 8,
																	"user_id": 1,
																	"values": "{\"name\":\"The user should be able to clear history.\",\"suite_id\":\"1\"}",
																	"filter_hash": "80b4f3385affcb11a8785739d9b0fdb3394272f9",
																	"status": 0,
																	"created_at": "2017-02-11 13:31:39",
																	"updated_at": "2017-02-11 13:31:39"
																},
																{
																	"id": 42,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 10,
																	"user_id": 1,
																	"values": "{\"name\":\"Check accessibility to clear button.\",\"suite_id\":\"2\"}",
																	"filter_hash": "da94470b2895c285fac1d258b2251644cdeb6b67",
																	"status": 0,
																	"created_at": "2017-02-11 13:32:37",
																	"updated_at": "2017-02-11 13:32:37"
																},
																{
																	"id": 43,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 11,
																	"user_id": 1,
																	"values": "{\"name\":\"Check that invoking the clear function clears the history\",\"suite_id\":\"2\"}",
																	"filter_hash": "416ea1ece553dc06ce2c8bcdc3e5fd5103223f4b",
																	"status": 0,
																	"created_at": "2017-02-11 13:32:49",
																	"updated_at": "2017-02-11 13:32:49"
																},
																{
																	"id": 44,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 12,
																	"user_id": 1,
																	"values": "{\"name\":\"Access entries from the conversion history and check that the converted values appear\",\"suite_id\":\"2\"}",
																	"filter_hash": "221bde6ce592abaf2c4f65f0d3ea7a5900eeb837",
																	"status": 0,
																	"created_at": "2017-02-11 13:33:16",
																	"updated_at": "2017-02-11 13:33:16"
																},
																{
																	"id": 45,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 13,
																	"user_id": 1,
																	"values": "{\"name\":\"Access an entry from the history and check that the parameters are loaded\",\"suite_id\":\"2\"}",
																	"filter_hash": "34bcffd46f96bd5c08b1b79ba00a04b4715fd93c",
																	"status": 0,
																	"created_at": "2017-02-11 13:33:37",
																	"updated_at": "2017-02-11 13:33:37"
																},
																{
																	"id": 46,
																	"project_id": 1,
																	"object_type": "update_case",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"suite_id\":\"1\"}",
																	"filter_hash": "d3727443c4a93b657ce9e2f479b4186cdde232a0",
																	"status": 0,
																	"created_at": "2017-02-11 13:36:29",
																	"updated_at": "2017-02-11 13:36:29"
																},
																{
																	"id": 47,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the page loads correctly, given the right address\"}",
																	"filter_hash": "193a927eecc99cfff393a5597ef47f5c7687c700",
																	"status": 0,
																	"created_at": "2017-02-11 13:37:42",
																	"updated_at": "2017-02-11 13:37:42"
																},
																{
																	"id": 48,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the page loads correctly, given the right address\"}",
																	"filter_hash": "193a927eecc99cfff393a5597ef47f5c7687c700",
																	"status": 0,
																	"created_at": "2017-02-11 13:37:54",
																	"updated_at": "2017-02-11 13:37:54"
																},
																{
																	"id": 49,
																	"project_id": 1,
																	"object_type": "update_case",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "[]",
																	"filter_hash": "d3727443c4a93b657ce9e2f479b4186cdde232a0",
																	"status": 0,
																	"created_at": "2017-02-11 13:38:29",
																	"updated_at": "2017-02-11 13:38:29"
																},
																{
																	"id": 50,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the page loads with the default currency.\"}",
																	"filter_hash": "e0fd4487d74fde230851b742998455e82e796d84",
																	"status": 0,
																	"created_at": "2017-02-11 13:39:10",
																	"updated_at": "2017-02-11 13:39:10"
																},
																{
																	"id": 51,
																	"project_id": 1,
																	"object_type": "update_case",
																	"object_id": 2,
																	"user_id": 1,
																	"values": "[]",
																	"filter_hash": "82a48f8b155c88f3a40517c47032e3a9004d47fb",
																	"status": 0,
																	"created_at": "2017-02-11 13:39:51",
																	"updated_at": "2017-02-11 13:39:51"
																},
																{
																	"id": 52,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Change locale and check that the page loads with the correct default currency.\"}",
																	"filter_hash": "aa8a4cc074aeab262e55d1e9cfe0ec79c95ba485",
																	"status": 0,
																	"created_at": "2017-02-11 13:42:52",
																	"updated_at": "2017-02-11 13:42:52"
																},
																{
																	"id": 53,
																	"project_id": 1,
																	"object_type": "update_case",
																	"object_id": 3,
																	"user_id": 1,
																	"values": "[]",
																	"filter_hash": "90a0e2d057fb433631f391ac57db91f03c7818e2",
																	"status": 0,
																	"created_at": "2017-02-11 13:43:43",
																	"updated_at": "2017-02-11 13:43:43"
																},
																{
																	"id": 54,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:44:54",
																	"updated_at": "2017-02-11 13:44:54"
																},
																{
																	"id": 55,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:44:54",
																	"updated_at": "2017-02-11 13:44:54"
																},
																{
																	"id": 56,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:44:55",
																	"updated_at": "2017-02-11 13:44:55"
																},
																{
																	"id": 57,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:45:04",
																	"updated_at": "2017-02-11 13:45:04"
																},
																{
																	"id": 58,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:45:11",
																	"updated_at": "2017-02-11 13:45:11"
																},
																{
																	"id": 59,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:46:05",
																	"updated_at": "2017-02-11 13:46:05"
																},
																{
																	"id": 60,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:46:22",
																	"updated_at": "2017-02-11 13:46:22"
																},
																{
																	"id": 61,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert an amount from one currency to another.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "abb37dfa5eaf25316c89783ed40bd225cdd0240d",
																	"status": 0,
																	"created_at": "2017-02-11 13:46:30",
																	"updated_at": "2017-02-11 13:46:30"
																},
																{
																	"id": 62,
																	"project_id": 1,
																	"object_type": "update_case",
																	"object_id": 4,
																	"user_id": 1,
																	"values": "{\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "34554859d61c73ae7a73ae57bc513010f77ee9a9",
																	"status": 0,
																	"created_at": "2017-02-11 13:47:17",
																	"updated_at": "2017-02-11 13:47:17"
																},
																{
																	"id": 63,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert back to the original currency.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "c5345c5882e4dae08148540288432f24e9ed86d3",
																	"status": 0,
																	"created_at": "2017-02-11 13:47:46",
																	"updated_at": "2017-02-11 13:47:46"
																},
																{
																	"id": 64,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert back to the original currency.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "c5345c5882e4dae08148540288432f24e9ed86d3",
																	"status": 0,
																	"created_at": "2017-02-11 13:47:46",
																	"updated_at": "2017-02-11 13:47:46"
																},
																{
																	"id": 65,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert back to the original currency.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "c5345c5882e4dae08148540288432f24e9ed86d3",
																	"status": 0,
																	"created_at": "2017-02-11 13:47:49",
																	"updated_at": "2017-02-11 13:47:49"
																},
																{
																	"id": 66,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert back to the original currency.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "c5345c5882e4dae08148540288432f24e9ed86d3",
																	"status": 0,
																	"created_at": "2017-02-11 13:48:05",
																	"updated_at": "2017-02-11 13:48:05"
																},
																{
																	"id": 67,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert back to the original currency.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "c5345c5882e4dae08148540288432f24e9ed86d3",
																	"status": 0,
																	"created_at": "2017-02-11 13:48:17",
																	"updated_at": "2017-02-11 13:48:17"
																},
																{
																	"id": 68,
																	"project_id": 1,
																	"object_type": "update_steps",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"case_name\":\"Check that the app can convert back to the original currency.\",\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "c5345c5882e4dae08148540288432f24e9ed86d3",
																	"status": 0,
																	"created_at": "2017-02-11 13:48:33",
																	"updated_at": "2017-02-11 13:48:33"
																},
																{
																	"id": 69,
																	"project_id": 1,
																	"object_type": "update_case",
																	"object_id": 5,
																	"user_id": 1,
																	"values": "{\"suite_id\":\"1\",\"scenario_id\":\"2\"}",
																	"filter_hash": "72dcbcd69e2f12bc7da8d7135a6a4f3315621a3c",
																	"status": 0,
																	"created_at": "2017-02-11 13:49:27",
																	"updated_at": "2017-02-11 13:49:27"
																},
																{
																	"id": 70,
																	"project_id": 1,
																	"object_type": "delete_case",
																	"object_id": 6,
																	"user_id": 1,
																	"values": "{\"name\":\"Does the conversion give the same result back and forth?\"}",
																	"filter_hash": "eaf80ede953ac08f74ac8727b117d657a7fe7c01",
																	"status": 0,
																	"created_at": "2017-02-11 13:57:59",
																	"updated_at": "2017-02-11 13:57:59"
																},
																{
																	"id": 71,
																	"project_id": 1,
																	"object_type": "create_test_case",
																	"object_id": 14,
																	"user_id": 1,
																	"values": "{\"name\":\"Sample\"}",
																	"filter_hash": "9fb1b567c75cc0b05d8325b8979bc8533ee98c4b",
																	"status": 0,
																	"created_at": "2017-02-11 13:59:31",
																	"updated_at": "2017-02-11 13:59:31"
																},
																{
																	"id": 72,
																	"project_id": 1,
																	"object_type": "delete_case",
																	"object_id": 14,
																	"user_id": 1,
																	"values": "{\"name\":\"Sample\"}",
																	"filter_hash": "eaf80ede953ac08f74ac8727b117d657a7fe7c01",
																	"status": 0,
																	"created_at": "2017-02-11 13:59:41",
																	"updated_at": "2017-02-11 13:59:41"
																},
																{
																	"id": 76,
																	"project_id": 1,
																	"object_type": "delete_case",
																	"object_id": 6,
																	"user_id": 1,
																	"values": "{\"name\":\"Does the conversion give the same result back and forth?\"}",
																	"filter_hash": "eaf80ede953ac08f74ac8727b117d657a7fe7c01",
																	"status": 0,
																	"created_at": "2017-02-11 14:02:34",
																	"updated_at": "2017-02-11 14:02:34"
																},
																{
																	"id": 77,
																	"project_id": 1,
																	"object_type": "create_test",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"name\":\"Sample Test Run\"}",
																	"filter_hash": "cc7ca3acacdadba71f20bf100a7397eb449495f2",
																	"status": 0,
																	"created_at": "2017-02-11 14:06:14",
																	"updated_at": "2017-02-11 14:06:14"
																},
																{
																	"id": 78,
																	"project_id": 1,
																	"object_type": "edit_test",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"name\":\"Sample Test Run\"}",
																	"filter_hash": "ee793512b53ac258baf820f5d1b2507141935ff4",
																	"status": 0,
																	"created_at": "2017-02-11 14:06:35",
																	"updated_at": "2017-02-11 14:06:35"
																},
																{
																	"id": 79,
																	"project_id": 1,
																	"object_type": "update_testers",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"name\":\"Sample Test Run\"}",
																	"filter_hash": "54150f333b915636c33668ba521d3c690978442a",
																	"status": 0,
																	"created_at": "2017-02-11 14:06:41",
																	"updated_at": "2017-02-11 14:06:41"
																},
																{
																	"id": 80,
																	"project_id": 1,
																	"object_type": "update_test_cases",
																	"object_id": 1,
																	"user_id": 1,
																	"values": "{\"name\":\"Sample Test Run\"}",
																	"filter_hash": "1eb26ea41b5a6b2bd00efb7a189ab048ff140814",
																	"status": 0,
																	"created_at": "2017-02-11 14:07:18",
																	"updated_at": "2017-02-11 14:07:18"
																}
															]
														}';

			// $data['test_activities'] = '';
			
			// $data['test_batches'] = '';
			
			$data['test_cases'] = '{
															"data":
															[
																{
																	"id": 1,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 1,
																	"name": "Check that the page loads correctly, given the right address",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the page loads with all elements in place.",
																	"fail_criteria": "This test fails if 1 or more element/s is/are missing from the page.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:24:18",
																	"updated_at": "2017-02-11 13:38:29"
																},
																{
																	"id": 2,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 1,
																	"name": "Check that the page loads with the default currency.",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the default currency selected by the app matches your locale currency.",
																	"fail_criteria": "This test fails if the default currency in the app doesn\'t match your locale currency.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:24:35",
																	"updated_at": "2017-02-11 13:39:51"
																},
																{
																	"id": 3,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 1,
																	"name": "Change locale and check that the page loads with the correct default currency.",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the locale currency change is matched by the new default currency in the app.",
																	"fail_criteria": "This test fails if the new currency from locale settings doesn\'t cause a change to the default currency selected in the app.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:25:07",
																	"updated_at": "2017-02-11 13:43:43"
																},
																{
																	"id": 4,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"name": "Check that the app can convert an amount from one currency to another.",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if you are able to convert one currency amount into another currency.",
																	"fail_criteria": "This test fails if you\'re not able to process the entire conversion of one currency amount into another.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:26:22",
																	"updated_at": "2017-02-11 13:47:17"
																},
																{
																	"id": 5,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"name": "Check that the app can convert back to the original currency.",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the amounts switched are equal to the original amounts used in the other direction.",
																	"fail_criteria": "This test fails if when you switch around the values, the calculation presents different values from the originals.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:26:40",
																	"updated_at": "2017-02-11 13:49:27"
																},
																{
																	"id": 7,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 3,
																	"name": "Check that the app saves the current currency selection parameters.",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the use is able to save the parameters.",
																	"fail_criteria": "This test fails if the user cannot save the currency parameters.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:27:22",
																	"updated_at": "2017-02-11 13:27:22"
																},
																{
																	"id": 8,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 7,
																	"name": "Check that the user can retrieve the last used currency parameters.",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the user is able to retrieve previously stored conversion parameters.",
																	"fail_criteria": "This test fails if the user is able not to retrieve previously stored conversion parameters.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:28:13",
																	"updated_at": "2017-02-11 13:28:13"
																},
																{
																	"id": 9,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 4,
																	"name": "After converting a few currencies, does the app present with historical conversions?",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if previously used converion data is restored.",
																	"fail_criteria": "This test passes if previously used converion data is not restored.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:31:25",
																	"updated_at": "2017-02-11 13:31:25"
																},
																{
																	"id": 10,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 8,
																	"name": "Check accessibility to clear button.",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the user can access the clear button.",
																	"fail_criteria": "This test fails if the user cannot access the clear button.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:32:37",
																	"updated_at": "2017-02-11 13:32:37"
																},
																{
																	"id": 11,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 8,
																	"name": "Check that invoking the clear function clears the history",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the user can verify that on clicking the clear button, the history is actually cleared.",
																	"fail_criteria": "This test fails if on clicking the clear button, the history is not cleared.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:32:49",
																	"updated_at": "2017-02-11 13:32:49"
																},
																{
																	"id": 12,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 6,
																	"name": "Access entries from the conversion history and check that the converted values appear",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the user can access values from the conversion history.",
																	"fail_criteria": "This test fails if the user cannot access entries of the conversion history.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:33:16",
																	"updated_at": "2017-02-11 13:33:16"
																},
																{
																	"id": 13,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 5,
																	"name": "Access an entry from the history and check that the parameters are loaded",
																	"instructions": null,
																	"description": null,
																	"pass_criteria": "This test passes if the user can access values from the conversion history and see the parameters loaded by default.",
																	"fail_criteria": "This test passes if the user can\'t access default parameters from entries in the conversion history.",
																	"item_position": 0,
																	"user_id": 1,
																	"status": 1,
																	"created_at": "2017-02-11 13:33:37",
																	"updated_at": "2017-02-11 13:33:37"
																}
															]
														}';
			
			//$data['test_issues'] = '';
			
			$data['test_scenarios'] = '{
																	"data":
																	[
																		{
																			"id": 1,
																			"project_id": 1,
																			"suite_id": 1,
																			"name": "The conversion should be accessible and load with default currency.",
																			"description": null,
																			"files": "",
																			"children": 3,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:00:34",
																			"updated_at": "2017-02-11 13:25:07"
																		},
																		{
																			"id": 2,
																			"project_id": 1,
																			"suite_id": 1,
																			"name": "The user should be able to convert currency back and forth.",
																			"description": null,
																			"files": "",
																			"children": 2,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:01:15",
																			"updated_at": "2017-02-11 14:02:34"
																		},
																		{
																			"id": 3,
																			"project_id": 1,
																			"suite_id": 1,
																			"name": "The user should be able to save their currency conversion results.",
																			"description": null,
																			"files": "",
																			"children": 1,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:01:27",
																			"updated_at": "2017-02-11 13:27:22"
																		},
																		{
																			"id": 4,
																			"project_id": 1,
																			"suite_id": 2,
																			"name": "The user should be able to access a list of past conversions.",
																			"description": null,
																			"files": "",
																			"children": 1,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:02:18",
																			"updated_at": "2017-02-11 13:31:25"
																		},
																		{
																			"id": 5,
																			"project_id": 1,
																			"suite_id": 2,
																			"name": "When selected, a past conversion should load all the parameters stored.",
																			"description": null,
																			"files": "",
																			"children": 1,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:02:34",
																			"updated_at": "2017-02-11 13:33:37"
																		},
																		{
																			"id": 6,
																			"project_id": 1,
																			"suite_id": 2,
																			"name": "When accessed, the past conversion should automatically convert the last amount used.",
																			"description": null,
																			"files": "",
																			"children": 1,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:02:52",
																			"updated_at": "2017-02-11 13:33:16"
																		},
																		{
																			"id": 7,
																			"project_id": 1,
																			"suite_id": 1,
																			"name": "The user should be able to retrieve their previously saved currency parameters.",
																			"description": null,
																			"files": "",
																			"children": 1,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:27:58",
																			"updated_at": "2017-02-11 13:28:13"
																		},
																		{
																			"id": 8,
																			"project_id": 1,
																			"suite_id": 2,
																			"name": "The user should be able to clear history.",
																			"description": null,
																			"files": "",
																			"children": 2,
																			"user_id": 1,
																			"created_at": "2017-02-11 13:31:39",
																			"updated_at": "2017-02-11 13:32:49"
																		}
																	]
																}';
			
			$data['test_steps'] = '{
															"data":
															[
																{
																	"id": 1,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 1,
																	"case_id": 1,
																	"name": "Navigate to the provided address to the page.",
																	"item_position": 0,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:24:18",
																	"updated_at": "2017-02-11 13:37:54"
																},
																{
																	"id": 2,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 1,
																	"case_id": 2,
																	"name": "Check that the page loads with your locale default currency.",
																	"item_position": 0,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:24:35",
																	"updated_at": "2017-02-11 13:39:10"
																},
																{
																	"id": 3,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 1,
																	"case_id": 3,
																	"name": "Select a different locale currency on your device and reload the app. Check if the default currency changes.",
																	"item_position": 0,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:25:07",
																	"updated_at": "2017-02-11 13:42:52"
																},
																{
																	"id": 4,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 4,
																	"name": "Select a source currency from the first dropdown.",
																	"item_position": 0,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:26:22",
																	"updated_at": "2017-02-11 13:46:30"
																},
																{
																	"id": 5,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 5,
																	"name": "Continuing from previous case, switch the source and target amounts.",
																	"item_position": 0,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:26:40",
																	"updated_at": "2017-02-11 13:48:33"
																},
																{
																	"id": 6,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 6,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:26:59",
																	"updated_at": "2017-02-11 13:26:59"
																},
																{
																	"id": 7,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 3,
																	"case_id": 7,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:27:22",
																	"updated_at": "2017-02-11 13:27:22"
																},
																{
																	"id": 8,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 7,
																	"case_id": 8,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:28:13",
																	"updated_at": "2017-02-11 13:28:13"
																},
																{
																	"id": 9,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 4,
																	"case_id": 9,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:31:25",
																	"updated_at": "2017-02-11 13:31:25"
																},
																{
																	"id": 10,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 8,
																	"case_id": 10,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:32:37",
																	"updated_at": "2017-02-11 13:32:37"
																},
																{
																	"id": 11,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 8,
																	"case_id": 11,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:32:49",
																	"updated_at": "2017-02-11 13:32:49"
																},
																{
																	"id": 12,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 6,
																	"case_id": 12,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:33:16",
																	"updated_at": "2017-02-11 13:33:16"
																},
																{
																	"id": 13,
																	"project_id": 1,
																	"suite_id": 2,
																	"scenario_id": 5,
																	"case_id": 13,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:33:37",
																	"updated_at": "2017-02-11 13:33:37"
																},
																{
																	"id": 14,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 4,
																	"name": "Select a target currency from the second dropdown.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:45:04",
																	"updated_at": "2017-02-11 13:46:30"
																},
																{
																	"id": 15,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 4,
																	"name": "Enter a numeric value in the amount field",
																	"item_position": 2,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:46:05",
																	"updated_at": "2017-02-11 13:46:30"
																},
																{
																	"id": 16,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 4,
																	"name": "Click the convert button",
																	"item_position": 3,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:46:22",
																	"updated_at": "2017-02-11 13:46:30"
																},
																{
																	"id": 17,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 4,
																	"name": "Check the amount converted that it is correct.",
																	"item_position": 4,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:46:30",
																	"updated_at": "2017-02-11 13:46:30"
																},
																{
																	"id": 18,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 5,
																	"name": "Switch the amounts used in the previous case.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:48:05",
																	"updated_at": "2017-02-11 13:48:33"
																},
																{
																	"id": 19,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 5,
																	"name": "Click the convert button to calculate the new amount.",
																	"item_position": 2,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:48:17",
																	"updated_at": "2017-02-11 13:48:33"
																},
																{
																	"id": 20,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 5,
																	"name": "Check that the new amount corresponds with the original amounts that you have switched.",
																	"item_position": 3,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:48:33",
																	"updated_at": "2017-02-11 13:48:33"
																},
																{
																	"id": 21,
																	"project_id": 1,
																	"suite_id": 1,
																	"scenario_id": 2,
																	"case_id": 14,
																	"name": "There must be at least 1 step on a test case. This is a default that you can edit or remove.",
																	"item_position": 1,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:59:31",
																	"updated_at": "2017-02-11 13:59:31"
																}
															]
														}';
			
			$data['test_suites'] = '{
															"data":
															[
																{
																	"id": 1,
																	"project_id": 1,
																	"name": "Test Currency Conversion",
																	"description": "This test will cover the conversion process.",
																	"children": 4,
																	"grand_children": 7,
																	"user_id": 1,
																	"created_at": "2017-02-11 12:59:59",
																	"updated_at": "2017-02-11 14:02:34"
																},
																{
																	"id": 2,
																	"project_id": 1,
																	"name": "Test conversion history",
																	"description": "Test the storage and retrieval of past conversions",
																	"children": 4,
																	"grand_children": 5,
																	"user_id": 1,
																	"created_at": "2017-02-11 13:01:57",
																	"updated_at": "2017-02-11 13:33:37"
																}
															]
														}';
			
			$data['tests'] = '{
																"data":
																[
																	{
																		"id": 1,
																		"project_id": 1,
																		"name": "Sample Test Run",
																		"description": "This is a sample test run with all the test cases. You can create more.",
																		"suites": "[1,2]",
																		"scenarios": "[1,2,3,7,4,5,6,8]",
																		"cases": "[1,2,3,4,5,7,8,9,13,12,10,11]",
																		"testers": "[5]",
																		"status": 1,
																		"user_id": 1,
																		"created_at": "2017-02-11 14:06:14",
																		"updated_at": "2017-02-11 14:07:18"
																	}
																]
															}';

			foreach ( $data as $table => $records ) {

				DB::table( $table )->truncate();

				print "\nTrying to seed $table.\n";

				$records = ( (array) json_decode( $records ) )['data'];

				foreach ( $records as $r ) {

					DB::table( $table )->insert( (array) $r );

				}

			}
    
    }

}
