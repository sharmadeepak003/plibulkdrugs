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

class ApplicationExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {

        // $apps = DB::table('application_mast')
        //         ->select('application_mast.app_no','users.name','eligible_products.product','application_mast.status','application_mast.created_at','application_mast.updated_at')
        //         ->join('users', 'users.id', '=', 'application_mast.created_by')
        //         ->join('eligible_products', 'eligible_products.id', '=', 'application_mast.eligible_product')
        //         ->get();

        $apps = Applications::where('applications.status','S')
        ->whereNotNull('applications.app_no')
        ->select('applications.app_no','applications.name','applications.product','applications.target_segment','applications.status','applications.round','applications.created_at','applications.updated_at')
        ->get();


        // foreach ($apps as $app) {
        //     //$ep = DB::table('eligible_products')->where('id', $app->eligible_product)->first();
        //     //$user = User::where('id',$app->created_by)->first();
        //     $apps->app_no = $app->app_no;
        //     $apps->name = $app->name;
        //     $apps->products = $app->product;
        //     $apps->status = $app->status;
        //     $apps->created = $app->created_at;
        //     $apps->submitted = $app->updated_at;
        // }
        // dd($apps);
        return $apps;
    }

    public function headings(): array
    {
        return [
            'Application No',
            'Organization Name',
            'Product Name',
            'Target Segment',
            'Round',
            'status',
            'Created At',
            'Submitted At'
        ];
    }
}