<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimBreakupAssest extends Model
{
    protected $table = 'claim_breakup_assest';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'inv_prt_id',
        'total_del_dis_sol',
        'consi_for_pli',
        'not_consi_for_pli'
    ];
}
