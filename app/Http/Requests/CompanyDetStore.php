<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyDetStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'comp_const' => 'required',
            'prom.*.name' => 'required',
            'prom.*.shares' => 'required|numeric',
            'prom.*.per' => 'required|numeric',
            'prom.*.capital' => 'required|numeric',
            'other.*.name' => 'sometimes|nullable',
            'other.*.shares' => 'sometimes|nullable|numeric',
            'other.*.per' => 'sometimes|nullable|numeric',
            'other.*.capital' => 'sometimes|nullable|numeric',
            'bus_profile' => 'required|min:300|max:1000',
            'doi' => 'required|date',
            // 'website' => array('regex:/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/'),
            'listed' => 'required',
            'gstin.*.gstin' => array('required', 'regex:/^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/'),
            'gstin.*.add' => 'required',
            'corp_add' => 'required',
            'corp_state' => 'required',
            'corp_city' => 'required',
            'corp_pin' => 'required|numeric|digits:6',
            'aud.*.name' => array('required', 'string'),
            'aud.*.frn' => 'required|distinct',
            'aud.*.fy' => array('required', 'regex:/^([2]{1})([0]{1})([0-9]{2})([-]{1})([0-9]{2})$/'),
            'bankruptcy' => 'required',
            'rbi_default' => 'required',
            'wilful_default' => 'required',
            'sebi_barred' => 'required',
            'cibil_score' => 'required',
            'case_pend' => 'required',
            'externalcreditrating' =>'required',
            'rat.*.rating' => 'required_if:externalcreditrating,Y',
            'rat.*.name' => 'required_if:externalcreditrating,Y',
            'rat.*.date' => 'required_if:externalcreditrating,Y|date',
            'rat.*.validity' => 'required_if:externalcreditrating,Y|date',
            'topMan.*.name' => 'required',
            'topMan.*.email' => array('required', 'regex:/(.+)@(.+)\.(.+)/i'),
            'topMan.*.phone' => 'required|numeric|digits:10|distinct',
            'topMan.*.din' => 'required',
            'topMan.*.add' => 'required',
            'kmp.*.name' => 'required',
            'kmp.*.email' => array('required', 'regex:/(.+)@(.+)\.(.+)/i'),
            'kmp.*.phone' => 'required|numeric|digits:10|distinct',
            'kmp.*.pan_din' => 'required'
        ];
    }
}
