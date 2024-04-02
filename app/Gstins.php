<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gstins extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'gstin',
        'add'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
