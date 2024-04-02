<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStatusRequest extends FormRequest
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
            'flage_id' => 'required',
            'approval_dt' => 'required',
            'remarks' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'flage_id.required' => 'Please Choose One',
            'approval_dt.required' => 'Please Select Approval Date',
            'remarks.required' => 'Please Fill Withdrawn'
        ];
    }
}
