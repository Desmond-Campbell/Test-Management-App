<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Suites;
use App\Scenarios;
use App\Cases;
use App\Police;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

  public function __construct()
  {

  }

  public function index( Request $r ) {

    $url = $r->input( 'url' );
    $w = max( max( $r->input( 'w' ), 0 ) / 1.75, 500 );
    $h = max( max( $r->input( 'h' ), 0 ) / 1.25, 500 );

    return '<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script><script>function passResult(result){ parent.receiveResult(); $("#frame").remove(); /*window.close();*/}</script><iframe id="frame" src="' . $url . '?request-type=full-template" height="' . $h . 'px" width="' . $w . 'px" border="0" style="border: none"></iframe>';

  }

}
