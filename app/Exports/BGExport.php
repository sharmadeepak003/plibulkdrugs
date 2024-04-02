<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use App\ApplicationMast;
use App\Applications;
use DB;
use Carbon;

class BGExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        // $bgview = DB::table('approved_apps_details as a')
        //     ->join('bg_trackers', 'bg_trackers.app_id', '=', 'a.id')
        //     ->orderBy('bg_trackers.id', 'DESC')
        //     ->where('bg_trackers.submit','Y')
        //     ->select(DB::raw("ROW_NUMBER() OVER(ORDER BY bg_trackers.id DESC) AS S_N"),'a.app_no','a.name','a.product','a.target_segment','a.round','bg_trackers.bg_no','bg_trackers.bg_amount','bg_trackers.bank_name','bg_trackers.branch_address','bg_trackers.issued_dt','bg_trackers.expiry_dt','bg_trackers.claim_dt',DB::raw("(case when bg_trackers.bg_status='RO' then 'RollOver' when bg_trackers.bg_status='RE' then 'Release' when bg_trackers.bg_status='EX' then 'Existing' when bg_trackers.bg_status='IN' then 'Invoke' else bg_trackers.bg_status end)as bg_status"))
        //     ->get();

            $bgview = DB::table('applications as a')
            ->join('bg_trackers', 'bg_trackers.app_id', '=', 'a.id')
            ->orderBy('bg_trackers.id', 'DESC')
            ->whereIn('bg_trackers.submit',array('Y','N'))
            ->orwhereIn('a.id',array(134,126,125))
            ->select(DB::raw("ROW_NUMBER() OVER(ORDER BY bg_trackers.id DESC) AS S_N"),'a.name','a.product','a.target_segment','a.round','bg_trackers.bg_no','bg_trackers.bg_amount',
            'bg_trackers.bank_name','bg_trackers.branch_address','bg_trackers.issued_dt','bg_trackers.expiry_dt','bg_trackers.claim_dt',
            DB::raw("(case when bg_trackers.bg_status='RO' then 'RollOver' when bg_trackers.bg_status='RE' then 'Release' when bg_trackers.bg_status='EX' then 'Existing' when bg_trackers.bg_status='IN' then 'Invoke' else bg_trackers.bg_status end)as bg_status"))
            ->get();

        return $bgview;
    }

    public function headings(): array
    {
        return [
            'S.No.',
            'Organization Name',
            'Product Name',
            'Target Segment',
            'Round',
            'BG Number',
            'BG Amount(in ₹)',
            'Bank Name',
            'Branch Address',
            'Issue Date',
            'Expiry Date',
            'Claim Date',
            'BG Status'
        ];
    }
}
