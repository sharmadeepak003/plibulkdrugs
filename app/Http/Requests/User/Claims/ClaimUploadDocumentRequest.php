<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimUploadDocumentRequest extends FormRequest
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
            'app_num.*.fy_statement'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'GenListDoc[1]'=>'required|mimes:pdf|max:20480',
            'GenFinancialDoc[1]'=>'required|mimes:xlsx,xls,csv|max:20480',
            'GenChqDoc.*.doc'=>'required',
            'GenChqDoc.*.bank_name'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'GenChqDoc.*.acc_name'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'GenChqDoc.*.acc_type'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'GenChqDoc.*.acc_no'=>'numeric|required|between:0,99999999999999999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'GenChqDoc.*.branch_name'=>'required|regex:/^(?!\s)[\w\s-]*$/',
            'GenChqDoc.*.ifsc_code'=>'required',
            'SalesPolicyDoc[1]'=>'required|mimes:pdf|max:20480',
            'SalesReconDoc[1]'=>'required|mimes:pdf|max:20480',
            'SalesAgreeDoc[1]'=>'required|mimes:pdf|max:20480',
            'RegulatoryITRDoc[1]'=>'required|mimes:pdf|max:20480',
            'RegulatoryAnnualDoc[1]'=>'required|mimes:pdf|max:20480',
            'RegulatoryGSTDoc[1]'=>'required|mimes:pdf|max:20480',
            'RegulatorySADoc[1]'=>'required|mimes:pdf|max:20480',
            'problem' => 'required',
            'GenListDocExcel[1]'=>'required|mimes:xlsx,xls,csv|max:20480',
            'SalesReconDocExcel[1]'=>'required|mimes:xlsx,xls,csv|max:20480',
            'RegulatoryAnnualDocExcel[1]'=>'required|mimes:xlsx,xls,csv|max:20480',
            'RegulatoryGSTDocExcel[1]'=>'required|mimes:xlsx,xls,csv|max:20480',
            'RegulatorySADocExcel[1]'=>'required|mimes:xlsx,xls,csv|max:20480',
            'GenFinDocPdf[1]'=>'required|mimes:pdf|max:20480',

        ];
    }

    public function messages()
    {

        return [
                'GenFinancialDoc[1].mimes'=>'File must be excel',
                'GenListDoc[1].mimes'=>'File must be pdf',
                'SalesPolicyDoc[1].mimes'=>'File must be pdf',
                'SalesReconDoc[1].mimes'=>'File must be pdf',
                'SalesAgreeDoc[1].mimes'=>'File must be pdf',
                'RegulatoryITRDoc[1].mimes'=>'File must be pdf',
                'RegulatoryAnnualDoc[1].mimes'=>'File must be pdf',
                'RegulatoryGSTDoc[1].mimes'=>'File must be pdf',
                'RegulatorySADoc[1].mimes'=>'File must be pdf',
                'GenListDocExcel[1].*.mimes'=>'File must be excel',
                'SalesReconDocExcel[1].*.mimes'=>'File must be excel',
                'RegulatoryAnnualDocExcel[1].*.mimes'=>'File must be excel',
                'RegulatoryGSTDocExcel[1].*.mimes'=>'File must be excel',
                'RegulatorySADocExcel[1].*.mimes'=>'File must be excel',    
        ];
    }
}
