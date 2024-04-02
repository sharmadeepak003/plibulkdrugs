<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagementProfiles extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'name',
        'email',
        'phone',
        'din',
        'add'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
