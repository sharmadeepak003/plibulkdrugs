<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimCertificateDocDetail  extends Model
{
    protected $table = 'claim_certificate_doc_detail';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'prt_id',
        'pdf_doc_id',
        'pdf_upload_id',
        'excel_doc_id',
        'excel_upload_id'
    ];
}
