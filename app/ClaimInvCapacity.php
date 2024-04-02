<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimInvCapacity extends Model
{
    protected $table = 'claim_inv_annual_production_capcity';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'product',
        'capacity_proposed',
        'capacity_achieved',
        'date_of_commission',
    ];
}
