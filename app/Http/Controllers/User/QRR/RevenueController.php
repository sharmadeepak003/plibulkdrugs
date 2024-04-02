<?php

namespace App\Http\Controllers\User\QRR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\QrrRevenue;
use App\GreenfieldEmp;
use App\QrrDva;
use App\DvaBreakdownMat;
use App\DvaBreakdownMatPrev;
use App\DvaBreakdownSer;
use App\DvaBreakdownSerPrev;
use App\QRRMasters;
use App\QrrStage;
use Exception;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$qrr)
    {
        $qrrMast = QRRMasters::where('id', $qrr)
        ->where('app_id',$id)->where('status', 'D')->first();
        // dd( $qrrMast);

        if (!$qrrMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('qpr.byname',202101);
        }
        $stage = QrrStage::where('qrr_id', $qrr)->where('stage', 2)->first();
        if ($stage) {
            return redirect()->route('revenue.edit', $qrr);
        }

        $qrrName=$qrrMast->qtr_id;
        $revPrev=null;
        $green=null;
        $dva=null;
        $matprev=null;
        $serprev=null;

        $currqtrdata=DB::table('qtr_master')->where('qtr_id',$qrrName)->first('qtr');
        $oldqtr=$currqtrdata->qtr-1;
       
        if($oldqtr == 0){
            $oldqtr = 1;
        }
        
        $qtrMaster=DB::table('qtr_master')->where('qtr',$oldqtr)->first();
        $oldQrr=$qtrMaster->qtr_id;

        $currQrr=$qrrMast->qtr_id;


     
        $fyqtr = substr($currQrr, -1);
        // dd($fyqtr);
        $app_dt=DB::table('approved_apps_details')->where('id',$id)->first();
        
        
        $fin_Data =substr($app_dt->approval_dt,0,10);
            
        $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);

        $year= substr((end($fy_year)->fin_year),0,4);
        

        if($qrrName!=$year.'01'){

            $qrrMast = QRRMasters::where('app_id',$id)->where('qtr_id',$oldQrr)
            ->where('status','S')->first();

            if($qrrMast){
                $revPrev=QrrRevenue::where('qrr_id',$qrrMast->id)->first();
                $green=GreenfieldEmp::where('qrr_id',$qrrMast->id)->first();
                $dva=QrrDva::where('qrr_id',$qrrMast->id)->first();
                $matprev=DvaBreakdownMat::where('qrr_id',$qrrMast->id)->get();
                $serprev=DvaBreakdownSer::where('qrr_id',$qrrMast->id)->get();
                $ser=DvaBreakdownSer::where('qrr_id',$qrrMast->id)->get();
            }
        }

        $oldcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($oldQrr))->first();
        $currcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($currQrr))->first();

        return view('user.qrr.revenue',
        compact('id','qrr','qrrName','revPrev','green','dva','matprev','serprev','oldcolumnName','currcolumnName','fyqtr','year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $rev=new QrrRevenue();
            $rev->fill([
                'qrr_id'=>$request->qrr,
                'gcDomPrevQuantity'=>$request->gcDomPrevQuantity,
                'gcDomPrevSales'=>$request->gcDomPrevSales,
                'gcDomCurrQuantity'=>$request->gcDomCurrQuantity,
                'gcDomCurrSales'=>$request->gcDomCurrSales,
                'gcExpPrevQuantity'=>$request->gcExpPrevQuantity,
                'gcExpPrevSales'=>$request->gcExpPrevSales,
                'gcExpCurrQuantity'=>$request->gcExpCurrQuantity,
                'gcExpCurrSales'=>$request->gcExpCurrSales,
                'gcCapPrevQuantity'=>$request->gcCapPrevQuantity,
                'gcCapPrevSales'=>$request->gcCapPrevSales,
                'gcCapCurrQuantity'=>$request->gcCapCurrQuantity,
                'gcCapCurrSales'=>$request->gcCapCurrSales,
                'gcTotPrevQuantity'=>$request->gcTotPrevQuantity,
                'gcTotPrevSales'=>$request->gcTotPrevSales,
                'gcTotCurrQuantity'=>$request->gcTotCurrQuantity,
                'gcTotCurrSales'=>$request->gcTotCurrSales ,
                'ecDomPrevQuantity'=>$request->ecDomPrevQuantity,
                'ecDomPrevSales'=>$request->ecDomPrevSales,
                'ecDomCurrQuantity'=>$request->ecDomCurrQuantity,
                'ecDomCurrSales'=>$request->ecDomCurrSales,
                'ecExpPrevQuantity'=>$request->ecExpPrevQuantity,
                'ecExpPrevSales'=>$request->ecExpPrevSales,
                'ecExpCurrQuantity'=>$request->ecExpCurrQuantity,
                'ecExpCurrSales'=>$request->ecExpCurrSales,
                'ecCapPrevQuantity'=>$request->ecCapPrevQuantity,
                'ecCapPrevSales'=>$request->ecCapPrevSales,
                'ecCapCurrQuantity'=>$request->ecCapCurrQuantity,
                'ecCapCurrSales'=>$request->ecCapCurrSales,
                'ecTotPrevQuantity'=>$request->ecTotPrevQuantity,
                'ecTotPrevSales'=>$request->ecTotPrevSales,
                'ecTotCurrQuantity'=>$request->ecTotCurrQuantity,
                'ecTotCurrSales'=>$request->ecTotCurrSales,
                'otDomPrevQuantity'=>$request->otDomPrevQuantity,
                'otDomPrevSales'=>$request->otDomPrevSales,
                'otDomCurrQuantity'=>$request->otDomCurrQuantity,
                'otDomCurrSales'=>$request->otDomCurrSales,
                'otExpPrevQuantity'=>$request->otExpPrevQuantity,
                'otExpPrevSales'=>$request->otExpPrevSales,
                'otExpCurrQuantity'=>$request->otExpCurrQuantity,
                'otExpCurrSales'=>$request->otExpCurrSales,
                'otCapPrevQuantity'=>$request->otCapPrevQuantity,
                'otCapPrevSales'=>$request->otCapPrevSales,
                'otCapCurrQuantity'=>$request->otCapCurrQuantity,
                'otCapCurrSales'=>$request->otCapCurrSales,
                'otTotPrevQuantity'=>$request->otTotPrevQuantity,
                'otTotPrevSales'=>$request->otTotPrevSales,
                'otTotCurrQuantity'=>$request->otTotCurrQuantity,
                'otTotCurrSales'=>$request->otTotCurrSales,
                'otherPrevQuantity'=>$request->otherPrevQuantity,
                'otherPrevSales'=>$request->otherPrevSales,
                'otherCurrQuantity'=>$request->otherCurrQuantity,
                'otherCurrSales'=>$request->otherCurrSales,
                'totPrevQuantity'=>$request->totPrevQuantity,
                'totPrevSales'=>$request->totPrevSales,
                'totCurrQuantity'=>$request->totCurrQuantity,
                'totCurrSales'=>$request->totCurrSales,
                'created_by' => Auth::user()->id
            ]);

            $green=new GreenfieldEmp();
            $green->fill([
                'qrr_id'=>$request->qrr,
                'laborPrevNo'=>$request->laborPrevNo,
                'laborCurrNo'=>$request->laborCurrNo,
                'empPrevNo'=>$request->empPrevNo,
                'empCurrNo'=>$request->empCurrNo,
                'conPrevNo'=>$request->conPrevNo,
                'conCurrNo'=>$request->conCurrNo,
                'appPrevNo'=>$request->appPrevNo,
                'appCurrNo'=>$request->appCurrNo,
                'totPrevNo'=>$request->totPrevNo,
                'totCurrNo'=>$request->totCurrNo,
                'created_by' => Auth::user()->id
            ]);

            $dva=new QrrDva();
            $dva->fill([
                'qrr_id'=>$request->qrr,
                'EPprevquant'=>$request->EPprevquant,
                'EPprevsales'=>$request->EPprevsales,
                'EPprevamount'=>$request->EPprevamount,
                'EPcurrquant'=>$request->EPcurrquant,
                'EPcurrsales'=>$request->EPcurrsales,
                'EPcurramount'=>$request->EPcurramount,
                'totConprevquant'=>$request->totConprevquant,
                //'totConprevsales'=>$request->totConprevsales,
                'totConprevamount' =>$request->totConprevamount,
                'totConcurrquant'=>$request->totConcurrquant,
                //'totConcurrsales'=>$request->totConcurrsales,
                'totConcurramount' =>$request->totConcurramount,
                'matprevquant'=>$request->matprevquant,
                //'matprevsales'=>$request->matprevsales,
                'matprevamount'=>$request->matprevamount,
                'matcurrquant'=>$request->matcurrquant,
                //'matcurrsales'=>$request->matcurrsales,
                'matcurramount'=>$request->matcurramount,
                'serprevquant'=>$request->serprevquant,
                //'serprevsales'=>$request->serprevsales,
                'serprevamount'=>$request->serprevamount,
                'sercurrquant'=>$request->sercurrquant,
                // 'sercurrsales'=>$request->sercurrsales,
                'sercurramount'=>$request->sercurramount,
                'prevDVATotal'=>$request->prevDVATotal,
                'currDVATotal'=>$request->currDVATotal,
                'created_by' => Auth::user()->id
            ]);



            DB::transaction(function () use ($request,$rev,$green,$dva) {
                
                $rev->save();
                $green->save();
                $dva->save();

                foreach ($request->mattcurr as $mp  ) {
                    $dmat=DvaBreakdownMat::create([
                        'qrr_id'=>$request->qrr,
                        'mattparticulars'=>$mp['particulars'],
                        'mattcountry'    =>$mp['country'],
                        'mattquantity'   =>$mp['quantity'],
                        'mattamount'     =>$mp['amount'],
                        'created_by' => Auth::user()->id
                    ]);
                }

            foreach ($request->mattprev as $mp  ) {
                $dbmat=DvaBreakdownMatPrev::create([
                    'qrr_id'=>$request->qrr,
                    'mattprevparticulars'=>$mp['particulars'],
                    'mattprevcountry'    =>$mp['country'],
                    'mattprevquantity'   =>$mp['quantity'],
                    'mattprevamount'     =>$mp['amount'],
                    'created_by' => Auth::user()->id
                ]);
            }

                foreach ($request->serrcurr as $mp  ) {
                    $dser=DvaBreakdownSer::create([
                        'qrr_id'=>$request->qrr,
                        'serrparticulars'=>$mp['particulars'],
                        'serrcountry'    =>$mp['country'],
                        'serrquantity'   =>$mp['quantity'],
                        'serramount'     =>$mp['amount'],
                        'created_by' => Auth::user()->id
                    ]);
                }

            foreach ($request->serrprev as $mp  ) {
                $dbser=DvaBreakdownSerPrev::create([
                    'qrr_id'=>$request->qrr,
                    'serrprevparticulars'=>$mp['particulars'],
                    'serrprevcountry'    =>$mp['country'],
                    'serrprevquantity'   =>$mp['quantity'],
                    'serrprevamount'     =>$mp['amount'],
                    'created_by' => Auth::user()->id
                ]);
            }

                QrrStage::create(['qrr_id' => $request->qrr, 'stage' => 2, 'status' => 'D']);

            });

            alert()->success('Data Saved', 'Success!')->persistent('Close');

            return redirect()->route('qpr.byname',$request->qrrName);
        }catch(Exception $e){
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $qrrMast = QRRMasters::where('id', $id)->where('status', 'D')->first();
            $app_id=$qrrMast->app_id;

            $app_dt=DB::table('approved_apps_details')->where('id',$app_id)->first();

            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);
    
            $year= substr((end($fy_year)->fin_year),0,4);

            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');
            }
            
            $stage = QrrStage::where('qrr_id', $id)->where('stage', 2)->first();
            if (!$stage) {
                return redirect()->route('revenue.create', ['id' => $app_id, 'qrr' => $id]);
            }
            
        
        
            $rev=QrrRevenue::where('qrr_id',$id)->first();
            $greenfield=GreenfieldEmp::where('qrr_id',$id)->first();
            $dva=QrrDva::where('qrr_id',$id)->first();
            
            $mat=DvaBreakdownMat::where('qrr_id',$id)->get();
            $ser=DvaBreakdownSer::where('qrr_id',$id)->get();

            $qtr=$qrrMast->qtr_id;

            $currqtrdata=DB::table('qtr_master')->where('qtr_id',$qtr)->first('qtr');
        
            if($currqtrdata->qtr==1)
            {
                $oldqtr=1;
                
            }else{
                $oldqtr=$currqtrdata->qtr-1;
            }

            $qtrMaster=DB::table('qtr_master')->where('qtr',$oldqtr)->first();

            $oldQrr=$qtrMaster->qtr_id;
            $currQrr=$qtr;
            $qrrName=$qtr;

            $qrr_id = DB::table('qrr_master')->where('app_id',$app_id)->where('qtr_id',$oldQrr)->first();
        
            if($qrr_id){
                
            // dd($qrr_id);
                // if($qrr_id){

                    $matprev=DvaBreakdownMat::where('qrr_id',$qrr_id->id)->select('id','qrr_id','mattparticulars as mattprevparticulars','mattcountry as mattprevcountry','mattquantity as mattprevquantity','mattamount as mattprevamount')->get();

                    $serprev=DvaBreakdownSer::where('qrr_id',$qrr_id->id)->select('id','qrr_id','serrparticulars as serrprevparticulars','serrcountry as serrprevcountry','serrquantity as serrprevquantity','serramount as serrprevamount')->get();
                    // dd($serprev);
                // }


            }else{
                $matprev=DvaBreakdownMatPrev::where('qrr_id',$id)->get();
                $serprev=DvaBreakdownSerPrev::where('qrr_id',$id)->get();
            }

            $oldcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($oldQrr))->first();
            $currcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($currQrr))->first();

            return view('user.qrr.revenue_edit',compact('app_id','id','rev','dva','greenfield'
        ,'matprev','mat','ser','serprev','qrrName','oldcolumnName','currcolumnName','year'));
        }catch(Exception $e){
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $qrrMast = QRRMasters::where('id', $id)->where('status', 'D')->first();

            $app_dt=DB::table('approved_apps_details')->where('id',$qrrMast->app_id)->first();
        
            $year = substr($app_dt->approval_dt,0,4);


            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');
            }

            $rev=QrrRevenue::where('qrr_id',$id)->first();
            $emp=GreenfieldEmp::where('qrr_id',$id)->first();
            $dva=QrrDva::where('qrr_id',$id)->first();
            $rev->fill([
                'qrr_id'=>$request->qrr,
                'gcDomPrevQuantity'=>$request->gcDomPrevQuantity,
                'gcDomPrevSales'=>$request->gcDomPrevSales,
                'gcDomCurrQuantity'=>$request->gcDomCurrQuantity,
                'gcDomCurrSales'=>$request->gcDomCurrSales,
                'gcExpPrevQuantity'=>$request->gcExpPrevQuantity,
                'gcExpPrevSales'=>$request->gcExpPrevSales,
                'gcExpCurrQuantity'=>$request->gcExpCurrQuantity,
                'gcExpCurrSales'=>$request->gcExpCurrSales,
                'gcCapPrevQuantity'=>$request->gcCapPrevQuantity,
                'gcCapPrevSales'=>$request->gcCapPrevSales,
                'gcCapCurrQuantity'=>$request->gcCapCurrQuantity,
                'gcCapCurrSales'=>$request->gcCapCurrSales,
                'gcTotPrevQuantity'=>$request->gcTotPrevQuantity,
                'gcTotPrevSales'=>$request->gcTotPrevSales,
                'gcTotCurrQuantity'=>$request->gcTotCurrQuantity,
                'gcTotCurrSales'=>$request->gcTotCurrSales ,
                'ecDomPrevQuantity'=>$request->ecDomPrevQuantity,
                'ecDomPrevSales'=>$request->ecDomPrevSales,
                'ecDomCurrQuantity'=>$request->ecDomCurrQuantity,
                'ecDomCurrSales'=>$request->ecDomCurrSales,
                'ecExpPrevQuantity'=>$request->ecExpPrevQuantity,
                'ecExpPrevSales'=>$request->ecExpPrevSales,
                'ecExpCurrQuantity'=>$request->ecExpCurrQuantity,
                'ecExpCurrSales'=>$request->ecExpCurrSales,
                'ecCapPrevQuantity'=>$request->ecCapPrevQuantity,
                'ecCapPrevSales'=>$request->ecCapPrevSales,
                'ecCapCurrQuantity'=>$request->ecCapCurrQuantity,
                'ecCapCurrSales'=>$request->ecCapCurrSales,
                'ecTotPrevQuantity'=>$request->ecTotPrevQuantity,
                'ecTotPrevSales'=>$request->ecTotPrevSales,
                'ecTotCurrQuantity'=>$request->ecTotCurrQuantity,
                'ecTotCurrSales'=>$request->ecTotCurrSales,
                'otDomPrevQuantity'=>$request->otDomPrevQuantity,
                'otDomPrevSales'=>$request->otDomPrevSales,
                'otDomCurrQuantity'=>$request->otDomCurrQuantity,
                'otDomCurrSales'=>$request->otDomCurrSales,
                'otExpPrevQuantity'=>$request->otExpPrevQuantity,
                'otExpPrevSales'=>$request->otExpPrevSales,
                'otExpCurrQuantity'=>$request->otExpCurrQuantity,
                'otExpCurrSales'=>$request->otExpCurrSales,
                'otCapPrevQuantity'=>$request->otCapPrevQuantity,
                'otCapPrevSales'=>$request->otCapPrevSales,
                'otCapCurrQuantity'=>$request->otCapCurrQuantity,
                'otCapCurrSales'=>$request->otCapCurrSales,
                'otTotPrevQuantity'=>$request->otTotPrevQuantity,
                'otTotPrevSales'=>$request->otTotPrevSales,
                'otTotCurrQuantity'=>$request->otTotCurrQuantity,
                'otTotCurrSales'=>$request->otTotCurrSales,
                'otherPrevQuantity'=>$request->otherPrevQuantity,
                'otherPrevSales'=>$request->otherPrevSales,
                'otherCurrQuantity'=>$request->otherCurrQuantity,
                'otherCurrSales'=>$request->otherCurrSales,
                'totPrevQuantity'=>$request->totPrevQuantity,
                'totPrevSales'=>$request->totPrevSales,
                'totCurrQuantity'=>$request->totCurrQuantity,
                'totCurrSales'=>$request->totCurrSales,
                'created_by' => Auth::user()->id
            ]);
            $emp->fill([
                'laborPrevNo'=>$request->laborPrevNo,
                'laborCurrNo'=>$request->laborCurrNo,
                'empPrevNo'=>$request->empPrevNo,
                'empCurrNo'=>$request->empCurrNo,
                'conPrevNo'=>$request->conPrevNo,
                'conCurrNo'=>$request->conCurrNo,
                'appPrevNo'=>$request->appPrevNo,
                'appCurrNo'=>$request->appCurrNo,
                'totPrevNo'=>$request->totPrevNo,
                'totCurrNo'=>$request->totCurrNo,
                'created_by' => Auth::user()->id
            ]);

            $dva->fill([
                'EPprevquant'=>$request->EPprevquant,
                'EPprevsales'=>$request->EPprevsales,
                'EPprevamount'=>$request->EPprevamount,
                'EPcurrquant'=>$request->EPcurrquant,
                'EPcurrsales'=>$request->EPcurrsales,
                'EPcurramount'=>$request->EPcurramount,
                'totConprevquant'=>$request->totConprevquant,
                //'totConprevsales'=>$request->totConprevsales,
                'totConprevamount' =>$request->totConprevamount,
                'totConcurrquant'=>$request->totConcurrquant,
                // 'totConcurrsales'=>$request->totConcurrsales,
                'totConcurramount' =>$request->totConcurramount,
                'matprevquant'=>$request->matprevquant,
                // 'matprevsales'=>$request->matprevsales,
                'matprevamount'=>$request->matprevamount,
                'matcurrquant'=>$request->matcurrquant,
                // 'matcurrsales'=>$request->matcurrsales,
                'matcurramount'=>$request->matcurramount,
                'serprevquant'=>$request->serprevquant,
                // 'serprevsales'=>$request->serprevsales,
                'serprevamount'=>$request->serprevamount,
                'sercurrquant'=>$request->sercurrquant,
                // 'sercurrsales'=>$request->sercurrsales,
                'sercurramount'=>$request->sercurramount,
                'prevDVATotal'=>$request->prevDVATotal,
                'currDVATotal'=>$request->currDVATotal,
                'created_by' => Auth::user()->id
            ]);

            DB::transaction(function () use ($rev,$emp,$dva,$request) {
                $rev->save();
                $emp->save();
                $dva->save();

                // if($request->mattprev){
                //     foreach ($request->mattprev as $mp) {
                //         if (isset($mp['id'])) {
                //             $pro = DvaBreakdownMatPrev::find($mp['id']);
                //             $pro->mattprevparticulars = $mp['particulars'];
                //             $pro->mattprevcountry     = $mp['country'];
                //             $pro->mattprevquantity    = $mp['quantity'];
                //             $pro->mattprevamount      = $mp['amount'];
                //             $pro->created_by  = Auth::user()->id;
                //             $pro->save();
                //         }else{
                //             $emp=DvaBreakdownMatPrev::create([
                //                 'qrr_id'=>$request->qrr,
                //                 'mattprevparticulars'=>$mp['particulars'],
                //                 'mattprevcountry'    =>$mp['country'],
                //                 'mattprevquantity'   =>$mp['quantity'],
                //                 'mattprevamount'     =>$mp['amount'],
                //                 'created_by' => Auth::user()->id

                //             ]);
                //         }
                //     }
                // }

                if($request->mattcurr){
                    foreach ($request->mattcurr as $mp) {
                        if (isset($mp['id'])) {
                            $pro = DvaBreakdownMat::find($mp['id']);
                            $pro->mattparticulars = $mp['particulars'];
                            $pro->mattcountry     = $mp['country'];
                            $pro->mattquantity    = $mp['quantity'];
                            $pro->mattamount      = $mp['amount'];
                            $pro->created_by      = Auth::user()->id;
                            $pro->save();
                        }else{
                            $emp=DvaBreakdownMat::create([
                                'qrr_id'=>$request->qrr,
                                'mattparticulars'=>$mp['particulars'],
                                'mattcountry'    =>$mp['country'],
                                'mattquantity'   =>$mp['quantity'],
                                'mattamount'     =>$mp['amount'],
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                }

                // if($request->serrprev){
                //     foreach ($request->serrprev as $sr) {
                //         if (isset($sr['id'])) {
                //             $pro = DvaBreakdownSerPrev::find($sr['id']);
                //             $pro->serrprevparticulars = $sr['particulars'];
                //             $pro->serrprevcountry     = $sr['country'];
                //             $pro->serrprevquantity    = $sr['quantity'];
                //             $pro->serrprevamount      = $sr['amount'];
                //             $pro-> created_by = Auth::user()->id;
                //             $pro->save();
                //         }else{
                //             $emp=DvaBreakdownSerPrev::create([
                //                 'qrr_id'=>$request->qrr,
                //                 'serrprevparticulars'=>$sr['particulars'],
                //                 'serrprevcountry'    =>$sr['country'],
                //                 'serrprevquantity'   =>$sr['quantity'],
                //                 'serrprevamount'     =>$sr['amount'],
                //                 'created_by' => Auth::user()->id
                //             ]);
                //         }
                //     }
                // }

                if($request->serrcurr){
                foreach ($request->serrcurr as $sr) {
                    if (isset($sr['id'])) {
                        $pro = DvaBreakdownSer::find($sr['id']);
                        $pro->serrparticulars = $sr['particulars'];
                        $pro->serrcountry     = $sr['country'];
                        $pro->serrquantity    = $sr['quantity'];
                        $pro->serramount      = $sr['amount'];
                        $pro->created_by      = Auth::user()->id;
                        $pro->save();
                    }else{
                        $emp=DvaBreakdownSer::create([
                            'qrr_id'=>$request->qrr,
                            'serrparticulars'=>$sr['particulars'],
                            'serrcountry'    =>$sr['country'],
                            'serrquantity'   =>$sr['quantity'],
                            'serramount'     =>$sr['amount'],
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
                }

            });

            alert()->success('Revenue Details Saved', 'Success')->persistent('Close');
            return redirect()->route('revenue.edit',$id);
        }catch(Exception $e){
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

    }

    public function deleteMatPrev($id)
    {
        $manuloc=DvaBreakdownMatPrev::where('id',$id)->first();
        if($manuloc){
            $manuloc->delete();
        }
        alert()->success(' Deleted Successfully', 'Success')->persistent('Close');
        return redirect()->back();
    }
    public function deleteMat($id)
    {
        $manuloc=DvaBreakdownMat::where('id',$id)->first();
        if($manuloc){
            $manuloc->delete();
        }
        alert()->success(' Deleted Successfully', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteSerPrev($id)
    {
        $manuloc=DvaBreakdownSerPrev::where('id',$id)->first();
        if($manuloc){
            $manuloc->delete();
        }
        alert()->success('Deleted Successfully', 'Success')->persistent('Close');
        return redirect()->back();
    }
    public function deleteSer($id)
    {
        $manuloc=DvaBreakdownSer::where('id',$id)->first();
        if($manuloc){
            $manuloc->delete();
        }
        alert()->success(' Deleted Successfully', 'Success')->persistent('Close');
        return redirect()->back();
    }
    public function destroy($id)
    {
        //
    }
}
