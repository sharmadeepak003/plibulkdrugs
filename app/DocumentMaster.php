<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentMaster extends Model
{
    protected $table = 'document_master';
    public $incrementing = false;
    protected $primaryKey = 'doc_id';

}
