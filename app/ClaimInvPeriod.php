<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimInvPeriod extends Model
{
    protected $table = 'claim_inv_period';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'claim_period',
        'inv_as_qrr',
        'actual_inv',
        'diff',
        'reason_change',
    ];
}
