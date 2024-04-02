<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimRelatedPartyRequest extends FormRequest
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
            'app_num.*.prt_name'=>'required',
            'app_num.*.fy_statement'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'app_num.*.3CEB'=>'required',
            'app_num.*.cd_type'=>'required',
            'app_num.*.3CD'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'app_num.*.3CEB_A'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'company_data.*.authority'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'company_data.*.approval_dt'=>'required',
            'company_data.*.pricing'=>'required|min:0',
            'company_data.*.tran_nature'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute.*.year'=>'required|max:4',
            'pendingdispute.*.forum_name'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute.*.amt'=>'required|min:0',
            'pendingdispute.*.dispute'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'pendingdispute.*.doc'=>'required|mimes:pdf|max:20480',
            'consideration.*.cd'=>'required|mimes:pdf|max:20480',
            'consideration.*.consi_id'=>'required|mimes:pdf|max:20480',
            'consideration.*.tax'=>'required|mimes:pdf|max:20480',
            'problem[20]' => 'required',
            'problem[21]' => 'required',
            'problem[22]' => 'required',
            'problem[23]' => 'required',
           
        ];
    }

    public function messages()
    {

        return [
            'app_num.*.cd_type.required'=>'This Field is required.',
            'app_num.*.prt_name.required'=>'This Field is required.',
            'app_num.*.fy_statement.required'=>'This Field is required.',
            'app_num.*.3CEB.required'=>'This Field is required.',
            'app_num.*.3CD.required'=>'This Field is required.',
            'app_num.*.3CEB_A.required'=>'This Field is required.',
            'company_data.*.authority.required'=>'This Field is required.',
            'company_data.*.approval_dt.required'=>'This Field is required',
            'company_data.*.pricing.required'=>'This Field is required.',
            'company_data.*.tran_nature.required'=>'This Field is required',
            'pendingdispute.*.year.required'=>'This Field is required',
            'pendingdispute.*.forum_name.required'=>'This Field is required.',
            'pendingdispute.*.amt.required'=>'This Field is required',
            'pendingdispute.*.dispute.mimes'=>'This Field is mimes.',
            'pendingdispute.*.doc.mimes'=>'File must be File.',
            'consideration.*.cd.mimes'=>'File must be File.',
            'consideration.*.consi_id.mimes'=>'File must be File.',
            'consideration.*.tax.mimes'=>'File must be File.',
            'problem[20].required' => 'This Field is required',
            'problem[21].required' => 'This Field is required',
            'problem[22].required' => 'This Field is required',
            'problem[23].required' => 'This Field is required',
        ];
    }
}
