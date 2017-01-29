<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    /**
     * Display timestamps in user's timezone
     */
    protected function asDateTime($value)
    {
        
        if ($value instanceof Carbon) {
            return $value;
        }

        $tz = Options::get( 'timezone_hours', '0' );

        $value = parent::asDateTime($value);

        return $value->addHours($tz);
    }
}
