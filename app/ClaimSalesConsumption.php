<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesConsumption extends Model
{
    protected $table = 'claim_sales_consumption';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'quantity_of_ep',
        'cost_production',
        'product_name_utilised',
        'response',
        'ques',
        'doc_id'
    ];
}
