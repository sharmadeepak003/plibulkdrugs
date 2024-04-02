<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncentiveDocMap extends Model
{
    protected $table = 'incetive_doc_map';
    public $incrementing = false;

    protected $fillable = [
        'id','claim_id','prt_id','pdf_upload_id','excel_upload_id','status','created_by','updated_by','created_at','updated_at','file_name'
    ];

}
