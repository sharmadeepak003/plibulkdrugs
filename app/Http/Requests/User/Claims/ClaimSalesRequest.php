<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimSalesRequest extends FormRequest
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
            'ep_approval_data.*.hsn'=>'required',
            'ep_approval_data.*.quoted_sales_price'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.dom_qnty'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.dom_sales'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.exp_qnty'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.exp_sales'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.cons_sales'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.cons_qnty'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.ts_total_qnty'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.ts_total_sales'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_qrr_data.*.ts_inc_sales'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_qrr_data.*.dom_reason_diff'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'ep_qrr_data.*.exp_reason_diff'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'ep_qrr_data.*.cons_reason_diff'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'breakup.*.particular_name'=>'required',
            'value[0]' =>'required',
            'value[1]' =>'required',
            'value[2]' =>'required',
            'value[3]' =>'required',
            'value[4]' =>'required',
            'value[5]' =>'required',
            'value[6]' =>'required',
            'amount_0[0]'=> 'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'amount_0[1]'=> 'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'breakup.*'=> 'required',
            'breakup.*.amount'=> 'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'breakup.*.particular'=>'required',
            'baselinesales.*.ts_dom_qnty' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'baselinesales.*.ts_dom_sales' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'baselinesales.*.ts_exp_qnty' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'baselinesales.*.ts_exp_sales' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ts_inc_sales_dtd' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ts_exp_salespromotion1' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ts_exp_royalty1' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ts_net_inc' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ts_threshold_sales' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_inc_sales_dtd' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_exp_salespromotion1' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_exp_royalty1' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_net_inc' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_inc_claim' =>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ts_goods.*.name_of_related_party'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'product_utilised_name'=>'required|regex:/^(?!\s)[\w\s-,.]*$/',
            'ts_goods.*.relationship'=>'required|regex:/^(?!\s)[A-Za-z \t]*$/i',
            'ts_goods.*.ts_sales'=>'required_if:value[3],Y',
            'ts_goods.*.ep_sales'=>'required_if:value[3],Y',
            'baseline_tick'=>'required',
            'SalesConsumption.*.upload'=>'required_if:value[4],Y|mimes:pdf|max:20480',
            'quantity_of_ep'=>'required',
            'cost_production'=>'required',
            'total_goods_amt'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'amount_0[2]'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'grand_total'=>'required',
            'unsettled.*.upload'=>'required_if:value[5],Y|mimes:pdf|max:20480',
            'creditnotes.*.upload'=>'required_if:value[6],N|mimes:pdf|max:20480',
            'salesconsideration.*.upload'=>'required_if:value[7],N|mimes:pdf|max:20480',
            'contractagreement.*.doc_upload'=>'required_if:value[8],Y|mimes:pdf|max:20480',
            'ep_approval_data.*.dom_incentive'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.exp_incentive'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'ep_approval_data.*.cons_incentive'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return[
            'ep_approval_data.*.hsn.required'=>'This field is required.',
            'ep_approval_data.*.quoted_sales_price.required'=>'This field is required.',
            'ep_approval_data.*.dom_qnty.required'=>'This field is required.',
            'ep_approval_data.*.dom_sales.required'=>'This field is required.',
            'ep_approval_data.*.exp_qnty.required'=>'This field is required.',
            'ep_approval_data.*.exp_sales.required'=>'This field is required.',
            'ep_approval_data.*.cons_sales.required'=>'This field is required.',
            'ep_approval_data.*.cons_qnty.required'=>'This field is required.',
            'ep_approval_data.*.ts_total_qnty.required'=>'This field is required.',
            'ep_approval_data.*.ts_total_sales.required'=>'This field is required.',
            'ep_qrr_data.*.ts_inc_sales.required'=>'This field is required.',
            'ep_qrr_data.*.dom_reason_diff.required'=>'This field is required.',
            'ep_qrr_data.*.exp_reason_diff.required'=>'This field is required.',
            'ep_qrr_data.*.cons_reason_diff.required'=>'This field is required.',
            'breakup.*.particular_name.required'=>'This field is required.',
            'value[0].required' =>'This field is required.',
            'value[1].required' =>'This field is required.',
            'value[2].required' =>'This field is required.',
            'value[3].required' =>'This field is required.',
            'value[4].required' =>'This field is required.',
            'value[5].required' =>'This field is required.',
            'value[6].required' =>'This field is required.',
            'amount_0[0].required'=>'This field is required.',
            'amount_0[1].required'=>'This field is required',
            'breakup.*.required'=>'This field is required.d',
            'breakup.*.amount.required'=>'This field is required',
            'breakup.*.particular.required'=>'This field is required.',
            'baselinesales.*.ts_dom_qnty.required' =>'This field is required',
            'baselinesales.*.ts_dom_sales.required' =>'This field is required',
            'baselinesales.*.ts_exp_qnty.required' =>'This field is required',
            'baselinesales.*.ts_exp_sales.required' =>'This field is required',
            'ts_inc_sales_dtd.required' =>'This field is required',
            'ts_exp_salespromotion1.required' =>'This field is required',
            'ts_exp_royalty1.required' =>'This field is required',
            'ts_net_inc.required' =>'This field is required',
            'ts_threshold_sales.required' =>'This field is required',
            'ep_inc_sales_dtd.required' =>'This field is required',
            'ep_exp_salespromotion1.required' =>'This field is required',
            'ep_exp_royalty1.required' =>'This field is required',
            'ep_net_inc.required' =>'This field is required',
            'ep_inc_claim.required' =>'This field is required',
            'ts_goods.*.name_of_related_party.required'=>'This field is required.',
            'product_utilised_name.required'=>'This field is required.',
            'ts_goods.*.relationship.required'=>'This field is required',
            'ts_goods.*.ts_sales.required'=>'This field is required',
            'ts_goods.*.ep_sales.required'=>'This field is required',
            'baseline_tick.required'=>'This field is required.',
            'SalesConsumption.*.upload.mimes'=>'File must be pdf and less than 20MB.',
            'quantity_of_ep.required'=>'This field is required',
            'cost_production.required'=>'This field is required',
            'total_goods_amt.required'=>'This field is required',
            'amount_0[2].required'=>'This field is required',
            'grand_total.required'=>'This field is required.',
            'unsettled.*.upload.mimes'=>'File must be pdf and less than 20MB.',
            'creditnotes.*.upload.mimes'=>'File must be pdf and less than 20MB.',
            'salesconsideration.*.upload.mimes'=>'File must be pdf and less than 20MB.',
            'contractagreement.*.doc_upload.mimes'=>'File must be pdf and less than 20MB.',
            'ep_approval_data.*.dom_incentive.required'=>'This field is required',
            'ep_approval_data.*.exp_incentive.required'=>'This field is required',
            'ep_approval_data.*.cons_incentive.required'=>'This field is required',
        ];
    }
}