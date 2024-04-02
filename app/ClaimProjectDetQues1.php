<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues1 extends Model
{
    protected $table = 'claim_project_det_que1';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'name_of_lease',
        'asset_description',
        'amnout',
        'created_at',
        'updated_at'
    ];
}
