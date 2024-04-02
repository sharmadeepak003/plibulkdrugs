<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesManufTsGoods extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'product_name',
        'ques_id',
        'related_party_name',
        'relationship',
        'quantity',
        'sales_ep',
        'created_at',
        'updated_at'
    ];
}