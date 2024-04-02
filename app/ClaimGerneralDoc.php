<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimGerneralDoc extends Model
{
    protected $table = 'claim_gerneral_doc_detail';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'period',
        'from_dt',
        'to_dt',
        'prt_id',
        'doc_id',
        'upload_id',
        'response',
        'section'
    ];
}
