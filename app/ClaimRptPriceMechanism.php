<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimRptPriceMechanism extends Model
{
    protected $table='claim_rpt_price_mechanism';
    protected $fillable = [
        'app_id',
        'claim_id',
        'created_by',
        'prt_id',
        'upload_id',
        'que_id',
        'doc_id',
        'response',
        'created_at',
        'updated_at',
    ];
}
