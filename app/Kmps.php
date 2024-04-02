<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kmps extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'name',
        'email',
        'phone',
        'pan_din'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
