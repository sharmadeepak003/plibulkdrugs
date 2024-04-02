<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManufactureLocation extends Model
{
    protected $table = 'manufacture_location';

    protected $fillable = [
        'id',
        'qtr_id',
        'address',
        'state',
        'city',
        'pincode',
        'changes_by',
        'remarks',
        'app_id','type','created_by'
    ];
}
