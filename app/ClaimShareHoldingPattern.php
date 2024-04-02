<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimShareHoldingPattern extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'que_id',
        'new_shareholder_name',
        'new_equity_share',
        'new_percentage',
        'date_of_change',
        'remark',
        'created_at',
        'updated_at'
    ];
}
