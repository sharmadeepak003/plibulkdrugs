<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employments extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'fy20',
        'fy21',
        'fy22',
        'fy23',
        'fy24',
        'fy25',
        'fy26',
        'fy27',
        'fy28'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
