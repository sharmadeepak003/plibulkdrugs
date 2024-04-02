<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues2 extends Model
{
    protected $table = 'claim_project_det_que2';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'name_of_lease',
        'amnout',
        'created_at',
        'updated_at'
    ];
}
