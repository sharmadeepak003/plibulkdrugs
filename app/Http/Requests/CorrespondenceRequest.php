<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrespondenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'corres.*.raise_date' => 'required',
            'twentyperamount' => 'required',
            'twentyperdisbursementdate' => 'required',
            'date_of_submission_by_bene' => 'required',
            'percentage' => 'required',
            'corres.*.message' => 'required|max:255',
            'claim.*.remarks'=>'max:255',
            'claim.*.apprAmount' => 'numeric|max:99999',
            'corres.*.image' => 'max:20480',
        ];
    }

    public function messages()
    {
        return [
            'corres.*.raise_date.required' => 'Raise date is required',
            'corres.*.message.required' => 'The Field is required.',
            'corres.*.message.max' => 'Each message field must not exceed 255 characters.',
            'claim.*.remarks.max' => 'The field must not exceed 255 characters.',
            'claim.*.apprAmount.numeric' => 'The field must be a Numeric Number.',
            'claim.*.apprAmount.max' => 'The field should not greater than 5 digit',
            'corres.*.image.max' => 'The field should not greater than 20 MB',
            'twentyperamount' => 'The Field is required',
            'twentyperdisbursementdate' => 'The Field is required',
            'date_of_submission_by_bene' => 'The Field is required',
            'percentage' => 'The Field is required',
            
        ];
    }
}
