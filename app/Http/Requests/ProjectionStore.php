<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectionStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'expfy20' => 'required|numeric',
            'expfy21' => 'required|numeric',
            'expfy22' => 'required|numeric',
            'expfy23' => 'required|numeric',
            'expfy24' => 'required|numeric',
            'expfy25' => 'required|numeric',
            'expfy26' => 'required|numeric',
            'expfy27' => 'required|numeric',
            'expfy28' => 'required|numeric',
            'domfy20' => 'required|numeric',
            'domfy21' => 'required|numeric',
            'domfy22' => 'required|numeric',
            'domfy23' => 'required|numeric',
            'domfy24' => 'required|numeric',
            'domfy25' => 'required|numeric',
            'domfy26' => 'required|numeric',
            'domfy27' => 'required|numeric',
            'domfy28' => 'required|numeric',
            'fy20' => 'required|numeric',
            'fy21' => 'required|numeric',
            'fy22' => 'required|numeric',
            'fy23' => 'required|numeric',
            'fy24' => 'required|numeric',
            'fy25' => 'required|numeric',
            'fy26' => 'required|numeric',
            'fy27' => 'required|numeric',
            'fy28' => 'required|numeric'
        ];
    }
}
