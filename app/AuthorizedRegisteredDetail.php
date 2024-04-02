<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AuthorizedRegisteredDetail extends Model
{
    
    protected $table = 'authorised_registered_detail';
    protected $fillable = [
        'app_id',
        'corp_add',
        'corp_state',
        'corp_city',
        'corp_pin',
        'new_corp_add',
        'new_corp_state',
        'new_corp_city',
        'new_corp_pin',
        'change_type',
        'created_by',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'created_at',
        'updated_at',
    ];
    
}
