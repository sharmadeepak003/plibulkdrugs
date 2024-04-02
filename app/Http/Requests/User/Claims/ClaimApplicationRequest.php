<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimApplicationRequest extends FormRequest
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
            'claim_period'=>'required',
            'quarterly_claim_empty'=>'required',
            'incentive[0]product_name'=>'required',
            'fy'=>'required',
            'loc.*.state'=>'required',
            'loc.*.city'=>'required',
            'loc.*.pincode'=>'required|max:6|min:6',
            'value.*'=>'required',
            'firm_name'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'appt_date'=>'required',
            'appt_valid'=>'required',
            'cert_detail'=>'required',
            'sa_date'=>'required',
            'ques[0]'=>'required',
            'udin'=>'required|regex:/^[0-9]{8}[A-Z]{6}[0-9]{4}$/',
            'partner_name'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'partner_cont_no'=>'required|numeric|min:0|max:9999999999|regex:/^[0-9]{10}$/',
            'reason_date'=>'required_if:value[0],Y',
            'reason_shareholding'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'shareholding.*.new_sh_name'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'shareholding.*.new_sh_eq_share'=>'required_if:value[0],Y|integer|min:0',
            'shareholding.*.new_sh_per'=>'required_if:value[0],Y',
            'ques[2]'=>'required',
            'shareHoldingPattern.*.doc'=>'required_if:value[2],Y|mimes:pdf|max:20480',
            'sa_email'=>'required|regex:/(.+)@(.+)\.(.+)/i',
            'applicant_data.*.hsn'=>'required|max:8|min:0|regex:/^[0-9]{8}$/',
            'applicant_data.*.committted_capacity'=>'required',
            'applicant_data.*.quoted_sales'=>'required|min:0',
            'applicant_data.*.inc_from_date'=>'required',
            'applicant_data.*.inc_to_date'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'claim_period'=>'This field is required',
            'loc.*.addr.required'=>'This field is required',
            'loc.*.state.required'=>'This field is required',
            'loc.*.city.required'=>'This field is required',
            'partner_name.required' => 'This field is required',
            'firm_name.required' => 'This field is required',
            'cert_detail.required' => 'This field is required',
            'ques[0].required'=>'This field is required',
            'applicant_data.*.hsn.required' => 'This field is required and fill 8 digit numeric Code.',
            'applicant_data.*.committted_capacity.required'=>'This field is required',
            'applicant_data.*.quoted_sales.required'=>'This field is required',
            'firm_name.required'=>'This field is required',
            'appt_date.required'=>'This field is required',
            'appt_valid.required'=>'This field is required',
            'cert_detail.required'=>'This field is required',
            'sa_date.required'=>'This field is required',
            'udin.required'=>'This field is required and UDIN Should be start 8 numeric,6 Alpha and 4 numeric like 00000000XXXXXX0000',
            'shareHoldingPattern.*.mimes'=>'File must be pdf and Less than 20MB.',
            'reason_shareholding.required'=>'This field is required',
            'shareholding.*.new_sh_name.required'=>'This field is required',
            'shareholding.*.new_sh_eq_share.required'=>'This field is required',
            'shareholding.*.new_sh_per.required'=>'This field is required',
            'sa_email.required'=>'This Email field is required',
            'ques[2].required'=>'This field is required',
            'loc.*.pincode.required'=>'This field is required and max digit 6.',
        ];
    }
}
