<?php

namespace App\Http\Controllers\User\QRR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\QRRMasters;
use App\QrrStage;
use App\CompanyDetails;
use App\EvaluationDetails;
use App\ProposalDetails;
use App\ApprovalsRequired;
use Exception;


class QrrAdditionalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$qrrid)
    {
        try{
            $qtr_curr=DB::table('qrr_master')->where('id',$qrrid)->select('qtr_id')->first();
            $qtr_prev=DB::table('qrr_master')->where('qtr_id',$qtr_curr->qtr_id-1)->where('app_id',$id)->where('status', 'S')->select('id')->first();

            $approval_req=null;
            if($qtr_prev){
                $approval_req=DB::table('approvals_required')->where('qrr_id',$qtr_prev->id)->get();
            }

            $qrrMast = QRRMasters::where('id', $qrrid)
            ->where('app_id',$id)->where('status', 'D')->first();

            // dd($approval_req);
            $app_dt=DB::table('approved_apps_details')->where('id',$id)->first();
            
            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);
    
            $year= substr((end($fy_year)->fin_year),0,4);

            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');
            }
            $stage = QrrStage::where('qrr_id', $qrrid)->where('stage', 5)->first();
            if ($stage) {
                return redirect()->route('qrradditionalinfo.edit', $qrrid);
            }
            $appId=$qrrMast->app_id;
            $companyDet=CompanyDetails::where('app_id',$id)->first();
            
            $apps=DB::table('approved_apps')->where('id',$id)->first();
            $prods = DB::table('eligible_products')->where('id', $apps->eligible_product)->first();
            $eva_det=EvaluationDetails::where('app_id',$id)->first();
            $proposal_det=ProposalDetails::where('app_id',$id)->first();
            $green_mAddress=DB::table('manufacture_location')->where('qtr_id', $qrrid)
            ->where('app_id',$apps->id)->where('type','green')->get();
            $other_mAddress=DB::table('manufacture_location')->where('qtr_id', $qrrid)
            ->where('app_id',$apps->id)->where('type','other')->get();
            $qtr=$qrrMast->qtr_id;
            return view('user.qrr.additionalInfo',compact('appId','qrrid','qtr','apps','companyDet','prods','eva_det','proposal_det','green_mAddress','other_mAddress','qrrMast','approval_req'));
        }catch(Exception $e){
            alert()->error('Data fetch wrong when open create page.', 'Attention!')->persistent('Close');
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
            $qrrMast = QRRMasters::where('id', $request->qrrId)->where('status', 'D')->first();
            // dd($qrrMast);

            $app_dt=DB::table('approved_apps_details')->where('id',$qrrMast->app_id)->first();
            // dd($app_dt);
            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);

            $year= substr((end($fy_year)->fin_year),0,4);
            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');
            }
            DB::transaction(function () use ($request) {
            foreach ($request->approvals as $mp  ) {
                    $dmat=ApprovalsRequired::create([
                        'qrr_id'=>$request->qrrId,
                        'reqapproval'=>$mp['reqapproval'], 
                        'concernbody'=>$mp['concernbody'],
                        'isapproval'=>$mp['isapproval'], 
                        'dtvalidity'=>$mp['dtvalidity'], 
                        'dtexpected'=>$mp['dtexpected'], 
                        'process'=>$mp['process'], 
                        'created_by' => Auth::user()->id
                    ]);
                }

                QrrStage::create(['qrr_id' => $request->qrrId, 'stage' => 5, 'status' => 'D']);

                });

                alert()->success('Data Saved', 'Success!')->persistent('Close');
                
            return redirect()->route('qpr.byname',$request->qtr_name);
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

    public function deleteapproval($id){

        try{
            $approval=ApprovalsRequired::where('id',$id)->first();
            $qrrId=$approval->qtr_id;
            if($approval){
                $approval->delete();
                alert()->success('Deleted Successfully', 'Success')->persistent('Close');
            }
            else{
                alert()->error('No Approval Found', 'warning')->persistent('Close');
    
            }
            
            return redirect()->back();
        }catch(Exception $e){
            alert()->error('Approval data is not deleted.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

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
            
            $qrrid=$id;
        
            $app_dt=DB::table('approved_apps_details')->where('id',$qrrMast->app_id)->first();
            
            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);

            $year= substr((end($fy_year)->fin_year),0,4);

            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');
            }
            $app_id=$qrrMast->app_id;

            $stage = QrrStage::where('qrr_id', $id)->where('stage', 5)->first();

            $tot_stage = QrrStage::whereIn('qrr_id', [$id])->distinct('stage')->get();


            if (!$stage) {
                return redirect()->route('qrradditionalinfo.create',['id' => $app_id, 'qrrid' => $id]);
            }
            
            $appId=$qrrMast->app_id;

            $companyDet=CompanyDetails::where('app_id',$app_id)->first();
            $apps=DB::table('approved_apps')->where('id',$app_id)->first();
            $prods = DB::table('eligible_products')->where('id', $apps->eligible_product)->first();
            $eva_det=EvaluationDetails::where('app_id',$app_id)->first();
            $proposal_det=ProposalDetails::where('app_id',$app_id)->first();
            $green_mAddress=DB::table('manufacture_location')->where('qtr_id', $qrrid)
            ->where('app_id',$apps->id)->where('type','green')->get();
            $other_mAddress=DB::table('manufacture_location')->where('qtr_id', $qrrid)
            ->where('app_id',$apps->id)->where('type','other')->get();
            $qtr=$qrrMast->qtr_id;
            $approvalsDetails=ApprovalsRequired::where('qrr_id',$qrrMast->id)->orderby('id','ASC')->get();
        
            return view('user.qrr.additionalInfo-edit',compact('appId','qrrid','qtr','apps','companyDet','prods','eva_det','proposal_det','green_mAddress','other_mAddress','qrrMast','approvalsDetails','tot_stage'));
        }catch(Exception $e){
            alert()->error('Data fetch wrong when displaying data in edit page', 'Attention!')->persistent('Close');
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
            DB::transaction(function () use ($request) {
            if($request->approvals){
                foreach ($request->approvals as $mp) {
                    if (isset($mp['id'])) {
                        $pro = ApprovalsRequired::find($mp['id']);
                        $pro->reqapproval = $mp['reqapproval'];
                        $pro->concernbody = $mp['concernbody'];
                        $pro->isapproval  = $mp['isapproval'];
                        $pro->dtvalidity  = $mp['dtvalidity'];
                        $pro->dtexpected  = $mp['dtexpected'];
                        $pro->process     = $mp['process'];
                        $pro->created_by   = Auth::user()->id;
                        $pro->save();
                    }else{
                        $emp=ApprovalsRequired::create([
                        'qrr_id'=>$request->qrrId,
                        'reqapproval'=>$mp['reqapproval'], 
                        'concernbody'=>$mp['concernbody'],
                        'isapproval'=>$mp['isapproval'], 
                        'dtvalidity'=>$mp['dtvalidity'], 
                        'dtexpected'=>$mp['dtexpected'], 
                        'process'=>$mp['process'], 
                        'created_by'=>Auth::user()->id, 
                        ]);
                    }
                }
                }
            });

            alert()->success('Approvals Required Saved', 'Success')->persistent('Close');
            return redirect()->route('qrradditionalinfo.edit',$request->qrrId);
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
