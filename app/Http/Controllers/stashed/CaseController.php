<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Cases;
use App\CaseSections;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class CaseController extends Controller
{

  public function __construct()
  {

  }

  public function index( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );

    if ( $r->input( 'format' ) == 'json' ) {

    	$cases = Cases::where( 'project_id', $project->id )->get();

    	return response()->json( [ 'cases' => $cases ] );

    }

    return view( 'case.index', compact( 'project' ) );

  }

  public function new( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );
 
    return view( 'case.new', compact( 'project' ) );

  }

  public function create( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );

    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
 
    $title = trim( $r->input( 'title' ) );
    $section_name = $r->input( 'section_name' );
      if ( $section_name ):
        $section = CaseSections::where( 'project_id', $project->id )->where( 'name', $section_name )->first();
        
        if ( !$section ):
          $section = CaseSections::create( [ 'project_id' => $project->id, 'name' => $section_name ] );
        endif;
      else:
        $section = CaseSections::where( 'project_id', $project->id )->first();
      endif;

      $section_id = $section->id;
      $section_name = $section->name;

    $instructions = trim( $r->input( 'instructions' ) );
    $notes = trim( $r->input( 'notes' ) );
    
    $err = null;

    if ( !$title ) {

      $err = [ 'errors' => ___( 'Please enter a title.' ), 'target' => 'title' ];

    } elseif ( strlen( $title ) > 50 ) {

      $n = strlen( $title ) - 50;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Case title is too long. Delete' ) . " $n " . $chars . ___( ' to make it 50 long' ) . '.', 'target' => 'title' ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      $newcase = [ 
                    'project_id'    => $project->id,
                    'title'         => $title, 
                    'instructions'  => $instructions,
                    'notes'         => $notes,
                    'section_id'    => $section_id,
                    'section_name'  => $section_name,
                    'user_id'       => get_user_id() ];

      $id = Cases::create( $newcase )->id;
      $result = [ 'result_id' => $id ];

    }

    return response()->json( $result );

  }

  public function import( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );
 
    return view( 'case.import', compact( 'project' ) );

  }

  public function createBulk( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );

    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
 
    $cases = trim( $r->input( 'cases' ) );

    if ( !$cases ) return response()->json( [ 'errors' => ___( "Please type or paste some test cases." ) ] );

    $cases = explode( "\n", $cases );

    $saved = 0;

    $section_name = $r->input( 'section_name' );
      if ( $section_name ):
        $section = CaseSections::where( 'project_id', $project->id )->where( 'name', $section_name )->first();
        
        if ( !$section ):
          $section = CaseSections::create( [ 'project_id' => $project->id, 'name' => $section_name ] );
        endif;
      else:
        $section = CaseSections::where( 'project_id', $project->id )->first();
      endif;

      $section_id = $section->id;
      $section_name = $section->name;
    
    foreach ( $cases as $case ) {

			if ( trim( $case ) ) {

				if ( strlen( $case ) > 50 ) {

      		$case = shorten( $case, 50 );

      	}

      	$section_id = 0;

      	$newcase = [ 
                    'project_id'    => $project->id,
                    'title'         => $case, 
                    'instructions'  => '',
                    'notes'         => '',
                    'section_id'    => $section_id,
                    'section_name'  => $section_name,
                    'user_id'       => get_user_id() ];

	      $id = Cases::create( $newcase )->id;
	      $saved++;

	    }

    }

    $result = [ 'success' => true, 'record_count' => $saved ];

    return response()->json( $result );

  }

  public function get( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );

    if ( !$project ) return response()->json( [ 'errors' => ___( 'Project not found.' ) ] );

    $case = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Cases', 'redirect' => '' ] );
 
    if ( !$case ) return response()->json( [ 'errors' => ___( 'Test case not found.' ) ] );
    
    return response()->json( [ 'case' => $case ] );

  }

  public function edit( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '/projects' ] );
    $case = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Cases', 'redirect' => '/projects/' . $project->id . '/cases' ] );
 
    return view( 'case.edit', compact( 'project', 'case' ) );

  }

  public function update( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $case = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Cases', 'redirect' => '' ] );
    
    if ( !$case ) return response()->json( [ 'errors' => ___( "Test case not found." ) ] );
    
    $id = trim( $r->route( 'id' ) );
    $title = trim( $r->input( 'title' ) );
    $section_name = $r->input( 'section_name' );

      if ( $section_name ):
        $section = CaseSections::where( 'project_id', $project->id )->where( 'name', $section_name )->first();
        
        if ( !$section ):
          $section = CaseSections::create( [ 'project_id' => $project->id, 'name' => $section_name ] );
        endif;
      else:
        $section = CaseSections::where( 'project_id', $project->id )->first();
      endif;

      $section_id = $section->id;
      $section_name = $section->name;

    $instructions = trim( $r->input( 'instructions' ) );
    $notes = trim( $r->input( 'notes' ) );
    
    $err = null;

    if ( !$title ) {

      $err = [ 'errors' => ___( 'Please enter a title.' ), 'target' => 'title' ];

    } elseif ( strlen( $title ) > 50 ) {

      $n = strlen( $title ) - 50;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Case title is too long. Delete' ) . " $n " . $chars . ___( ' to make it 50 long' ) . '.', 'target' => 'title' ];

    } elseif ( !empty( $notes ) && strlen( $notes ) > MAX_TEXT_LENGTH ) {

      $n = strlen( $notes ) - MAX_TEXT_LENGTH;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Notes is too long. Delete' ) . " $n " . $chars . ___( ' to make it' ) . MAX_TEXT_LENGTH . ___( 'long' ) . '.', 'target' => 'title' ];

    } elseif ( !empty( $instructions ) && strlen( $instructions ) > MAX_TEXT_LENGTH ) {

      $n = strlen( $instructions ) - MAX_TEXT_LENGTH;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Instructions is too long. Delete' ) . " $n " . $chars . ___( ' to make it' ) . MAX_TEXT_LENGTH . ___( 'long' ) . '.', 'target' => 'title' ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      $changes = [ 
                    'title'         => $title, 
                    'instructions'  => $instructions,
                    'notes'         => $notes,
                    'section_name'  => $section_name,
                    'section_id'    => $section_id,
                    'user_id'       => get_user_id() ];

      Cases::find( $id )->update( $changes );

      $result = [ 'success' => true ];

    }

    return response()->json( $result );

  }

  public function copy( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $case = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Cases', 'redirect' => '' ] );
    
    if ( !$case ) return response()->json( [ 'errors' => ___( "Test case not found." ) ] );
    
    $id = trim( $r->route( 'id' ) );

    unset( $case->id );

    $case->title .= ' - ' . ___( 'Copy');
    
		$newcase = [ 
                  'project_id'   	=> $project->id, 
                  'title'         => $case->title, 
                  'instructions'  => $case->instructions,
                  'notes'         => $case->notes,
                  'section_id'    => intval( $case->section_id ),
                  'section_name'  => $case->section_name,
                  'user_id'       => get_user_id() ];

    $id = Cases::create( $newcase )->id;

    $result = [ 'result_id' => $id ];

    return response()->json( $result );

  }

  public function delete( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $case = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Cases', 'redirect' => '' ] );
    
    if ( !$case ) return response()->json( [ 'errors' => ___( "Test case not found." ) ] );
    
    $case->delete();

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

  public function archive( Request $r ) {

    $project = findOrFail( [ 'id' => $r->route( 'project_id' ), 'class' => 'Projects', 'redirect' => '' ] );
    
    if ( !$project ) return response()->json( [ 'errors' => ___( "Project not found." ) ] );
    
    $case = findOrFail( [ 'id' => $r->route( 'id' ), 'class' => 'Cases', 'redirect' => '' ] );
    
    if ( !$case ) return response()->json( [ 'errors' => ___( "Test case not found." ) ] );
    
    $case->status = 2;
    $case->save();

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

}
