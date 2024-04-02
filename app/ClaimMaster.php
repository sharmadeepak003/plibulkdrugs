<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimMaster extends Model
{
    protected $table = 'claims_masters';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'status'
    ];
}
