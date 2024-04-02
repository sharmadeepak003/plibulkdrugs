<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentUploads extends Model
{
    protected $fillable = ['app_id', 'doc_id', 'user_id','file_name','mime','file_size','remarks','created_by','uploaded_by'];
    protected $binaries = ['uploaded_file'];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
