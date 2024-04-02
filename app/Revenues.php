<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revenues extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'expfy20',
        'expfy21',
        'expfy22',
        'expfy23',
        'expfy24',
        'expfy25',
        'expfy26',
        'expfy27',
        'expfy28',
        'domfy20',
        'domfy21',
        'domfy22',
        'domfy23',
        'domfy24',
        'domfy25',
        'domfy26',
        'domfy27',
        'domfy28'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
