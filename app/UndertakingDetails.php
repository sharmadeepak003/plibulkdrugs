<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndertakingDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'doc_id'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }

    public function setDocIdAttribute($value)
    {
        $this->attributes['doc_id'] = implode(',', $value);
    }

    public function getDocIdAttribute($value)
    {
        return explode(',', $value);
    }

}
