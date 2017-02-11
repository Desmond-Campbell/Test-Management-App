<?php

namespace App;

use \App\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class Police 
{    
    
  public static function getKeys() {
  	
  	$keys = [];
  	$keys['network'] = config( 'permission_keys.network' );
  	$keys['projects'] = config( 'permission_keys.projects' );
 
    return $keys;

  }

  public static function getAllKeys() {
    
    $keys = [];
    $keys['projects'] = config( 'permission_keys.projects' );

    $allkeys = [];
 
    foreach ( $keys['projects'] as $c => $data ) {

      foreach ( $data as $key => $key_data ) {

        $allkeys[$key] = $key_data;

      }

    }

    return $allkeys;

  }  

  public static function check( $args ) {

    if ( !is_array( $args ) || ( is_array( $args ) && !empty( $args['keystring'] ) ) ) {

      $keystring = !is_array( $args ) ? explode( '.', $args ) : ( !empty( $args['keystring'] ) ? explode( '.', $args['keystring'] ) : [] );
      $args = is_array( $args ) ? $args : [];

      if ( count( $keystring ) > 2 ) {

        $args['section'] = $keystring[0];
        $args['category'] = $keystring[1];
        $args['key'] = $keystring[2];

      } elseif ( count( $keystring ) > 1 ) {

        $args['category'] = $keystring[0];
        $args['key'] = $keystring[1];

      } else {

        $args['key'] = $keystring[0];
      
      }

    }
      
    $section = arg( $args, 'section', 'projects' );
    $category = arg( $args, 'category', 'projects' );
    $key = arg( $args, 'key' );

    $theUser = User::find( get_user_id() );

    if ( !empty( $theUser ) ) {

      if ( $theUser->is_network_owner ) return self::handleReturn( [ 'result' => [ 'allow' => true, 'message' => ___( 'Permission granted based on exclusive network access.' ), 'debug' => null ], 'args' => $args ] );

    }

    if ( $section == 'network' ) {

      $user_id = arg( $args, 'user_id', get_user_id() );
      $user = User::find( $user_id );
      $debug = [ 'section' => $section, 'category' => $category, 'key' => $key, 'user_id' => $user_id, 'user' => $user ];

      if ( !$user ) self::handleReturn( [ 'result' => [ 'allow' => false, 'message' => ___( 'Person was not found in network.' ), 'debug' => $debug ], 'args' => $args ] );

    } else {

      $project_id = arg( $args, 'project_id', 0 );

      $project = Projects::find( $project_id );
      
      $debug = [ 'section' => $section, 'category' => $category, 'key' => $key, 'project_id' => $project_id ];

      if ( !$project ) self::handleReturn( [ 'result' => [ 'allow' => false, 'message' => ___( 'Project was not found.' ), 'debug' => $debug ], 'args' => $args ] );

      $member_user_id = arg( $args, 'member_user_id', get_user_id() );
      $member = TeamMembers::where( 'user_id', $member_user_id )->where( 'project_id', $project_id )->where( 'is_removed', 0 )->first();
      $debug['member_user_id'] = $member_user_id;
      $debug['member'] = $member;

      if ( !$member ) self::handleReturn( [ 'result' => [ 'allow' => false, 'message' => ___( 'Team member was not found.' ), 'debug' => $debug ], 'args' => $args ] );

    }

    $keys = self::getKeys();

    $debug['keys'] = $keys;

    $member_key_restrictions = $member_key_overrides = [];

    if ( empty( $keys[$section][$category][$key] ) ) return self::handleReturn( [ 'result' => [ 'allow' => false, 'message' => ___( 'Permission denied because of an invalid key request.' ), 'debug' => $debug ], 'args' => $args ] );

    if ( $section == 'network' ) {

      if ( $user ) {

        $member_key_restrictions = (array) try_json_decode( $user->permissions_exclude );
        $member_key_overrides = (array) try_json_decode( $user->permissions_include );

      }

    } else {

      if ( $member ) {

        $member_key_restrictions = (array) try_json_decode( $member->key_restrictions );
        $member_key_overrides = (array) try_json_decode( $member->key_overrides );

      }
    
    }

    // if ( $member_key_restrictions === null ) $member_key_restrictions = [];
    // if ( $member_key_overrides === null ) $member_key_overrides = [];

    // 1st Check: deny if permission is excluded on member account

    if ( in_array( $key, $member_key_restrictions ) ) return self::handleReturn( [ 'result' => [ 'allow' => false, 'message' => ___( 'Permission denied based on an override.' ), 'debug' => $debug ], 'args' => $args ] );

    // 2nd Check: allow if permission is included on member account

    if ( in_array( $key, $member_key_overrides ) ) return self::handleReturn( [ 'result' => [ 'allow' => true, 'message' => ___( 'Permission granted based on an override.' ), 'debug' => $debug ], 'args' => $args ] );

    // 3rd Check: deny if permission is included on any member role

    $member_roles = [];

    if ( !( !isset( $member ) && !isset( $user ) ) ) $member_roles = $section != 'network' ? (array) try_json_decode( $member->roles ) : (array) try_json_decode( $user->roles );
	 	$role_key_overrides = [];

    $debug['member_roles'] = [];

    foreach ( $member_roles as $member_role ) {
 
 			if ( intval( $member_role ) ) {

	 			$role = TeamRoles::find( $member_role );

	 			if ( $role ) {

          $debug['member_roles'][] = $role;

		 			$role_keys = (array) try_json_decode( $role->permissions );

		 			if ( in_array( $key, $role_keys ) ) {

		 				return self::handleReturn( [ 'result' => [ 'allow' => true, 'message' => 'Permission granted based on a role inclusion.', 'debug' => $debug ], 'args' => $args ] );

		 			}

          // Check for exclusive access

          if ( in_array( 'exclusive_access', $role_keys ) ) {

            return self::handleReturn( [ 'result' => [ 'allow' => true, 'message' => 'Permission granted based on an exclusive access permission.', 'debug' => $debug ], 'args' => $args ] );

          }

          // Check for admin access

          if ( in_array( 'project_admin', $role_keys ) && $section == 'projects' && $category == 'projects' ) {

            return self::handleReturn( [ 'result' => [ 'allow' => true, 'message' => 'Permission granted based on project administrative access permission.', 'debug' => $debug ], 'args' => $args ] );

          }

		 		}

	    }

	  }

    if ( in_array( 'exclusive_access', $member_key_overrides ) ) {

      return self::handleReturn( [ 'result' => [ 'allow' => true, 'message' => 'Permission granted based on an exclusive access permission.', 'debug' => $debug ], 'args' => $args ] );

    }

	  self::handleReturn( [ 'result' => [ 'allow' => false, 'message' => ___( 'Permission denied because there were no records found that would permit.' ), 'debug' => $debug ], 'args' => $args ] );

  }

  public static function handleReturn( $A ) {

    $return = arg( arg( $A, 'args' ), 'return' );
    $result = $A['result'];

    $accessmessage = ___( "Sorry, you do not have permission to do that. Please contact an administrator. [{$A['result']['debug']['key']}]" );

    $d = arg( $result, 'debug', [] );
    $ks = arg( $d, 'keys', [] );
      $k = arg( $d, 'key', '' );
      $s = arg( $d, 'section' );
      $c = arg( $d, 'category' );
    $p = arg( arg( arg( $ks, $s, [] ), $c, [] ), $k ) ;
    $m = arg( $p, 'message', '' );

    if ( !env( 'PERMISSION_DEBUG' ) ) {

      $A['result']['debug'] = $result['debug'] = $d = [];

    }

    if ( arg( arg( $A, 'args' ), 'quickcheck' ) ) return $result['allow'];

    if ( $return ) {

      if ( !$result['allow'] ) {

        if ( $m ) $accessmessage = $m;

        $result['errors'] = $accessmessage;

      } else {

        return;

      }

      print_r( json_encode( $result ) );
      die;

    }

    $redirect = arg( arg( $A, 'args' ), 'redirect' );

    if ( $redirect ):

      header( "Location: $redirect"); 
      die;

    endif;

    if ( !$A['result']['allow'] ) {

      print_r(View::make('index-empty', compact( 'result' ) )->nest('child', 'blocked')->render());

      die;
    
    }

    $result['errors'] = $accessmessage;

    return arg( $A, 'result', [ 'allow' => false, 'message' => ___( 'Permission denied, possibly due to a system error.' ) ] );

  }

}
