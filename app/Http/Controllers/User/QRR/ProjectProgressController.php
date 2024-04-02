<?php

namespace App\Http\Controllers\User\QRR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ManufactureLocation;
use App\StatusOfLand;
use App\FinancialProgress;
use App\PhysicalProgress;
use App\QRRMasters;
use App\QrrStage;
use App\InvestmentDetails;
use DB;
use Auth;
use Exception;


class ProjectProgressController extends Controller
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
        try{
            $qrrMast = QRRMasters::where('id', $qrr)
            ->where('app_id',$id)->where('status', 'D')->first();

            $app_dt=DB::table('approved_apps_details')->where('id',$id)->first();
            
            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);
    
            $year= substr((end($fy_year)->fin_year),0,4);

            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');
            }
            $stage = QrrStage::where('qrr_id', $qrr)->where('stage', 3)->first();
            if ($stage) {
                return redirect()->route('projectprogress.edit', $qrr);
            }

            $address=ManufactureLocation::where('app_id',$id)
            ->where('qtr_id',$qrrMast->qtr_id)->where('type','green')->get();

            $proposeInvest=InvestmentDetails::join('investment_particulars','investment_details.prt_id','=','investment_particulars.id')
            ->where('investment_details.app_id',$id)->get();
            // $proposeInvest=DB::table('investment_details')
            // ->leftJoin('investment_particulars', 'investment_details.prt_id','=','investment_particulars.id')
            // ->where('investment_details.app_id',$id)->get();
            $qrrName=$qrrMast->qtr_id;
            $finProg=new FinancialProgress();
            $physicalProg=new PhysicalProgress();

            $currqtrdata=DB::table('qtr_master')->where('qtr_id',$qrrName)->first('qtr');
            $oldqtr=$currqtrdata->qtr-1;
            if($oldqtr == 0){
                $oldqtr = 1;
            }
            $qtrMaster=DB::table('qtr_master')->where('qtr',$oldqtr)->first();
            $oldQrr=$qtrMaster->qtr_id;
            $currQrr=$qrrMast->qtr_id;

            if($qrrName!=$year.'01'){
                $qrrMast = QRRMasters::where('app_id',$id)->where('qtr_id',$oldQrr)->first();
                if($qrrMast){
                    $finProg=FinancialProgress::where('qrr_id',$qrrMast->id)->first();
                    $physicalProg=PhysicalProgress::where('qrr_id',$qrrMast->id)->first();

                }
            }

            $oldcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($oldQrr))->first();
            $currcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($currQrr))->first();
            return view('user.qrr.project_progress',compact('id','qrr','address','proposeInvest','qrrName','finProg','physicalProg','oldcolumnName','currcolumnName','year'));
        }catch(Exception $e){
            alert()->error('Data fetch wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
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
            $fp=new FinancialProgress();

                    $fp->fill([
                        'qrr_id'=>$request->qrr,
                        'bprevExpense'=>$request->bprevExpense,
                        'bcurrExpense'=>$request->bcurrExpense,
                        'pprevExpense'=>$request->pprevExpense,
                        'pcurrExpense'=>$request->pcurrExpense,
                        'lprevExpense'=>$request->lprevExpense,
                        'lcurrExpense'=>$request->lcurrExpense,
                        'eprevExpense'=>$request->eprevExpense,
                        'ecurrExpense'=>$request->ecurrExpense,
                        'rdprevExpense'=>$request->rdprevExpense,
                        'rdcurrExpense'=>$request->rdcurrExpense,
                        'efprevExpense'=>$request->efprevExpense,
                        'efcurrExpense'=>$request->efcurrExpense,
                        'solidprevExpense'=>$request->solidprevExpense,
                        'solidcurrExpense'=>$request->solidcurrExpense,
                        'hprevExpense'=>$request->hprevExpense,
                        'hcurrExpense'=>$request->hcurrExpense,
                        'wsprevExpense'=>$request->wsprevExpense,
                        'wscurrExpense'=>$request->wscurrExpense,
                        'rwprevExpense'=>$request->rwprevExpense,
                        'rwcurrExpense'=>$request->rwcurrExpense,
                        'swprevExpense'=>$request->swprevExpense,
                        'swcurrExpense'=>$request->swcurrExpense,
                        'dmprevExpense'=>$request->dmprevExpense,
                        'dmcurrExpense'=>$request->dmcurrExpense,
                        'stmprevExpense'=>$request->stmprevExpense,
                        'stmcurrExpense'=>$request->stmcurrExpense,
                        'caprevExpense'=>$request->caprevExpense,
                        'cacurrExpense'=>$request->cacurrExpense,
                        'coprevExpense'=>$request->coprevExpense,
                        'cocurrExpense'=>$request->cocurrExpense,
                        'boprevExpense'=>$request->boprevExpense,
                        'bocurrExpense'=>$request->bocurrExpense,
                        //'bocurrExpense'=>$request->bocurrExpense,
                        'poprevExpense'=>$request->poprevExpense,
                        'pocurrExpense'=>$request->pocurrExpense,
                        'stprevExpense'=>$request->stprevExpense,
                        'stcurrExpense'=>$request->stcurrExpense,
                        'misprevExpense'=>$request->misprevExpense,
                        'miscurrExpense'=>$request->miscurrExpense,
                        'totprevExpense'=>$request->totprevExpense,
                        'totcurrExpense'=>$request->totcurrExpense,
                        'created_by' => Auth::user()->id,
                    ]);
            $mf=new PhysicalProgress();
                    $mf->fill([
                        'qrr_id' => $request->qrr,
                        'bArea'     =>$request->barea,
                        'bStartDate'=>$request->bStartDate,
                        'bCompDate' =>$request->bCompDate,
                        'bRemarks'  =>$request->bRemarks,
                        'oArea'     =>$request->oarea,
                        'oStartDate'=>$request->oStartDate,
                        'oCompDate' =>$request->oCompDate,
                        'oRemarks'  =>$request->oRemarks,
                        'cArea'     =>$request->carea,
                        'cStartDate'=>$request->cStartDate,
                        'cCompDate'=>$request->cCompDate,
                        'cRemarks'=>$request->cRemarks,
                        'uArea'=>$request->uarea,
                        'uStartDate'=>$request->uStartDate,
                        'uCompDate'=>$request->uCompDate,
                        'uRemarks'=>$request->uRemarks,
                        'pArea'=>$request->parea,
                        'pStartDate'=>$request->pStartDate,
                        'pCompDate'=>$request->pCompDate,
                        'pRemarks'=>$request->pRemarks,
                        'lArea'=>$request->larea,
                        'lStartDate'=>$request->lStartDate,
                        'lCompDate'=>$request->lCompDate,
                        'lRemarks'=>$request->lRemarks,
                        'rArea'=>$request->rarea,
                        'rStartDate'=>$request->rStartDate,
                        'rCompDate'=>$request->rCompDate,
                        'rRemarks'=>$request->rRemarks,
                        'eArea'=>$request->earea,
                        'eStartDate'=>$request->eStartDate,
                        'eCompDate'=>$request->eCompDate,
                        'eRemarks'=>$request->eRemarks,
                        'sArea'=>$request->sarea,
                        'sStartDate'=>$request->sStartDate,
                        'sCompDate'=>$request->sCompDate,
                        'sRemarks'=>$request->sRemarks,
                        'hArea'=>$request->harea,
                        'hStartDate'=>$request->hStartDate,
                        'hCompDate'=>$request->hCompDate,
                        'hRemarks'=>$request->hRemarks,
                        'wArea'=>$request->warea,
                        'wStartDate'=>$request->wStartDate,
                        'wCompDate'=>$request->wCompDate,
                        'wRemarks'=>$request->wRemarks,
                        'rwArea'=>$request->rwarea,
                        'rwStartDate'=>$request->rwStartDate,
                        'rwCompDate'=>$request->rwCompDate,
                        'rwRemarks'=>$request->rwRemarks,
                        'swArea'=>$request->swarea,
                        'swStartDate'=>$request->swStartDate,
                        'swCompDate'=>$request->swCompDate,
                        'swRemarks'=>$request->swRemarks,
                        'dmwArea'=>$request->dmwarea,
                        'dmwStartDate'=>$request->dmwStartDate,
                        'dmwCompDate'=>$request->dmwCompDate,
                        'dmwRemarks'=>$request->dmwRemarks,
                        'stmArea'=>$request->stmarea,
                        'stmStartDate'=>$request->stmStartDate,
                        'stmCompDate'=>$request->stmCompDate,
                        'stmRemarks'=>$request->stmRemarks,
                        'caArea'=>$request->caarea,
                        'caStartDate'=>$request->caStartDate,
                        'caCompDate'=>$request->caCompDate,
                        'caRemarks'=>$request->caRemarks,
                        'coArea'=>$request->coarea,
                        'coStartDate'=>$request->coStartDate,
                        'coCompDate'=>$request->coCompDate,
                        'coRemarks'=>$request->coRemarks,
                        'boArea'=>$request->boarea,
                        'boStartDate'=>$request->boStartDate,
                        'boCompDate'=>$request->boCompDate,
                        'boRemarks'=>$request->boRemarks,
                        'pgArea'=>$request->pgarea,
                        'pgStartDate'=>$request->pgStartDate,
                        'pgCompDate'=>$request->pgCompDate,
                        'pgRemarks'=>$request->pgRemarks,
                        'stArea'=>$request->starea,
                        'stStartDate'=>$request->stStartDate,
                        'stCompDate'=>$request->stCompDate,
                        'stRemarks'=>$request->stRemarks,
                        'misArea'=>$request->misarea,
                        'misStartDate'=>$request->misStartDate,
                        'misCompDate'=>$request->misCompDate,
                        'misRemarks'=>$request->misRemarks,
                        'created_by' => Auth::user()->id,
                    ]);

            DB::transaction(function () use ($mf,$fp,$request) {
                $mf->save();
                $fp->save();
                if($request->address){
                    foreach ($request->address as $key=> $address  ) {
                        $det = StatusOfLand::create([
                            'qrr_id'=>$request->qrr,
                            'mid' => $key,
                            'area' => $address['area'],
                            'acqusition' => $address['acqusition'],
                            'freeleash' => $address['freelease'],
                            'created_by' => Auth::user()->id,
                        ]);
                    }
                }
                QrrStage::create(['qrr_id' => $request->qrr, 'stage' => 3, 'status' => 'D']);

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
        
            $stage = QrrStage::where('qrr_id', $id)->where('stage', 3)->first();
            if (!$stage) {
                return redirect()->route('projectprogress.create', ['id' => $app_id, 'qrr' => $id]);
            }
            $address=ManufactureLocation::leftJoin('status_of_land','status_of_land.mid','=','manufacture_location.id')
            ->where('app_id',$qrrMast->app_id)->where('qtr_id',$qrrMast->qtr_id)->where('type','green')
            ->select('manufacture_location.*','status_of_land.id as sid','status_of_land.qrr_id',
            'status_of_land.mid','status_of_land.area','status_of_land.freeleash','status_of_land.acqusition')->get();
            
            $proposeInvest=InvestmentDetails::join('investment_particulars','investment_details.prt_id','=','investment_particulars.id')
            ->where('investment_details.app_id',$qrrMast->app_id)->get();

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

            $oldcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($oldQrr))->first();
            $currcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($currQrr))->first();

            $physicalProg=PhysicalProgress::where('qrr_id',$id)->first();

            $statusLand=StatusOfLand::where('qrr_id',$id)->get();
            $finProg=FinancialProgress::where('qrr_id',$id)->first();
            return view('user.qrr.project_progress_edit',compact('app_id','id','address'
            ,'proposeInvest','physicalProg','statusLand','finProg','qrrName','oldcolumnName','currcolumnName','year'));
        }catch(Exception $e){
            alert()->error('Data fetch wrong when displaying data in Edit page.', 'Attention!')->persistent('Close');
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
            // dd($app_dt);
             $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);
    
            $year= substr((end($fy_year)->fin_year),0,4);
            
            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');

            }
            $fp=FinancialProgress::where('qrr_id',$id)->first();
            $pp = PhysicalProgress::where('qrr_id',$id)->first();
            $fp->fill([
                'bprevExpense'=>$request->bprevExpense,
                'bcurrExpense'=>$request->bcurrExpense,
                'pprevExpense'=>$request->pprevExpense,
                'pcurrExpense'=>$request->pcurrExpense,
                'lprevExpense'=>$request->lprevExpense,
                'lcurrExpense'=>$request->lcurrExpense,
                'eprevExpense'=>$request->eprevExpense,
                'ecurrExpense'=>$request->ecurrExpense,
                'rdprevExpense'=>$request->rdprevExpense,
                'rdcurrExpense'=>$request->rdcurrExpense,
                'efprevExpense'=>$request->efprevExpense,
                'efcurrExpense'=>$request->efcurrExpense,
                'solidprevExpense'=>$request->solidprevExpense,
                'solidcurrExpense'=>$request->solidcurrExpense,
                'hprevExpense'=>$request->hprevExpense,
                'hcurrExpense'=>$request->hcurrExpense,
                'wsprevExpense'=>$request->wsprevExpense,
                'wscurrExpense'=>$request->wscurrExpense,
                'rwprevExpense'=>$request->rwprevExpense,
                'rwcurrExpense'=>$request->rwcurrExpense,
                'swprevExpense'=>$request->swprevExpense,
                'swcurrExpense'=>$request->swcurrExpense,
                'dmprevExpense'=>$request->dmprevExpense,
                'dmcurrExpense'=>$request->dmcurrExpense,
                'stmprevExpense'=>$request->stmprevExpense,
                'stmcurrExpense'=>$request->stmcurrExpense,
                'caprevExpense'=>$request->caprevExpense,
                'cacurrExpense'=>$request->cacurrExpense,
                'coprevExpense'=>$request->coprevExpense,
                'cocurrExpense'=>$request->cocurrExpense,
                'boprevExpense'=>$request->boprevExpense,
                'bocurrExpense'=>$request->bocurrExpense,
                'poprevExpense'=>$request->poprevExpense,
                'pocurrExpense'=>$request->pocurrExpense,
                'stprevExpense'=>$request->stprevExpense,
                'stcurrExpense'=>$request->stcurrExpense,
                'misprevExpense'=>$request->misprevExpense,
                'miscurrExpense'=>$request->miscurrExpense,
                'totprevExpense'=>$request->totprevExpense,
                'totcurrExpense'=>$request->totcurrExpense,
                'created_by'=>Auth::user()->id,
            ]);
            $pp->fill([
                'bArea'     =>$request->barea,
                'bStartDate'=>$request->bStartDate,
                'bCompDate' =>$request->bCompDate,
                'bRemarks'  =>$request->bRemarks,
                'oArea'     =>$request->oarea,
                'oStartDate'=>$request->oStartDate,
                'oCompDate' =>$request->oCompDate,
                'oRemarks'  =>$request->oRemarks,
                'cArea'     =>$request->carea,
                'cStartDate'=>$request->cStartDate,
                'cCompDate'=>$request->cCompDate,
                'cRemarks'=>$request->cRemarks,
                'uArea'=>$request->uarea,
                'uStartDate'=>$request->uStartDate,
                'uCompDate'=>$request->uCompDate,
                'uRemarks'=>$request->uRemarks,
                'pArea'=>$request->parea,
                'pStartDate'=>$request->pStartDate,
                'pCompDate'=>$request->pCompDate,
                'pRemarks'=>$request->pRemarks,
                'lArea'=>$request->larea,
                'lStartDate'=>$request->lStartDate,
                'lCompDate'=>$request->lCompDate,
                'lRemarks'=>$request->lRemarks,
                'rArea'=>$request->rarea,
                'rStartDate'=>$request->rStartDate,
                'rCompDate'=>$request->rCompDate,
                'rRemarks'=>$request->rRemarks,
                'eArea'=>$request->earea,
                'eStartDate'=>$request->eStartDate,
                'eCompDate'=>$request->eCompDate,
                'eRemarks'=>$request->eRemarks,
                'sArea'=>$request->sarea,
                'sStartDate'=>$request->sStartDate,
                'sCompDate'=>$request->sCompDate,
                'sRemarks'=>$request->sRemarks,
                'hArea'=>$request->harea,
                'hStartDate'=>$request->hStartDate,
                'hCompDate'=>$request->hCompDate,
                'hRemarks'=>$request->hRemarks,
                'wArea'=>$request->warea,
                'wStartDate'=>$request->wStartDate,
                'wCompDate'=>$request->wCompDate,
                'wRemarks'=>$request->wRemarks,
                'rwArea'=>$request->rwarea,
                'rwStartDate'=>$request->rwStartDate,
                'rwCompDate'=>$request->rwCompDate,
                'rwRemarks'=>$request->rwRemarks,
                'swArea'=>$request->swarea,
                'swStartDate'=>$request->swStartDate,
                'swCompDate'=>$request->swCompDate,
                'swRemarks'=>$request->swRemarks,
                'dmwArea'=>$request->dmwarea,
                'dmwStartDate'=>$request->dmwStartDate,
                'dmwCompDate'=>$request->dmwCompDate,
                'dmwRemarks'=>$request->dmwRemarks,
                'stmArea'=>$request->stmarea,
                'stmStartDate'=>$request->stmStartDate,
                'stmCompDate'=>$request->stmCompDate,
                'stmRemarks'=>$request->stmRemarks,
                'caArea'=>$request->caarea,
                'caStartDate'=>$request->caStartDate,
                'caCompDate'=>$request->caCompDate,
                'caRemarks'=>$request->caRemarks,
                'coArea'=>$request->coarea,
                'coStartDate'=>$request->coStartDate,
                'coCompDate'=>$request->coCompDate,
                'coRemarks'=>$request->coRemarks,
                'boArea'=>$request->boarea,
                'boStartDate'=>$request->boStartDate,
                'boCompDate'=>$request->boCompDate,
                'boRemarks'=>$request->boRemarks,
                'pgArea'=>$request->pgarea,
                'pgStartDate'=>$request->pgStartDate,
                'pgCompDate'=>$request->pgCompDate,
                'pgRemarks'=>$request->pgRemarks,
                'stArea'=>$request->starea,
                'stStartDate'=>$request->stStartDate,
                'stCompDate'=>$request->stCompDate,
                'stRemarks'=>$request->stRemarks,
                'misArea'=>$request->misarea,
                'misStartDate'=>$request->misStartDate,
                'misCompDate'=>$request->misCompDate,
                'misRemarks'=>$request->misRemarks,
                'created_by'=>Auth::user()->id,
            ]);

            DB::transaction(function () use ($fp,$pp,$request) {
                $fp->save();
                $pp->save();
                if($request->address){
                    foreach($request->address as $key => $status){
                        $addres=StatusOfLand::where('mid',$key)->first();

                        if($addres==null){
                            StatusOfLand::create([
                                'qrr_id'=>$request->qrr,
                                'mid' => $key,
                                'area' => $status['area'],
                                'acqusition' => $status['acqusition'],
                                'freeleash' => $status['freelease'],
                                'created_by'=>Auth::user()->id,
                            ]);
                        }else{
                            $addres->area = $status['area'];
                            $addres->acqusition = $status['acqusition'];
                            $addres->freeleash =$status['freelease'];
                            $addres->created_by=Auth::user()->id;
                            $addres->save();
                        }
                    }
                }
            });

            alert()->success('Project Progress Details Saved', 'Success')->persistent('Close');
            return redirect()->route('projectprogress.edit',$id);
        }catch(Exception $e){
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
