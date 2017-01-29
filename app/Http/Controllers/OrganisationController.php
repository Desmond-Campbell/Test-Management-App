<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Police;
use App\Projects;
use App\TeamMembers;
use App\Options;
use App\User;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{

  public function __construct()
  {

  }

  public function people( Request $r ) {

    $project_id = $r->input( 'project_id' );

    $project = Projects::find( $project_id );

    if ( $r->input( 'format') == 'json' ) {

      $members = TeamMembers::where( 'project_id', $project_id )->get();
      $members_filtered = [];

      foreach ( $members as $m ) {

        $members_filtered[] = $m->user_id; 

      }

      $people = User::all();
      $people_filtered = [];

      $filter_members = $r->input( 'filter_members' );
      $filter_option_name = "filter_organisation_members_" . get_user_id() . "_" . $project_id;

      if ( empty( $filter_members ) ) $filter_members = Options::get( $filter_option_name, '' );
      else Options::set( $filter_option_name, $filter_members );

      foreach ( $people as $person ) {
        
        $person->is_member = in_array( $person->id, $members_filtered );

        if ( !( $filter_members == '1' && $person->is_member ) || !$person->is_member || $filter_members != '1' ) {

          $people_filtered[] = $person;

        }

      }

      return response()->json( [ 'people' => $people_filtered, 'filter_members' => intval( $filter_members ) > 0 ] );

    } else {

      if ( !$project ) return redirect( '/organisation' );

    }

    return view( 'organisation.people' );

  }

}
