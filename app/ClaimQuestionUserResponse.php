<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimQuestionUserResponse extends Model
{
    protected $table = 'claim_question_user_responses';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'ques_id',
        'response',
        'created_at',
        'updated_at'
    ];
}
