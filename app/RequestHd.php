<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestHd extends Model
{
    protected $table = 'request_hd';
    protected $fillable = [
        'id','user_id','req_id','first_applied_dt','cat_id','cat_subtype',
        'pending_with','pending_since','raise_by_role',
        'status','close_dt','type_of_req','visible','visible_com','raised_for_user',
    ];
}
