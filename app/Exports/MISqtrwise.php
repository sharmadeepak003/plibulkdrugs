<?php

namespace App\Exports;
use DB;
use \stdClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Arr;

class MISqtrwise implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

        protected $qtr;
        protected $data;


    function __construct($qtr,$data)
    {
        $this->qtr=$qtr;
        $this->data=$data;

        $qtrMaster=DB::table('qtr_master')->where('qtr_id',$this->qtr)->select('qtr_id','month','yr_short','fy')->first();

        $this->fy=$qtrMaster->fy;
    }

    public function collection()
    {
        $investment_data = DB::table('qrr_master as qm')
         ->join('financial_progress as fp', 'fp.qrr_id', '=', 'qm.id')
         ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
         ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
         ->join('qtr_master as qm2','qm2.qtr_id','=','qm.qtr_id')
         ->where('qm.status', 'S')
         ->orderBy('qm.app_id')
         ->get(['qm.id','aad.name','aad.target_segment','aad.product','ed.investment','fp.totcurrExpense','qm.app_id','qm.qtr_id', 'aad.app_no','qm2.start_month','qm2.month']);

        $scod_data = DB::table('qrr_master as qm')
         ->join('scod as s', 's.qrr_id', '=', 'qm.id')
         ->join('manufacture_location as ml', 'ml.app_id', '=', 'qm.app_id')
         ->join('manufacture_product_capacities as mpc', DB::raw('mpc.m_id :: INTEGER'), '=', 'ml.id')
         ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
         ->join('proposal_details as pd','pd.app_id','=','qm.app_id')
         ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
         ->join('qtr_master as qm2','qm2.qtr_id','=','qm.qtr_id')
         ->where('qm.status', 'S')
         ->where('ml.type', 'green')
         ->orderBy('qm.app_id')
         ->get(['qm.id', 'qm.app_id', 'qm.qtr_id','s.commercial_op','aad.app_no','aad.name','aad.product','aad.target_segment','ml.address','mpc.capacity','mpc.product as green_product','pd.prod_date','ed.investment','qm2.start_month','qm2.month']);

        $revenue_data = DB::table('qrr_master as qm')
         ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
         ->join('qrr_revenue as qr','qr.qrr_id','=','qm.id')
         ->join('qtr_master as qm2','qm2.qtr_id','=','qm.qtr_id')
         ->where('qm.status', 'S')
         ->orderBy('qm.app_id')
         ->get(['qm.id','qm.qtr_id','qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','qr.gcDomCurrQuantity','qr.gcDomCurrSales','qr.gcTotCurrSales','qr.gcExpCurrQuantity','qr.gcExpCurrSales','qr.gcCapCurrQuantity','qr.gcCapCurrSales','qm2.start_month','qm2.month']);

        $employment_data = DB::table('qrr_master as qm')
         ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
         ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
         ->join('greenfield_emp as ge','ge.qrr_id','=','qm.id')
         ->join('qtr_master as qm2','qm2.qtr_id','=','qm.qtr_id')
         ->where('qm.status', 'S')
         ->orderBy('qm.app_id')
         ->get(['qm.id','qm.qtr_id','qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment','ge.laborCurrNo','ge.empCurrNo','ge.conCurrNo','ge.appCurrNo','ge.totCurrNo','qm2.start_month','qm2.month']);

        $apps = DB::table('approved_apps')->whereNotNull('app_no')->pluck('id')->toArray();
        $qtrs = DB::table('qtr_master')->where('qtr_id', '<=',$this->qtr)->where('fy',$this->fy)->orderBy('qtr_id','DESC')->pluck('qtr_id')->toArray();

        foreach($apps as $key =>$app){
            foreach($qtrs as $k=>$qtr)
            {
            
                if($investment_data->where('app_id', $app)->where('qtr_id', $qtr)->first() &&
                $scod_data->where('app_id', $app)->where('qtr_id', $qtr)->first() &&
                $revenue_data->where('app_id', $app)->where('qtr_id', $qtr)->first() && $employment_data->where('app_id', $app)->where('qtr_id', $qtr)->first())
                {
                    $investment[] = $investment_data->where('app_id', $app)->where('qtr_id', $qtr)->first();                   
                    $scod[] = $scod_data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                    $revenue[] = $revenue_data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                    $employment[] = $employment_data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                    break;
                }
            }
        }
        if($this->data=='Investment')
        {
            $sno=1;
            foreach ($investment as $key=>$inv) {
                $data1[$key]['sno']=$sno++;
                $data1[$key]['name']= $inv->name;
                $data1[$key]['target_segment']= $inv->target_segment;
                $data1[$key]['product']= $inv->product;
                $data1[$key]['investment']= $inv->investment;
                $data1[$key]['totcurrExpense']= $inv->totcurrExpense;
                $data1[$key]['qtr_name']= $inv->start_month.'-'.$inv->month;
            }

            return collect($data1);

        }
        elseif($this->data=='Scod')
        {
            $sno=1;
            foreach ($scod as $key=>$sd) {
                $data2[$key]['sno']=$sno++;
                $data2[$key]['name']= $sd->name;
                $data2[$key]['target_segment']= $sd->target_segment;
                $data2[$key]['product']= $sd->product;
                $data2[$key]['investment']= $sd->investment;
                $data2[$key]['address']= $sd->address;
                $data2[$key]['green_product']= $sd->green_product;
                $data2[$key]['prod_date']= $sd->prod_date;
                if($scod[$key]->commercial_op>0){
                    $commercial_date=$scod[$key]->commercial_op;
                }
                else{
                    $commercial_date="0";
                }
                $data2[$key]['commercial_op']=$commercial_date;

                if($scod[$key]->capacity>0){
                    $capacity=$scod[$key]->capacity;
                }
                else{
                    $capacity="0";
                }
                $data2[$key]['capacity']=$capacity;
                $data2[$key]['qtr_name']= $sd->start_month.'-'.$sd->month;

            }
            return collect($data2);
        }
        elseif($this->data=='Revenue')
        {
            $sno=1;
            foreach ($revenue as $key=>$rev) {
                $data3[$key]['sno']=$sno++;
                $data3[$key]['name']= $rev->name;
                $data3[$key]['target_segment']= $rev->target_segment;
                $data3[$key]['product']= $rev->product;
                $data3[$key]['gcDomCurrQuantity']= $rev->gcDomCurrQuantity;
                $data3[$key]['gcDomCurrSales']= $rev->gcDomCurrSales;
                if($revenue[$key]->gcDomCurrQuantity>0){
                    $total=$revenue[$key]->gcDomCurrSales/$revenue[$key]->gcDomCurrQuantity;
                }
                else{
                    $total="0";

                }
                $data3[$key]['domtotal']= round($total,2);
                $data3[$key]['gcExpCurrQuantity']= $rev->gcExpCurrQuantity;
                $data3[$key]['gcExpCurrSales']= $rev->gcExpCurrSales;
                if($revenue[$key]->gcExpCurrQuantity>0){
                    $total1=$revenue[$key]->gcExpCurrSales/$revenue[$key]->gcExpCurrQuantity;
                }
                else{
                    $total1="0";
                }
                $data3[$key]['exptotal']= round($total1,2);
                $data3[$key]['gcCapCurrQuantity']= $rev->gcCapCurrQuantity;
                $data3[$key]['gcCapCurrSales']= $rev->gcCapCurrSales;
                if($revenue[$key]->gcCapCurrQuantity>0){
                    $total2=$revenue[$key]->gcCapCurrSales/$revenue[$key]->gcCapCurrQuantity;
                }
                else{
                    $total2="0";

                }
                $data3[$key]['capptotal']= round($total2,2);
                $data3[$key]['gcTotCurrSales']= $rev->gcTotCurrSales;
                $data3[$key]['qtr_name']= $rev->start_month.'-'.$rev->month;
            }
            return collect($data3);
        }
        elseif($this->data=='Employment')
        {
            $sno=1;
            foreach ($employment as $key=>$emp) {
                $data4[$key]['sno']=$sno++;
                $data4[$key]['name']= $emp->name;
                $data4[$key]['target_segment']= $emp->target_segment;
                $data4[$key]['product']= $emp->product;
                $data4[$key]['investment']= $emp->investment;
                $data4[$key]['qtr_name']= $emp->start_month.'-'.$emp->month;

                if($employment[$key]->laborCurrNo>0){
                    $labour=$employment[$key]->laborCurrNo;
                }
                else{
                    $labour="0";
                }
                $data4[$key]['labour']=$labour;

                if($employment[$key]->empCurrNo>0){
                    $emp=$employment[$key]->empCurrNo;
                }
                else{
                    $emp="0";
                }
                $data4[$key]['employee']=$emp;

                if($employment[$key]->conCurrNo>0){
                    $con=$employment[$key]->conCurrNo;
                }
                else{
                    $con="0";
                }
                $data4[$key]['contractual']=$con;

                if($employment[$key]->appCurrNo>0){
                    $appr=$employment[$key]->appCurrNo;
                }
                else{
                    $appr="0";
                }
                $data4[$key]['apprentice']=$appr;

                if($employment[$key]->totCurrNo>0){
                    $total=$employment[$key]->totCurrNo;
                }
                else{
                    $total="0";
                }
                $data4[$key]['totalemployment']=$total;
            }
            return collect($data4);
        }
        elseif($this->data=='Master')
        {
            $sno=1;
            foreach ($investment as $key=>$inv) {
                $data5[$key]['sno']=$sno++;
                $data5[$key]['name']= $inv->name;
                $data5[$key]['target_segment']= $inv->target_segment;
                $data5[$key]['product']= $inv->product;
                $data5[$key]['investment']= $inv->investment;
                $data5[$key]['totcurrExpense']= $inv->totcurrExpense;

                $data5[$key]['address']= $scod[$key]->address;
                $data5[$key]['green_product']= $scod[$key]->green_product;
                $data5[$key]['prod_date']=$scod[$key]->prod_date;
               
                if($scod[$key]->commercial_op>0){
                    $date=$scod[$key]->commercial_op;
                }
                else{
                    $date="0";
                }
                $data5[$key]['commercial_op']=$date;
                if($scod[$key]->capacity>0){
                    $capacity=$scod[$key]->capacity;
                }
                else{
                    $capacity="0";
                }
                $data5[$key]['capacity']=$capacity;

                $data5[$key]['gcDomCurrQuantity']= $revenue[$key]->gcDomCurrQuantity;
                $data5[$key]['gcDomCurrSales']= $revenue[$key]->gcDomCurrSales;
                if($revenue[$key]->gcDomCurrQuantity>0){
                    $total=$revenue[$key]->gcDomCurrSales/$revenue[$key]->gcDomCurrQuantity;

                }
                else{
                    $total="0";

                }
                $data5[$key]['domtotal']= $total;
                $data5[$key]['gcExpCurrQuantity']= $revenue[$key]->gcExpCurrQuantity;
                $data5[$key]['gcExpCurrSales']= $revenue[$key]->gcExpCurrSales;
                if($revenue[$key]->gcExpCurrQuantity>0){
                    $total1=$revenue[$key]->gcExpCurrSales/$revenue[$key]->gcExpCurrQuantity;
                }
                else{
                    $total1="0";

                }
                $data5[$key]['exptotal']= $total1;
                $data5[$key]['gcCapCurrQuantity']= $revenue[$key]->gcCapCurrQuantity;
                $data5[$key]['gcCapCurrSales']= $revenue[$key]->gcCapCurrSales;
                if($revenue[$key]->gcCapCurrQuantity>0){
                    $total2=$revenue[$key]->gcCapCurrSales/$revenue[$key]->gcCapCurrQuantity;
                }
                else{
                    $total2="0";

                }
                $data5[$key]['capptotal']= $total2;
                $data5[$key]['gcTotCurrSales']= $revenue[$key]->gcTotCurrSales;

                if($employment[$key]->laborCurrNo>0){
                    $labour=$employment[$key]->laborCurrNo;
                }
                else{
                    $labour="0";
                }
                $data5[$key]['labour']=$labour;

                if($employment[$key]->empCurrNo>0){
                    $emp=$employment[$key]->empCurrNo;
                }
                else{
                    $emp="0";
                }
                $data5[$key]['employee']=$emp;

                if($employment[$key]->conCurrNo>0){
                    $con=$employment[$key]->conCurrNo;
                }
                else{
                    $con="0";
                }
                $data5[$key]['contractual']=$con;

                if($employment[$key]->appCurrNo>0){
                    $appr=$employment[$key]->appCurrNo;
                }
                else{
                    $appr="0";
                }
                $data5[$key]['apprentice']=$appr;

                if($employment[$key]->totCurrNo>0){
                    $total=$employment[$key]->totCurrNo;
                }
                else{
                    $total="0";
                }
                $data5[$key]['totalemployment']=$total;
                $data5[$key]['qtr_name']=  $inv->start_month.'-'.$inv->month;;
            }
            return collect($data5);
        }
    }

    public function headings(): array
    {
        if($this->data=='Investment')
        {
            // .'-['. $this->qtrMaster->month.'-'.$this->qtrMaster->yr_short.']'
            return[
            // ['June'],
            // [
                'Sr.No',
                'Applicant Name.',
                'Target Segment',
                'Product Name',
                'Committed Investment (₹ in Cr.)',
                'Actual Investment (₹ in Cr.)',
                'Qtr Name'
            // ]
            ];
        }
        elseif($this->data=='Scod')
        {
            return [
                'Sr.No',
                'Applicant Name.',
                'Target Segment',
                'Product Name',
                'Committed Investment (₹ in Cr.)',
                'Project Location',
                'Project Location Product Name',
                'Original SCOD',
                'Actual COD',
                'Achieved Capacity (in kg)',
                'Qtr Name'
            ];
        }
        elseif($this->data=='Revenue')
        {
            return [
                'Sr.No',
                'Applicant Name.',
                'Target Segment',
                'Product Name',
                'Domestic Quantity (in kg)',
                'Domestic Total (₹ in Cr.)',
                'Domestic Price (₹ in Cr.)',
                'Export Quantity (in kg)',
                'Export Total (₹ in Cr.)',
                'Export Price (₹ in Cr.)',
                'Captive Consumption Quantity (in kg)',
                'Captive Consumption Total (₹ in Cr.)',
                'Captive Consumption Price (₹ in Cr.)',
                'Total Sales (₹ in Cr.)',
                'Qtr Name'
            ];
        }
        elseif($this->data=='Employment')
        {
            return [
                'Sr.No',
                'Applicant Name.',
                'Target Segment',
                'Product Name',
                'Committed Investment (₹ in Cr.)',
                'Qtr Name',
                'On-Roll Labour (in Number)',
                'On-Roll Employee (in Number)',
                'Contractual (in Number)',
                'Apprentice (in Number)',
                'Total Employment (in Number)',
               

            ];
        }
        elseif($this->data=='Master')
        {
            return [
                'Sr.No',
                'Applicant Name.',
                'Target Segment',
                'Product Name',
                'Committed Investment (₹ in Cr.)',
                'Actual Investment (₹ in Cr.)',

                'Project Location',
                'Project Location Product Name',
                'Original SCOD',
                'Actual COD',
                'Achieved Capacity (in units)',

                'Domestic Quantity (in kg)',
                'Domestic Price (₹ in Cr.)',
                'Domestic Total (₹ in Cr.)',
                'Export Quantity (in kg)',
                'Export Price (₹ in Cr.)',
                'Export Total (₹ in Cr.)',
                'Captive Consumption Quantity (in kg)',
                'Captive Consumption Price (₹ in Cr.)',
                'Captive Consumption Total (₹ in Cr.)',
                'Total Sales (₹ in Cr.)',

                'On-Roll Labour (in Number)',
                'On-Roll Employee (in Number)',
                'Contractual (in Number)',
                'Apprentice (in Number)',
                'Total Employment (in Number)',
                'Qtr Name'
            ];
        }

    }
}
