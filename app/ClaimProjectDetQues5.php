<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues5 extends Model
{
    protected $table = 'claim_project_det_que5';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'nature_of_utility',
        'intended_use',
        'amt',
        'created_at',
        'updated_at'
    ];
}
