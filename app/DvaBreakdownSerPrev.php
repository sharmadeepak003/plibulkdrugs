<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DvaBreakdownSerPrev extends Model
{
    protected $table = 'dva_breakdown_ser_prev';
    protected $fillable = [
        'id',
        'qrr_id',    
            'serrprevparticulars',
            'serrprevcountry',
            'serrprevquantity', 
            'serrprevamount','created_by'  
    ];
}
