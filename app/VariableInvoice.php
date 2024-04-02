<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariableInvoice extends Model
{
    protected $table = 'variable_invoice';

    protected $fillable = [
        'id',
        'schedular_mail_claimvariable_id',
        'doc_upload_id',
        'invoice_amt',
        'invoice_date',
        'created_at',
        'updated_at',

    ];
}
