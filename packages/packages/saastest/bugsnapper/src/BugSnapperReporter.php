<?php

namespace SaasTest\BugSnapper;
use Illuminate\Support\Facades\Config;

class BugSnapperReporter
{
    /**
     * Report or log an exception.
     *
     *
     *
     * @return void
     */
    public function report(\Exception $exception)
    {

        $string = $exception->__toString();
            $lines = explode( "\n", $string );
                $desc_lines = explode( "\\", explode( ":", $lines[0] )[0] );
                $class = explode( " in ", $desc_lines[count( $desc_lines ) - 1] )[0]; 
        $code_line_n = 0;
        $error = $error_details = [];

        $extract = '';
        $file = @file_get_contents( $exception->getFile() );

        if ( $file ) {
            
            $code_line = explode( ":", $lines[0] );
            $code_line = $code_line_n = $code_line[count($code_line)-1];

            $code_line_start = max( 0, $code_line - 8 );
            $code_line_end = $code_line_start + 17;

            $file_lines = explode( "\n", $file );

            $file_data = [];

            for ( $i = $code_line_start; $i < $code_line_end; $i++ ) {

                if ( !empty( $file_lines[$i-1] ) ) {
                    $file_data["$i"] = $file_lines[$i-1];
                } else {
                    $file_data["$i"] = "";
                }

            }

            $extract = $file_data;

        }

        $path = $exception->getFile();

        $error['description'] = $description = $lines[0];
        $error['code'] = $exception->getCode();
        $error['line'] = $exception->getLine();
        $error['message'] = $exception->getMessage();
        $error['class'] = $class;
        $error['codeline'] = $code_line_n;
        $error['path'] = $path;
        $error['hash'] = sha1( $error['code'] . $error['codeline'] . $error['path'] . $error['class'] );
        $error['app_id'] = env( 'APP_ID', 'NA' );
        $error['app_env'] = env( 'APP_ENV', 'NA' );

        $error_details['extract'] = json_encode( $extract );
        $error_details['variables'] = json_encode( [ 'server' => $_SERVER, 'get' => $_GET, 'post' => $_POST, 'request' => $_REQUEST, 'cookie' => $_COOKIE ] );
        $error_details['debug'] = env('APP_DEBUG');
        $error_details['trace'] = $string;
        $error_details['ip'] = $this->arg( $_SERVER, 'REMOTE_ADDR', '' );
        $error_details['browser'] = $this->arg( $_SERVER, 'HTTP_USER_AGENT', '' );
        $error_details['url'] = $this->arg( $_SERVER, 'REQUEST_SCHEME', 'http' ) . '://'  . $this->arg( $_SERVER, 'HTTP_HOST', '' ) . $this->arg( $_SERVER, 'REQUEST_URI', '' );

        $content = json_encode( [ 'error' => $error, 'error_details' => $error_details ] );

        $headers = [ 'Content-type: application/x-www-form-urlencoded' ];
        $api_key = 'demo';
        $api_secret = 'demo';
        $params = [ 'http' => [
                        'method' => 'POST',
                        'header' => implode( "\n", $headers ),
                        'content' => http_build_query( [ 'error' => $content, 'api_key' => $api_key, 'api_secret' => $api_secret ] ) ] ];

        $endpoint = 'http://www.bugsnapper.com/';
        $endpoint = env( 'BUGSNAPPER_ENDPOINT', $endpoint ) . 'api/v0.1/report';

        $context = stream_context_create( $params );
        
        if ( function_exists( 'file_get_contents' ) ) {

            $resource = file_get_contents( $endpoint, false, $context );

        } elseif ( function_exists( 'fopen') ) {

            $resource = fopen( $endpoint, 'rb', false, $context );

        }

        $resource = @json_decode( $resource );

        if ( $resource && !is_array( $resource ) ) $resource = @json_decode( $resource );

        if ( is_object( $resource ) ) $resource = (array) $resource;

        if ( !is_array( $resource ) ) $resource = [];

        $resource['class'] = $class;
        $resource['string'] = $string;
        $resource['description'] = $description;

        Config::set( 'bugsnapper_response', $resource );

        if ( $class == 'FatalThrowableError' ) {

            abort( 500 );

        }

    }

    function arg( $object, $key, $default = null ) {

        try {

            if ( !is_array( $object ) ) $object = (array) $object;

        } catch ( Exception $e ) {

            return $default;

        }

        if ( is_array( $object ) ) {

            if ( !empty( $object[$key] ) ) return $object[$key];

        }

        return $default;

    }
    
}
