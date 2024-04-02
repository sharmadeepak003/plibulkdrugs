<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaddressStore extends FormRequest
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
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode'=>'required',
            'remarks' => 'required',
            'madd.*.product' => 'required',
            'madd.*.capacity' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
           
            'address.required' => 'This field is required',
            'state.required' => 'State field is required',
            'city.required' => 'City field is required',
            'pincode.required'=>'Pincode field is required',
            'remarks.required' => 'Remarks field is required',
            'madd.*.product.required' => 'Product field is required',
            'madd.*.capacity.required' => 'Capacity field is required',
        ];
    }
}
