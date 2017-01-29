<?php

namespace App\Http\Controllers;

use App\Projects;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class ListController extends Controller
{

  public function __construct()
  {

  }

  public function getList( Request $r ) {

    $slug = $r->route( 'slug' );
    $format = $r->route( 'format' );

    $lists = $data = [];

    $lists['project-types'] = [ 'Other', 'Mobile App', 'Web Application', 'Website' ];

    if ( !empty( $lists[$slug] ) ) $data = $lists[$slug];

    return response()->json( [ 'list' => $data ] );

  }

}
