<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues7 extends Model
{
    protected $table = 'claim_project_det_que7';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'nature_of_asset',
        'amt',
        'year_dt',
        'reason_of_discard',
        'created_at',
        'updated_at'
    ];
}
