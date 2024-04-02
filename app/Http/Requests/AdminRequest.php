<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public static $rules = [
                'msg' => 'required|string|max:3000',
                'status' => 'required',
    ];

    public function authorize()
    {
        return true;
    }



    public function rules(): array
    {
        return self::$rules;
    }
}
