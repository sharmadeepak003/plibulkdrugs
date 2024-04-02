<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimOpenHistory extends Model
{
    protected $table = 'claim_open_history';
    protected $fillable = [
        'id',
        'claim_id',
        'app_id',
        'change_by',
        'satatus',
        'created_at',
        'updated_at',
    ];
}
