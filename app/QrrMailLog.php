<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrrMailLog extends Model
{
    protected $table='qrr_mail_log';
    protected $fillable = [
        'id',
        'app_id',
        'app_no',
        'qtr_id',
        'user_id',
        'user_name',
        'user_email',
        'product',
        'admin_id',
        'admin_name',
        'send_mail_date',
        'cc_email',
        'email_subject',
        'status',
        'created_at',
        'updated_at',
    ];
}
