<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesEpApproval extends Model
{
    protected $table = 'claim_sales_of_ep_approval';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'hsn',
        'cons_qnty',
        'cons_sales',
        'dom_qty',
        'dom_sales',
        'exp_qty',
        'exp_sales',
        'tot_qty',
        'tot_sales',
        'dva',
        'created_at',
        'updated_at'
    ];
}