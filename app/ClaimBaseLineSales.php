<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimBaseLineSales extends Model
{
    protected $table = 'claim_baseline_sales';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'dom_qty',
        'dom_sales',
        'exp_qty',
        'exp_sales',
        'created_at',
        'updated_at'
    ];
}
