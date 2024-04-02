<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinancialStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phar_dom_17' => 'required|numeric',
            'phar_dom_18' => 'required|numeric',
            'phar_dom_19' => 'required|numeric',
            'phar_exp_17' => 'required|numeric',
            'phar_exp_18' => 'required|numeric',
            'phar_exp_19' => 'required|numeric',
            'oth_dom_17' => 'required|numeric',
            'oth_dom_18' => 'required|numeric',
            'oth_dom_19' => 'required|numeric',
            'oth_exp_17' => 'required|numeric',
            'oth_exp_18' => 'required|numeric',
            'oth_exp_19' => 'required|numeric',
            'oth_inc_17' => 'required|numeric',
            'oth_inc_18' => 'required|numeric',
            'oth_inc_19' => 'required|numeric',
            'tot_rev_17' => 'required|numeric',
            'tot_rev_18' => 'required|numeric',
            'tot_rev_19' => 'required|numeric',
            'pbt17' => 'required|numeric',
            'pbt18' => 'required|numeric',
            'pbt19' => 'required|numeric',
            'pat17' => 'required|numeric',
            'pat18' => 'required|numeric',
            'pat19' => 'required|numeric',
            'sh_cap_17' => 'required|numeric',
            'sh_cap_18' => 'required|numeric',
            'sh_cap_19' => 'required|numeric',
            'eq_prom_17' => 'required|numeric',
            'eq_prom_18' => 'required|numeric',
            'eq_prom_19' => 'required|numeric',
            'eq_ind_17' => 'required|numeric',
            'eq_ind_18' => 'required|numeric',
            'eq_ind_19' => 'required|numeric',
            'eq_frn_17' => 'required|numeric',
            'eq_frn_18' => 'required|numeric',
            'eq_frn_19' => 'required|numeric',
            'eq_mult_17' => 'required|numeric',
            'eq_mult_18' => 'required|numeric',
            'eq_mult_19' => 'required|numeric',
            'eq_bank_17' => 'required|numeric',
            'eq_bank_18' => 'required|numeric',
            'eq_bank_19' => 'required|numeric',
            'int_acc_17' => 'required|numeric',
            'int_acc_18' => 'required|numeric',
            'int_acc_19' => 'required|numeric',
            'ln_prom_17' => 'required|numeric',
            'ln_prom_18' => 'required|numeric',
            'ln_prom_19' => 'required|numeric',
            'ln_ind_17' => 'required|numeric',
            'ln_ind_18' => 'required|numeric',
            'ln_ind_19' => 'required|numeric',
            'ln_frn_17' => 'required|numeric',
            'ln_frn_18' => 'required|numeric',
            'ln_frn_19' => 'required|numeric',
            'ln_mult_17' => 'required|numeric',
            'ln_mult_18' => 'required|numeric',
            'ln_mult_19' => 'required|numeric',
            'ln_bank_17' => 'required|numeric',
            'ln_bank_18' => 'required|numeric',
            'ln_bank_19' => 'required|numeric',
            'gr_ind_17' => 'required|numeric',
            'gr_ind_18' => 'required|numeric',
            'gr_ind_19' => 'required|numeric',
            'gr_frn_17' => 'required|numeric',
            'gr_frn_18' => 'required|numeric',
            'gr_frn_19' => 'required|numeric',
            'rnd_unit' => 'required',
            'rnd_rcnz' => 'sometimes|nullable',
            'rnd_inv_17' => 'required|numeric',
            'rnd_inv_18' => 'required|numeric',
            'rnd_inv_19' => 'required|numeric',
            'rnd_achv' => 'required',
        ];
    }
}
