<?php

namespace App\Exports;
use DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Arr;

class MISfywise implements FromCollection, WithHeadings, ShouldAutoSize
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
        // $qtrMaster=DB::table('qtr_master')->where('qtr_id',$this->qtr)->select('qtr_id','month','yr_short','fy')->first();
// dd($qtrMaster);
    $this->qtrMast=DB::table('qtr_master')->get();

        // $this->fy=$qtrMaster->fy;

    }

    public function collection()
    {

        $fy_qtr=$this->qtrMast->where('fy',$this->qtr)->pluck('qtr_id')->toArray();

        $all_investment=DB::table('qrr_master as qm')
        ->join('financial_progress as fp', 'fp.qrr_id', '=', 'qm.id')
        ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
        ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
        ->where('qm.status', 'S')
        ->whereIn('qm.qtr_id', $fy_qtr)
        ->orderBy('qm.app_id')
        ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment', DB::raw('SUM(fp."totcurrExpense") as totcurrExpense'))
        ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment')
        ->get();

        $all_scod=DB::table('qrr_master as qm')
        ->join('scod as s', 's.qrr_id', '=', 'qm.id')
        ->leftJoin('manufacture_location as ml',function($a){
            $a->on('ml.app_id', '=', 'qm.app_id')
            ->on('qm.qtr_id','=','ml.qtr_id');
        })
        ->join('manufacture_product_capacities as mpc', DB::raw('mpc.m_id :: INTEGER'), '=', 'ml.id')
        ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
        ->join('proposal_details as pd','pd.app_id','=','qm.app_id')
        ->join('evaluation_details as ed','ed.app_id','=','aad.id')
        ->where('qm.status', 'S')
        ->whereIn('qm.qtr_id', $fy_qtr)
        ->where('ml.type', 'green')
        ->orderBy('qm.app_id')
        ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment','s.commercial_op','ml.address','mpc.product as green_product','pd.prod_date',DB::raw('SUM(mpc.capacity) as capacity'))
        ->distinct('qm.app_id')
        ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment','s.commercial_op','ml.address','mpc.product','pd.prod_date')
        ->get();

        $all_revenue=DB::table('qrr_master as qm')
        ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
        ->join('qrr_revenue as qr','qr.qrr_id','=','qm.id')
        ->where('qm.status', 'S')
        ->whereIn('qm.qtr_id', $fy_qtr)
        ->orderBy('qm.app_id')
        ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment',DB::raw('SUM(qr."gcDomCurrQuantity") as gcDomCurrQuantity'),DB::raw('SUM(qr."gcDomCurrSales") as gcDomCurrSales'),DB::raw('SUM(qr."gcExpCurrQuantity") as gcExpCurrQuantity'),DB::raw('SUM(qr."gcExpCurrSales") as gcExpCurrSales'),DB::raw('SUM(qr."gcCapCurrQuantity") as gcCapCurrQuantity'),DB::raw('SUM(qr."gcCapCurrSales") as gcCapCurrSales'),DB::raw('SUM(qr."totCurrSales") as totCurrSales'))
        ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment')
        ->get();

        // dd($all_revenue);


        $all_employment = DB::table('qrr_master as qm')
        ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
        ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
        ->join('greenfield_emp as emp','emp.qrr_id','=','qm.id')
        ->where('qm.status', 'S')
        ->whereIn('qm.qtr_id', $fy_qtr)
        ->orderBy('qm.app_id')
        ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment',DB::raw('SUM(emp."laborCurrNo") as laborCurrNo'),DB::raw('SUM(emp."empCurrNo") as empCurrNo'),DB::raw('SUM(emp."conCurrNo") as conCurrNo'),DB::raw('SUM(emp."appCurrNo") as appCurrNo'),DB::raw('SUM(emp."totCurrNo") as totCurrNo'))
        ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment')
        ->get();

        $all_applicant = DB::select('select u."name" as "Company Name",aad.target_segment as "Target Segment",aad.product as "Eligible Product",
        u.off_add as "Corporate Office Address",u.contact_person as "Authorized Signatory (AS) Name",u.email as "Email ID of (AS)",
        u.mobile as "Contact No. (AS)",k."name" as "Name of Chairman, CEO, MD, KMP (from pt.1.5 & 1.6 application form)",u.designation as "Designation (from 1.5 & 1.6  application form)",
        k.email as "Email ID of Chairman, CEO, MD, KMP (from 1.5 & 1.6  application form)",
        k.phone as "Contact No. of Chairman, CEO, MD, KMP (from 1.5 & 1.6  application form)",
        pd.prop_man_add as "Address of Greenfield Manufacturing Facility (pt.5.1 of application form)"
        from users u join approved_apps_details aad on aad.user_id =u.id
        join kmps k on aad.id =k.app_id
        join proposal_details pd on aad.id =pd.app_id 
        join management_profiles mp on aad.id =mp.app_id
        where is_normal_user(aad.user_id) = 1');

    // MISqtrwise
        if($this->data=='Investment')
        {
            $sno=1;
            foreach ($all_investment as $key=>$inv) {
                $data1[$key]['sno']=$sno++;
                $data1[$key]['name']= $inv->name;
                $data1[$key]['target_segment']= $inv->target_segment;
                $data1[$key]['product']= $inv->product;
                $data1[$key]['investment']= $inv->investment;
                $data1[$key]['totcurrexpense']= $inv->totcurrexpense;
            }
            return collect($data1);
        }
        elseif($this->data=='Scod')
        {
            $sno=1;
            foreach ($all_scod as $key=>$sd) {
                $data2[$key]['sno']=$sno++;
                $data2[$key]['name']= $sd->name;
                $data2[$key]['target_segment']= $sd->target_segment;
                $data2[$key]['product']= $sd->product;
                $data2[$key]['investment']= $sd->investment;
                $data2[$key]['address']= $sd->address;
                $data2[$key]['green_product']= $sd->green_product;
                $data2[$key]['prod_date']= $sd->prod_date;

                if($all_scod[$key]->commercial_op>0){
                    $commercial_date=$all_scod[$key]->commercial_op;
                }
                else{
                    $commercial_date="0";
                }
                $data2[$key]['commercial_op']=$commercial_date;

                if($all_scod[$key]->capacity>0){
                    $capacity=$all_scod[$key]->capacity;
                }
                else{
                    $capacity="0";
                }
                $data2[$key]['capacity']=$capacity;

            }
            return collect($data2);
        }
        elseif($this->data=='Revenue')
        {
            $sno=1;
            foreach ($all_revenue as $key=>$rev) {
                $data3[$key]['sno']=$sno++;
                $data3[$key]['name']= $rev->name;
                $data3[$key]['target_segment']= $rev->target_segment;
                $data3[$key]['product']= $rev->product;
                $data3[$key]['gcdomcurrquantity']= $rev->gcdomcurrquantity;
                $data3[$key]['gcdomcurrsales']= $rev->gcdomcurrsales;
                if($all_revenue[$key]->gcdomcurrquantity>0){
                    $total=$all_revenue[$key]->gcdomcurrsales/$all_revenue[$key]->gcdomcurrquantity;
                }
                else{
                    $total="0";

                }
                $data3[$key]['domtotal']= round($total,2);
                $data3[$key]['gcexpcurrquantity']= $rev->gcexpcurrquantity;
                $data3[$key]['gcexpcurrsales']= $rev->gcexpcurrsales;
                if($all_revenue[$key]->gcexpcurrquantity>0){
                    $total1=$all_revenue[$key]->gcexpcurrsales/$all_revenue[$key]->gcexpcurrquantity;
                }
                else{
                    $total1="0";
                }
                $data3[$key]['exptotal']= round($total1,2);
                $data3[$key]['gccapcurrquantity']= $rev->gccapcurrquantity;
                $data3[$key]['gccapcurrsales']= $rev->gccapcurrsales;
                if($all_revenue[$key]->gccapcurrquantity>0){
                    $total2=$all_revenue[$key]->gccapcurrsales/$all_revenue[$key]->gccapcurrquantity;
                }
                else{
                    $total2="0";

                }
                $data3[$key]['capptotal']=round($total2,2);
                $data3[$key]['totcurrsales']= $rev->totcurrsales;
            }
            return collect($data3);
        }
        elseif($this->data=='Employment')
        {
            $sno=1;
            foreach ($all_employment as $key=>$emp) {
                $data4[$key]['sno']=$sno++;
                $data4[$key]['name']= $emp->name;
                $data4[$key]['target_segment']= $emp->target_segment;
                $data4[$key]['product']= $emp->product;
                $data4[$key]['investment']= $emp->investment;
                if($all_employment[$key]->laborcurrno>0){
                    $labour=$all_employment[$key]->laborcurrno;
                }
                else{
                    $labour="0";
                }
                $data4[$key]['labour']=$labour;

                if($all_employment[$key]->empcurrno>0){
                    $emp=$all_employment[$key]->empcurrno;
                }
                else{
                    $emp="0";
                }
                $data4[$key]['employee']=$emp;

                if($all_employment[$key]->concurrno>0){
                    $con=$all_employment[$key]->concurrno;
                }
                else{
                    $con="0";
                }
                $data4[$key]['contractual']=$con;

                if($all_employment[$key]->appcurrno>0){
                    $appr=$all_employment[$key]->appcurrno;
                }
                else{
                    $appr="0";
                }
                $data4[$key]['apprentice']=$appr;

                if($all_employment[$key]->totcurrno>0){
                    $total=$all_employment[$key]->totcurrno;
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
            foreach ($all_investment as $key=>$inv) {
        

                $data5[$key]['sno']=$sno++;
                $data5[$key]['name']= $inv->name;
                $data5[$key]['target_segment']= $inv->target_segment;
                $data5[$key]['product']= $inv->product;
                $data5[$key]['investment']= $inv->investment;
                $data5[$key]['totcurrexpense']= $inv->totcurrexpense;

                $data5[$key]['address']= $all_scod[$key]->address;
                $data5[$key]['green_product']= $all_scod[$key]->green_product;
                $data5[$key]['prod_date']=$all_scod[$key]->prod_date;

                if($all_scod[$key]->commercial_op>0){
                    $date=$all_scod[$key]->commercial_op;
                }
                else{
                    $date="0";
                }
                $data5[$key]['commercial_op']=$date;
                if($all_scod[$key]->capacity>0){
                    $capacity=$all_scod[$key]->capacity;
                }
                else{
                    $capacity="0";
                }
                $data5[$key]['capacity']=$capacity;

                $data5[$key]['gcdomcurrquantity']= $all_revenue[$key]->gcdomcurrquantity;
                $data5[$key]['gcdomcurrsales']= $all_revenue[$key]->gcdomcurrsales;
                if($all_revenue[$key]->gcdomcurrquantity>0){
                    $total=$all_revenue[$key]->gcdomcurrsales/$all_revenue[$key]->gcdomcurrquantity;

                }
                else{
                    $total="0";

                }
                $data5[$key]['domtotal']= $total;
                $data5[$key]['gcexpcurrquantity']= $all_revenue[$key]->gcexpcurrquantity;
                $data5[$key]['gcexpcurrsales']= $all_revenue[$key]->gcexpcurrsales;
                if($all_revenue[$key]->gcexpcurrquantity>0){
                    $total1=$all_revenue[$key]->gcexpcurrsales/$all_revenue[$key]->gcexpcurrquantity;
                }
                else{
                    $total1="0";

                }
                $data5[$key]['exptotal']= $total1;
                $data5[$key]['gccapcurrquantity']= $all_revenue[$key]->gccapcurrquantity;
                $data5[$key]['gccapcurrsales']= $all_revenue[$key]->gccapcurrsales;
                if($all_revenue[$key]->gccapcurrquantity>0){
                    $total2=$all_revenue[$key]->gccapcurrsales/$all_revenue[$key]->gccapcurrquantity;
                }
                else{
                    $total2="0";

                }
                $data5[$key]['capptotal']= $total2;
                $data5[$key]['totcurrsales']= $all_revenue[$key]->totcurrsales;

                if($all_employment[$key]->laborcurrno>0){
                    $labour=$all_employment[$key]->laborcurrno;
                }
                else{
                    $labour="0";
                }
                $data5[$key]['labour']=$labour;

                if($all_employment[$key]->empcurrno>0){
                    $emp=$all_employment[$key]->empcurrno;
                }
                else{
                    $emp="0";
                }
                $data5[$key]['employee']=$emp;

                if($all_employment[$key]->concurrno>0){
                    $con=$all_employment[$key]->concurrno;
                }
                else{
                    $con="0";
                }
                $data5[$key]['contractual']=$con;

                if($all_employment[$key]->appcurrno>0){
                    $appr=$all_employment[$key]->appcurrno;
                }
                else{
                    $appr="0";
                }
                $data5[$key]['apprentice']=$appr;

                if($all_employment[$key]->totcurrno>0){
                    $total=$all_employment[$key]->totcurrno;
                }
                else{
                    $total="0";
                }
                $data5[$key]['totalemployment']=$total;
            }
            return collect($data5);
        }
        elseif($this->data == 'Applicant_Info'){
            return collect($all_applicant);
        }
    }

    public function headings(): array
    {
        // dd($this->data);

        if($this->data=='Investment')
        {
            return[
                'Sr.No',
                'Applicant Name.',
                'Target Segment',
                'Product Name',
                'Committed Investment (₹ in Cr.)',
                'Actual Investment (₹ in Cr.)'
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
                'Achieved Capacity (in kg)'
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
                'Total Sales (₹ in Cr.)'
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
                'Total Employment (in Number)'
            ];
        }
        elseif($this->data=='Applicant_Info'){
            return [
                'Company Name',
                'Target Segment',
                'Eligible Product',
                'Corporate Office Address',
                'Authorized Signatory (AS) Name',
                'Email ID of (AS)',
                'Contact No. (AS)',
                'Name of Chairman, CEO, MD, KMP (from pt.1.5 & 1.6 application form)',
                'Designation (from 1.5 & 1.6  application form)',
                'Email ID of Chairman, CEO, MD, KMP (from 1.5 & 1.6  application form)',
                'Contact No. of Chairman, CEO, MD, KMP (from 1.5 & 1.6  application form)',
                'Address of Greenfield Manufacturing Facility (pt.5.1 of application form)'
            ];
        }
    }
}
