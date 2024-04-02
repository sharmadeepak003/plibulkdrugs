<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimUploadCRequest extends FormRequest
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
            'Misc_1[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_2[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_3[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_4[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_5[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_6[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_7[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_8[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_9[doc]'=>'sometimes|mimes:pdf|max:20480',
            'Misc_10[doc]'=>'sometimes|mimes:pdf|max:20480',
        ];
    }
    public function messages()
    {

        return [
            'Misc_1.*.mimes'=>'File must be pdf',
            'Misc_2.*.mimes'=>'File must be pdf',
            'Misc_3.*.mimes'=>'File must be pdf',
            'Misc_4.*.mimes'=>'File must be pdf',
            'Misc_5.*.mimes'=>'File must be pdf',
            'Misc_6.*.mimes'=>'File must be pdf',
            'Misc_7.*.mimes'=>'File must be pdf',
            'Misc_8.*.mimes'=>'File must be pdf',
            'Misc_9.*.mimes'=>'File must be pdf',
            'Misc_10.*.mimes'=>'File must be pdf',

        ];
    }
}
