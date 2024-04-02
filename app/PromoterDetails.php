<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoterDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'name',
        'shares',
        'per',
        'capital',
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
