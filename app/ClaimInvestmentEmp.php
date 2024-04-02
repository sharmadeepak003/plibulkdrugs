<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimInvestmentEmp extends Model
{
    protected $table = 'claim_investment_employment';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'on_roll_labor',
        'no_of_emp',
        'on_roll_contr',
        'total_emp',
        'apprentice',
        'created_at',
        'updated_at',
        'qrr_labor',
        'qrr_emp',
        'qrr_contr',
        'qrr_apprentice',
        'qrr_total_emp',
        'diff_labor',
        'diff_emp',
        'diff_cont',
        'diff_app',
        'diff_total_emp',
        'difference_labor',
        'difference_emp',
        'difference_con',
        'difference_app'
    ];
}
