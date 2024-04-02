<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchedularMailFixed extends Model
{
    protected $table = 'schedular_mail_fixed';

    protected $fillable = [
        'id',
        'financial_year',
        'qtr_id',
        'doc_upload_id',
        'invoice_amt',
        'invoice_date',
        'remark',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',

    ];
}
