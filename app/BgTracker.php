<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BgTracker extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'bank_name',
        'branch_address',
        'bg_no',
        'bg_amount',
        'issued_dt',
        'expiry_dt',
        'claim_dt',
        'bg_status',
        'remark',
        'submit',
        'bg_upload_id',
        'created_at',
        'updated_at',


    ];
}
