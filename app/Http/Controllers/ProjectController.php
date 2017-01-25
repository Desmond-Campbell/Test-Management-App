<?php

namespace App\Http\Controllers;

use App\Projects;
use App\CaseSections;
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

      $err = [ 'errors' => ___( 'Please enter a title.' ), 'target' => 'title' ];

    } elseif ( strlen( $title ) > 50 ) {

      $n = strlen( $title ) - 50;
      $chars = $n != 1 ? ___( 'characters' ) : ___( 'character' );

      $err = [ 'errors' => ___( 'Project title is too long. Delete' ) . " $n " . $chars . ___( ' to make it 50 long' ) . '.', 'target' => 'title' ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      $p = Projects::create( [ 'title' => $title, 'user_id' => get_user_id() ] );
      $id = $p->id;

      $result = [ 'result_id' => $id ];

      $section_id = CaseSections::create( [ 'name' => 'Main', 'project_id' => $id ] )->id;

      $p->default_section_id = $section_id;
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

    $changes = [ 'title' => $title,
                'description' => $description,
                'type' => $type['id'] ];

    Projects::find( $id )->update( $changes );

  }

  public function getSections( Request $r ) {

    $id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( "Failed to load sections." ) ];

    $sections = CaseSections::where( 'project_id', $project->id )->get();

    return response()->json( [ 'sections' => $sections ] );

  }

  

}
