<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MIS;
use Illuminate\Http\Request;
use App\Exports\MISqtrwise;
use App\Exports\MISfywise;
use Excel;


use DB;
class MISController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($qtr_id)
    {
        $qtrMast=DB::table('qtr_master')->get();

        // $fy1=$qtrMast->where('fy',$qtr_id)->pluck('fy')->first();
        $fys=$qtrMast->where('status',1)->unique('fy')->pluck('fy');

        $qtrMaster=$qtrMast->where('qtr_id',$qtr_id)->first();
        $fydata=$qtrMast->where('qtr_id',$qtr_id)->unique('fy')->pluck('fy')->first();

        if($qtrMaster)
        {
            $investment_data = DB::table('qrr_master as qm')
                ->join('financial_progress as fp', 'fp.qrr_id', '=', 'qm.id')
                ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
                ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
                ->where('qm.status', 'S')
                ->get(['qm.id', 'qm.app_id','qm.qtr_id', 'fp.totcurrExpense','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment']);
            //     dd($investment_data);
            // dd(array_sum(array_column($investment_data,'investment')));
            $scod_data = DB::table('qrr_master as qm')
                ->leftJoin('manufacture_location as ml',function($a){
                    $a->on('ml.app_id', '=', 'qm.app_id')
                    ->on('qm.qtr_id','=','ml.qtr_id');
                    })
                ->join('scod as s', 's.qrr_id', '=', 'qm.id')
                ->join('manufacture_product_capacities as mpc', DB::raw('mpc.m_id :: INTEGER'), '=', 'ml.id')
                ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
                ->join('proposal_details as pd','pd.app_id','=','qm.app_id')
                ->join('evaluation_details as ed','ed.app_id','=','aad.id')
                ->where('qm.status', 'S')
                ->where('ml.type', 'green')
                ->get(['qm.id', 'qm.app_id', 'qm.qtr_id', 's.commercial_op','aad.app_no','aad.name','aad.product','aad.target_segment','ml.address','mpc.capacity','mpc.product as green_product','pd.prod_date','ed.investment']);

            $revenue_data = DB::table('qrr_master as qm')
                ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
                ->join('qrr_revenue as qr','qr.qrr_id','=','qm.id')
                ->where('qm.status', 'S')
                ->select('qm.id','qm.qtr_id','qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','qr.gcDomCurrQuantity','qr.gcDomCurrSales','qr.gcTotCurrSales','qr.gcExpCurrQuantity','qr.gcExpCurrSales','qr.gcCapCurrQuantity','qr.gcCapCurrSales',DB::raw('CASE WHEN qr."gcDomCurrQuantity" > 0 then qr."gcDomCurrSales"/qr."gcDomCurrQuantity" else 0 END as gcDomPrice'),DB::raw('CASE WHEN qr."gcExpCurrQuantity" > 0 then qr."gcExpCurrSales"/qr."gcExpCurrQuantity" else 0 END as gcExpPrice'),DB::raw('CASE WHEN qr."gcCapCurrQuantity" > 0 then qr."gcCapCurrSales"/qr."gcCapCurrQuantity" else 0 END as gcCapPrice'))
                ->get();
            $employment_data = DB::table('qrr_master as qm')
                ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
                ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
                ->join('greenfield_emp as ge','ge.qrr_id','=','qm.id')
                ->where('qm.status', 'S')
                ->get(['qm.id','qm.qtr_id','qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment','ge.laborCurrNo','ge.empCurrNo','ge.conCurrNo','ge.appCurrNo','ge.totCurrNo']);


            $apps = DB::table('approved_apps')->whereNotNull('app_no')->pluck('id')->toArray();
            $qtrs = DB::table('qtr_master')->where('qtr_id', '<=',$qtr_id)->where('fy',$fydata)->orderBy('qtr_id','DESC')->pluck('qtr_id')->toArray();

            foreach($apps as $app){
                foreach($qtrs as $qtr)
                {
                    if($investment_data->where('app_id', $app)->where('qtr_id', $qtr)->first() &&
                    $scod_data->where('app_id', $app)->where('qtr_id', $qtr)->first() &&
                    $revenue_data->where('app_id', $app)->where('qtr_id', $qtr)->first() &&
                        $employment_data->where('app_id', $app)->where('qtr_id', $qtr)->first())
                    {
                        $investment[] = $investment_data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                        $scod[] = $scod_data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                        $revenue[] = $revenue_data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                        $employment[] = $employment_data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                        break;
                    }

                }
            }
            return view('admin.MIS.index',compact('investment','scod','revenue','employment','qtr','qtrMaster','qtr_id','fys'));
        }
        else
        {

            $fy_qtr=$qtrMast->where('fy',$qtr_id)->pluck('qtr_id')->toArray();

                $all_investment=DB::table('qrr_master as qm')
                ->join('financial_progress as fp', 'fp.qrr_id', '=', 'qm.id')
                ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
                ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
                ->where('qm.status', 'S')
                ->whereIn('qm.qtr_id', $fy_qtr)
                ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment', DB::raw('SUM(fp."totcurrExpense") as totcurrExpense'))
                ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment')
                ->get()->toArray();

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
            ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment','s.commercial_op','ml.address','mpc.product as green_product','pd.prod_date',DB::raw('SUM(mpc.capacity) as capacity'))
            ->distinct('qm.app_id')
            ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment','s.commercial_op','ml.address','mpc.product','pd.prod_date')
            ->get();

            $all_revenue=DB::table('qrr_master as qm')
            ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
            ->join('qrr_revenue as qr','qr.qrr_id','=','qm.id')
            ->where('qm.status', 'S')
            ->whereIn('qm.qtr_id', $fy_qtr)
            ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment',DB::raw('SUM(qr."gcDomCurrQuantity") as gcDomCurrQuantity'),DB::raw('SUM(qr."gcDomCurrSales") as gcDomCurrSales'),
            DB::raw('CASE WHEN SUM(qr."gcDomCurrQuantity")>0 then SUM(qr."gcDomCurrSales")/SUM(qr."gcDomCurrQuantity") else 0 END as gcdomprice'),DB::raw('SUM(qr."gcExpCurrQuantity") as gcExpCurrQuantity'),DB::raw('SUM(qr."gcExpCurrSales") as gcExpCurrSales'),DB::raw('case when SUM(qr."gcExpCurrQuantity")>0 then
            round(SUM(qr."gcExpCurrSales")/SUM(qr."gcExpCurrQuantity"),2) else 0 END AS gcexpprice'),
            DB::raw('SUM(qr."gcCapCurrQuantity") as gcCapCurrQuantity'),DB::raw('SUM(qr."gcCapCurrSales") as gcCapCurrSales'),DB::raw('SUM(qr."totCurrSales") as totCurrSales'),DB::raw('case when SUM(qr."gcCapCurrQuantity")>0 then
            round(SUM(qr."gcCapCurrSales")/SUM(qr."gcCapCurrQuantity"),2) else 0 END AS gccapprice'))
            ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment')
            ->get()->toArray();
            // dd($all_revenue);


            $all_employment = DB::table('qrr_master as qm')
            ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
            ->join('evaluation_details as ed','ed.app_id','=','qm.app_id')
            ->join('greenfield_emp as emp','emp.qrr_id','=','qm.id')
            ->where('qm.status', 'S')
            ->whereIn('qm.qtr_id', $fy_qtr)
            ->select('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment',DB::raw('SUM(emp."laborCurrNo") as laborCurrNo'),DB::raw('SUM(emp."empCurrNo") as empCurrNo'),DB::raw('SUM(emp."conCurrNo") as conCurrNo'),DB::raw('SUM(emp."appCurrNo") as appCurrNo'),DB::raw('SUM(emp."totCurrNo") as totCurrNo'))
            ->groupBy('qm.app_id','aad.app_no','aad.name','aad.product','aad.target_segment','ed.investment')
            ->get()->toArray();

        }
        return view('admin.MIS.index',compact('all_investment','all_scod','all_revenue','all_employment','qtrMaster','qtr_id','fys'));

    }

    public function MISExport($qtr,$data)
    {
        $qtrMaster=DB::table('qtr_master')->where('qtr_id',$qtr)->select('qtr_id','month','yr_short','fy')->first();
 
        if($data =='Applicant_Info'){
            return Excel::download(new MISfywise($qtr,$data), 'QRR-'.'F.Y.'.$qtrMaster->fy.'-'.$data.'.xlsx');
        }else{
            if($qtrMaster)
            {
                return Excel::download(new MISqtrwise($qtr,$data), 'QRR-'.$qtrMaster->month.'-'.$qtrMaster->yr_short.'_'.$data.'.xlsx');
            }else
            {
            $qtrMaster=DB::table('qtr_master')->where('fy',$qtr)->select('qtr_id','month','yr_short','fy')->first();
                return Excel::download(new MISfywise($qtr,$data), 'QRR-'.'F.Y.'.$qtrMaster->fy.'-'.$data.'.xlsx');
            }
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MIS  $mIS
     * @return \Illuminate\Http\Response
     */
    public function show(MIS $mIS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MIS  $mIS
     * @return \Illuminate\Http\Response
     */
    public function edit(MIS $mIS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MIS  $mIS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MIS $mIS)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MIS  $mIS
     * @return \Illuminate\Http\Response
     */
    public function destroy(MIS $mIS)
    {
        //
    }
    public function qrr($fy)
    {
        $qtrMaster=DB::table('qtr_master')->where('fy',$fy)->where('status',1)->get();
        return json_encode($qtrMaster);
    }
}
