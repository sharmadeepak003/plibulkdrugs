<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialProgress extends Model
{
    protected $table = 'financial_progress';
    protected $fillable = [
        'id',
        'qrr_id',
        'bprevExpense',
        'bcurrExpense',
        'pprevExpense',
        'pcurrExpense',
        'lprevExpense',
        'lcurrExpense',
        'eprevExpense',
        'ecurrExpense',
        'rdprevExpense',
        'rdcurrExpense',
        'efprevExpense',
        'efcurrExpense',
        'solidprevExpense',
        'solidcurrExpense',
        'hprevExpense',
        'hcurrExpense',
        'wsprevExpense',
        'wscurrExpense',
        'rwprevExpense',
        'rwcurrExpense',
        'swprevExpense',
        'swcurrExpense',
        'dmprevExpense',
        'dmcurrExpense',
        'caprevExpense',
        'cacurrExpense',
        'coprevExpense',
        'cocurrExpense',
        'boprevExpense',
        'bocurrExpense',
        'poprevExpense',
        'pocurrExpense',
        'stprevExpense',
        'stcurrExpense',
        'stmprevExpense',
        'stmcurrExpense',
        'misprevExpense',
        'miscurrExpense',
        'totprevExpense',
        'totcurrExpense','created_by',
    ];
}
