<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues8 extends Model
{
    protected $table = 'claim_project_det_que8';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'nature_of_asset',
        'amt',
        'nature_of_use',
        'created_at',
        'updated_at'
    ];
}
