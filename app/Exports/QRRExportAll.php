<?php

namespace App\Exports;

use App\User;
use DB;
use App\QRRMasters;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QRRExportAll implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $qtr;
        protected $type;


    function __construct($qtr,$type)
    {
        $this->qtr=$qtr;
        $this->type=$type;  
    }

    public function collection()
    {   
        if($this->type == 'A'){
            $apps = QRRMasters::join('approved_apps','approved_apps.id','=','qrr_master.app_id')
            ->join('eligible_products','eligible_products.id','=','approved_apps.eligible_product')
            ->join('users','approved_apps.created_by','=','users.id')
            ->select('approved_apps.app_no','users.name','eligible_products.product','qrr_master.status','qrr_master.created_at','qrr_master.updated_at')
            ->orderby('qrr_master.id')->get();

            foreach ($apps as $app) {
                $app->app_no=$app->app_no;
                $app->name = $app->name;
                $app->product = $app->product;
                if($app->status=='S')
                $app->status = 'Submitted';
                else 
                $app->status = 'Draft';
                $app->created_at = $app->created_at;
                $app->updated_at = $app->updated_at;
            }
            // return $apps;
        }else{
            $apps = DB::select("select aad.app_no,aad.name,aad.product ,aad.email,aad.mobile,aad.target_segment ,aad.round  from  approved_apps_details aad where is_normal_user(aad.user_id)=1 
            and NOT exists (select * from qrr_master where app_id in (aad.id) and qtr_id='$this->qtr' and status='S')");
            // dd($apps);
            // $apps = DB::table('approved_apps_details as aad')->whereRaw('is_normal_user(aa.user_id)=1')
            // ->whereNotExists(select * from qrr_master where app_id in (aad.id) and qtr_id='$this->qtr' and status='S');

            foreach ($apps as $app) {
                $app->app_no=$app->app_no;
                $app->name = $app->name;
                $app->product = $app->product;
                $app->email=$app->email;
                $app->mobile = $app->mobile;
                $app->target_segment = $app->target_segment;
                $app->round = $app->round;
            }
        }
      
        return collect($apps);
    }

    public function headings(): array
    {
        if($this->type == 'A'){

            $data = [
                'App No.',
                'Organization Name',
                'Product Name',
                'status',
                'Created At',
                'Submitted At'
            ];
            
        }else{
            $data = [
                'App No',
                'Organization Name',
                'Product Name',
                'Email',
                'Mobile',
                'Target Segment',
                'Round'
            ];
        }

        return $data;
    }
}
