<?php

namespace App\Exports;

use App\Qpr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
use Auth;

class ClaimIncentiveExport implements FromQuery, WithHeadings, ShouldAutoSize, WithEvents
{


    public function query()
    {

            $claim_incentive_query = DB::table('admin_claim_incentive')->select('scheme_name','company_name','claim_duration','claim_fy',
                'incentive_amount','claim_filing','expsubdate_reportinfo','expsubdate_reportmeitytopma','daysbetween_submandreport','daysbetween_dataandreport','status',
                'appr_date','remarks','appr_amount')->whereNull('system_remarks')->orderby('id','asc');
            

        return $claim_incentive_query;
    }

    public function headings(): array
    {
        $arr = [];

            $arr = ['Scheme Name','Company Name','Claim Duration','Financial Year (FY)','Incentive Amount(₹ in crores)','Date of Filing','Expected Date of Submission of Complete Information by Applicant','Expected Date of Submission of report to Ministry by PMA','No. of days between date of filing and submission of report to ministry','No. of days between receipt of complete information and submission of report to ministry','Status','Approval Date','Remarks','Approved Incentive Amount(₹ in crores)'];

        return $arr;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Apply borders to the entire sheet
                $event->sheet->getDelegate()->getStyle($event->sheet->calculateWorksheetDimension())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Apply gray background color to the header row
                $event->sheet->getDelegate()->getStyle('A1:N1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '808080', // Gray color code
                        ],
                    ],
                    'font' => [
                        'color' => [
                            'rgb' => 'FFFFFF', // White text color
                        ],
                    ],
                ]);
            },
        ];
    }
}
