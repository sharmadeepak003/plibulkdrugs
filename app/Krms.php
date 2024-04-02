<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krms extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'name',
        'coo',
        'man',
        'amt'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
