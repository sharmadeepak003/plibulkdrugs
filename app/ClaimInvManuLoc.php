<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimInvManuLoc extends Model
{
    protected $table='claim_invest_manuf_locs';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'address',
        'tot_investment_claim',
        'eligible_inv_pli',
    ];
}
