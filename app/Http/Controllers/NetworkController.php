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
use Illuminate\Support\Facades\View;

class NetworkController extends Controller
{

  public function __construct( Request $r )
  {


    \App\Tracker::track( $r->all() );

  }

  public function people( Request $r ) {

    Police::check( [ 'keystring' => 'network.people.view_people', 'return' => 1 ] );

    $project_id = $r->input( 'project_id' );

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

    }

  }

  public function autoLogin( Request $r ) {

    $user_id = (int) $r->route('user_id');

    if ( $user_id < 1 || $user_id > 5 ) {

      print '<h1>' . ___("Authentication Error") . '</h1>';
      print '<p>' . ___("Sorry, we could not authenticate your request.");
      print ' <a href="/">' . ___( "Click here to try again" ) . '</a> ';
      print ___( "or you may" ) . ' <a href="http://www.' . env( 'APP_DOMAIN' ) . '">' . ___("contact us") . '</a> ';
      print ___( "for assistance") . '.</p>';
      
      die;

    }

    $random = rand( 111111, 99999999 );
    $random = "$random." . dechex( crc32( $random ) );
    $r2 = rand( 700, 720 );
    $global_cookie_value = "$random.$user_id.$r2";

    setcookie( config( 'session.global_cookie' ), $global_cookie_value, time() + ( 60 * 60 * 3 ), "/", "demo." . env( 'APP_DOMAIN' ) );

    return redirect( '/' );

  }

  public function logout() {

    setcookie( config( 'session.global_cookie' ), 'X', time() - ( 60 * 60 * 24 ), "/", "." . env( 'APP_DOMAIN' ) );
    setcookie( config( 'session.global_cookie' ), '', time() - ( 60 * 60 * 24 ), "/", "demo." . env( 'APP_DOMAIN' ) );

    header( "Location: http://my." . env('APP_DOMAIN') . '/.logout' );

    die;

  }

}
