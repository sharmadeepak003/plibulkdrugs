<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimStage extends Model
{
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
