<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UndertakingStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'loa' => 'required|mimes:pdf|max:20000',
            'shareholdingCertificate' => 'required|mimes:pdf|max:10000',
            'bankruptcyUndertaking' => 'required|mimes:pdf|max:10000',
            'legalUndertaking' => 'required|mimes:pdf|max:10000',
            'networthCertificate' => 'required|mimes:pdf|max:10000',
            'auditConsenting' => 'required|mimes:pdf|max:10000',
            //'salesUndertaking' => 'sometimes|nullable|mimes:pdf|max:10000',
            'integrityPact' => 'required|mimes:pdf|max:10000',
            'businessProfile' => 'required|mimes:pdf|max:10000',
            'maoa' => 'required|mimes:pdf|max:10000',
            'coi' => 'required|mimes:pdf|max:10000',
            'pan' => 'required|mimes:pdf|max:10000',
            'gstin' => 'required|mimes:pdf|max:10000',
            'cibil' => 'sometimes|nullable|mimes:pdf|max:10000',
            'managementProfiles' => 'required|mimes:pdf|max:10000',
            'annualReports' => 'required|mimes:pdf|max:20000',
            'projectReport' => 'required|mimes:pdf|max:10000',
            'rdAchievement' => 'required_if:rnd_flag,Y|mimes:pdf|max:10000',
            'annualReportsfy1718' => 'sometimes|nullable|mimes:pdf|max:10000',
            'annualReportsfy1819' => 'sometimes|nullable|mimes:pdf|max:10000',
            'annualReportsfy1920' => 'sometimes|nullable|mimes:pdf|max:10000'
        ];
    }
}
