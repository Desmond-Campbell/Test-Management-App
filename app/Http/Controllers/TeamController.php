<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Police;
use App\Projects;
use App\TeamMembers;
use App\TeamRoles;
use App\User;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class TeamController extends Controller
{

  public function __construct( Request $r )
  {

    if ( $r->input( 'request-type' ) == 'full-template' ) Config::set( 'pageconfig', 'full-template' );

  }

  public function index( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'project_id' => $id, 
                      'keystring' => 'projects.team.view_members', 
                      'return' => $r->input( 'format' ) == 'json' ] );

    ////////////////////////////////////////////

    $project = Projects::find( $id );

    if ( $r->input( 'format') == 'json' ) {

      if ( block( 'team.view_deleted_members', $id ) ) {

        $members = TeamMembers::where( 'project_id', $id )->where( 'is_removed', '0' )->get();

      }

      if ( empty( $members ) ) $members = TeamMembers::where( 'project_id', $id )->get();

      $members_filtered = [];

      foreach ( $members as $m ) {

        $user = \App\User::find( $m->user_id );

        if ( $user ) {

          $m->name = $user->name;
          $m->class = ___( "Member" );

          if ( $m->user_type == 1 ) $m->class = ___( "Owner" );
          if ( $m->user_type == 2 ) $m->class = ___( "Administrator" );

          $members_filtered[] = $m; 

        }

      }

      return response()->json( [ 'members' => $members_filtered ] );

    } else {

      if ( !$project ) return redirect( '/projects' );

    }

    return view( 'team.index', compact( 'project' ) );

  }

  public function newMember( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.view_members', 'project_id' => $id ] );

    $project = Projects::find( $id );

    if ( !$project ) return redirect( '/projects' );

    return view( 'team.new-member', compact( 'project' ) );

  }

  public function createMember( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.add_member', 'project_id' => $id, 'return' => 1 ] );
 
    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $user_id = $r->input( 'user_id' );
    $err = null;

    if ( !$user_id ) {

      $err = [ 'errors' => ___( 'Invalid user selected.' ) ];

    }

    $user = User::find( $user_id );

    if ( !$user ) {

      $err = [ 'errors' => ___( "Invalid user selected." ) ];

    } else {

      $name = $user->name;

    }

    if ( $err ) {

      $result = $err;

    } else {

      // Check if they exist

      $teammember = TeamMembers::where( 'project_id', $id )->where( 'user_id', $user_id )->first();

      if ( !$teammember ) {

        // Create team member for this project, adding an owner and a team member

          $newteammember = [
                            'project_id'    => $id,
                            'user_id'       => $user_id,
                            'user_type'     => 3
                          ];

          $result_id = TeamMembers::create( $newteammember )->id;

        // Create activity feed

          $filter_hash = sha1( "add_team_member." . date( 'Y-m-d' ) );
          $activity_values = [];
          $activity_values['user_id'] = $user_id;
          $activity_values['name'] = $user->name;

          $newactivity = [
                            'project_id'    => $id,
                            'object_type'   => 'add_team_member',
                            'object_id'     => $user_id,
                            'user_id'       => get_user_id(),
                            'values'        => json_encode( $activity_values ),
                            'filter_hash'   => $filter_hash
                          ];

        Activities::create( $newactivity );

        $result = [ 'success' => true, 'result_id' => $result_id ];

      } elseif ( $teammember->is_removed ) {

        $teammember->is_removed = 0;
        $teammember->save();
      
        // Create activity feed

          $filter_hash = sha1( "add_team_member." . date( 'Y-m-d' ) );
          $activity_values = [];
          $activity_values['user_id'] = $user_id;
          $activity_values['name'] = $user->name;

          $newactivity = [
                            'project_id'    => $id,
                            'object_type'   => 'add_team_member',
                            'object_id'     => $user_id,
                            'user_id'       => get_user_id(),
                            'values'        => json_encode( $activity_values ),
                            'filter_hash'   => $filter_hash
                          ];

        Activities::create( $newactivity );

        $result = [ 'success' => true, 'result_id' => $teammember->id ];

      } else {

        $result = [ 'errors' => $name . ' ' . ___( 'has already been added to this project.' ) ];

      }

    }

    return response()->json( $result );

  }

  public function removeMember( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.remove_member', 'project_id' => $id, 'return' => 1 ] );
 
    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $member_id = $r->route( 'member_id' );
    $teammember = TeamMembers::find( $member_id );

    $err = null;

    if ( !$teammember ) {

      $err = [ 'errors' => ___( "Invalid team member selected." ) ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      // Strip access rights and set as removed

      $teammember->is_removed = 1;
      $teammember->roles = '[]';
      $teammember->key_overrides = '[]';
      $teammember->key_restrictions = '[]';
      $teammember->save();

      $user = User::find( $teammember->user_id );

      if ( $user ) {
      
        // Create activity feed

          $filter_hash = sha1( "remove_team_member." . date( 'Y-m-d' ) );
          $activity_values = [];
          $activity_values['user_id'] = $user->id;
          $activity_values['name'] = $user->name;

          $newactivity = [
                            'project_id'    => $id,
                            'object_type'   => 'remove_team_member',
                            'object_id'     => $user->id,
                            'user_id'       => get_user_id(),
                            'values'        => json_encode( $activity_values ),
                            'filter_hash'   => $filter_hash
                          ];

        Activities::create( $newactivity );

      }

      $result = [ 'success' => true, 'result_id' => $teammember->id ];

    }

    return response()->json( $result );

  }

  public function roles( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.view_roles',
                      'project_id' => $id, 
                      'return' => $r->input( 'format' ) == 'json' ] );

    $project = Projects::find( $id );

    if ( $r->input( 'format') == 'json' ) {

      $roles = TeamRoles::where( 'project_id', $id )->get();

      if ( $r->input( 'request-type') == 'namesonly' ) {

        $output = [];

        foreach ( $roles as $role ) {

          $output[] = $role->name;

        }

        return response()->json( [ 'roles' => $output ] );

      }

      return response()->json( [ 'roles' => $roles ] );

    } else {

      if ( !$project ) return redirect( '/projects' );

    }

    return view( 'team.roles', compact( 'project' ) );

  }

  public function newRole( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.create_role', 'project_id' => $id ] );

    $project = Projects::find( $id );

    if ( !$project ) return redirect( '/projects' );

    return view( 'team.new-role', compact( 'project' ) );

  }

  public function createRole( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.create_role', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $name = $r->input( 'name' );
    $copy = $r->input( 'copy' );
    $description = $r->input( 'description' );
    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a name for this role.' ) ];

    } else {

      $count = TeamRoles::where( 'project_id', $id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used for a role in this project team.' ) ];

      }

    }

    /* DOC-ToDo: work out is_owner */

    $is_owner = 0;

    if ( $err ) {

      $result = $err;

    } else {

      $newrole = [
                  'name'          => $name,
                  'project_id'    => $id,
                  'is_owner'      => $is_owner,
                  'role_type'     => 0,
                  'description'   => $description
                ];

      if ( $copy ) {

        $source = TeamRoles::where( 'project_id', $id )->where( 'name', $copy )->first();

        if ( $source ) {

          if ( !$newrole['description'] ) $newrole['description'] = $source->description;
          if ( empty( $newrole['is_owner'] ) ) $newrole['is_owner'] = $source->is_owner;
          if ( !$newrole['role_type'] ) $newrole['role_type'] = $source->role_type;

          $newrole['permissions'] = $source->permissions;

        }

      }

      $result_id = TeamRoles::create( $newrole )->id;

      $result = [ 'success' => true, 'result_id' => $result_id ];

    }

    return response()->json( $result );

  }

  public function saveRole( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.update_role', 'project_id' => $id, 'return' => 1 ] );
 
    $role_id = $r->route( 'role_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $role = TeamRoles::find( $role_id );

    if ( $role ) {

      if ( $role->project_id != $id ) return [ 'errors' => ___( 'Role not found on selected project.' ) ];

      $description = $r->input( 'description' );
      $name = $r->input( 'name' );

      if ( !$name ) {

        $err = [ 'errors' => ___( 'Please enter a name for this role.' ) ];

      } else {

        $count = TeamRoles::where( 'project_id', $id )->where( 'name', $name )->where( 'id', '<>', $role_id )->count();

        if ( $count > 0 ) {

          $err = [ 'errors' => ___( 'The name you entered is already being used for a role in this project team.' ) ];

        }

      }

      $role->name = $name;
      $role->description = $description;
      $role->save();

      return response()->json( [ 'success' => true ] );

    } else {

      return [ 'errors' => ___( 'Could not find role.' ) ];

    }

  }

  public function editRole( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.update_role', 'project_id' => $id ] );

    $role_id = $r->route( 'role_id' );

    $project = Projects::find( $id );

    if ( !$project ) return redirect( '/projects' );

    $role = TeamRoles::find( $role_id );

    if ( !$role ) return redirect( "/projects/$id/team" );

    return view( 'team.edit-role', compact( 'project', 'role_id' ) );

  }

  public function getRole( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.view_role', 'project_id' => $id, 'return' => 1 ] );

    $role_id = $r->route( 'role_id' );

    $project = Projects::find( $id );
    $role = TeamRoles::find( $role_id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];
    if ( !$role ) return [ 'errors' => ___( 'Project team role not found.' ) ];

    if ( $role->project_id != $id ) return [ 'errors' => ___( 'The role you selected is not attached to this project.' ) ];

    return response()->json( [ 'role' => $role ] );

  }

  public function getPermissions( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.view_role_permissions', 'project_id' => $id, 'return' => 1 ] );

    $role_id = $r->route( 'role_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $role = TeamRoles::where( 'id', $role_id )->where( 'project_id', $id )->first();

    if ( $role ) {

      $perms = $perm_info = [];
      $selected_perms = $role->permissions;

      if ( $selected_perms ) $selected_perms = try_json_decode( $selected_perms );

      if ( !$selected_perms ) $selected_perms = [];
      else $selected_perms = (array) $selected_perms;

      $permsCollection = Police::getAllKeys();

      foreach ( $permsCollection as $p => $p_info ) {

        $perm_info[$p] = $p_info;
        $perms[] = $p;

      }

      return response()->json( [ 'perms' => $perms, 'perm_info' => $perm_info, 'selected_perms' => $selected_perms ] );

    } else {

      return [ 'errors' => ___( 'Could not find role.' ) ];

    }

  }

  public function savePermissions( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.update_role_permissions', 'project_id' => $id, 'return' => 1 ] );

    $role_id = $r->route( 'role_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $role = TeamRoles::find( $role_id );

    if ( $role ) {

      $selected_perms = $r->input( 'selected_perms' );

      $role->permissions = json_encode( $selected_perms );
      $role->save();

      return response()->json( [ 'success' => true ] );

    } else {

      return [ 'errors' => ___( 'Could not find role selected.' ) ];

    }

  }

  public function editAccess( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.update_member', 'project_id' => $id ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );

    if ( !$project ) return redirect( '/projects' );

    $teammember = TeamMembers::find( $member_id );

    if ( !$teammember ) return redirect( "/projects/$id/team" );
    
    if ( $teammember->is_removed ) return redirect( "/projects/$id/team" );

    $member_user_id = $teammember->user_id;

    $user = User::find( $member_user_id );
    $member_sso_id = 0;

    if ( $user ) $member_sso_id = $user->sso_id;

    return view( 'team.edit-access', compact( 'project', 'member_id', 'member_user_id', 'member_sso_id' ) );

  }

  public function getMember( Request $r ) {

    $id = $r->route( 'project_id' );
    
    police( [ 'keystring' => 'projects.team.view_member', 'project_id' => $id, 'return' => 1 ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );
    $member = TeamMembers::find( $member_id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];
    if ( !$member ) return [ 'errors' => ___( 'Project team member not found.' ) ];
    if ( $member->is_removed ) return [ 'errors' => ___( 'The team member you selected has been removed from this project.' ) ];

    $user = User::find( $member->user_id );
    if ( !$user ) return [ 'errors' => ___( 'The person you selected does not exist in the network at all.' ) ];

    if ( $member->project_id != $id ) return [ 'errors' => ___( 'The person you selected is not a member of this project\'s team.' ) ];

    $member->name = $user->name;

    return response()->json( [ 'member' => $member ] );

  }

  public function getRoles( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.view_member_roles', 'project_id' => $id, 'return' => 1 ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $rolesCollection = \App\TeamRoles::where( 'project_id', $id )->get();

    foreach ( $rolesCollection as $r ) {

      $role_info[$r->id] = $r;
      $roles[] = $r->id;

    }

    $teammember = TeamMembers::find( $member_id );

    if ( $teammember ) {

      if ( $teammember->is_removed ) return [ 'errors' => ___( 'The team member you selected has been removed from this project.' ) ];

      $selected_roles = $teammember->roles;

      if ( $selected_roles ) $selected_roles = try_json_decode( $selected_roles );

      if ( !$selected_roles ) $selected_roles = [];
      else $selected_roles = (array) $selected_roles;

      return response()->json( [ 'roles' => $roles, 'role_info' => $role_info, 'selected_roles' => $selected_roles ] );

    } else {

      return [ 'errors' => ___( 'Could not find team member or network person.' ) ];

    }

  }

  public function saveRoles( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.update_member_roles', 'project_id' => $id, 'return' => 1 ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $teammember = TeamMembers::find( $member_id );

    if ( $teammember ) {

    if ( $teammember->is_removed ) return [ 'errors' => ___( 'The team member you selected has been removed from this project.' ) ];
  
      $selected_roles = $r->input( 'selected_roles' );

      $teammember->roles = json_encode( $selected_roles );
      $teammember->save();

      return response()->json( [ 'success' => true ] );

    } else {

      return [ 'errors' => ___( 'Could not find team member or network person.' ) ];

    }

  }

  public function getOverrides( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.view_member_overrides', 'project_id' => $id, 'return' => 1 ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $teammember = TeamMembers::find( $member_id );

    if ( $teammember ) {

      if ( $teammember->is_removed ) return [ 'errors' => ___( 'The team member you selected has been removed from this project.' ) ];

      $overrides = $override_info = [];

      $selected_overrides = $teammember->key_overrides;

      if ( $selected_overrides ) $selected_overrides = try_json_decode( $selected_overrides );

      if ( !$selected_overrides ) $selected_overrides = [];
      else $selected_overrides = (array) $selected_overrides;

      $overridesCollection = Police::getAllKeys();

      foreach ( $overridesCollection as $o => $o_info ) {

        $override_info[$o] = $o_info;
        $overrides[] = $o;

      }

      return response()->json( [ 'overrides' => $overrides, 'override_info' => $override_info, 'selected_overrides' => $selected_overrides ] );

    } else {

      return [ 'errors' => ___( 'Could not find team member or network person.' ) ];

    }

  }

  public function saveOverrides( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.update_member_overrides', 'project_id' => $id, 'return' => 1 ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $teammember = TeamMembers::find( $member_id );

    if ( $teammember ) {

      if ( $teammember->is_removed ) return [ 'errors' => ___( 'The team member you selected has been removed from this project.' ) ];

      $selected_overrides = $r->input( 'selected_overrides' );

      $teammember->key_overrides = json_encode( $selected_overrides );
      $teammember->save();

      return response()->json( [ 'success' => true ] );

    } else {

      return [ 'errors' => ___( 'Could not find team member or network person.' ) ];

    }

  }

  public function getRestrictions( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.view_member_restrictions', 'project_id' => $id, 'return' => 1 ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $teammember = TeamMembers::find( $member_id );

    if ( $teammember ) {

      if ( $teammember->is_removed ) return [ 'errors' => ___( 'The team member you selected has been removed from this project.' ) ];

      $restrictions = $restriction_info = [];
 
      $selected_restrictions = $teammember->key_restrictions;

      if ( $selected_restrictions ) $selected_restrictions = try_json_decode( $selected_restrictions );

      if ( !$selected_restrictions ) $selected_restrictions = [];
      else $selected_restrictions = (array) $selected_restrictions;

      $restrictionsCollection = Police::getAllKeys();

      foreach ( $restrictionsCollection as $o => $o_info ) {

        $restriction_info[$o] = $o_info;
        $restrictions[] = $o;

      }

      return response()->json( [ 'restrictions' => $restrictions, 'restriction_info' => $restriction_info, 'selected_restrictions' => $selected_restrictions ] );

    } else {

      return [ 'errors' => ___( 'Could not find team member or network person.' ) ];

    }

  }

  public function saveRestrictions( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.team.update_member_restrictions', 'project_id' => $id, 'return' => 1 ] );

    $member_id = $r->route( 'member_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $teammember = TeamMembers::find( $member_id );

    if ( $teammember ) {

      if ( $teammember->is_removed ) return [ 'errors' => ___( 'The team member you selected has been removed from this project.' ) ];

      $selected_restrictions = $r->input( 'selected_restrictions' );

      $teammember->key_restrictions = json_encode( $selected_restrictions );
      $teammember->save();

      return response()->json( [ 'success' => true ] );

    } else {

      return [ 'errors' => ___( 'Could not find team member or network person.' ) ];

    }

  }

}
