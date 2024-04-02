<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AuthorizedPersonUpload extends Model
{
    

    protected $table = 'authorized_doc_mapping';
    protected $fillable = [
        'id',
        'user_id',
        'doc_id',
        'upload_id',
        'created_at',
        'updated_at',
	    'change_type',
        'upload_doc_id',
    ];
}
