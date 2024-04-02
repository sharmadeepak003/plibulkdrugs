<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimProjectDetQues4 extends Model
{
    protected $table = 'claim_project_det_que4';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'question_id',
        'type_pm',
        'impot_dom',
        'residual_life',
        'capitalized_value',
        'value_by_ce',
        'value_custom_rule',
        'eligibilty_criteria',
        'created_at',
        'updated_at'
    ];
}
