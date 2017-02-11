<?php

namespace App;

use \App\Model;

class Files extends Model
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
  protected $table = "files";
    
  public static function store( $file, $args ) {

  	$filename = arg( $file, 'name', self::getRandomFileName() );

    $files_directory = self::getRootDirectoryName();
    $subdirectory = self::getSubDirectoryName();
    $project_directory = self::getProjectDirectoryName( arg( $args, 'project_id' ) );
    $file_name = self::getFileName( $filename );

    $destination_directory = "$files_directory/$subdirectory/$project_directory";

    if ( !file_exists( $destination_directory ) ) {

      mkdir( $destination_directory, 0777, true );

    }

    $destination = "$destination_directory/$file_name";

    move_uploaded_file( $file['tmp_name'], $destination );

    // Add file record to database now

    $newfile = [];
    $newfile['object_id'] = arg( $args, 'object_id', 0 );
    $newfile['name'] = $filename;
    $newfile['path'] = $destination;
    $newfile['network_id'] = arg( $args, 'network_id', 0 );
    $newfile['size'] = arg( $file, 'size', 0 );
    $newfile['type'] = arg( $file, 'type', 'Unknown' );
    $newfile['created_by'] = get_user_id();

    if ( arg( $args, 'project_id' ) ) $newfile['project_id'] = arg( $args, 'project_id' );
    if ( arg( $args, 'variables' ) ) $newfile['variables'] = arg( $args, 'variables' );

    $id = self::create( $newfile )->id;

    return $id;

  }

  public static function getRootDirectoryName() {

  	return base_path()  . '/' . env( 'FILES_DIRECTORY' );

  }

  public static function getSubDirectoryName() {

    $network_id = \App\Options::get( 'network_id' );
  	$subdirectory = "." . strtolower( dechex( crc32( $network_id ) ) );
    $subdirectory .= "_" . substr( strtolower( dechex( crc32( $network_id + 100000 ) ) ), 2, 2 );

    return $subdirectory;

  }

  public static function getProjectDirectoryName( $id ) {

  	return "." . strtolower( dechex( crc32( $id + 10000000000 ) ) );

  }

  public static function getFileName( $name ) {

  	return "." . sha1( $name . rand( 1000000, 99999999999 ) . "-" . time() );

  }

  public static function getRandomFileName() {

  	return 'untitled-' . dechex( crc32( time() ) ) . ".dat";

  }

}
