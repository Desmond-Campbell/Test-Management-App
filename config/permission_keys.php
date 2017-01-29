<?php

$keys = [];
$string = 'Section:Organisation

Category:Projects
	view_projects|View Projects|r|view project list|View list of projects.
	create_project|Create Project|w|create add new project|Create a new project.
	own_projects|Own Projects|w|own project|Own a new or existing project. The existing one must be transfered by original owner.

Category:members
	view_members|View Members|r|view list organisation members|View a list of members in the organisation.
	create_member|Add Member|w|add new create member organisation|Add a member to the organisation, by invitation.
	update_member|Update Member|w|update edit change member|Update member\'s access.
	remove_member|Remove Member|w|delete remove member|Remove member from organisation.

Section:Projects

Category:Projects
	access_project|Access Project|rw|view access project|General access to project, subject to additional permission requirements.
	update_project|Update Project|w|edit update change project details|Update project details, including title, description, type, etc.
	view_details|View Details|r|view project details information|View project details. If the user doesn\'t have permission to update, the page will be read-only.
	view_dashboard|View Dashboard|r|view project dashboard|View the project dashboard. Permissions to view activity feed and project information are separate. 
	view_activities|View Activities|r|view project dashboard activity activities feed|View activities in the dashboard feed originated by the team member.
	view_all_activities|View All Activities|r|view project dashboard activity activities feed|View activities in the dashboard feed originated by someone else.
	view_properties|View Project Properties|r|view dashboard properties project|View properties on project dashboard.

Category:Team
	view_project_team|View Team|r|view list team members|View a list of members in project team.
	assign_member|Assign Member|w|assign add team member|Assign a member to project team.
	unassign_member|Unassign Member|w|unassign remove delete team member|Unassign a member from project team.
';

$lines = preg_split( "/\n/siU", $string );

$section_name = $category_name = '';
// print_r( $lines ); die;

foreach ( $lines as $line ) {

	$meta = false;

	if ( substr( $line, 0, 7 ) == 'Section' ) {

		$section_name = strtolower( trim( str_replace( 'Section:', '', $line ) ) );

		if ( empty( $keys[$section_name] ) ) {

			$keys[$section_name] = [];

		}

		$meta = true;

	}

	if ( substr( $line, 0, 8 ) == 'Category' ) {

		$category_name = strtolower( trim( str_replace( 'Category:', '', $line ) ) );

		if ( empty( $keys[$section_name][$category_name] ) ) {

			$keys[$section_name][$category_name] = [];

		}

		$meta = true;

	}

	if ( trim( $line ) && !$meta ) {

		//$keys[$section_name][$category_name][] = trim( $line );

	}

	if ( $section_name && $category_name && trim( $line ) && !$meta ) {

		$key_data = explode( '|', trim( $line ) );
		$key_value = trim( $key_data[0] );
		$key_name = trim( $key_data[1] );

		$key_info = [];
		$key_info['key'] = $key_value;
		$key_info['name'] = $key_name;
		$key_info['access_type'] = $key_data[2];
		$key_info['keywords'] = $key_data[3];
		$key_info['description'] = $key_data[4];

		$keys[$section_name][$category_name][$key_value] = $key_info;

	}

}

return $keys;
