<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchedularMailList extends Model
{
    protected $table = 'schedular_mail_list';

    protected $fillable = [
        'id',
        'quater',
        'financial_year',
        'uploaded_by',
        'remark',
        'doc_upload_id',
    ];
}
