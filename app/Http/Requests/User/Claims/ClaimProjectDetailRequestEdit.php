<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimProjectDetailRequestEdit extends FormRequest
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
            'pendingdispute_ques5.*.nature_of_utility'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques6.*.name_of_pli_scheme'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques7.*.nature_of_asset'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques7.*.year_dt'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques7.*.reason_of_discard'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques8.*.nature_of_asset'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute_ques8.*.nature_of_use'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            
        ];
    }
    public function messages()
    {
        return[
            'pendingdispute_ques.*.nature_of_lease.required'=>'This field is Required.',
            'pendingdispute_ques.*.asset_description.required'=>'This field is Required.',
            'pendingdispute_ques.*.amt.required'=>'This field is Required.',
            'pendingdispute_ques2.*.amt.required'=>'This field is Required.',
            'problem5.required'=>'This field is Required.',
            'problem6.required'=>'This field is Required.',
            'problem7.required'=>'This field is Required.',
            'problem8.required'=>'This field is Required.',
            'problem9.required'=>'This field is Required.',
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
        ];
    }
}
