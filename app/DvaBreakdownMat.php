<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DvaBreakdownMat extends Model
{
    protected $table = 'dva_breakdown_mat';
    protected $fillable = [
        'id',
        'qrr_id',
            'mattparticulars', 
            'mattcountry',
            'mattquantity', 
            'mattamount', 'created_by'
    ];
}
