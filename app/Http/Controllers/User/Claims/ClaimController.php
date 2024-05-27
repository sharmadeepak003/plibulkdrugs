<?php
// namespace Aspose\Pdf\WorkingWithDocumentConversion;

// use com\aspose\pdf\Document as Document;

namespace App\Http\Controllers\User\Claims;

use Carbon;
use DB;
use Auth;
use Mail;
use PDF;
use Exception;
use File;

include "../vendor/autoload.php";

use Smalot\PdfParser\Parser;

use App\QRRMasters;
use App\SubmissionSms;
use App\AdminSubmissionSms;
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
use App\ApprovalsRequired;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public $user;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();
            //dd($this->user);
            $apps = DB::table('approved_apps')
                ->where('created_by', $this->user->id)
                ->whereNotNull('approval_dt')
                ->where('approved_apps.status', 'S')->get()->toArray();

            if (!$apps) {
                alert()->error('No Submitted or Approved Application!', 'Attention!')->persistent('Close');
                return redirect()->route('home');
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //dd($id);


        try {

            $apps = DB::table('approved_apps_details')
                ->leftjoin('claims_masters', 'approved_apps_details.id', 'claims_masters.app_id')
                ->where('user_id', Auth::user()->id)
                //->where('claims_masters.fy',$id)
                ->select('approved_apps_details.id as application_id', 'approved_apps_details.*', 'claims_masters.*')
                ->distinct('approved_apps_details.app_no')
                ->get();


            $claimMaster = DB::table('claims_masters')
                ->join('approved_apps_details', 'approved_apps_details.id', '=', 'claims_masters.app_id')
                ->where('fy', $id)->where('created_by', Auth::user()->id)
                ->select('approved_apps_details.id as application_id', 'approved_apps_details.*', 'claims_masters.*')
                ->get();
            //dd($claimMaster);
            $claimStage = DB::table('claim_stages')->where('created_by', Auth::user()->id)->get();

            $fy = DB::table('fy_master')->where('status', 1)->get();

            //get select fy year
            $getSelectedFy = DB::table('fy_master')->where('status', 1)->where('id', $id)->first();

            //dd($fy);

            $arr_claims = DB::table('claims_masters')
                ->join('approved_apps_details', 'approved_apps_details.id', '=', 'claims_masters.app_id')
                ->join('claim_applicant_details', 'claim_applicant_details.claim_id', '=', 'claims_masters.id')
                ->join('eligible_products', 'eligible_products.id', '=', 'approved_apps_details.eligible_product')
                ->join('qtr_master', 'qtr_master.qtr_id', '=', 'claim_applicant_details.incentive_from_date')
                ->join('qtr_master as qtr_master2', 'qtr_master2.qtr_id', '=', 'claim_applicant_details.incentive_to_date')
                ->where('claims_masters.created_by', Auth::user()->id)
                ->where('claims_masters.fy', $id)
                ->select('claims_masters.*', 'claim_applicant_details.incentive_from_date', 'claim_applicant_details.incentive_to_date', 'claim_applicant_details.claim_fill_period', 'claim_applicant_details.claim_id', 'approved_apps_details.app_no', 'approved_apps_details.name', 'eligible_products.target_segment as target_segment_name', 'eligible_products.ts_short_name as ts', 'eligible_products.product', "qtr_master.start_month", "qtr_master2.month as end_month")
                ->get();


            $doc_particular = DB::table('claim_20_percent_incentive_particular')->get();
            $claim_ids = $claimMaster->pluck('id')->toArray();

            $incentive_map_data = IncentiveDocMap::whereIn('claim_id', $claim_ids)->distinct('claim_id')->get();
            //dd($incentive_map_data);


            return view('user.claims.index', compact('id', 'apps', 'claimMaster', 'claimStage', 'fy', 'getSelectedFy', 'arr_claims', 'doc_particular', 'incentive_map_data'));
        } catch (Exception $e) {
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $fyId)
    {
        
        try {

            $claimAppDetail = ClaimMaster::where('app_id', $id)->where('fy', $fyId)->where('status', 'D')->get();

            $fy = DB::table('fy_master')->where('status', 1)->where('id', $fyId)->first();
            // dd($id, $fyId, $fy->fy_name, $claimAppDetail);
            //dd(count($claimAppDetail));

            if ($fy->fy_name !=  '2023-24') {
                alert()->error('Can not applied the Claim for the Session 2022-2023', 'Attention!')->persistent('Close');
                return redirect()->route('claims.index', $fy->status);
            }

            if (count($claimAppDetail) > 0) {

                alert()->error('Already in Edit Mode. Please submit claim form for this Application', 'Attention!')->persistent('Close');
                return redirect()->route('claims.index', $fy->status);
            }
            // else{
            //     alert()->error('Already submitted claim form for this Application', 'Attention!')->persistent('Close');
            //     return redirect()->route('claims.index', $fy->status);
            // }

            //dd($id, $fyId, $fy, $claimAppDetail);



            $shareholder = DB::table('promoter_details')->where('app_id', $id)->get();
            //$fy = DB::table('fy_master')->where('status', 1)->first();
            $appMast = DB::table('approved_apps_details')->where('id', $id)->first();
            //dd('ddsfds');

            $arr_qtr_id = ClaimMaster::where('app_id', $id)->where('status', 'S')->get()->toArray();
            //dd($shareholder,$fy,$appMast, count($arr_qtr_id), count($arr_qtr_id) > 0 );
            if (count($arr_qtr_id) > 0) {
                // $a = DB::select("select max(incentive_from_date) as incentive_from_date  from (select distinct (incentive_from_date) from claim_applicant_details cad  where app_id= $claimAppDetail->app_id
                // union
                // select distinct (incentive_to_date) from claim_applicant_details cad  where app_id=$id) a");

                $a = DB::select("select max(incentive_from_date) as incentive_from_date  from (select distinct (incentive_from_date) from claim_applicant_details cad  where app_id= $id
                union
                select distinct (incentive_to_date) from claim_applicant_details cad  where app_id=$id) a");

                $arr_qtr = DB::table('qtr_master')->where('fy', $fy->fy_name)->where('qtr_id', '>', $a[0]->incentive_from_date)->where('status', '1')->orderby('qtr')->get();
                // dd($shareholder,$fy,$appMast, count($arr_qtr_id), count($arr_qtr_id) > 0, $a, $arr_qtr );
            } else {

                $arr_qtr = DB::table('qtr_master')->where('fy', $fy->fy_name)->where('status', '1')->orderby('qtr')->get();
            }

            $manufac = DB::table('manufacture_location')->where('app_id', $id)->where('type', 'green')->select('address')->first();


            $users = DB::table('users as u')
                ->join('approved_apps_details as aad', 'u.id', '=', 'aad.user_id')
                ->where('aad.id', $id)
                ->select('u.*')->first();

            $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');
            return view('user.claims.applicant_detail', compact('fyId', 'appMast', 'fy', 'users', 'shareholder', 'states', 'id', 'manufac', 'arr_qtr'));
        } catch (Exception $e) {
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
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
        // dd($request);
        // dd("store");
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
        //
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
        dd('inside claim update controller');
        //
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

    public function getClaimsByName($id)
    {

        $apps = DB::table('approved_apps')
            ->join('eligible_products', 'eligible_products.id', '=', 'approved_apps.eligible_product')
            ->where('created_by', $this->user->id)
            ->whereNotNull('approved_apps.approval_dt')
            ->where('approved_apps.status', 'S')
            ->select(
                'approved_apps.*',
                'eligible_products.id as ep_id',
                'eligible_products.code',
                'eligible_products.target_segment',
                'eligible_products.product',
                'eligible_products.min_cap',
                'eligible_products.short_name',
                DB::raw('row_number() OVER () rownum')
            )->get();

        $appsIds = DB::table('approved_apps')
            ->join('eligible_products', 'eligible_products.id', '=', 'approved_apps.eligible_product')
            ->where('created_by', $this->user->id)
            ->whereNotNull('approved_apps.approval_dt')
            ->where('approved_apps.status', 'S')
            ->pluck('approved_apps.id');

        $qrrMast = DB::table('qrr_master')->where('qtr_id', $id)->whereIn('app_id', $appsIds)->get();
        $qrrName = $id;
        $qrrAppIds = $qrrMast->pluck('app_id')->toArray();
        $qrrMaster = null;
        foreach ($qrrMast as $a) {
            $qrrMaster[$a->id] = QRRMasters::where('id', $a->id)->get();
        }

        $currQrr = $qrrName;
        $currcolumnName = DB::table('qtr_master')->whereIn('qtr_id', array($currQrr))->first();


        $qtrMast = DB::table('qtr_master')->get();
        // dd($qtrMast,$qrrMast,$qrrName,$qrrMaster,$qrrAppIds);
        return view('user.claims.index', compact('apps', 'qrrMast', 'qrrName', 'qrrMaster', 'qrrAppIds', 'currcolumnName', 'qtrMast'));
    }


    public function upload()
    {

        $doc_part = DB::table('claim_doc_particular')->get();
        return view('user.claim.upload', compact('doc_part'));
    }

    public function finalSubmit($claim_id)
    {
        
        try {
            if (Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-12-31 23:59:00'))) {
                $claimMast = ClaimMaster::where('id', $claim_id)->where('status', 'D')->first();

                //dd($claimMast);

                $stage = ClaimStage::where('claim_id', $claim_id)->pluck('stages')->toArray();

                $allStages = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];

                $arrDiff1 = array_diff($stage, $allStages);
                $arrDiff2 = array_diff($allStages, $stage);
                $diff = array_merge($arrDiff1, $arrDiff2);


                if ($diff) {
                    alert()->error('Please complete previous sections first!', 'Attention!')->persistent('Close');
                    return redirect()->back();
                }

                $userdetail = DB::select("select * from users
                join claims_masters cm on cm.created_by=users.id
                join fy_master fy on fy.id=cm.fy::integer where users.id=$claimMast->created_by");

                //dd($userdetail);

                $revision_dt = DB::table('claim_open_history')->where('claim_id', $claim_id)->orderby('id', 'DESC')->first();

                DB::transaction(function () use ($claimMast, $claim_id, $userdetail, $revision_dt) {
                    if ($claimMast) {
                        if ($claimMast && $revision_dt == null) {
                            //dd('if');
                            $claimMaster = ClaimMaster::find($claim_id);
                            $claimMaster->status = 'S';
                            $claimMaster->submitted_at = Carbon\Carbon::now();
                            //$claimMaster->save();
                        }
                        elseif ($claimMast && $revision_dt) {
                            dd('elseif');
                            $claimMaster = ClaimMaster::find($claim_id);
                            $claimMaster->status = 'S';
                            $claimMaster->revision_dt = Carbon\Carbon::now();
                            //$claimMaster->save();
                        }

                        $d_data = DB::table('claim_applicant_details')->where('claim_id', $claim_id)->select('incentive_from_date', 'incentive_to_date')->first();

                        $from_dt = DB::table('qtr_master')->where('qtr_id', $d_data->incentive_from_date)->select('start_month', 'year')->first();
                        $to_dt = DB::table('qtr_master')->where('qtr_id', $d_data->incentive_to_date)->select('month', 'year')->first();

                        $user = array(
                            'name' => $userdetail[0]->name, 'email' => $userdetail[0]->email,
                            'from_dt' => $from_dt->start_month, 'to_dt' => $to_dt->month, 'status' => 'Incentive Claim Form Submitted Successfully',
                            'fr_year' => $from_dt->year, 'to_year' => $to_dt->year
                        );

                        //below code for to send SMS to Admin 07052024
                        
                        $getClaimsMasterData = DB::table('claims_masters')->where('id', $claim_id)->first(['created_by', 'fy']);
                        $claim_year = DB::table('fy_master')->where('id', $getClaimsMasterData->fy)->first('fy_name');
                        $admin_number = DB::table('users')->where('email', 'dgm.md@ifciltd.com')->first();

                        $SMS = new SubmissionSms();
                        $message1 = array($claim_year->fy_name);
                        $module = "Claim";
                        //$smsResponse = $SMS->sendSMS(Auth::user()->mobile, $message1, $module);

                        $SMS2 = new AdminSubmissionSms();
                        $module2 = "Claim";
                        $message2 = array($claim_year->fy_name, Auth::user()->name);
                        //$smsResponse = $SMS2->sendSMS($admin_number->mobile, $message2, $module2);

                        // End below code for to send SMS to Admin 07052024

                        Mail::send('emails.claimFinalSubmit', $user, function ($message) use ($user) {
                            $message->to($user['email'])->subject($user['status']);
                            $message->cc('bdpli@ifciltd.com');
                        });
                    }

                    alert()->success('Claim has been Submitted', 'Success')->persistent('Close');
                });
                return redirect()->route('claims.index', 1);
            } else {
                alert()->error(' !! The claim form has been closed. You can not submit your form. !!', 'Warning!')->persistent('Close');
                return redirect()->route('claims.index', 1);
            }
        } catch (Exception $e) {
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }


    public function downloadfile($id)
    {
        //
        try {
            $maxId = DB::table('document_uploads as a')->max('id');

            if ((strlen($id)) > strlen($maxId)) {
                $ids = decrypt($id);
            } else {
                $ids = $id;
            }

            $doc = DB::table('document_uploads as a')->join('document_master as dm', 'dm.doc_id', '=', 'a.doc_id')->where('a.id', $ids)->select('a.*', 'dm.doc_type')->first();
            // dd($doc);
            ob_start();
            fpassthru($doc->uploaded_file);
            $docc = ob_get_contents();
            ob_end_clean();
            $ext = '';
            if ($doc->mime == "application/pdf") {

                $ext = 'pdf';
            } elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {

                $ext = 'docx';
            } elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {

                $ext = 'xlsx';
            } elseif ($doc->mime == 'application/vnd.ms-excel') {
                $ext = 'xls';
            } elseif ($doc->mime == 'application/vnd.ms-excel') {
                $ext = 'xlsx';
            } elseif ($doc->mime == "image/png") {
                $ext = 'png';
            }

            $doc_name = $doc->file_name;


            return response($docc)

                ->header('Cache-Control', 'no-cache private')

                ->header('Content-Description', 'File Transfer')

                ->header('Content-Type', $doc->mime)

                ->header('Content-length', strlen($docc))

                ->header('Content-Disposition', 'attachment; filename=' . $doc_name . '.' . $ext)

                ->header('Content-Transfer-Encoding', 'binary');
        } catch (Exception $e) {
            alert()->error('File not available. Please try Again', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }


    public function claimincentivestatus($claimId)
    {

        $getClaimIncentiveData =  DB::table('admin_claim_incentive')->where('claim_id', $claimId)->where('claim_status', '=', 'S')->first();
        $qtr = DB::table('qtr_master')->get();
        return view('user.claims.claimincentivestatus', compact('getClaimIncentiveData', 'qtr'));
    }
}
