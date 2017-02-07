<?php

namespace App\Http\Controllers;

use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{

  public function __construct()
  {

  }

  public function people( Request $r ) {

    $police_args = [ 'keystring' => 'network.people.view_people' ];

    if ( $r->input( 'format' ) == 'json' ) {

      $police_args['return'] = true;

    } else {

      $police_args['redirect'] = '/network';

    }

    //Police::check( $police_args );

    if ( $r->input( 'format') == 'json' ) {

      $members = TeamMembers::where( 'project_id', $project_id )->get();
      $members_filtered = [];

      foreach ( $members as $m ) {

        $members_filtered[] = $m->user_id; 

      }

      $people = User::all();
      $people_filtered = [];

      $filter_members = $r->input( 'filter_members' );
      $filter_option_name = "filter_network_members_" . get_user_id() . "_" . $project_id;

      if ( empty( $filter_members ) ) $filter_members = Options::get( $filter_option_name, '' );
      else Options::set( $filter_option_name, $filter_members );

      foreach ( $people as $person ) {
        
        $person->is_member = in_array( $person->id, $members_filtered );

        if ( !( $filter_members == '1' && $person->is_member ) || !$person->is_member || $filter_members != '1' ) {

          $people_filtered[] = $person;

        }

      }

      return response()->json( [ 'people' => $people_filtered, 'filter_members' => intval( $filter_members ) > 0 ] );

    }

    return view( 'network.people' );

  }

}
