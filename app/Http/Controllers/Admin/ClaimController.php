<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon;
use DB;
use Auth;
use App\QRRMasters;
use App\CompanyDetails;
use App\EvaluationDetails;
use App\ClaimInvPeriod;
use App\ClaimInvCapacity;
use App\ProposalDetails;
use App\ClaimOpenHistory;
use App\ClaimStage;
use App\ClaimMaster;
use App\ClaimBreakupInvBal;
use App\ClaimBreakupTotAddition;
use App\ClaimBreakupAssest;
use App\ClaimInvestmentEmp;
use App\ApprovalsRequired;
use App\ClaimProjectDetQues1;
use App\ClaimProjectDetQues2;
use App\ClaimProjectDetQues3;
use App\ClaimProjectDetQues4;
use App\ClaimProjectDetQues5;
use App\ClaimProjectDetQues6;
use App\ClaimProjectDetQues7;
use App\ClaimProjectDetQues8;
use App\ClaimDocProjectDet;
use App\ClaimQuestionUserResponse;

use App\RelatedParty;
use App\ClaimRptCompanyAct;
use App\ClaimRptPendingDispute;
use App\ClaimRptConsideration;
use App\ClaimRptPriceMechanism;
use App\IncentiveDocMap;


class ClaimController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin'], ['only' => ['claim_edit']]);
    }

    public function claimdashboard()
    {
        $fy = DB::table('fy_master')->where('status', 1)->get();


        // dd($fy);
        $claim_fy=1;
        
        $appData = DB::table('approved_apps_details as aa')
            ->leftJoin('claims_masters as cm', function($join) use($claim_fy){
                $join->on('aa.id', '=', 'cm.app_id')
                ->join('claim_applicant_details as cad','cad.claim_id','=','cm.id')
                ->join('qtr_master','qtr_master.qtr_id','=','cad.incentive_from_date')
                ->join('qtr_master as qtr_master2','qtr_master2.qtr_id','=','cad.incentive_to_date')
                ->where('cm.fy', $claim_fy);
            })
            ->whereRaw('is_normal_user(aa.user_id)=1')
            ->select('aa.id as app_id','cm.fy','cad.claim_fill_period','aa.name','aa.product','aa.target_segment','aa.id as app_id','aa.target_segment_id','cm.id as claim_id','cm.status as claim_status','cm.submitted_at','cm.updated_at','qtr_master.start_month','qtr_master2.month','cm.revision_dt')
            ->orderBy('cm.id')
            ->get();
            // dd($fy);

            $claim_ids= DB::table('claims_masters')->pluck('id')->toArray();
            // dd($claim_ids);
            $incentive_map_data=IncentiveDocMap::whereIn('claim_id',$claim_ids)->get();
            // dd($incentive_map_data);
            // $mm = '2023-24';
            $getFy ='';
        return view('admin.claim.dashboard',compact('fy','getFy','appData','incentive_map_data'));
    }

    public function claimyearwise(Request $request)
    {
        $id = $request->fy_name;
        
        $getFyData = DB::table('fy_master')->where('id',$id)->where('status', 1)->first();
        $getFy = $getFyData->fy_name;
        $fy = DB::table('fy_master')->where('status', 1)->get();
        $claim_fy = $id;

        $appData = DB::table('approved_apps_details as aa')
            ->leftJoin('claims_masters as cm', function($join) use($claim_fy){
                $join->on('aa.id', '=', 'cm.app_id')
                ->join('claim_applicant_details as cad','cad.claim_id','=','cm.id')
                ->join('qtr_master','qtr_master.qtr_id','=','cad.incentive_from_date')
                ->join('qtr_master as qtr_master2','qtr_master2.qtr_id','=','cad.incentive_to_date')
                ->where('cm.fy', $claim_fy);
            })
            ->whereRaw('is_normal_user(aa.user_id)=1')
            ->select('aa.id as app_id','cm.fy','cad.claim_fill_period','aa.name','aa.product','aa.target_segment','aa.id as app_id','aa.target_segment_id','cm.id as claim_id','cm.status as claim_status','cm.submitted_at','cm.updated_at','qtr_master.start_month','qtr_master2.month','cm.revision_dt')
            ->orderBy('cm.id')
            ->get();

            $claim_ids= DB::table('claims_masters')->pluck('id')->toArray();
            $incentive_map_data=IncentiveDocMap::whereIn('claim_id',$claim_ids)->get();
            return view('admin.claim.dashboard',compact('fy','getFy','appData','incentive_map_data'));

        // dd($request->fy_name, $fy, $appData);
    }

    public function claim_edit($claim_id){

        $page = ClaimMaster::find($claim_id);

        if($page) {
            $page->status = 'D';
            $page->save();
            $claim_data= new ClaimOpenHistory;
            $claim_data->claim_id=$claim_id;
            $claim_data->app_id=$page->app_id;
            $claim_data->change_by=Auth::user()->id;
            $claim_data->status=$page->status;
            $claim_data->save();
        }

        alert()->success('Claim Successfully open in edit mode!', 'Success!')->persistent('Close');
        return redirect()->route('admin.claim.claimdashboard');
    }

    public function claim_close($claim_id)
    {
        $claimMast = ClaimMaster::where('id', $claim_id)->where('status', 'D')->first();

        $stage = ClaimStage::where('claim_id', $claim_id)->pluck('stages')->toArray();

        $allStages = ['1', '2', '3','4','5','6','7','8'];

        $arrDiff1 = array_diff($stage, $allStages);
        $arrDiff2 = array_diff($allStages, $stage);
        $diff = array_merge($arrDiff1, $arrDiff2);


        if ($diff) {
            alert()->error('User Not complete previous sections!', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

        DB::transaction(function () use ($claim_id, $claimMast) {
            ClaimMaster::where('id', $claim_id)->update(['status' => 'S']);
            $claim=ClaimMaster::where('id', $claim_id)->select('id','app_id','status')->first();
            if($claim) {
                $claim_data= new ClaimOpenHistory;
                $claim_data->claim_id=$claim_id;
                $claim_data->app_id=$claim->app_id;
                $claim_data->change_by=Auth::user()->id;
                $claim_data->status=$claim->status;
                $claim_data->save();
            }
        });
        alert()->success('! Edit mode Successfully Closed !', 'Success!')->persistent('Close');
        return redirect()->route('admin.claim.claimdashboard');
    }

    public function twenty_per_incentive_edit($claim_id)
    {
        
        // below code for open edit mode 20% incentive
        // $pages = IncentiveDocMap::where('claim_id',$claim_id)->get();
        //$getFy = ClaimMaster::find($claim_id);
        // if ($pages->isNotEmpty()) {
            // foreach ($pages as $page) {
            //     $page->status = 'D';
            //     $page->edit_auth_id = Auth::user()->id;
            //     $page->edit_by_dt = now();
            //     $page->save();
            // }
        // }
        // $user_id=Auth::user()->id;
        

        // $claim_id = 1; // Set the desired claim_id

        IncentiveDocMap::where('claim_id', $claim_id)
            ->update([
                'status' => 'D',
                'edit_auth_id' => Auth::user()->id,
                'edit_by_dt' => now(),
            ]);

        // if($page) {
        //     $page->status = 'D';
        //     $page->edit_auth_id = Auth::user()->id;
        //     $page->edit_by_dt = Carbon::now();
        //     $page->save();
            
        // }

        alert()->success('Claim 20% Incentive Successfully open in edit mode!', 'Success!')->persistent('Close');
        return redirect()->route('admin.claim.claimdashboard');  
    }
}
