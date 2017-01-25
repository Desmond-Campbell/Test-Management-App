<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Requirements extends Model
{
  
  protected $guarded = ['id'];
  protected $table = "requirements";

  public static function updateDependencies( $id ) {

  	// Find all the requirements that use the one in question and update child count on this one

  	$childcount = self::where( 'parent_requirement_id', $id )->count();

  	self::find( $id )->update( [ 'has_children' => $childcount ] );

  }

}
