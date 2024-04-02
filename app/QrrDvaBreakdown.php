<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrrDvaBreakdown extends Model
{
    protected $table = 'qrr_dva_breakdown';
    protected $fillable = [
        'id',
        'qrr_id',
            'mattprevparticulars',
            'mattprevcountry',   
            'mattprevquantity',    
            'mattprevamount',    
            'serrprevparticulars',
            'serrprevcountry',
            'serrprevquantity', 
            'serrprevamount', 
            'mattcurrparticulars', 
            'mattcurrcountry',
            'mattcurrquantity', 
            'mattcurramount', 
            'serrcurrparticulars',
            'serrcurrcountry',
            'serrcurrquantity', 
            'serrcurramount', 
    ];
}
