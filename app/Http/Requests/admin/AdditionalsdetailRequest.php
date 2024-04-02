<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalsDetailRequest extends FormRequest
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
            //revenue
            'expfy20' => 'required|numeric',
            'expfy21' => 'required|numeric',
            'expfy22' => 'required|numeric',
            'expfy23' => 'required|numeric',
            'expfy24' => 'required|numeric',
            'expfy25' => 'required|numeric',
            'expfy26' => 'required|numeric',
            'expfy27' => 'required|numeric',
            'expfy28' => 'required|numeric',
            'totalexp' => 'required|numeric',
            'domfy20' => 'required|numeric',
            'domfy21' => 'required|numeric',
            'domfy22' => 'required|numeric',
            'domfy23' => 'required|numeric',
            'domfy24' => 'required|numeric',
            'domfy25' => 'required|numeric',
            'domfy26' => 'required|numeric',
            'domfy27' => 'required|numeric',
            'domfy28' => 'required|numeric',
            'totaldom' => 'required|numeric',
            'revremark' => 'required',

            //Employment
            'empfy20' => 'required|numeric',
            'empfy21' => 'required|numeric',
            'empfy22' => 'required|numeric',
            'empfy23' => 'required|numeric',
            'empfy24' => 'required|numeric',
            'empfy25' => 'required|numeric',
            'empfy26' => 'required|numeric',
            'empfy27' => 'required|numeric',
            'empfy28' => 'required|numeric',
            'empremark' => 'required',
            'reason'    =>'required',
            'price' =>'required',
            'capacity'=>'required',
            'prod_date'=>'required',

            //commiited Investmetn
            'investment' => 'required|numeric',
            'invremark' => 'required',

            //Particular investment
            'val.*.amount' => 'required|numeric',
            'partremark' => 'required',

        ];
    }

    public function messages()
    {
        return [
            // Revenue
            'expfy20.required' => 'This filed is required',
            'expfy21.required' => 'This filed is required',
            'expfy22.required' => 'This filed is required',
            'expfy23.required' => 'This filed is required',
            'expfy24.required' => 'This filed is required',
            'expfy25.required' => 'This filed is required',
            'expfy26.required' => 'This filed is required',
            'expfy27.required' => 'This filed is required',
            'expfy28.required' => 'This filed is required',
            'totalexp.required' => 'This filed is required',
            'domfy20.required' => 'This filed is required',
            'domfy21.required' => 'This filed is required',
            'domfy22.required' => 'This filed is required',
            'domfy23.required' => 'This filed is required',
            'domfy24.required' => 'This filed is required',
            'domfy25.required' => 'This filed is required',
            'domfy26.required' => 'This filed is required',
            'domfy27.required' => 'This filed is required',
            'domfy28.required' => 'This filed is required',
            'totaldom.required' => 'This filed is required',
            'revremark.required'=> 'This filed is required',

            //Employment
            'empfy20.required' => 'This filed is required',
            'empfy21.required' => 'This filed is required',
            'empfy22.required' => 'This filed is required',
            'empfy23.required' => 'This filed is required',
            'empfy24.required' => 'This filed is required',
            'empfy25.required' => 'This filed is required',
            'empfy26.required' => 'This filed is required',
            'empfy27.required' => 'This filed is required',
            'empfy28.required' => 'This filed is required',
            'empremark.required' => 'This filed is required',

            //commiited Investmetn
            'investment.required' => 'This filed is required',
            'invremark.required'=> 'This filed is required',

            //Particular investment
            'val.*.amount.required' => 'This filed is required',
            'partremark.required'=> 'This filed is required',
            'reason.required'=> 'This filed is required',
            'price.required'=> 'This filed is required',
            'capacity.required'=> 'This filed is required',
            'prod_date.required'=> 'This filed is required',
        ];
    }
}
