<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimIncentiveDocument extends FormRequest
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
            'data.0.pdf'=>'required|mimes:pdf|max:20480',
            'data.1.pdf'=>'required|mimes:pdf|max:20480',
            'data.2.pdf'=>'required|mimes:pdf|max:20480',
            'data.3.pdf'=>'required|mimes:pdf|max:20480',
            'data.4.pdf'=>'required|mimes:pdf|max:20480',
            'data.5.pdf'=>'required|mimes:pdf|max:20480',
            'data.6.pdf'=>'mimes:pdf|max:20480',
            'data.7.pdf'=>'mimes:pdf|max:20480',
            'data.8.pdf'=>'mimes:pdf|max:20480',
            'data.10.pdf'=>'required|mimes:pdf|max:20480',
            'data.0.excel'=>'required|mimes:xls,xlsx|max:20480',
            'data.1.excel'=>'required|mimes:xls,xlsx|max:20480',
            'data.2.excel'=>'required|mimes:xls,xlsx|max:20480',
            'data.3.excel'=>'mimes:xls,xlsx|max:20480',
            'data.4.excel'=>'mimes:xls,xlsx|max:20480',
            'data.5.excel'=>'mimes:xls,xlsx|max:20480',
            'data.6.excel'=>'mimes:xls,xlsx|max:20480',
            'data.7.excel'=>'mimes:xls,xlsx|max:20480',
            'data.8.excel'=>'mimes:xls,xlsx|max:20480',
            'data.11.pdf' => 'mimes:pdf|max:20480',
            'data.12.pdf' => 'mimes:pdf|max:20480',
            'data.13.pdf' => 'mimes:pdf|max:20480',
            'data.14.pdf' => 'mimes:pdf|max:20480',
            'data.15.pdf' => 'mimes:pdf|max:20480',
            'data.11.excel' => 'mimes:xls,xlsx|max:20480',
            'data.12.excel' => 'mimes:xls,xlsx|max:20480',
            'data.13.excel' => 'mimes:xls,xlsx|max:20480',
            'data.14.excel' => 'mimes:xls,xlsx|max:20480',
            'data.15.excel' => 'mimes:xls,xlsx|max:20480',
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
