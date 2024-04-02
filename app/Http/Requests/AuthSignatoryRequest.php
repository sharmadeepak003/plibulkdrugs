<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthSignatoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'contact_person' => 'required',
            'designation' => 'required',
            'mobile' => 'required|numeric|digits:10|regex:/[6789]{1}[0-9]{9}/',
            'email'=> 'required|email',
            'authorizationLetter' => 'required|max:2000|mimes:pdf',     
        ];
    }
}
