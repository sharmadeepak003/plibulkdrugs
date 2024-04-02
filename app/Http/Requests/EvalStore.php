<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvalStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'capacity' => 'required',
           'price' => 'required|numeric',
           'investment' => 'required|numeric',
           'amt.*' => 'required|numeric',
           'prom.*' => 'required|numeric',
           'banks.*' => 'required|numeric',
           'others.*' => 'required|numeric'
        ];
    }
}
