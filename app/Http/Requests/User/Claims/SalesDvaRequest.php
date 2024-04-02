<?php

namespace App\Http\Requests\User\Claims;

use Illuminate\Foundation\Http\FormRequest;

class SalesDvaRequest extends FormRequest
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
            'other_dva_data.*.amount'=>'required|numeric',
            'other_dva_data.*.quantity'=>'required|numeric',
            'dva_data.*.raw_material' => 'required|regex:/^(?!\s)[\w\s-.,^0-9]*$/',
            'dva_data.*.country_origin' => 'required',
            'dva_data.*.supplier_name' => 'required|regex:/^(?!\s)[\w\s-.,^0-9]*$/',
            'dva_data.*.quantity' => 'required|numeric',
            'dva_data.*.amount' => 'required|numeric',
            'dva_data.*.goods_amt' => 'required|numeric',
            'other_dva_data.*.goods_amt'=>'required|numeric',
            'ser_amount'=>'required',
            'ser_goods_amt'=>'required',
            
        ];
    }
    public function messages()
    {
        return[
            'other_dva_data.*.amount.required'=>'This field is required.',
            'other_dva_data.*.quantity.required'=>'This field is required.',
            'dva_data.*.raw_material.required'=>'This field is required.',
            'dva_data.*.country_origin.required'=>'required',
            'dva_data.*.supplier_name.required'=>'This field is required.',
            'dva_data.*.quantity.required'=>'This field is required.',
            'dva_data.*.amount.required'=>'This field is required.',
            'dva_data.*.goods_amt.required'=>'This field is required.',
            'other_dva_data.*.goods_amt.required'=>'This field is required.',
            'ser_amount.required'=>'This field is required.',
            'ser_goods_amt.required'=>'This field is required.',
           
        ];
    }
}
