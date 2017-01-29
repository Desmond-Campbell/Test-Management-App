<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Police;
use App\Projects;
use App\CaseSections;
use App\RequirementSections;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

  public function __construct()
  {

  }

  public function index( Request $r ) {

    if ( $r->input( 'format') == 'json' ) {

      $projects = Projects::all();

      return response()->json( [ 'projects' => $projects ] );

    }

    return view( 'project.index' );

  }

  public function new() {

    return view( 'project.new' );

  }

  public function create( Request $r ) {

    $title = trim( $r->input( 'title' ) );
    $err = null;

    if ( !$title ) {

      $err = [ 'errors' => ___( 'Please enter a title for your project.' ), 'target' => 'title' ];

    } elseif ( strlen( $title ) > 50 ) {

      $n = strlen( $title ) - 50;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Project title is too long. Delete' ) . " $n " . $chars . ___( ' to make it 50 long' ) . '.', 'target' => 'title' ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      $user_id = get_user_id();

      $is_owner = \App\Police::check( 'team.projects.own_projects' );

      if ( $is_owner ) $owner_id = $user_id;
      else $owner_id = User::getPrincipalId();

      $newproject = [ 
                      'title' => $title, 
                      'user_id' => $user_id, 
                      'owner_id' => $owner_id 
                    ];

      $p = Projects::create( $newproject );
      $id = $p->id;

      // Create owner role for this project.

      $newrole = [ 
                  'name'          => ___( 'Owner' ), 
                  'role_type'     => 1,
                  'project_id'    => $id,
                  'permissions_include' => json_encode( [ 'all_project_permissions' ] ),
                  'description'   => ___( 'Owner has all rights on this project.' )
                  ];

      \App\TeamRoles::create( $newrole );

      if ( !$is_owner ) {

        // DOC-ToDo: Check if there's a default role defined for new projects. If not, create the Administrator role.

          $newrole = [ 
                    'name'          => ___( 'Administrator' ), 
                    'role_type'     => 2,
                    'project_id'    => $id,
                    'permissions_include' => json_encode( [ 'all_project_admin_permissions' ] ), 
                    'description'   => ___( 'Administrator can do most things with a project, but not all.' )
                    ];

          \App\TeamRoles::create( $newrole );

      }

      // Create team member for this project, adding an owner and a team member

        $newteammember = [
                          'project_id'   => $id,
                          'user_id'   => $user_id,
                          'user_type' => $is_owner ? 1 : 2
                        ];

        \App\TeamMembers::create( $newteammember );

      // Create activity feed

        $filter_hash = sha1( "create_project." . date( 'Y-m-d' ) );
        $activity_values = [];
        $activity_values['title'] = $title;

        $newactivity = [
                          'project_id'    => $id,
                          'object_type'   => 'create_project',
                          'object_id'     => $id,
                          'user_id'       => $user_id,
                          'values'        => json_encode( $activity_values ),
                          'filter_hash'   => $filter_hash
                        ];

      Activities::create( $newactivity );

      $result = [ 'result_id' => $id, 'url' => '/projects/' . $id ];

      $section_id = CaseSections::create( [ 'name' => 'Main', 'project_id' => $id ] )->id;
      $requirement_section_id = RequirementSections::create( [ 'name' => 'Main', 'project_id' => $id ] )->id;

      $p->default_section_id = $section_id;
      $p->default_requirement_section_id = $requirement_section_id;
      $p->save();

    }

    return response()->json( $result );

  }

  public function dashboard( Request $r ) {

    $id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return redirect( '/projects' );

    return view( 'project.dashboard', compact( 'project' ) );

  }

  public function details( Request $r ) {

    $id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return redirect( '/projects' );

    if ( $r->input( 'format' ) == 'json' ) return response()->json( [ 'project' => $project ] );

    return view( 'project.details', compact( 'project' ) );

  }

  public function detailsUpdate( Request $r ) {

    $id = $r->route( 'id' );
    $title = $r->input( 'title' );
    $description = $r->input( 'description' );
    $type = $r->input( 'type' );
    $colour = $r->input( 'colour' );

    $changes = [ 'title' => $title,
                'description' => $description,
                'type' => $type,
                'colour' => validate_html_color( $colour ),
                 ];

    $project = Projects::find( $id );

    $user_id = get_user_id();

    $filter_hash = sha1( "update_project.$title." . date( 'Y-m-d' ) );
    $activity_values = [ 'old' => [], 'new' => [] ];
    $activity_values['old']['title'] = $project->title;
    $activity_values['old']['description'] = $project->description;
    $activity_values['old']['type'] = $project->type;
    $activity_values['old']['colour'] = $project->colour;
    $activity_values['new']['title'] = $title;
    $activity_values['new']['description'] = $description;
    $activity_values['new']['type'] = $type;
    $activity_values['new']['colour'] = $colour;

    $newactivity = [
                      'project_id'    => $id,
                      'object_type'   => 'update_project',
                      'object_id'     => $id,
                      'user_id'       => $user_id,
                      'values'        => Activities::prepareValues( $activity_values ),
                      'filter_hash'   => $filter_hash
                    ];

    Activities::create( $newactivity );

    $project->update( $changes );

    return response()->json( $project );

  }

  public function getActivities( Request $r ) {

    $id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( "Failed to load activities." ) ];

    $activitiesCollection = Activities::where( 'project_id', $project->id )->orderBy( 'id', 'desc' )->take(10)->get();

    $activities = [];

    foreach ( $activitiesCollection as $a ) {

      $content = Activities::getContent( $a );
      $activities[] = [ 'id'      => $a->id, 
                        'content' => $content,
                        'record'  => $a ];

    }

    return response()->json( [ 'activities' => $activities ] );

  }

  public function getSections( Request $r ) {

    $id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( "Failed to load sections." ) ];

    $sections = CaseSections::where( 'project_id', $project->id )->get();

    return response()->json( [ 'sections' => $sections ] );

  }

  public function getRequirementSections( Request $r ) {

    $id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( "Failed to load sections." ) ];

    $sections = RequirementSections::where( 'project_id', $project->id )->get();

    return response()->json( [ 'sections' => $sections ] );

  }

  

}
