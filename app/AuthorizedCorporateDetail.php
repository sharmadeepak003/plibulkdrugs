<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AuthorizedCorporateDetail extends Model
{
    
    protected $table = 'authorised_corporate_detail';
    protected $fillable = [
        'off_add',
        'off_state',
        'off_city',
        'off_pin',
        'new_off_add',
        'new_off_state',
        'new_off_city',
        'new_off_pin',
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
