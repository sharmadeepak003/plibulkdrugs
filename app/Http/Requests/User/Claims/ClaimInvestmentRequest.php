<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimInvestmentRequest extends FormRequest
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
            'from_date'=>'required',
            'to_date'=>'required',
            'manufact_loc'=>'required',
            'tot_inv'=>'numeric|required',
            'eligible_inv'=>'numeric|required',
            'capacity_data.*.capacity_proposed'=>'required',
            'capacity_data.*.capacity_achieved'=>'required',
            'capacity_data.*.date_of_commission'=>'required',
            'inv.*.other'=>'required',
            'inva.*.other'=>'required',
            'invaa.*.other'=>'required',
            'claim_period.*.period_fy'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'claim_period.*.investment_per_qrr'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'claim_period.*.actual_invest'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'claim_period.*.reason_any_change'=>'required',
            'claim_period.*.diff'=>'required',
            'manufact_loc.*.tot_inv'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'manufact_loc.*.eligible_inv'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'investment_data.*.asset_type'=>'required',
            'investment_data.*.imp_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'investment_data.*.imp_not_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'investment_data.*.ind_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'investment_data.*.ind_not_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'investment_data.*.tot_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'investment_data.*.tot_not_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'gt_imp_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'gt_imp_not_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'gt_ind_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'gt_ind_not_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'gt_tot_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'gt_tot_not_party'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'qrr_inv'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'submitted_inv'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'difference'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'reason_for_diff'=>'required',
            'inv.*.open_bal'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'inv.*.addition'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'inv.*.deletion'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'inv.*.close_bal'=>'numeric|required',
            'inva.*.PLI_Scheme'=>'required',
            'inva.*.reason_for_not_cons'=>'required',
            'on_roll_labor'=>'required',
            'on_roll_emp'=>'required',
            'on_roll_cont'=>'required',
            'on_roll_app'=>'required',
            'total_emp'=>'required',
            'difference_labor'=>'required',
            'difference_emp'=>'required',
            'difference_con'=>'required',
            'difference_app'=>'required',
            'invaa.*.PLI_Scheme_curr'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return[
            'from_date.required'=>'This field is required.',
            'to_date.required'=>'This field is required.',
            'manufact_loc.required'=>'This field is required.',
            'tot_inv.required'=>'This field is required.required',
            'eligible_inv.required'=>'This field is required.required',
            'capacity_data.*.capacity_proposed.required'=>'This field is required.',
            'capacity_data.*.capacity_achieved.required'=>'This field is required.',
            'capacity_data.*.date_of_commission.required'=>'This field is required.',
            'inv.*.other.required'=>'This field is required.',
            'inva.*.other.required'=>'This field is required.',
            'invaa.*.other.required'=>'This field is required.',
            'claim_period.*.period_fy.required'=>'This field is required.',
            'claim_period.*.investment_per_qrr.required'=>'This field is required.',
            'claim_period.*.actual_invest.required'=>'This field is required.',
            'claim_period.*.reason_any_change.required'=>'This field is required.',
            'claim_period.*.diff.required'=>'This field is required.',
            'manufact_loc.*.tot_inv.required'=>'This field is required.',
            'manufact_loc.*.eligible_inv.required'=>'This field is required.',
            'investment_data.*.asset_type.required'=>'This field is required.',
            'investment_data.*.imp_party.required'=>'This field is required.',
            'investment_data.*.imp_not_party.required'=>'This field is required.',
            'investment_data.*.ind_party.required'=>'This field is required.',
            'investment_data.*.ind_not_party.required'=>'This field is required.',
            'investment_data.*.tot_party.required'=>'This field is required.',
            'investment_data.*.tot_not_party.required'=>'This field is required.',
            'gt_imp_party.required'=>'This field is required.',
            'gt_imp_not_party.required'=>'This field is required.',
            'gt_ind_party.required'=>'This field is required.',
            'gt_ind_not_party.required'=>'This field is required.',
            'gt_tot_party.required'=>'This field is required.',
            'gt_tot_not_party.required'=>'This field is required.',
            'qrr_inv.required'=>'This field is required.',
            'submitted_inv.required'=>'This field is required.',
            'difference.required'=>'This field is required.',
            'reason_for_diff.required'=>'This field is required.',
            'inv.*.open_bal.required'=>'This field is required.',
            'inv.*.addition.required'=>'This field is required.',
            'inv.*.deletion.required'=>'This field is required.',
            'inv.*.close_bal.required'=>'This field is required',
            'inva.*.PLI_Scheme.required'=>'This field is required.',
            'inva.*.reason_for_not_cons.required'=>'This field is required.',
            'on_roll_labor.required'=>'This field is required.',
            'on_roll_emp.required'=>'This field is required.',
            'on_roll_cont.required'=>'This field is required.',
            'on_roll_app.required'=>'This field is required.',
            'total_emp.required'=>'This field is required.',
            'difference_labor.required'=>'This field is required.',
            'difference_emp.required'=>'This field is required.',
            'difference_con.required'=>'This field is required.',
            'difference_app.required'=>'This field is required.',
            'invaa.*.PLI_Scheme_curr.required'=>'This field is required.',
        ];
    }
}
