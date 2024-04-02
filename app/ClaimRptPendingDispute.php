<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimRptPendingDispute extends Model
{
    protected $table='claim_rpt_pending_dispute';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'year',
        'forum_name',
        'amt',
        'que_id',
        'doc_id',
        'dispute',
        'prt_id',
        'upload_id',
        'response',
        'created_at',
        'updated_at',
    ];
}
