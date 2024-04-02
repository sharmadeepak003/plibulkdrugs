<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues3 extends Model
{
    protected $table = 'claim_project_det_que3';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'name_of_party',
        'address',
        'type_of_asset',
        'gross_value',
        'created_at',
        'updated_at'
    ];
}
