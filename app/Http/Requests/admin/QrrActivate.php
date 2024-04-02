<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QrrActivate extends FormRequest
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
            'month' => 'required',
            'year' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'month.required' => 'This field is required',
            'year.required' => 'This field is required',
            'status.required' => 'This field is required',
        ];
    }
}
