<?php

namespace App;

use Carbon\Carbon;
use \App\Model;
use Illuminate\Support\Facades\DB;

class Cases extends Model
{
  
  protected $guarded = ['id'];
  protected $table = "test_cases";

}
