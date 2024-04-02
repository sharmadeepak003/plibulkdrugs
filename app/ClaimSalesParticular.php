<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesParticular extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'particular',
        'created_at',
        'updated_at'
    ];
}
