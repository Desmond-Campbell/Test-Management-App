<?php

namespace App;

use \App\Model;

class Issues extends Model
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
    protected $table = "test_issues";
    
}
