<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UndertakingUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'loa' => 'sometimes|nullable|mimes:pdf|max:20000',
            'shareholdingCertificate' => 'sometimes|nullable|mimes:pdf|max:10000',
            'bankruptcyUndertaking' => 'sometimes|nullable|mimes:pdf|max:10000',
            'legalUndertaking' => 'sometimes|nullable|mimes:pdf|max:10000',
            'networthCertificate' => 'sometimes|nullable|mimes:pdf|max:10000',
            'auditConsenting' => 'sometimes|nullable|mimes:pdf|max:10000',
            //'salesUndertaking' => 'sometimes|nullable|mimes:pdf|max:10000',
            'integrityPact' => 'sometimes|nullable|mimes:pdf|max:10000',
            'businessProfile' => 'sometimes|nullable|mimes:pdf|max:10000',
            'maoa' => 'sometimes|nullable|mimes:pdf|max:10000',
            'coi' => 'sometimes|nullable|mimes:pdf|max:10000',
            'pan' => 'sometimes|nullable|mimes:pdf|max:10000',
            'gstin' => 'sometimes|nullable|mimes:pdf|max:10000',
            'cibil' => 'sometimes|nullable|mimes:pdf|max:10000',
            'managementProfiles' => 'sometimes|nullable|mimes:pdf|max:10000',
            'annualReports' => 'sometimes|nullable|mimes:pdf|max:20000',
            'projectReport' => 'sometimes|nullable|mimes:pdf|max:10000',
            'rdAchievement' => 'required_if:rnd_flag,Y|mimes:pdf|max:10000',
            'annualReportsfy1718' => 'sometimes|nullable|mimes:pdf|max:10000',
            'annualReportsfy1819' => 'sometimes|nullable|mimes:pdf|max:10000',
            'annualReportsfy1920' => 'sometimes|nullable|mimes:pdf|max:10000'
        ];
    }
}
