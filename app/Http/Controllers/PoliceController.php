<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Police;
use App\Projects;
use App\CaseSections;
use App\RequirementSections;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class PoliceController extends Controller
{

  public function __construct()
  {

    \App\Tracker::track( $r->all() );

  }

  public function quickCheck( Request $r ) {

    $key = $r->input( 'key' );
    $project_id = $r->route( 'project_id' );

    $args = [ 'keystring' => "projects.$key", 'project_id' => $project_id ];

    $result = Police::check( $args );

  }

}
