<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimBreakupTotAddition extends Model
{
    protected $table = 'claim_breakup_total_additions';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'inv_prt_id',
        'total_add_bal',
        'consi_for_pli',
        'not_consi_for_pli',
        'reason'
    ];
}
