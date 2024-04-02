<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimRptCompanyAct extends Model
{
    protected $table='claim_rpt_company_act';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'authority',
        'approval_dt',
        'pricing',
        'tran_nature',
        'que_id',
        'response',
        'created_at',
        'updated_at',
    ];
}
