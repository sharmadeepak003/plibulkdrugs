<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BgTrackerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_name' => 'required',
            'branch_address' => 'required',
            'bg_no' => 'required',
            'bg_amount' => 'required|numeric',
            'issued_dt' => 'required|date',
            'expiry_dt' => 'required|date',
            'claim_dt' => 'sometimes|nullable|date',
            'bg_status'=>'required',
            'remark'=>'required',
            'bgDoc' => 'required|mimes:pdf|max:20000',
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required' => 'This field is required',
            'bank_adress.required' => 'This field is required',
            'bg_no.required' => 'This field is required',
            'bg_amount.required' => 'This field is required',
            'issued_date.required' => 'This field is required',
            'expiry_date.required' => 'This field is required',
            'claim_date.required' => 'This field is required',
            'Bg_rol.required' => 'This field is required',
            'Remark.required' => 'This field is required',
            'Bg_inv.required' => 'This field is required',
            'Remark1.required' => 'This field is required',
            'bgDoc.required' => 'This field is required',
        ];
    }
}
