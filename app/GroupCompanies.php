<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupCompanies extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'name',
        'location',
        'regno',
        'relation',
        'networth'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
