<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimBreakupInvBal extends Model
{
    protected $table = 'claim_breakup_inv_balancesheet';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'inv_prt_id',
        'opening_bal',
        'additions',
        'deletions',
        'closing_bal'
    ];
}
