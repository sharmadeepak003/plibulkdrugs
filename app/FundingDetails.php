<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'prt_id',
        'prom',
        'banks',
        'others'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
