<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'prt_id',
        'info_prov',
        'dpr_ref',
        'remarks',
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
