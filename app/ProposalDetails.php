<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalDetails extends Model
{
    protected $table = 'proposal_details';
    protected $fillable = [
        'id',
        'app_id',
        'prop_man_add',
        'prop_man_det',
        'exst_man_add',
        'prod_date',
        'remarks',
        'changes_by',
        'changes_at',
        'scod_doc_id','scod_upload_id'
    ];
}
