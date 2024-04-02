<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public static $rules = [
        'related_to' => 'required',
        'catsubtype' => 'required',
        'request_to' => 'required',
        'user_type' => 'required',
    //     'pan' => array('sometimes','nullable','required_if:category,1,2,3', 'regex:/^([A-Za-z]{5})([0-9]{4})([A-Za-z]{1})$/'),
    //     'dp_folio' => array('sometimes','nullable'),
    //     'emp_id' => array('sometimes','nullable','required_if:category,4'),
	// 'company_nm' => array('sometimes','nullable','required_if:category,3'),
    //     'desig' => array('sometimes','nullable','required_if:category,4'),
        'msg' => 'required|string|max:3000|min:10|regex:/^[^\s]+(\s*[^\s]+)*$/',
        'reqtype'=>'required',
	'reqdoc.*' => 'mimes:pdf,jpg,jpeg,png,doc,docx|max:10000'

    ];

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return[
            'category.required' => 'Category is required.',
            'catsubtype.required' => 'Subtype is required.',
            'pan.required_if' => 'PAN is required.',
            'emp_id.required_if' => 'Employee Code is required.',
	    'company_nm.required_if' => 'Company Name is required.',
            'desig.required_if' => 'Designation is required.',
            'msg.required' => 'Message is required.',
            'reqtype.required' => 'Type of Request is required.',
	    'reqdoc.*.max'=>'Max size allowed is 10 MB',
            'reqdoc.*.mimes'=>'Only PDF/DOC/JPG/PNG files are allowed'

        ];
    }

    public function rules(): array
    {
        return self::$rules;
    }
}
