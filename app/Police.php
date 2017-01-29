<?php

namespace App;

use \App\Model;

class Police 
{    
    
  public static function getKeys() {
  	
  	$keys = [];
  	$keys['team'] = config( 'permission_keys.team' );
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

    if ( !is_array( $args ) ) {

      $args = explode( '.', $args );

      if ( count( $args ) > 2 ) {

        $args = [ 'section' => $args[0],
                  'category' => $args[1],
                  'key' => $args[2],
                ];

      } elseif ( count( $args ) > 1 ) {

        $args = [ 'category' => $args[0],
                  'key' => $args[1],
                ];

      } else {

        $args = [ 'key' => $args[0] ];
      }

    }
      
    $section = arg( $args, 'section', 'projects' );
    $category = arg( $args, 'category', 'projects' );
    $member_id = arg( $args, 'member_id', 0 );
    $project_id = arg( $args, 'member_id', 0 );
    $member = TeamMembers::where( 'id', $member_id )->where( 'project_id', $project_id )->first();

    if ( !$member ) return [ 'deny' => true, 'message' => ___( 'Team member was not found.' ) ];

    $key = arg( $args, 'key' );

    $keys = self::getKeys();

    if ( empty( $keys[$section][$category][$key] ) ) return [ 'deny' => true, 'message' => ___( 'Permission denied because of an invalid key request.' ) ];

    $member_key_restrictions = (array) try_json_decode( $member->key_restrictions );
    $member_key_overrides = (array) try_json_decode( $member->key_overrides );

    // 1st Check: deny if permission is excluded on member account

    if ( in_array( $key, $member_key_restrictions ) ) return [ 'allow' => false, 'message' => ___( 'Permission denied based on an override.' ) ];

    // 2nd Check: allow if permission is included on member account

    if ( in_array( $key, $member_key_overrides ) ) return [ 'allow' => true, 'message' => ___( 'Permission granted based on an override.' ) ];

    // 3rd Check: deny if permission is excluded on any member role

    $member_roles = (array) try_json_decode( $member->roles );
	 	$role_key_overridess = [];

    foreach ( $member_roles as $member_role ) {
 
 			if ( intval( $role ) ) {

	 			$role = TeamRoles::find( $role );

	 			if ( $role ) {

		 			$role_key_restrictions = (array) try_json_decode( $role->key_restrictions );
		 			$role_key_overridess[] = (array) try_json_decode( $role->key_overrides );

		 			if ( in_array( $key, $role_key_restrictions ) ) {

		 				return [ 'allow' => false, 'message' => 'Permission denied based on a role restriction.' ];

		 			}

		 		}

	    }

	  }

	  // 4th Check: allow if permission is included on any member role, after deny has been fully checked

	  foreach ( $role_key_overridess as $keys ) {

	  	if ( in_array( $key, $keys ) ) return [ 'allow' => true, 'message' => 'Permission granted based on a role override.' ];

	  }

    return [ 'allow' => false, 'message' => ___( 'Permission denied because there were no records found that would permit.' ) ];

  }

}
