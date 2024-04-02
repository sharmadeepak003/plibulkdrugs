<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimManufLoc extends Model
{
    protected $table = 'claim_manuf_locs';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'stages',
        'status',
        'created_at',
        'updated_at'
    ];
}
