<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadsUpdate extends FormRequest
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
            'filefactgate' => 'sometimes|nullable|mimes:png,jpg,jpeg|max:20000',
            'filemainbuild' => 'sometimes|nullable|mimes:png,jpg,jpeg|max:20000',
            'filereactor' => 'sometimes|nullable|mimes:png,jpg,jpeg|max:20000',
            'filereactor2' => 'sometimes|nullable|mimes:png,jpg,jpeg|max:20000',
            'fileutility' => 'sometimes|nullable|mimes:png,jpg,jpeg|max:20000',
            'fileadditional' => 'sometimes|nullable|mimes:png,jpg,jpeg|max:20000',
        ];
    }
}
