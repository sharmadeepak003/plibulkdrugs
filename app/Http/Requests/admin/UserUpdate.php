<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'userStatus' => 'required',
            'remarks' => array('required_if:userStatus,userInactive','min:3')
        ];
    }
}
