<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Requirements;
use App\RequirementSections;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class RequirementController extends Controller
{

  public function __construct()
  {

  }

  public function index( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );

    if ( $r->input( 'format' ) == 'json' ) {

      $requirements = Requirements::where( 'project_id', $project->id )->get();

    	$groups = [];
      $singles = [];

      foreach ( $requirements as $req ) {

        if ( empty( $groups[$req->section_name] ) ) $groups[$req->section_name] = [];

        if ( !( $r->input( 'restrict-level' ) == '1' && $req->parent_requirement_id > 0 )
            || $r->input( 'restrict-level' ) != '1' || $req->parent_requirement_id < 1 ) {

          $groups[$req->section_name][] = $req;
          $singles[] = $req;

        }

      }

      $results = [];

      if ( $r->input( 'unsorted' ) == '1' ) {

        return response()->json( [ 'requirements' => $singles ] );

      } else {

        foreach ( $groups as $section_name => $requirements ) {

          if ( $requirements ) {

            $results[] = [ 'section_name' => $section_name, 'requirements' => $requirements ];

          }

        }

        return response()->json( [ 'requirements' => $results ] );

      }

    }

    return view( 'requirement.index', compact( 'project' ) );

  }

  public function new( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );
 
    return view( 'requirement.new', compact( 'project' ) );

  }

  public function create( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );

    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
 
    $summary = trim( $r->input( 'summary' ) );
    $children = trim( $r->input( 'children' ) );
    $section_name = $r->input( 'section_name' );
      if ( $section_name ):
        $section = RequirementSections::where( 'project_id', $project->id )->where( 'name', $section_name )->first();
        
        if ( !$section ):
          $section = RequirementSections::create( [ 'project_id' => $project->id, 'name' => $section_name ] );
        endif;
      else:
        $section = RequirementSections::where( 'project_id', $project->id )->first();
      endif;

      $section_id = $section->id;
      $section_name = $section->name;

    $parent_requirement_name = $r->input( 'parent_requirement_name' );
      if ( $parent_requirement_name ):
        $parent_requirement = Requirements::where( 'project_id', $project->id )->where( 'summary', $parent_requirement_name )->first();
        
        if ( !$parent_requirement ):
          $parent_requirement = Requirements::where( 'project_id', $project->id )->where( 'summary', 'like', "%$parent_requirement_name%" )->first();
        endif;
      else:
        $parent_requirement = null;
      endif;

      if ( $parent_requirement ) {
        $parent_requirement_id = $parent_requirement->id;
        $parent_requirement_name = $parent_requirement->summary;
      } else {
        $parent_requirement_id = 0;
        $parent_requirement_name = '';
      }

    $description = trim( $r->input( 'description' ) );
    
    $err = null;

    if ( !$summary ) {

      $err = [ 'errors' => ___( 'Please enter a summary.' ), 'target' => 'summary' ];

    } elseif ( strlen( $summary ) > MAX_STRING_LENGTH ) {

      $n = strlen( $summary ) - MAX_STRING_LENGTH;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Requirement summary is too long. Delete' ) . " $n " . $chars . ___( ' to make it 50 long' ) . '.', 'target' => 'summary' ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      $newrequirement = [ 
                    'project_id'    => $project->id,
                    'summary'       => $summary, 
                    'description'   => $description,
                    'section_id'    => $section_id,
                    'section_name'  => $section_name,
                    'parent_requirement_name'  => $parent_requirement_name,
                    'parent_requirement_id'  => $parent_requirement_id,
                    'user_id'       => get_user_id() ];

      $id = Requirements::create( $newrequirement )->id;
      $result = [ 'result_id' => $id ];

      if ( $parent_requirement_id ) Requirements::updateDependencies( $parent_requirement_id );

      if ( $children ) {

        $children = explode( "\n", $children );
      
        foreach ( $children as $requirement ) {

        if ( trim( $requirement ) ) {

          if ( strlen( $requirement ) > MAX_STRING_LENGTH ) {

            $requirement = shorten( $requirement, MAX_STRING_LENGTH );

          }

          $newrequirement = [ 
                      'project_id'    => $project->id,
                      'summary'       => $requirement, 
                      'description'   => '',
                      'section_id'    => $section_id,
                      'section_name'  => $section_name,
                      'parent_requirement_id' => $id,
                      'parent_requirement_name' => $summary,
                      'user_id'       => get_user_id() ];

          Requirements::create( $newrequirement );

        }

      }

    }

    }

    return response()->json( $result );

  }

  public function import( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );
 
    return view( 'requirement.import', compact( 'project' ) );

  }

  public function createBulk( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );

    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
 
    $requirements = trim( $r->input( 'requirements' ) );

    if ( !$requirements ) return response()->json( [ 'errors' => ___( "Please type or paste some requirements." ) ] );

    $requirements = explode( "\n", $requirements );
    $section_name = $r->input( 'section_name' );
      if ( $section_name ):
        $section = RequirementSections::where( 'project_id', $project->id )->where( 'name', $section_name )->first();
        
        if ( !$section ):
          $section = RequirementSections::create( [ 'project_id' => $project->id, 'name' => $section_name ] );
        endif;
      else:
        $section = RequirementSections::where( 'project_id', $project->id )->first();
      endif;

      $section_id = $section->id;
      $section_name = $section->name;

    $parent_requirement_name = $r->input( 'parent_requirement_name' );
      if ( $parent_requirement_name ):
        $parent_requirement = Requirements::where( 'project_id', $project->id )->where( 'summary', $parent_requirement_name )->first();
        
        if ( !$parent_requirement ):
          $parent_requirement = Requirements::where( 'project_id', $project->id )->where( 'summary', 'like', "%$parent_requirement_name%" )->first();
        endif;
      else:
        $parent_requirement = null;
      endif;

      if ( $parent_requirement ) {
        $parent_requirement_id = $parent_requirement->id;
        $parent_requirement_name = $parent_requirement->summary;
      } else {
        $parent_requirement_id = 0;
        $parent_requirement_name = '';
      }

    $saved = 0;
    
    foreach ( $requirements as $requirement ) {

			if ( trim( $requirement ) ) {

				if ( strlen( $requirement ) > MAX_STRING_LENGTH ) {

      		$requirement = shorten( $requirement, MAX_STRING_LENGTH );

      	}

      	$section_id = 0;

      	$newrequirement = [ 
                    'project_id'    => $project->id,
                    'summary'       => $requirement, 
                    'description'   => '',
                    'section_id'    => $section_id,
                    'section_name'  => $section_name,
                    'parent_requirement_id'    => $parent_requirement_id,
                    'parent_requirement_name'    => $parent_requirement_name,
                    'user_id'       => get_user_id() ];

	      $id = Requirements::create( $newrequirement )->id;
	      $saved++;

        if ( $parent_requirement_id ) Requirements::updateDependencies( $parent_requirement_id );

	    }

    }

    $result = [ 'success' => true, 'record_count' => $saved ];

    return response()->json( $result );

  }

  public function get( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );

    if ( !$project ) return response()->json( [ 'errors' => ___( 'Project not found.' ) ] );

    $requirement = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Requirements', 'redirect' => '' ] );
 
    if ( !$requirement ) return response()->json( [ 'errors' => ___( 'Project requirement not found.' ) ] );
    
    return response()->json( [ 'requirement' => $requirement ] );

  }

  public function edit( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );
    $requirement = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Requirements', 'redirect' => '/projects/' . $project->id . '/requirements' ] );
 
    return view( 'requirement.edit', compact( 'project', 'requirement' ) );

  }

  public function update( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $requirement = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Requirements', 'redirect' => '' ] );
    
    if ( !$requirement ) return response()->json( [ 'errors' => ___( "Project requirement not found." ) ] );
    
    $id = trim( $r->route( 'id' ) );
    $summary = trim( $r->input( 'summary' ) );
    $section_name = $r->input( 'section_name' );
    $children = $r->input( 'children' );

      if ( $section_name ):
        $section = RequirementSections::where( 'project_id', $project->id )->where( 'name', $section_name )->first();
        
        if ( !$section ):
          $section = RequirementSections::create( [ 'project_id' => $project->id, 'name' => $section_name ] );
        endif;
      else:
        $section = RequirementSections::where( 'project_id', $project->id )->first();
      endif;

      $section_id = $section->id;
      $section_name = $section->name;

    $parent_requirement_name = $r->input( 'parent_requirement_name' );
      if ( $parent_requirement_name ):
        $parent_requirement = Requirements::where( 'project_id', $project->id )->where( 'summary', $parent_requirement_name )->first();
        
        if ( !$parent_requirement ):
          $parent_requirement = Requirements::where( 'project_id', $project->id )->where( 'summary', 'like', "%$parent_requirement_name%" )->first();
        endif;
      else:
        $parent_requirement = null;
      endif;

      if ( $parent_requirement ) {
        $parent_requirement_id = $parent_requirement->id;
        $parent_requirement_name = $parent_requirement->summary;
      } else {
        $parent_requirement_id = 0;
        $parent_requirement_name = '';
      }

    $description = trim( $r->input( 'description' ) );
    
    $err = null;

    if ( !$summary ) {

      $err = [ 'errors' => ___( 'Please enter a summary.' ), 'target' => 'summary' ];

    } elseif ( strlen( $summary ) > MAX_STRING_LENGTH ) {

      $n = strlen( $summary ) - MAX_STRING_LENGTH;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Requirement summary is too long. Delete' ) . " $n " . $chars . ___( ' to make it 50 long' ) . '.', 'target' => 'summary' ];

    } elseif ( !empty( $description ) && strlen( $description ) > MAX_TEXT_LENGTH ) {

      $n = strlen( $notes ) - MAX_TEXT_LENGTH;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Description is too long. Delete' ) . " $n " . $chars . ___( ' to make it' ) . MAX_TEXT_LENGTH . ___( 'long' ) . '.', 'target' => 'title' ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      $changes = [ 
                    'summary'       => $summary, 
                    'description'   => $description,
                    'section_name'  => $section_name,
                    'section_id'    => $section_id,
                    'parent_requirement_name'  => $parent_requirement_name,
                    'parent_requirement_id'  => $parent_requirement_id,
                    'user_id'       => get_user_id() ];

      Requirements::find( $id )->update( $changes );

      if ( $parent_requirement_id != $requirement->parent_requirement_id ) {

        Requirements::updateDependencies( $requirement->parent_requirement_id );
        Requirements::updateDependencies( $parent_requirement_id );

      }

      // Update summary names where this is being used as a parent

      if ( $summary != $requirement->summary ) {

        Requirements::where( 'parent_requirement_id', $requirement->id )->update( [ 'parent_requirement_name' => $summary ] );

      }

      // Add bulk sub-requirements

      if ( $children ) {
      
        $children = explode( "\n", $children );
        
        foreach ( $children as $requirement ) {

          if ( trim( $requirement ) ) {

            if ( strlen( $requirement ) > MAX_STRING_LENGTH ) {

              $requirement = shorten( $requirement, MAX_STRING_LENGTH );

            }

            $newrequirement = [ 
                        'project_id'    => $project->id,
                        'summary'       => $requirement, 
                        'description'   => '',
                        'section_id'    => $section_id,
                        'section_name'  => $section_name,
                        'parent_requirement_id' => $requirement->id,
                        'user_id'       => get_user_id() ];

            Requirements::create( $newrequirement );

          }

        }

      }

      $result = [ 'success' => true ];

    }

    return response()->json( $result );

  }

  public function copy( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $requirement = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Requirements', 'redirect' => '' ] );
    
    if ( !$requirement ) return response()->json( [ 'errors' => ___( "Project requirement not found." ) ] );
    
    $id = $rid = trim( $r->route( 'id' ) );

    unset( $requirement->id );

    $requirement->title .= ' - ' . ___( 'Copy');
    
		$newrequirement = [ 
                  'project_id'   	=> $project->id, 
                  'summary'       => $requirement->summary, 
                  'description'   => $requirement->description,
                  'section_id'    => intval( $requirement->section_id ),
                  'section_name'  => $requirement->section_name,
                  'user_id'       => get_user_id() ];

    $id = Requirements::create( $newrequirement )->id;

    Requirements::updateDependencies( $rid );

    $result = [ 'result_id' => $id ];

    return response()->json( $result );

  }

  public function delete( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $requirement = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Requirements', 'redirect' => '' ] );
    
    if ( !$requirement ) return response()->json( [ 'errors' => ___( "Project requirement not found." ) ] );
    
    $id = $requirement->id;
    $requirement->delete();
    Requirements::updateDependencies( $id );

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

  public function archive( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $requirement = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Requirements', 'redirect' => '' ] );
    
    if ( !$requirement ) return response()->json( [ 'errors' => ___( "Project requirement not found." ) ] );
    
    $requirement->status = 2;
    $requirement->save();

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

}
