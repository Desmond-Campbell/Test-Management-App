<?php

namespace App;

use Carbon\Carbon;
use App\Model;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Projects extends Model
{
  
  protected $guarded = ['id'];
  protected $table = "projects";

}
