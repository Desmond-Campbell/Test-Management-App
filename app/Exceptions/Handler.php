<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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

            header( "content-type: text/plain" );

            $string = $exception->__toString();
                $lines = explode( "\n", $string );
                    $desc_lines = explode( "\\", explode( ":", $lines[0] )[0] );
                    $class = $desc_lines[count( $desc_lines ) - 1]; 
            $code_line_n = 0;
            $error = [];
            
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
            
            $error['description'] = $lines[0];
            $error['code'] = $exception->getCode();
            $error['line'] = $exception->getLine();
            $error['message'] = $exception->getMessage();
            $error['class'] = $class;
            $error['codeline'] = $code_line_n;
            $error['path'] = $exception->getFile();
            $error['extract'] = $extract;
            $error['server'] = $_SERVER;
            $error['get'] = $_GET;
            $error['post'] = $_POST;
            $error['request'] = $_REQUEST;
            $error['cookie'] = $_COOKIE;
            $error['environment'] = env('APP_ENV');
            $error['debug'] = env('APP_DEBUG');
            $error['string'] = $string;

            print_r( $error );

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
