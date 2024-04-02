<?php

namespace App\Http\Controllers\User\Claims;

use Illuminate\Http\Request;
use Carbon\Carbon ;
use DB;
use Auth;
use Mail;

use App\QRRMasters;
use App\CompanyDetails;
use App\EvaluationDetails;
use App\ClaimInvPeriod;
use App\ClaimInvCapacity;
use App\ProposalDetails;
use App\ClaimStage;
use App\ClaimMaster;
use App\ClaimBreakupInvBal;
use App\ClaimBreakupTotAddition;
use App\ClaimBreakupAssest;
use App\ClaimInvestmentEmp;
use App\Http\Controllers\Controller;
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



class ClaimPreviewController extends Controller
{
    public function claimpreveiw($id)
    {
        
        $claimMast=DB::table('claims_masters as cm')
        ->join('claim_applicant_details as cad','cad.claim_id','=','cm.id')
        ->join('claim_statutory_auditors as csa','csa.claim_id','=','cm.id')
        ->where('cm.id',$id)->first(); // Route::resource('claims', 'User\Claims\ClaimController');

        $shareholder=DB::table('claim_share_holding_patterns')->where('claim_id',$id)->get();
        $old_shareholder=DB::table('promoter_details')->where('app_id',$claimMast->app_id)->get();
        $appMast = DB::table('approved_apps_details')->where('id',$claimMast->app_id)->where('user_id',$claimMast->created_by)->first();
        $users = DB::table('users')->where('id',$appMast->user_id)->first();
        $manuf_loc=DB::table('claim_manuf_locs')->where('claim_id',$id)->get();
        $sh_patterns=DB::table('claim_share_holding_patterns')->where('claim_id',$id)->get();
        $shareholding_change=DB::table('claim_share_holding_patterns')->where('claim_id',$id)->first();
        // $statutory_auditor=DB::table('claim_statutory_auditors')->where('claim_id',$id)->first();
        $sh_docs=DB::table('claim_share_holding_docs')->where('claim_id',$id)->get();
        $fy=DB::table('fy_master')->where('status',1)->first();
        $claimUserResponse = DB::table('claim_question_user_responses')->where('claim_id',$id)->get();
        $arr_qtr=DB::table('qtr_master')->where('fy',$fy->fy_name)->where('status','1')->orderby('qtr')->get();
        $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');

        $city = DB::table('pincodes')->whereNotNull('city')->orderBy('city')->select('state','city')->get()->unique('city');


        //sales_prev

        $claimSalesParticular = DB::table('claim_sales_particulars')->get();

        $claimApproval = DB::table('claim_sales_of_ep_approval')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->first();
        // dd($claimMast);
        // $hsn = DB::table('claim_applicant_details')->where('claim_id',$id)->pluck('hsn','hsn')->first();
    //    dd($hsn);
        $claimAsQrr = DB::table('claim_sales_ep_qrr')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->first();

        $claimSalesManufTsGoods = DB::table('claim_sales_manuf_ts_goods')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->get();

        $claimRecSales = DB::table('claim_sales_reconciliation')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->orderby('part_id','ASC')->get();

        $claimBaselineSales = DB::table('claim_baseline_sales')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->first();
        $claimSalesDoc = DB::table('claim_sales_doc')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->get();
        $eligible_product=DB::table('approved_apps_details')->where('id',$claimMast->app_id)->get('product');
        $claimSalesConsumption = DB::table('claim_sales_consumption')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->first();

        $claimSalesContractAgreement = DB::table('claim_sales_contract_agreements')->where('claim_id',$id)->where('app_id',$claimMast->app_id)->get();
        $claimUserResponse = DB::table('claim_question_user_responses')->where('claim_id',$id)->where('created_by',$claimMast->created_by)->orderby('ques_id','ASC')->get();
        $product=DB::table('approved_apps_details')->where('id',$claimMast->app_id)->first('product');
        // dva_pre
        $raw_material = DB::table('claim_dva_key_material')->where('claim_id',$id)->get();

        $other_data = DB::table('claim_dva_other')->where('claim_id',$id)->orderby('prt_id','ASC')->get();

        // investment_prev

        // $apps = DB::table('approved_apps_details as a')
        // ->join('claims_masters as cm','cm.app_id','=','a.id')
        // ->where('cm.created_by', $claimMast->created_by)
        // ->whereNotNull('a.approval_dt')
        // ->where('cm.id',$id)
        // ->select('a.id as app_id','cm.id as claim_id')->first();
        // $claim_id=$apps->claim_id;
        $inv_part=DB::table('claim_investment_particular')->get();

        $claim_period =ClaimInvPeriod::where('claim_id',$id)
        ->where('created_by',$claimMast->created_by)->get()->toArray();
        // $capacity =ClaimInvCapacity::where('claim_id',$id)->where('created_by',$claimMast->created_by)->get()->toArray();
        // $manu_loc =ClaimInvManuLoc::where('claim_id',$id)->where('created_by',$claimMast->created_by)->get()->toArray();
        $capacity =DB::Table('claim_inv_annual_production_capcity as cia')->join('approved_apps_details as aad','aad.id','=','cia.app_id')->where('cia.claim_id',$id)->where('cia.created_by',$claimMast->created_by)->select('cia.*','aad.product as product_name')->get();

        $claim_brkp_inv =DB::table('claim_breakup_investment')->where('claim_id',$id)->where('created_by',$claimMast->created_by)->get();
        $claim_brkp_balsheet= ClaimBreakupInvBal::where('claim_id',$id)->where('created_by',$claimMast->created_by)->get()->toArray();
        $claim_brkp_totAdd=ClaimBreakupTotAddition::where('claim_id',$id)->where('created_by',$claimMast->created_by)->get()->toArray();
        $claim_brkp_assest=ClaimBreakupAssest::where('claim_id',$id)->where('created_by',$claimMast->created_by)->get()->toArray();

        $claim_emp =ClaimInvestmentEmp::where('claim_id',$id)->where('created_by',$claimMast->created_by)->first();
        // dd($claim_emp);
        //project-details
        $contents = ClaimDocProjectDet::where('claim_id', $id)->orderby('doc_id')->get();

        $docs = [];
        $docids = [];
        foreach($contents as $content)
        {
            $docids[] = $content->doc_id;
        }

        $projectDetRes1=ClaimProjectDetQues1::where('claim_id',$id)->get();
        $projectDetRes2=ClaimProjectDetQues2::where('claim_id',$id)->get()->toArray();

        $projectDetRes4=ClaimProjectDetQues4::where('claim_id',$id)->get();
        $projectDetRes5=ClaimProjectDetQues5::where('claim_id',$id)->get();
        $projectDetRes6=ClaimProjectDetQues6::where('claim_id',$id)->get();
        $projectDetRes7=ClaimProjectDetQues7::where('claim_id',$id)->get();
        $projectDetRes8=ClaimProjectDetQues8::where('claim_id',$id)->get();

        // $claimMast=ClaimMaster::where('id',$id)->first();
        $response_question=ClaimQuestionUserResponse::where('claim_id',$id)->orderBy('ques_id','asc')->get();

        //rpt
        $related_party=RelatedParty::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->OrderBy('related_prt_id','ASC')->get()->toArray();
       $pending=ClaimRptPendingDispute::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->get();
       $consi=ClaimRptConsideration::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->first();
    //    dd($consi);
       $price=ClaimRptPriceMechanism::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->first();
       $com_act=ClaimRptCompanyAct::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->get();
       $user_response=ClaimQuestionUserResponse::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->select('ques_id','response')->get()->toArray();
    //    dd($user_response);
       $pending_res=ClaimRptPendingDispute::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->first();
       $com_act_res=ClaimRptCompanyAct::where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->first();
       $doc_data1=DB::table('claim_doc_info_map')->where('claim_id',$id)->where('section','C')->where('app_id',$claimMast->app_id)->orderby('id')->get();
       $incetive_doc_map =DB::table('incetive_doc_map')->where('claim_id',$id)->orderby('id')->get();
       
       $incetive_doc_map = DB::table('incetive_doc_map')
        ->join('claim_20_percent_incentive_particular', 'incetive_doc_map.prt_id', '=', 'claim_20_percent_incentive_particular.serial_number')
        ->select('incetive_doc_map.*', 'claim_20_percent_incentive_particular.serial_number as serial_number', 'claim_20_percent_incentive_particular.doc_name as doc_name')
        ->where('serial_number',9)
        ->where('claim_id',$id)
        ->get();
       //dd($incetive_doc_map);
       //project detail
       $doc_data=DB::table('claim_doc_info_map')->where('claim_id',$id)->where('created_by',$claimMast->created_by)->where('app_id',$claimMast->app_id)->get();
        $genral_doc=DB::table('claim_gerneral_doc_detail')->where('created_by',$claimMast->created_by)->where('claim_id',$id)->where('app_id',$claimMast->app_id)->get();
        $response=DB::table('claim_gerneral_doc_detail')->where('created_by',$claimMast->created_by)->where('claim_id',$id)->where('app_id',$claimMast->app_id)->pluck('response')->first();
        $bank_info=DB::table('claim_doc_remmittance_incentive')->where('created_by',$claimMast->created_by)->where('claim_id',$id)->where('app_id',$claimMast->app_id)->first();
        
        $time_data = carbon::now();
        //dd($doc_data1);
        return view('user.claims.preview',compact('claimMast','shareholder','old_shareholder','appMast','users','manuf_loc','sh_patterns','shareholding_change','sh_docs','fy','arr_qtr','states','city','claimSalesParticular','claimApproval','claimAsQrr','claimSalesManufTsGoods','claimRecSales','claimBaselineSales','claimSalesDoc','eligible_product','claimSalesConsumption','claimSalesContractAgreement','claimUserResponse','product','raw_material','other_data','inv_part','claim_period','capacity','claim_brkp_inv','claim_brkp_balsheet','claim_brkp_totAdd','claim_brkp_assest','claim_emp','response_question','docids','contents'
        ,'projectDetRes1','projectDetRes2','projectDetRes4','projectDetRes5','projectDetRes6','time_data'
        ,'projectDetRes7','projectDetRes8','related_party','pending','consi','price','com_act','pending_res','com_act_res','user_response','doc_data','genral_doc','bank_info','response','doc_data1','incetive_doc_map'));

    }
   
    public function downloadfile($id)
    {

    
        $maxId =  DB::table('document_uploads as a')->max('id');
        if((strlen($id)) > strlen($maxId)){
            $ids = decrypt($id);
        }else{
            $ids = $id;
        }

        $doc =  DB::table('document_uploads as a')->join('document_master as dm','dm.doc_id','=','a.doc_id')->where('a.id',$ids)->select('a.*','dm.doc_type')->first();

        // dd($doc);

        ob_start();
        fpassthru($doc->uploaded_file);
        $docc= ob_get_contents();
        ob_end_clean();
        $ext = '';
        if($doc->mime == "application/pdf") {

            $ext = 'pdf';

        }elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {

            $ext = 'docx';

        }elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {

            $ext = 'xlsx';

        }
        elseif($doc->mime == "image/png")
        {
            $ext = 'png';
        }

        // dd($doc->file_name);
        $doc_name = $doc->doc_type;


        return response($docc)

        ->header('Cache-Control', 'no-cache private')

        ->header('Content-Description', 'File Transfer')

        ->header('Content-Type', $doc->mime)

        ->header('Content-length', strlen($docc))

        ->header('Content-Disposition', 'attachment; filename='.$doc_name.'.'.$ext)

        ->header('Content-Transfer-Encoding', 'binary');

    }
}
