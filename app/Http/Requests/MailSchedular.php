<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailSchedular extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'quarter' => 'required',
           'fyear'=>'required',
           'formFile'=>'required|mimes:pdf|max:20480',
           'invoiceAmount'=>'required',
           'invoiceDate'=>'required',
          
        ];  
    }
    
    
    public function messages()
    {
        return [
            'quarter.required' =>'Quater Field is Required.',
            'fyear.required' =>'Financial Year Field is Required.',
            'formFile.required' =>'Document upload Field is Required.',
            'invoiceAmount.required' =>'Invoice Amount Field is Required.',
            'invoiceDate.required' =>'Invoice Date Field is Required.',
            
        ];
    }
}
