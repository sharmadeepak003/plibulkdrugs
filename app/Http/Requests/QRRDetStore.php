<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QRRDetStore extends FormRequest
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
            'proCap' => 'required',
            'dateCO' => 'required',
            'eAmount' => 'required|numeric|min:0',
            'eStatus' => 'required',
            'eRemarks' => 'required',
            'dAmount' => 'required|numeric|min:0',
            'dStatus' => 'required',
            'dRemarks' => 'required',
            'iAmount' => 'required|numeric|min:0',
            'iStatus' => 'required',
            'iRemarks' => 'required',
            'tAmount' => 'required|numeric|min:0',
            'tStatus' => 'required',
            'tRemarks' => 'required',
            'mAddress' => 'required',
            'pd_capacity' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'proCap.required' => 'This field is required',
            'dateCO.required' => 'This field is required',
            'eAmount.required' => 'This field is required',
            'eStatus.required' => 'This field is required',
            'eRemarks.required' => 'This field is required',
            'dAmount.required' => 'This field is required',
            'dStatus.required' => 'This field is required',
            'dRemarks.required' => 'This field is required',
            'iAmount.required' => 'This field is required',
            'iStatus.required' => 'This field is required',
            'iRemarks.required' => 'This field is required',
            'tAmount.required' => 'This field is required',
            'tStatus.required' => 'This field is required',
            'tRemarks.required' => 'This field is required',
            'mAddress.required' => 'This field is required',
            'pd_capacity.required' => 'This field is required',
            
        ];
    }
}
