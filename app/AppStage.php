<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppStage extends Model
{
    protected $table = 'app_stage';

    protected $fillable = [
        'id',
        'app_id',
        'stage',
        'status'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
