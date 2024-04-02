<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DvaStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'krm.*.name' => 'required',
            'krm.*.coo' => 'required',
            'krm.*.man' => 'required',
            'krm.*.amt' => 'required',
            'sal_exp' => 'required|numeric',
            'oth_exp' => 'required|numeric',
            'non_orig' => 'required|numeric',
            'tot_cost' => 'required|numeric',
            'non_orig_raw' => 'required|numeric',
            'non_orig_srv' => 'required|numeric',
            'tot_a' => 'required|numeric',
            'sales_rev' => 'required|numeric',
            'dva' => 'required|numeric',
            'man_dir' => 'required',
            'man_desig' => 'required',
        ];
    }
}
