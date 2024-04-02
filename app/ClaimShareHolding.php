<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimShareHoldingDoc extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'que_id',
        'doc_id',
        'upload_id',
        'created_at',
        'updated_at'
    ];
}
