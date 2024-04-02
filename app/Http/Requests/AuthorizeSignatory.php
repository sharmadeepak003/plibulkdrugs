<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;


class AuthorizeSignatory extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'authorise_user_name' => 'required',
            'designation' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'authorizeLetter' => 'required',
            'panCard' => 'required',
            'mobile'=>'required|numeric|min:0|max:9999999999|regex:/^[0-9]{10}$/',        ];
    }
}
