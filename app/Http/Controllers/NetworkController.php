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

class NetworkController extends Controller
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

    Police::check( $police_args );

    $project_id = $r->input( 'project_id' );

    $project = Projects::find( $project_id );

    if ( $r->input( 'format') == 'json' ) {

      $members = TeamMembers::where( 'project_id', $project_id )->get();
      $members_filtered = $members_list = [];

      foreach ( $members as $m ) {

        $members_filtered[] = $m->user_id;
        $members_list[$m->user_id] = $m;

      }

      $people = User::all();
      $people_filtered = [];

      $filter_members = $r->input( 'filter_members' );
      $filter_option_name = "filter_network_members_" . get_user_id() . "_" . $project_id;

      if ( empty( $filter_members ) ) $filter_members = Options::get( $filter_option_name, '' );
      else Options::set( $filter_option_name, $filter_members );

      foreach ( $people as $person ) {
        
        $teammember = null;
        if ( !empty( $members_list[$person->id] ) ) $teammember = $members_list[$person->id];
        
        $person->is_member = in_array( $person->id, $members_filtered );
        $person->removed = false;

        if ( $teammember ) {

          if ( $teammember->is_removed ) {

            $person->is_member = false;
            $person->removed = true;

          }

        }

        if ( $person->is_member ) {

          if ( $teammember ) $person->member_id = $teammember->id;

        }

        if ( !( $filter_members == '1' && $person->is_member ) || !$person->is_member || $filter_members != '1' ) {

          
          $people_filtered[] = $person;

        }

      }

      return response()->json( [ 'people' => $people_filtered, 'filter_members' => intval( $filter_members ) > 0 ] );

    } else {

      if ( !$project ) return redirect( '/' );

    }

    return view( 'network.people' );

  }

}
