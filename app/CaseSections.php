<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CaseSections extends Model
{
  
  protected $guarded = ['id'];
  protected $table = "case_sections";

}
