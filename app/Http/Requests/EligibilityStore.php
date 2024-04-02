<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EligibilityStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'greenfield' => 'required',
            'bankrupt' => 'required',
            'networth' => 'required|numeric',
            'group.*.name' => 'required',
            'group.*.location' => 'required',
            'group.*.regno' => 'required',
            'group.*.relation' => 'required',
            'group.*.networth' => 'required|numeric',
            'dva' => 'required|numeric',
            'ut_audit' => 'required',
           // 'ut_sales' => 'required',
            'ut_integrity' => 'required',
            'payment' => 'required',
            'date' => 'required_if:payment,Y|nullable|date',
            'urn' => 'required_if:payment,Y',
            'bank_name' => 'required_if:payment,Y',
            'amount' => 'required_if:payment,Y|nullable|numeric',
        ];
    }
}
