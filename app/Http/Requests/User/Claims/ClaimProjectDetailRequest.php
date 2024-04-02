<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimProjectDetailRequest extends FormRequest
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
            'problem'=>'required',
            'pendingdispute_ques.*.nature_of_lease'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques.*.asset_description'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques.*.amt'=>'required_if:problem,Y|min:0',
            'problem2'=>'required',
            'pendingdispute_ques2.*.amt'=>'required_if:problem2,Y|min:0',
            'problem3'=>'required',
            'problem4'=>'required',
            'pendingdispute_ques4.*.type_pm'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques4.*.impot_dom'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques4.*.residual_life'=>'required|min:0',
            'pendingdispute_ques4.*.capitalized_value'=>'required|min:0',
            'pendingdispute_ques4.*.value_by_ce'=>'required|min:0',
            'pendingdispute_ques4.*.value_by_ce'=>'required|min:0',
            'pendingdispute_ques2.*.quest_particular'=>'required',
            'pendingdispute_ques4.*.eligibilty_criteria'=>'required|min:0',
            'pendingdispute_ques4.*.value_custom_rule'=>'required|min:0',
            'problem5'=>'required',
            'problem6'=>'required',
            'problem7'=>'required',
            'problem8'=>'required',
            'problem9'=>'required',
            'problem_file'=>'required|mimes:pdf|max:20480',
            'problem2_file'=>'required|mimes:pdf|max:20480',
            'problem4_file'=>'required|mimes:pdf|max:20480',
            'problem5_file'=>'required|mimes:pdf|max:20480',
            'problem6_file'=>'required|mimes:pdf|max:20480',
            'problem7_file'=>'required|mimes:pdf|max:20480',
            'problem8_file'=>'required|mimes:pdf|max:20480',
            'problem9_file'=>'required|mimes:pdf|max:20480',
            'problem10_file'=>'required|mimes:pdf|max:20480',
            'problem11_file'=>'required|mimes:pdf|max:20480',
            'pendingdispute_ques5.*.nature_of_utility'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques6.*.name_of_pli_scheme'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques7.*.nature_of_asset'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques7.*.year_dt'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques7.*.reason_of_discard'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques8.*.nature_of_asset'=>'required|regex:/^(?!\s)[\w\s-,.]*$/',
            'pendingdispute_ques8.*.nature_of_use'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques8[0][amt]'=>'required',
            'pendingdispute_ques7[0][amt]'=>'required',
            'pendingdispute_ques6[0][amt]'=>'required',
            'pendingdispute_ques5[0][intended_use]'=>'required',
            'pendingdispute_ques5[0][amt]'=>'required',
            'pendingdispute_ques[0][amt]'=>'required',
            
        ];
    }
    public function messages()
    {
        return[
            'pendingdispute_ques.*.nature_of_lease.required'=>'This field is Required.',
            'pendingdispute_ques.*.asset_description.required'=>'This field is Required.',
            'pendingdispute_ques.*.amt.required'=>'This field is Required.',
            'problem5.required'=>'This field is Required.',
            'problem6.required'=>'This field is Required.',
            'problem7.required'=>'This field is Required.',
            'problem8.required'=>'This field is Required.',
            'problem9.required'=>'This field is Required.',
            'problem_file.mimes'=>'File must be Pdf.',
            'problem2_file.mimes'=>'File must be Pdf.',
            'problem4_file.mimes'=>'File must be Pdf.',
            'problem5_file.mimes'=>'File must be Pdf.',
            'problem6_file.mimes'=>'File must be Pdf.',
            'problem7_file.mimes'=>'File must be Pdf.',
            'problem8_file.mimes'=>'File must be Pdf.',
            'problem9_file.mimes'=>'File must be Pdf.',
            'problem10_file.mimes'=>'File must be Pdf.',
            'problem11_file.mimes'=>'File must be Pdf.',
            'pendingdispute_ques4.*.type_pm.required'=>'This field is Required.',
            'pendingdispute_ques4.*.impot_dom.required'=>'This field is Required.',
            'pendingdispute_ques4.*.residual_life.required'=>'This field is Required.',
            'pendingdispute_ques4.*.capitalized_value.required'=>'This field is Required.',
            'pendingdispute_ques4.*.value_by_ce.required'=>'This field is Required.',
            'pendingdispute_ques4.*.value_by_ce.required'=>'This field is Required.',
            'pendingdispute_ques4.*.value_by_ce.required'=>'This field is Required.',
            'pendingdispute_ques4.*.eligibilty_criteria.required'=>'This field is Required.',
            'pendingdispute_ques4.*.value_custom_rule.required'=>'This field is Required.',
            'pendingdispute_ques5.*.nature_of_utility.required'=>'This field is Required.',
            'pendingdispute_ques6.*.name_of_pli_scheme.required'=>'This field is Required.',
            'pendingdispute_ques7.*.nature_of_asset.required'=>'This field is Required.',
            'pendingdispute_ques7.*.year_dt.required'=>'This field is Required.',
            'pendingdispute_ques7.*.reason_of_discard.required'=>'This field is Required.',
            'pendingdispute_ques8.*.nature_of_asset.required'=>'This field is Required.',
            'pendingdispute_ques8.*.nature_of_use.required'=>'This field is Required.',
            'pendingdispute_ques8[0][amt].required'=>'This field is Required.',
            'pendingdispute_ques7[0][amt].required'=>'This field is Required.',
            'pendingdispute_ques6[0][amt].required'=>'This field is Required.',
            'pendingdispute_ques5[0][intended_use].required'=>'This field is Required.',
            'pendingdispute_ques5[0][amt].required'=>'This field is Required.',
            'pendingdispute_ques[0][amt].required'=>'This field is Required.',
        ];
    }
}
