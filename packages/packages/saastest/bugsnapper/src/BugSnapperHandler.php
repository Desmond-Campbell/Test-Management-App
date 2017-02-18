<?php

namespace SaasTest\BugSnapper;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as Handler;

class BugSnapperHandler extends Handler
{
    /**
     * Report or log an exception.
     *
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {

        if ( $this->shouldReport( $exception ) ) {
            
            if ( app()->bound( 'bugsnapper' ) ) {

                app( 'bugsnapper' )->report( $exception );

            }

        }

        return parent::report( $exception );

    }
}
