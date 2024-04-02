<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class scod extends Model
{
    protected $table = 'scod';
    protected $fillable = [
        'id',
        'qtr_id','app_id',
        'committed_annual','commercial_op','created_by'
    ];
}
