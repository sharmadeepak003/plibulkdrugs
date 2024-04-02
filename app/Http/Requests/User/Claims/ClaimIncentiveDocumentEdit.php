<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimIncentiveDocumentEdit extends FormRequest
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
            'data.*.pdf'=>'sometimes|mimes:pdf|max:20480',
            'data.*.excel' => 'sometimes|mimes:xls,xlsx|max:20480',
        ];
    }
    public function messages()
    {

        return [
            'data.*.pdf.mimes'=>'File must be PDF',
            'data.*.excel.mimes'=>'File must be Excel',
            'data.*.pdf.required'=>'File must be required',
            'data.*.excel.required'=>'File must be required',
            'data.*.pdf.max'=>'File size must be less than 20 MB',
            'data.*.excel.max'=>'File size must be less than 20 MB',

        ];
    }
}
