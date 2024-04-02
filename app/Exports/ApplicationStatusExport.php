<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


use DB;
use Carbon;

use App\ApplicationStatus;
use App\Applications;

class ApplicationStatusExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $apps=Applications::join('application_statuses','application_statuses.app_id','=','applications.id')
                          ->join('application_status_role','application_status_role.id','=','application_statuses.flage_id')
                          ->where('applications.status','S')
                          ->distinct()
                          ->get(['applications.id','applications.name','applications.app_no','applications.round','applications.product','applications.target_segment','application_status_role.flag_name']);
// dd($apps);

        return $apps;
    }

    public function headings(): array
    {
        return [
            'User Id',
            'Applicant Name',
            'Application No.',
            'Application Round No.',
            'Product Name',
            'Target Segment',
            'Application Status',
        ];
    }
}