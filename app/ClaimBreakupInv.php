<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimBreakupInv extends Model
{
    protected $table = 'claim_breakup_investment';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'asset_type',
        'imp_party',
        'imp_not_party',
        'ind_party',
        'ind_not_party',
        'tot_party',
        'tot_not_party',
    ];
}
