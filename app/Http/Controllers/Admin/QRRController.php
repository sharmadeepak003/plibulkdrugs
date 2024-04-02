<?php

namespace App\Http\Controllers\Admin;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Mail;
use App\User;
use App\ProjectParticulars;
use App\InvestmentParticulars;
use App\DocumentUploads;
use App\CompanyDetails;
use App\EvaluationDetails;
use App\ProposalDetails;
use App\QRRMasters;
use App\QrrPDDetails;
use App\MeansOfFinance;
use App\scod;
use App\Upload;
use Exception;
use App\UploadMaster;
use App\QrrStage;
use App\QrrRevenue;
use App\GreenfieldEmp;
use App\QrrDva;
use App\DvaBreakdownMat;
use App\DvaBreakdownMatPrev;
use App\DvaBreakdownSer;
use App\DvaBreakdownSerPrev;
use App\ManufactureLocation;
use App\StatusOfLand;
use App\FinancialProgress;
use App\PhysicalProgress;
use App\InvestmentDetails;
use Excel;
use Auth;
use App\ApprovalsRequired;
use App\Exports\QRRExportAll;
use App\ManufactureProductCapacity;
use App\QrrOpenHistory;
use App\QrrMailLog;
use Carbon\Carbon;

class QRRController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin'], ['only' => ['qrrOpenEdit']]);
    }

    public function index()
    {

    }

    public function qrrDash(Request $request,$qtr)
    {
        $qrr=QrrMasters::join('approved_apps','approved_apps.id','=','qrr_master.app_id')
        ->join('eligible_products','eligible_products.id','=','approved_apps.eligible_product')
        ->join('users','approved_apps.created_by','=','users.id')
        ->where('qrr_master.qtr_id',$qtr)
        ->whereRaw('is_normal_user(approved_apps.created_by)=1')
        ->whereNotNull('approved_apps.app_no')
	    ->distinct()
        ->orderby('qrr_master.status','asc')
        ->select('qrr_master.*','approved_apps.app_no','approved_apps.round','users.name','eligible_products.target_segment','eligible_products.product')
        ->get();
        // dd($qrr);
        // $qrr_rev = DB::table('qrr_open_history')->where('qrr_id',$id)->orderby('id','DESC')->get();

        $totalqrr=DB::table('approved_apps')
            ->whereNotNull('app_no')
            ->whereRaw('is_normal_user(approved_apps.created_by)=1')
            ->count(DB::raw('DISTINCT id'));


        $fillqrr=DB::table('approved_apps as aa')
            ->join('qrr_master as qm','qm.app_id','=','aa.id')
            ->where('qm.qtr_id',$qtr)
            ->whereRaw('is_normal_user(aa.created_by)=1')
            ->where('qm.status','S')
            ->whereNotNull('aa.app_no')
            ->count(DB::raw('DISTINCT qm.app_id'));

        $pending_qrr=DB::table('approved_apps as aa')
            ->join('eligible_products','eligible_products.id','=','aa.eligible_product')
            ->join('users','aa.created_by','=','users.id')
            ->whereRaw('is_normal_user(aa.created_by)=1')
            ->whereNotExists(function($fillqrr) use($qtr)
            {
                $fillqrr->select('app_no')
                    ->from('qrr_master as qm')
                    ->whereRaw('aa.id = qm.app_id')
                    ->whereRaw('is_normal_user(aa.created_by)=1')
                    ->where('qm.qtr_id',$qtr)
                    ->where('qm.status','S');;
            })
            ->whereNotNull('aa.app_no')
            ->distinct()
            ->select('aa.id','aa.app_no','aa.round','users.name','eligible_products.target_segment','eligible_products.product')
            ->get();

        $notfillqrr=$pending_qrr->count('id');
        $qrrName=$qtr;
        $currQrr=$qrrName;
        $currcolumnName=DB::table('qtr_master')->where('qtr_id',$currQrr)->first();

        $qtrMast=DB::table('qtr_master')->where('status',1)->orderby('qtr','DESC')->get();

        return view('admin.qrr.dashboard', compact('qrr','qtr','totalqrr','fillqrr','pending_qrr','notfillqrr','currcolumnName','qtrMast'));
    }

    public function qrrView($id, $qtr)
    {
        // dd($id,$qtr);
        $appdata=QrrMasters::join('approved_apps_details as a','a.id','=','qrr_master.app_id')
        ->join('qtr_master','qtr_master.qtr_id','=','qrr_master.qtr_id')
        ->where('qrr_master.qtr_id',$qtr)
        ->where('qrr_master.id',$id)
        ->where('qtr_master.qtr_id',$qtr)
        ->whereNotNull('a.app_no')
	    ->distinct()
        ->select('a.app_no','a.name','a.target_segment','a.product','qrr_master.qtr_id','qtr_master.month','qtr_master.year')
        ->get();


        $qrrData= QRRMasters::where('id', $id)->where('qtr_id',$qtr)
        ->where('status', 'S')->first();
        $apps=DB::table('approved_apps')->where('id',$qrrData->app_id)->first();

        $companyDet=User::where('id',$apps->created_by)->first();
        // dd($companyDet);

        $user=User::where('id',$apps->created_by)->first();

        $prods = DB::table('eligible_products')
            ->where('id', $apps->eligible_product)->first();
        $eva_det=EvaluationDetails::where('app_id',$qrrData->app_id)->first();
        $proposal_det=ProposalDetails::where('app_id',$qrrData->app_id)->first();
        $app_id=$qrrData->app_id;
        $qtr=$qrrData->qtr_id;
        $mf=MeansOfFinance::where('qrr_id',$id)->first();
        $scod=scod::where('qrr_id',$id)->first();
        // dd($app_id);
        $green_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
            ->where('app_id',$app_id)->where('type','green')->get();
        $other_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
            ->where('app_id',$app_id)->where('type','other')->get();
        $prod_capacity=DB::table('manufacture_product_capacities')
            ->join('manufacture_location', DB::raw('manufacture_product_capacities.m_id :: INTEGER'), '=', 'manufacture_location.id')
            ->join('qrr_master', 'manufacture_location.app_id','=','qrr_master.app_id')
            ->where('qrr_master.qtr_id',$qtr)
            ->where('manufacture_location.qtr_id',$qtr)
            ->where('qrr_master.id',$id)
            ->get();

        //Revenue
        // dd($id);
        $rev=QrrRevenue::where('qrr_id',$id)->first();
        $greenfield=GreenfieldEmp::where('qrr_id',$id)->first();
        $dva=QrrDva::where('qrr_id',$id)->first();
        $matprev=DvaBreakdownMatPrev::where('qrr_id',$id)->get();
        $mat=DvaBreakdownMat::where('qrr_id',$id)->get();
        $serprev=DvaBreakdownSerPrev::where('qrr_id',$id)->get();
        $ser=DvaBreakdownSer::where('qrr_id',$id)->get();

        $address=ManufactureLocation::where('app_id',$qrrData->app_id)
        ->where('qtr_id',$qrrData->qtr_id)->where('type','green')->get();

        $proposeInvest=InvestmentDetails::join('investment_particulars','investment_details.prt_id','=','investment_particulars.id')
        ->where('investment_details.app_id',$qrrData->app_id)->get();


        $physicalProg=PhysicalProgress::where('qrr_id',$id)->first();
        $statusLand=StatusOfLand::where('qrr_id',$id)->get();
        $finProg=FinancialProgress::where('qrr_id',$id)->first();

        $contents = DocumentUploads::where('app_id',$qrrData->app_id)
        ->whereIn('doc_id',array(22,23,24,25,26,27))->get();

        $docs = [];
        $docids = [];
        $doc_names = [];

        foreach ($contents as $key => $content) {
            $docids[] = $content->doc_id;
            $doc_names[$content->doc_id] = $content->file_name;

            ob_start();
            fpassthru($content->uploaded_file);
            $doc = ob_get_contents();
            ob_end_clean();

            if ($content->mime == "application/pdf") {
                $docs[$content->doc_id] = "data:application/pdf;base64," . base64_encode($doc);
            } elseif ($content->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                $docs[$content->doc_id] = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64," . base64_encode($doc);
            } elseif ($content->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                $docs[$content->doc_id] = "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($doc);
            }elseif ($content->mime == "image/png") {
                $mime='png'; $docs[$content->doc_id] = "data:application/png;base64," . base64_encode($doc);
            }elseif ($content->mime == "image/jpeg"||$contents->mime == "image/jpg") {
                $mime='jpeg'; $docs[$content->doc_id] = "data:application/jpeg;base64," . base64_encode($doc);
            }
        }

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
        $pd=QrrPDDetails::where('qrr_id',$id)->first();
        $approvalsDetails=ApprovalsRequired::where('qrr_id',$id)->get();

        return view('admin.qrr.view',compact('appdata','id','companyDet','prods','apps'
        ,'eva_det','proposal_det','qtr','green_mAddress','prod_capacity','other_mAddress','qrrData'
    ,'mf','scod','app_id','rev','dva','greenfield','qrrName'
    ,'matprev','mat','ser','serprev','address','user','approvalsDetails'
    ,'proposeInvest','physicalProg','statusLand','finProg','docids','docs','doc_names','oldcolumnName','currcolumnName','pd'));
    }

    public function qrrExport($id, $qtr)
    {
        // dd('export',$type);
        return Excel::download(new QrrsExport($id, $qtr), 'qrrs.xlsx');
    }

    public function qrrExportAll($qtr,$type)
    {

        if($type == 'A'){
            return Excel::download(new QrrExportAll($qtr,$type), 'qrrsAll.xlsx');
        }else{
            return Excel::download(new QrrExportAll($qtr,$type), 'PendingQrrList.xlsx');
        }
    }

    public function qrrOpenEdit($id,$qtr){
        $page = QRRMasters::find($id);

        // Make sure you've got the Page model
        if($page) {
            $page->status = 'D';
            $page->save();

            $qrrHistory= new QrrOpenHistory;
            $qrrHistory->qrr_id=$id;
            $qrrHistory->qtr_id=$qtr;
            $qrrHistory->app_id=$page->app_id;
            $qrrHistory->updated_by=Auth::user()->id;
            $qrrHistory->status=$page->status;
            $qrrHistory->save();

            // $user = DB::table('qrr_master as qm')
            //     ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
            //      ->join('qtr_master as qm2','qm2.qtr_id','=','qm.qtr_id','left')
            //     ->where('qm.id',$id)
            //     ->select('aad.name','aad.email','aad.app_no','qm2.month','qm2.year')
            //     ->first();

            // $data = array('name'=>$user->name,'app_no'=>$user->app_no,'email'=>$user->email,'month'=>$user->month,'year'=>$user->year);

            // Mail::send('emails.openQrr', $data, function($message) use($data) {
            //     $message->to($data['email'],$data['name'])->subject
            //     ('QRR Open in Edit Mode Successful -PLI Bulk Drugs');
            //     $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
            // });
        }
        alert()->success('Qrr Successfully open in edit mode!', 'Success!')->persistent('Close');
        return redirect()->route('admin.qrr.dash',$qtr);
    }

    public function qrrCloseEdit($id,$qtr)
    {
        $qrrMast = QRRMasters::where('id', $id)->where('status', 'D')->first();
        if($qtr=='202101' || $qtr =='202102')
        {
            $stage = $qrrMast->qrrstages->pluck('stage')->toArray();
            $allStages = ['1', '2', '3','4'];
            $arrDiff1 = array_diff($stage, $allStages);
            $arrDiff2 = array_diff($allStages, $stage);
            $diff = array_merge($arrDiff1, $arrDiff2);
        }else
        {
            $stage = $qrrMast->qrrstages->pluck('stage')->toArray();
            $allStages = ['1', '2', '3','4','5'];
            $arrDiff1 = array_diff($stage, $allStages);
            $arrDiff2 = array_diff($allStages, $stage);
            $diff = array_merge($arrDiff1, $arrDiff2);
        }

        if ($diff) {
            alert()->error('User Not complete previous sections!', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
        DB::transaction(function () use ($id, $qtr) {
        QRRMasters::where('id', $id)->where('qtr_id', $qtr)->update(['status' => 'S']);
        $qrr=QRRMasters::where('id', $id)->where('qtr_id', $qtr)->select('id','qtr_id','app_id','status')->first();
        if($qrr) {
            $qrrHistory= new QrrOpenHistory;
            $qrrHistory->qrr_id=$id;
            $qrrHistory->qtr_id=$qtr;
            $qrrHistory->app_id=$qrr->app_id;
            $qrrHistory->updated_by=Auth::user()->id;
            $qrrHistory->status=$qrr->status;
            $qrrHistory->save();

            // $user = DB::table('qrr_master as qm')
            //     ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
            //      ->join('qtr_master as qm2','qm2.qtr_id','=','qm.qtr_id','left')
            //     ->where('qm.id',$id)
            //     ->select('aad.name','aad.email','aad.app_no','qm2.month','qm2.year')
            //     ->first();

            // $data = array('name'=>$user->name,'app_no'=>$user->app_no,'email'=>$user->email,'month'=>$user->month,'year'=>$user->year);

            // Mail::send('emails.closeQrr', $data, function($message) use($data) {
            //     $message->to($data['email'],$data['name'])->subject
            //     ('QRR Open in Edit Mode Successful -PLI Bulk Drugs');
            //     $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
            // });
        }
        });
        alert()->success('! Edit mode Successfully Closed !', 'Success!')->persistent('Close');
        return redirect()->route('admin.qrr.dash',$qtr);
    }

//For New Quarter Dashboard
    public function qrractivedash()
    {
        $qtrMast=DB::table('qtr_master')->orderBy('qtr')->get();
        return view('admin.qrr.QRR_active',compact('qtrMast'));
    }

// For Activate New Qrr
    public function qrractivation(Request $request)
    {
        $qtrMast=DB::table('qtr_master')->where('month',$request->month)
        ->where('year',$request->year)->first();

        DB::table('qtr_master')->where('month', $qtrMast->month)
        ->where('year', $qtrMast->year)->update(['status' =>  $request->status,'activated_by'=>Auth::User()->id]);

        if( $request->status==1)
        {
            $msg='Activate';
        }
        else{
            $msg='Deactivate';
        }

        alert()->success('New Quarter'.' '.$qtrMast->month.'-'.$qtrMast->year.' '.'has been'.' '.$msg, 'Success')->persistent('Close');
        return redirect()->route('admin.qrr.qrractivedash');
    }

// For Non-Submission Qrr Mail
    public function pendingQrrMail(Request $request)
    {

        try{
            $app=DB::table('approved_apps_details')->whereRaw('is_normal_user(approved_apps_details.user_id)=1')->select('id','app_no','name' ,'email' ,'product','user_id')->get();

            $qtr_master=DB::table('qtr_master')->where('qtr_id',$request->qtr)->select('month','yr_short')->first();

            foreach($app as $appRow)
            {
                $app_id=$appRow->id;

                $qrrRow=DB::table('qrr_master')
                ->where('qtr_id',$request->qtr)
                ->where('app_id',$app_id)
                ->where('status','S')
                ->first();

                // $qrr_mail_log = DB::table('qrr_mail_log')
                // ->where('qtr_id',$request->qtr)
                // ->where('app_id',$app_id)
                // ->first();

                if(empty($qrrRow))
                {
                    $data=array('name'=>$appRow->name,'app_no'=>$appRow->app_no,'email'=>$appRow->email,'product'=>$appRow->product,'month'=>$qtr_master->month,'year'=>$qtr_master->yr_short);

                    Mail::send('emails.QRR_reminder', $data, function($message) use($data) {
                    $message->to($data['email'],$data['name'])->subject
                    ('Non-Submission of Quarterly Review Report | PLI Scheme for Bulk Drugs | Reminder!');
                    $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
                    });

                    if( count(Mail::failures()) > 0 ) {
                        echo "There was one or more failures. They were: <br />";
                        foreach(Mail::failures as $email_address) {
                            echo " - $email_address <br />";
                            DB::transaction(function () use ($appRow,$request) {
                                QrrMailLog::create([
                                    'app_id'=>$appRow->id,
                                    'app_no'=>$appRow->app_no,
                                    'qtr_id'=>$request->qtr,
                                    'user_id'=>$appRow->user_id,
                                    'user_name'=>$appRow->name,
                                    'user_email'=>$appRow->email,
                                    'product'=>$appRow->product,
                                    'admin_id'=>Auth::user()->id,
                                    'admin_name'=>Auth::user()->name,
                                    'send_mail_date'=>Carbon::now()->format('Y-m-d'),
                                    'cc_email'=>'bdpli@ifciltd.com','PLI Bulk Drugs',
                                    'email_subject'=>'Non-Submission of Quarterly Review Report | PLI Scheme for Bulk   Drugs | Reminder!',
                                    'status'=>'0',
                                    'created_at'=>Carbon::now(),
                                    'updated_at'=>Carbon::now(),
                                ]);
                            });
                        }
                    } else {
                        DB::transaction(function () use ($appRow,$request) {
                            QrrMailLog::create([
                                'app_id'=>$appRow->id,
                                'app_no'=>$appRow->app_no,
                                'qtr_id'=>$request->qtr,
                                'user_id'=>$appRow->user_id,
                                'user_name'=>$appRow->name,
                                'user_email'=>$appRow->email,
                                'product'=>$appRow->product,
                                'admin_id'=>Auth::user()->id,
                                'admin_name'=>Auth::user()->name,
                                'send_mail_date'=>Carbon::now()->format('Y-m-d'),
                                'cc_email'=>'bdpli@ifciltd.com','PLI Bulk Drugs',
                                'email_subject'=>'Non-Submission of Quarterly Review Report | PLI Scheme for Bulk   Drugs | Reminder!',
                                'status'=>'1',
                                'created_at'=>Carbon::now(),
                                'updated_at'=>Carbon::now(),
                            ]);
                        });
                    }
                }
                $today=Carbon::now()->format('Y-m-d');
            }

            return redirect()->route('admin.qrr.QrrMailLog',$today);
        }catch(Exception $e){
            // dd($e);
            alert()->error('Please make sure there are no more pending qrr emails, then click the Send pending Qrr button once more', 'Attention!')->persistent('Close');
            return redirect()->route('admin.qrr.QrrMailLog',$today);
        }
    }

    public function QrrMailLog($today)
    {

      $MailData=DB::table('qrr_mail_log as  ql')
      ->join('qtr_master as  qm','qm.qtr_id','=','ql.qtr_id')
      ->join('eligible_products as  ep','ep.product','=','ql.product')
      ->where('send_mail_date',$today)->get(['ql.*','qm.month','qm.year','ep.target_segment']);

      $date=DB::table('qrr_mail_log as  ql')->distinct('send_mail_date')->get();

      return view('admin.qrr.QrrMailLog', compact('MailData','date'));
    }

    public static function getqrr() {
        $qtrMast=DB::table('qtr_master')->where('status',1)->orderby('qtr','DESC')->get();
        return $qtrMast[0]->qtr_id;
    }
}
