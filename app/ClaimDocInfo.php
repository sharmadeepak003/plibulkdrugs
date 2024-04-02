<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimDocInfo extends Model
{
    protected $table = 'claim_doc_info_map';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'prt_id',
        'doc_id',
        'upload_id',
        'upload_id_excel',
        'section','file_name'
    ];
}
