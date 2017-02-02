<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Steps extends Model
{
  
  protected $guarded = ['id'];
  protected $table = "test_steps";

}
