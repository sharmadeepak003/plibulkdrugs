<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesEpQrr extends Model
{
    protected $table = 'claim_sales_ep_qrr';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'sales_per_qrr',
        'sales_for_incentive',
        'difference_reason',
        'created_at',
        'updated_at'
    ];
}