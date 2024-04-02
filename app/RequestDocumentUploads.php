<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RequestDocumentUploads extends Model
{
    // use LogsActivity;

    protected $table = 'request_document_uploads';
    protected $fillable = ['app_id', 'user_id','doc_id',
    'file_name','mime','file_size','created_by','uploaded_by','doc_date'];
    protected $binaries = ['uploaded_file'];
    protected static $logFillable = true;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
