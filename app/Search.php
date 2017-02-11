<?php

namespace App;

use \App\Model;
use Illuminate\Support\Facades\DB;

class Search extends Model
{    
  /**
   * This contains an array of attributes that you do not want to be mass assignable
   * @var array
   */
  protected $guarded = ['id'];
  /**
   * This is the name of the database table for this Model
   * @var string
   */
  protected $table = "search";
    
  public static function index() {

  	// Find dirty indexes and update

  	$indexes = Search::where( 'status', 0 )->orderBy( 'updated_at', 'asc' )->take(10)->get();

  	foreach ( $indexes as $i ) {

  		$id = $i->object_id;

  		switch ( $i->object_type ):

  			case 'test_cases':

  				$object = Cases::find( $id );
  				if ( $object ) $keywords = implode( ' ', [ $object->name, $object->description, $object->instructions, $object->fail_criteria, $object->pass_criteria ] );

  			break;

  			case 'test_issues':

					$object = Issues::find( $id );
  				if ( $object ) $keywords = implode( ' ', [ $object->title, $object->details ] );

  			break;

  			case 'test_scenarios':

					$object = Scenarios::find( $id );
  				if ( $object ) $keywords = implode( ' ', [ $object->name, $object->description ] );

  			break;

				case 'test_suites':

					$object = Suites::find( $id );
  				if ( $object ) $keywords = implode( ' ', [ $object->name, $object->description ] );

  			break;  			

  			default:
  			break;

  		endswitch;

  		if ( isset( $object ) && isset( $keywords ) ) {

  			$words = string_to_words( $keywords );

  			$i->update( [ 'keywords' => $words, 'status' => 1 ] );

  		}

  	}

  }

  public static function foil( $args ) {

  	$project_id = arg( $args, 'project_id', 0 );
  	$object_id = arg( $args, 'object_id', 0 );
  	$object_type = arg( $args, 'object_type', 0 );
  	$object_name = arg( $args, 'object_name', 0 );

  	if ( $project_id && $object_id && $object_type ) {

	  	$hash = sha1( "$project_id/$object_id/$object_type" );

	  	$object = self::where( 'hash', $hash )->first();

	  	if ( !$object ) {

	  		self::create( [ 'project_id' => $project_id, 
	  										'hash' => $hash, 
	  										'object_type' => $object_type, 
	  										'object_name' => $object_name, 
	  										'object_id' => $object_id, 
	  										'status' => 0 ] );

	  	} else {

	  		$object->update( [ 'status' => 0 ] );

	  	}

	  }

  }

  public static function unseed( $args ) {

  	$project_id = arg( $args, 'project_id', 0 );
  	$object_id = arg( $args, 'object_id', 0 );
  	$object_type = arg( $args, 'object_type', 0 );

  	if ( $project_id && $object_id && $object_type ) {

	  	$hash = sha1( "$project_id/$object_id/$object_type" );

	  	$object = self::where( 'hash', $hash )->delete();

	  }

  }

  public static function search( $query, $project_id ) {

  	$query = str_replace( [ "'" ], [ "''" ], implode( " ", array_map( function( $word ){ return "+$word"; }, explode( ' ', $query ) ) ) );

  	$sql = "select * from search where project_id = $project_id AND match(keywords) against ('$query' IN BOOLEAN MODE )";

  	$results = DB::select( $sql );

  	return $results;

  }

  public static function getUrl( $result ) {

  	return "/o/" . $result->object_type . "/" . $result->object_id;

  }

}
