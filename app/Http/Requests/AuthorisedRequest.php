<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorisedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'registeredletter' => 'required|mimes:pdf|max:20480',
            'authorizeLetter' => 'required|mimes:pdf|max:20480',
            'panCard' => 'required|mimes:pdf|max:20480',
            'corpletter' => 'required|mimes:pdf|max:20480',
            'corpProof' => 'required|mimes:pdf|max:20480',
            'registeredletter' => 'required|mimes:pdf|max:20480',
            'registeredProof' => 'required|mimes:pdf|max:20480',
            'authorise_user_name' => 'required',
            'designation' => 'required',
            'mobile'=>'required|numeric|min:0|max:9999999999|regex:/^[0-9]{10}$/',        ];
    }
}
