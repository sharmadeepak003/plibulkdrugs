<?php

namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use Carbon\Carbon;

class UsersExportRound1 implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
			$date = Carbon::parse('2020-11-31 23:59:59');
			$appl=DB::table('application_mast')->whereDate('created_at', '<', $date)->pluck('created_by')->toArray();
			
			//dd('hi');
			
			$user = User::query()
            ->whereNotIn('id', [68, 69, 70, 270,271,272,273,274,275,276,277])
			->whereIn('id', $appl)
            ->select(
				'id',
                'name',
                'email',
                'mobile',
                'type',
                'pan',
                'cin_llpin',
                'off_add',
                'off_city',
                'off_state',
                'off_pin',
                'existing_manufacturer',
                'business_desc',
                'applicant_desc',
                'eligible_product',
                'contact_person',
                'designation',
                'contact_add',
				'isapproved'
            );
		//dd($user);
        $users = User::query()
            ->whereNotIn('id', [68, 69, 70, 270,271,272,273,274,275,276,277])
			->whereDate('created_at', '<', $date)
            ->select(
				'id',
                'name',
                'email',
                'mobile',
                'type',
                'pan',
                'cin_llpin',
                'off_add',
                'off_city',
                'off_state',
                'off_pin',
                'existing_manufacturer',
                'business_desc',
                'applicant_desc',
                'eligible_product',
                'contact_person',
                'designation',
                'contact_add',
				'isapproved'
            )->orderBy('id')->union($user)->get();
		//dd($users);
        foreach ($users as $user) {
			//dd($user);
			// $us = User::find(278);
			// dd($us->hasRole('Applicant'));
			if($user->hasRole('Applicant'))
			{
				$user->status = 'Applicant';
			}elseif($user->isapproved=='N')
			{
				$user->status = 'Reject';
			}
			elseif($user->isapproved == 'Y')
			{
				$user->status = 'Pending';
			}
		//	dd($user);
			$prod = $user->eligible_product;
			$prod  = array_map('intval', $prod);
			//dd($prod);
            $ep = DB::table('eligible_products')->whereIn('id', $prod)->orderBy('id')->pluck('product')->implode(',');
            $user->products = $ep;
        }

        //dd($users);

        return $users;
    }

    public function headings(): array
    {
        return [
			'Id',
            'Name',
            'Email',
            'Mobile',
            'Business Constitution',
            'PAN',
            'CIN / LLPIN',
            'Office Add',
            'City',
            'State',
            'Pincode',
            'Existing Manufacturer',
            'Business Desc',
            'Applicant Desc',
            'Eligible Product',
            'Contact Person',
            'Designation',
            'Contact Add',
			'Status',
			'Final status',
            'Eligible Products'
        ];
    }
}
