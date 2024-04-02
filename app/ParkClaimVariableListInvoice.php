<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkClaimVariableListInvoice extends Model
{
    protected $table = 'park_claimvariable_list_invoice';

    protected $fillable = [
        'id',
        'parkClaimVariable_id',
        'doc_upload_id',
        'invoice_amt',
        'invoice_date',
        'created_at',
        'updated_at',

    ];
}
