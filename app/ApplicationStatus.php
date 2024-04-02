<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    protected $fillable = [
      'flage_id',
      'app_id',
      'created_by',
      'remarks',
      'old_approval_dt',
    ];
}
