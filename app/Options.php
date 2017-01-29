<?php

namespace App;

use \App\Model;

class Options extends Model
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
    protected $table = "general_options";

    public static function set($key, $value)
    {
        $data = [ 'option_key' => $key, 'option_value' => $value ];

        return self::updateOrCreate(['option_key' => $key], $data);
    }

    public static function stepUp($key)
    {
        return self::step($key, 1);
    }

    public static function step($key, $value)
    {
        $option = self::where('option_key', $key)->first();
        $value = 0;

        if ($option) {
            $value = intval($option->option_value);
        }

        return self::set($key, $value + 1);
    }
    
    public static function get_raw($key)
    {
        return self::where('option_key', $key)->first();
    }

    public static function get($key, $default = '')
    {
        $option = self::get_raw($key);

        if ($option) {
            return $option->option_value;
        } else {
            return $default;
        }
    }

    public static function kill($key)
    {
        return self::where( 'option_key', $key )->delete();
    }
    
}
