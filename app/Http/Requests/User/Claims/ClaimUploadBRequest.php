<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class ClaimUploadBRequest extends FormRequest
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
            'CerSADoc.*'=>'required|mimes:pdf|max:20480',
            'CerSaRegDoc.*'=>'required|mimes:pdf|max:20480',
            'CerCapexDoc.*'=>'required|mimes:pdf|max:20480',
            'CerCEDoc.*'=>'required|mimes:pdf|max:20480',
            'CerIntDoc.*'=>'required|mimes:pdf|max:20480',
            'CerIntePro.*'=>'required|mimes:pdf|max:20480',
            'CerCost.*'=>'required|mimes:pdf|max:20480',
            'CerSADocExcel.*'=>'required|mimes:xlsx,xls|max:20480',
            'CerSaRegDocExcel.*'=>'required|mimes:xlsx,xls|max:20480',
            'CerCapexDocExcel.*'=>'required|mimes:xlsx,xls|max:20480',
            'CerCEDocExcel.*'=>'required|mimes:xlsx,xls|max:20480',
            'CerIntDocExcel.*'=>'required|mimes:xlsx,xls|max:20480',
            'CerInteProExcel.*'=>'required|mimes:xlsx,xls|max:20480',
            'CerCostExcel.*'=>'required|mimes:xlsx,xls|max:20480',
            'CerCostDoc.*'=>'required|mimes:pdf|max:20480',
            'UnderDecDoc.*'=>'required|mimes:pdf|max:20480',
            'UnderDeviDoc.*'=>'required|mimes:pdf|max:20480',
            'UnderIntDoc.*'=>'required|mimes:pdf|max:20480',
            'UnderGoodsDoc.*'=>'required|mimes:pdf|max:20480',
            'UnderCertificateDoc.*'=>'required|mimes:pdf|max:20480',
            'UnderBoardDoc.*'=>'required|mimes:pdf|max:20480',
            'problem' => 'required',

        ];
    }
    public function messages()
    {

        return [
                'CerSADoc.*.required'=>'This filed is required',
                'CerSaRegDoc.*.required'=>'This filed is required',
                'CerCapexDoc.*.required'=>'This filed is required',
                'CerCEDoc.*.required'=>'This filed is required',
                'CerIntDoc.*.required'=>'This filed is required',
                'CerIntePro.*.required'=>'This filed is required',
                'CerCost.*.required'=>'This filed is required',
                'CerSADocExcel.*.required'=>'This filed is required',
                'CerSaRegDocExcel.*.required'=>'This filed is required',
                'CerCapexDocExcel.*.required'=>'This filed is required',
                'CerCEDocExcel.*.required'=>'This filed is required',
                'CerIntDocExcel.*.required'=>'This filed is required',
                'CerInteProExcel.*.required'=>'This filed is required',
                'CerCostExcel.*.required'=>'This filed is required',
                'CerCostDoc.*.required'=>'This filed is required',
                'UnderDecDoc.*.required'=>'This filed is required',
                'UnderDeviDoc.*.required'=>'This filed is required',
                'UnderIntDoc.*.required'=>'This filed is required',
                'UnderGoodsDoc.*.required'=>'This filed is required',
                'UnderCertificateDoc.*.required'=>'This filed is required',
                'UnderBoardDoc.*.required'=>'This filed is required',
                'CerSADoc.*.mimes'=>'File must be pdf',
                'CerSaRegDoc.*.mimes'=>'File must be pdf',
                'CerCapexDoc.*.mimes'=>'File must be pdf',
                'CerCEDoc.*.mimes'=>'File must be pdf',
                'CerIntDoc.*.mimes'=>'File must be pdf',
                'CerIntePro.*.mimes'=>'File must be pdf',
                'CerCost.*.mimes'=>'File must be pdf',
                'CerSADocExcel.*.mimes'=>'File must be excel',
                'CerSaRegDocExcel.*.mimes'=>'File must be excel',
                'CerCapexDocExcel.*.mimes'=>'File must be excel',
                'CerCEDocExcel.*.mimes'=>'File must be excel',
                'CerIntDocExcel.*.mimes'=>'File must be excel',
                'CerInteProExcel.*.mimes'=>'File must be excel',
                'CerCostDoc.*.mimes'=>'File must be pdf',
                'CerCostExcel.*.mimes'=>'File must be excel',
                'UnderDecDoc.*.mimes'=>'File must be pdf',
                'UnderDeviDoc.*.mimes'=>'File must be pdf',
                'UnderIntDoc.*.mimes'=>'File must be pdf',
                'UnderGoodsDoc.*.mimes'=>'File must be pdf',
                'UnderCertificateDoc.*.mimes'=>'File must be pdf',
                'UnderBoardDoc.*.mimes'=>'File must be pdf',

        ];
    }
}
