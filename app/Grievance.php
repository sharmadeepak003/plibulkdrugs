<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grievance extends Model
{
    protected $table = 'grievances';

    protected $fillable = [
        'id',
        'name',
        'designation',
        'email',
        'mobile',
        'compliant_det',
        'complaint_doc',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'complaint_doc' => 'array',
    ];
}
