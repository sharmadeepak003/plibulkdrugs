<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimDocProjectDet extends Model
{
    protected $table = 'claim_doc_project_det';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'doc_id',
        'upload_id',
        'section',
        'created_at',
        'updated_at'
    ];
}
