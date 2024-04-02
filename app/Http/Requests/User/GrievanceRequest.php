<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class GrievanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public static $rules = [

        'name' => 'required',
        'designation' => 'required',
        'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        'mobile' => 'required|numeric|min:0|digits:10',
        'compliant_det' => 'required',
    ];

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return self::$rules;
    }

    public function messages()
    {
        return [

            'name.required' => 'Field Required',
            'designation.required' => 'Field Required',
            'email.required' => 'Field Required',
            'mobile.required' => 'Field Required',
            'compliant_det.required' => 'Field Required',
            'email.regex' => 'Email Must be in a Proper Format',
            'mobile.numeric' => 'Must Be a Number',
            'mobile.min' => 'Please enter positive value',
            'mobile.digits' => 'Number must be in 10 digit',

        ];
    }
}
