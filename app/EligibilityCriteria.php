<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EligibilityCriteria extends Model
{
    protected $table = 'eligibility_criteria';

    protected $fillable = [
        'id',
        'app_id',
        'greenfield',
        'bankrupt',
        'networth',
        'dva',
        'ut_audit',
        'ut_sales',
        'ut_integrity'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }


}
