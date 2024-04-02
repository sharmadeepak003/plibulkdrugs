<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'prt_id',
        'amt'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
