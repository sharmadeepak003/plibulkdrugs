<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesReconciliation extends Model
{
    protected $table ='claim_sales_reconciliation';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'part_id',
        'amount',
        'ts_goods_total',
        'particular_name',
        'created_at',
        'updated_at'
    ];
}
