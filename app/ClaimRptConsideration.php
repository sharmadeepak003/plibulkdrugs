<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimRptConsideration extends Model
{
    protected $table='claim_rpt_consideration';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'prt_id',
        'cd_doc_id',
        'cd_upload_id',
        'ceb_doc_id',
        'ceb_upload_id',
        'tax_doc_id',
        'tax_upload_id',
        'sub_response',
        'que_id',
        'response',
        'created_at',
        'updated_at',
    ];
}
