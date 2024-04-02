<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestDet extends Model
{
    protected $table = 'request_det';
    protected $fillable = [
        'id','req_id','msg','doc_id','created_by',
    ];
    protected $casts = [
        'doc_id' => 'json',
    ];
}
