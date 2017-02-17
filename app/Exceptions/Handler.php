<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Errors;
use App\ErrorDetails;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        
        if ( env('ERROR_REPORTER') ) {

            // header( "content-type: text/plain" );

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
            $error_details['ip'] = arg( $_SERVER, 'REMOTE_ADDR', '' );
            $error_details['browser'] = arg( $_SERVER, 'HTTP_USER_AGENT', '' );
            $error_details['url'] = arg( $_SERVER, 'REQUEST_SCHEME', 'http' ) . '://'  . arg( $_SERVER, 'HTTP_HOST', '' ) . arg( $_SERVER, 'REQUEST_URI', '' );

            if ( !env( 'APP_DEBUG' ) ) {

                $database = env( 'DB_DATABASE' );
                $connection = [];
                $connection['driver'] = env( 'DB_CONNECTION' );
                $connection['host'] = env( 'DB_HOST' );
                $connection['port'] = env( 'DB_PORT' );
                $connection['database'] = $database;
                $connection['username'] = env( 'DB_USERNAME' );
                $connection['password'] = env( 'DB_PASSWORD' );

                Config::set( "database.connections.$database", $connection );
                Config::set( 'database.default', $database );

                // Find error
                $repeat = Errors::where( 'hash', $error['hash'] )->first();

                if ( !$repeat ) {

                    $subject = "$class at line $code_line_n in $path";

                    $body = "<h1>{$error['class']}</h1>

											<big><big>{$error['description']}</big></big>

											<h3>URL:</h3>
											<p>{$error_details['url']}</p>

											<h3>IP:</h3>
											<p>{$error_details['ip']}</p>

											<h3>Host:</h3>
											<p>" . @gethostbyaddr( $error_details['ip'] ) . "</p>

											<h3>Browser:</h3>
											<p>{$error_details['browser']}</p>

											<div>
											<pre>
												{$error_details['trace']}
											</pre>
											</div>";

                    $email = 'docampbell@gmail.com';

                    try {
                        $response = Mail::send('errors.email', [ 'subject' => $subject, 'email' => $email, 'error_details' => $error_details, 'error' => $error ], 
                              function ($message) use ($subject, $email, $error, $error_details ) {
    						            $message->to($email, null)->subject($subject);
    						        });
                    } catch( Exception $e ) {

                        die( '<h1>Server is too busy.</h1><p>A lot of people are connected right now and the server is very busy. Please try again in a few.</p>' );

                    }

                    $error_id = Errors::create( $error )->id;

                } else {

                    $error_id = $repeat->id;
                    $offences = $repeat->offences;
                    $repeat->update( [ 'offences' => $offences + 1 ] );
                    // ddd( $repeat );

                }

                $error_details['error_id'] = $error_id;

                $details_id = ErrorDetails::create( $error_details )->id;

                $reference_number = "$error_id-$details_id";

            } else {

                $reference_number = 0;

            }

            $template = $class == 'NotFoundHttpException' ? '404' : '500';

            print_r(View::make('errors.' . $template, compact( 'reference_number', 'description', 'string', 'class' ) )->render());

            die;

        }  
        
        parent::report($exception);
    
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
