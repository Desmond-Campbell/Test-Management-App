<?php

if ( !empty( $_REQUEST['regenerate_keys'] ) ) {

	$csv = fopen( "../database/seeds/permissions_list.csv", 'r' );

	$keys = $output = $output_header = [];

	while ( !feof( $csv ) ) {

		$line = fgetcsv( $csv );
		$key = $line[1];
		$section = $line[2];
		$category = $line[3];
		$access_type = $line[4];
		$name = $line[5];
		$description = $line[6];
		$keywords = $line[7];
		$message = $line[8];

		$key_info = [];
		$key_info['key'] = $key;
		$key_info['section'] = $section;
		$key_info['category'] = $category;
		$key_info['access_type'] = $access_type;
		$key_info['name'] = $line[5];
		$key_info['description'] = $line[6];
		$key_info['keywords'] = $line[7];
		$key_info['message'] = $line[8];

		if ( $section != 'section' && $section && $key_info ) {

			$keys[$section][$category][$key] = $key_info;

			$output_header[] = '$keys["' . $section . '"] = [];';
			$output_header[] = '$keys["' . $section . '"]["' . $category . '"] = [];';

			$output[] = '$keys["' . $section . '"]["' . $category . '"]["' . $key . '"] = 
					[ 
						"name" => "' . $name . '", 
						"message" => "' . $message . '", 
						"keywords" => "' . $keywords . '", 
						"access_type" => "' . $access_type . '" 
					];' . "\n";

		}

	}

	fclose( $csv );

	$final_output = "<" . "?php\n\n$" . "keys = [];\n\n";
	$final_output .= implode( "\n", array_unique( $output_header ) );
	$final_output .= "\n\n";
	$final_output .= implode( "\n", array_unique( $output ) );
	$final_output .= "\n

	return $" . "keys;\n";

	$final_output = trim( $final_output );

	file_put_contents( "../config/permission_keys.php", $final_output );

	print $final_output;

	die;

}

if ( !empty( $_REQUEST['print_keys'] ) ) {

	print file_get_contents( '../config/permission_keys.php' );

}
