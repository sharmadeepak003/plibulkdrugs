<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DvaBreakdownMatPrev extends Model
{
    protected $table = 'dva_breakdown_mat_prev';
    protected $fillable = [
        'id',
        'qrr_id',
            'mattprevparticulars',
            'mattprevcountry',   
            'mattprevquantity',    
            'mattprevamount','created_by'    
    ];
}
