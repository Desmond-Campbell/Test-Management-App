<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Police;
use App\Projects;
use App\CaseSections;
use App\TeamMembers;
use App\User;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

class UtilityController extends Controller
{

  public function updateTracker( Request $r ) {

    return \App\Tracker::updateTime( $r->input( 'timevalue' ), $r->input( 'pagehash' ), $r->input( 'properties' ) );

  }

}
