<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProposalStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'prop_man_add' => 'required',
           'prop_man_det' => 'required',
           'exst_man_add' => 'required',
           'prod_date' => 'required|date',
           'info_prov.*' => 'required'
        //    'dpr_ref.*' => 'required',
        //    'remarks.*' => 'required'
        ];
    }
}
