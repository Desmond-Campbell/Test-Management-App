<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequirementSections extends Model
{
  
  protected $guarded = ['id'];
  protected $table = "requirement_sections";

}
