<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalsRequiredStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'approvals.*.reqapproval' => 'required',
            'approvals.*.concernbody' => 'required',
            'approvals.*.isapproval' => 'required',
            'approvals.*.dtvalidity' => 'date',
            'approvals.*.dtexpected' => 'date',
            'approvals.*.process' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'approvals.*.reqapproval.required' => 'This field is required',
            'approvals.*.concernbody.required' => 'This field is required',
            'approvals.*.isapproval.required' => 'This field is required',
            'approvals.*.dtvalidity.required' => 'This field is required',
            'approvals.*.dtexpected.required' => 'This field is required',
            'approvals.*.process.required' => 'This field is required',
        ];
    }
}
