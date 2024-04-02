<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesContractAgreement extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'ques_id',
        'response',
        'upload_id',
        'doc_id'
    ];
}
