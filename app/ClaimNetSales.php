<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimNetSales extends Model
{
    protected $table = 'claim_net_sales_ep';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'net_incremental_sales',
        'threshold_sales',
        'incentive_claim',
        'created_at',
        'updated_at'
    ];
}
