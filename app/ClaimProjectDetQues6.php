<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues6 extends Model
{
    protected $table = 'claim_project_det_que6';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'name_of_pli_scheme',
        'amt',
        'created_at',
        'updated_at'
    ];
}
