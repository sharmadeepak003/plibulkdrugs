<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ParkClaimVariableList extends Model
{
    protected $table = 'park_claimvariable_list';

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
