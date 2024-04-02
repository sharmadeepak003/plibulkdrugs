<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditors extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'name',
        'frn',
        'fy'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
