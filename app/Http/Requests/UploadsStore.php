<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadsStore extends FormRequest
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
            'filefactgate' => 'required|mimes:png,jpg,jpeg|max:20000',
            'filemainbuild' => 'required|mimes:png,jpg,jpeg|max:20000',
            'filereactor' => 'required|mimes:png,jpg,jpeg|max:20000',
            'filereactor2' => 'required|mimes:png,jpg,jpeg|max:20000',
            'fileutility' => 'required|mimes:png,jpg,jpeg|max:20000',
            'fileadditional' => 'sometimes|nullable|mimes:png,jpg,jpeg|max:20000',
            
        ];
    }
}
