<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'capacity',
        'price',
        'investment','changes_by','changes_at','remarks','cc_doc_id','cc_upload_id','qsp_doc_id','qsp_upload_id'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
