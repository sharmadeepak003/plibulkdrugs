<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DvaBreakdownSer extends Model
{
    protected $table = 'dva_breakdown_ser';
    protected $fillable = [
        'id',
        'qrr_id',
            'serrparticulars',
            'serrcountry',
            'serrquantity', 
            'serramount', 'created_by',
    ];
}
