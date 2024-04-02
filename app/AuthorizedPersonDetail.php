<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AuthorizedPersonDetail extends Model
{
    
    protected $table = 'authorized_person_details';
    protected $fillable = [
        'user_id',
        'new_contact_person',
        'new_designation',
        'new_email',
        'new_mobile',
        'old_contact_person',
        'old_designation',
        'old_email',
        'old_mobile',
        'submitted_at',
        'status',
        'approved_at',
        'approved_by',
        'created_at',
        'updated_at',
        'change_type',
        'admin_created_by',
        'admin_created_at',
        'upload_id'
    ];
    

    protected $casts = [
        'upload_id'=>'array',
    ];
}
