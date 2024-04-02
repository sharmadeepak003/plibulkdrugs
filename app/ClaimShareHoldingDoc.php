<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimShareHoldingDoc extends Model
{
    protected $table = 'claim_share_holding_docs';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'ques_id',
        'doc_id',
        'upload_id',
        'created_at',
        'updated_at'
    ];
}
