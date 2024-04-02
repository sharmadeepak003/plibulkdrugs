<?php

namespace App\Http\Controllers\User\QRR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Collection;
use App\ApplicationMast;
use Carbon;
use App\FeeDetails;
use App\QrrPDDetails;
use Mail;
use App\Mail\AppSubmit;
use App\ProjectParticulars;
use App\InvestmentParticulars;
use App\DocumentUploads;
use App\CompanyDetails;
use App\EvaluationDetails;
use App\ProposalDetails;
use App\QRRMasters;
use App\MeansOfFinance;
use App\scod;
use App\Upload;
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
use App\ApprovalsRequired;
use App\ManufactureProductCapacity;
use Exception;

class QRRController extends Controller
{
    public $user;

    public function __construct() {

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            //dd($this->user);
            $apps = DB::table('approved_apps')
            ->where('created_by', $this->user->id)
            ->whereNotNull('approval_dt')
            ->where('approved_apps.status','S')->get()->toArray();

            if(!$apps){
                alert()->error('No Submitted or Approved Application!', 'Attention!')->persistent('Close');
                return redirect()->route('home');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // new function created as requirement
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    

    public function create($id, $qrrName)
    {
        
        try{
            $qtr_mast=DB::table('qtr_master')->where('qtr_id',$qrrName)->first();
            $currqtrdata=$qtr_mast->qtr;
            $pre_qtr_id=DB::table('qtr_master')->where('qtr',$qtr_mast->qtr-1)->first('qtr_id');
            $qtr_curr=DB::table('qrr_master')->where('qtr_id',$qrrName)->select('qtr_id')->first();
        
            $app_dt=DB::table('approved_apps_details')->where('id',$id)->first();
            
            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);

            $year= substr((end($fy_year)->fin_year),0,4);

            
            $qtr_prev=DB::table('qrr_master')->where('qtr_id',$pre_qtr_id->qtr_id)->where('app_id',$id)->where('status', 'S')->select('id')->first();

            if($qtr_prev){
            
                $commercial_dt=DB::table('scod')->where('qrr_id',$qtr_prev->id)->first();
            }else{
                $commercial_dt = null;
            }

            $oldqtr=$currqtrdata-1;
            if($oldqtr == 0){
                $oldqtr = 1;
            }

            $qtrMaster=DB::table('qtr_master')->where('qtr',$oldqtr)->first();

            $qtr = $qrrName;

            //for-dynamic qtr approval 
            
            // if($qtrMaster){
                // $qrrMast = QRRMasters::where('app_id',$id)->where('qtr_id',$qtrMaster->qtr_id)->where('status','S')->first();

            // }
            // else{
            //     $qrrMast = QRRMasters::where('app_id',$id)->where('qtr_id',$qrrName)->where('status','S')->first();
            // }
            // $qrrMast = QRRMasters::where('app_id',$id)->where('qtr_id',$qtrMaster->qtr_id)->where('status','S')->first();
        
            $qrrMast = QRRMasters::where('app_id',$id)->where('qtr_id',$qtrMaster->qtr_id)->where('status','S')->first();

            if(!($qrrMast || $qtr == $year.'01') )
            {
                alert()->error('Please fill QRR for Previous Quarter First!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$qtrMaster->qtr_id);
            }

            $qrrMast = QRRMasters::where('app_id',$id)->get();

            $companyDet=CompanyDetails::where('app_id',$id)->where('created_by',Auth::user()->id)->first();
            
            $apps=DB::table('approved_apps')->where('id',$id)->first();
            $prods = DB::table('eligible_products')->where('id', $apps->eligible_product)->first();
            $eva_det=EvaluationDetails::where('app_id',$id)->first();
            $proposal_det=ProposalDetails::where('app_id',$id)->first();
            $green_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
            ->where('app_id',$apps->id)->where('type','green')->get();
            $other_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
            ->where('app_id',$apps->id)->where('type','other')->get();

            return view('user.qrr.create',compact('companyDet','prods','apps'
            ,'eva_det','proposal_det','qtr','green_mAddress','other_mAddress','qrrMast','commercial_dt'));
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
        //dd('store');
        try{
            $qrrMast = QRRMasters::where('app_id',$request->app_id)
            ->where('qtr_id',$request->qtr_name)->first();
            if($qrrMast){
                alert()->error('Application already exists', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$request->qtr_name);
            }
            $mAddress=DB::table('manufacture_location')->where('qtr_id', $request->qtr_name)
            ->where('app_id',$request->app_id)->get('manufacture_location.id');

            if($mAddress->isEmpty()){
                alert()->error('Please add Green Field Manufacting Location', 'Attention!')->persistent('Close');
                return redirect()->back();
            }

            $user = Auth::user();
            $master= new QRRMasters();
            $mf=new MeansOfFinance();
            // $qrr_pd=new QrrPDDetails();
            $sc=new scod();
            $maxid = getMaxID($master->getTable());

            $master->fill([
                'id' => $maxid+1,
                'status' => 'D',
                'app_id' => $request->app_id,
                'qtr_id' => $request->qtr_name,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'created_by' => Auth::user()->id
            ]);

            $mf->fill(['eAmount' => $request->eAmount,
                        'eStatus' => $request->eStatus,
                        'eRemarks' => $request->eRemarks,
                        'iAmount' => $request->iAmount,
                        'iStatus' => $request->iStatus,
                        'iRemarks' => $request->iRemarks,
                        'tAmount' => $request->tAmount,
                        'dAmount' => $request->dAmount,
                        'dStatus' => $request->dStatus,
                        'dRemarks' => $request->dRemarks, 
                        'created_by' => Auth::user()->id]);

            $sc->fill(['committed_annual' => $request->proCap,
            'commercial_op' => $request->dateCO, 'created_by' => Auth::user()->id]);
        
            // $qrr_pd->fill(['annual_capacity' => $request->pd_capacity]);

            DB::transaction(function () use ($request,$master, $mf, $sc){
                $master->save();
                $max_appid = getMaxID($master->getTable());
                QrrStage::create(['qrr_id' => $max_appid, 'stage' => 1, 'status' => 'D']);

                $qrr_data = new QrrPDDetails;
                    $qrr_data->qrr_id=$max_appid;
                    $qrr_data->annual_capacity=$request->pd_capacity;
                    $qrr_data->created_by= Auth::user()->id;
                $qrr_data->save();

                $scod_data = new QrrPDDetails;
                    $scod_data->qrr_id=$max_appid;
                    $scod_data->annual_capacity=$request->pd_capacity;
                    $scod_data->created_by= Auth::user()->id;
                $scod_data->save();

                $mf->qrr_id = $max_appid;
                $sc->qrr_id = $max_appid;
            
                $mf->save();
                $sc->save();
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
        // try{
            $qrrData= QRRMasters::where('id', $id)->first();
            $app_dt=DB::table('approved_apps_details')->where('id',$qrrData->app_id)->first();
            
            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);
    
            $year= substr((end($fy_year)->fin_year),0,4);
        
            if (!$qrrData) {
                alert()->error('No Submitted QRR!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$year.'01');
            }

            //QRR Details
            $companyDet=CompanyDetails::where('app_id',$qrrData->app_id)->where('created_by',Auth::user()->id)->first();
            $apps=DB::table('approved_apps')->where('id',$qrrData->app_id)->first();
            $prods = DB::table('eligible_products')
                ->where('id', $apps->eligible_product)->first();
            $eva_det=EvaluationDetails::where('app_id',$qrrData->app_id)->first();
            $proposal_det=ProposalDetails::where('app_id',$qrrData->app_id)->first();
            $app_id=$qrrData->app_id;
            $qtr=$qrrData->qtr_id;
            $mf=MeansOfFinance::where('qrr_id',$id)->first();

            $scod=scod::where('qrr_id',$id)->first();
            
            $green_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
                ->where('app_id',$app_id)->where('type','green')->get();
            $other_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
                ->where('app_id',$app_id)->where('type','other')->get();
            

            $pd=QrrPDDetails::where('qrr_id',$id)->first();
        
            $prod_capacity=DB::table('manufacture_product_capacities')
                ->join('manufacture_location', DB::raw('manufacture_product_capacities.m_id :: INTEGER'), '=', 'manufacture_location.id')
                ->join('qrr_master', 'manufacture_location.app_id','=','qrr_master.app_id')
                ->where('qrr_master.qtr_id',$qtr)
                ->where('manufacture_location.qtr_id',$qtr)
                ->where('qrr_master.id',$id)
                ->get();

            //Revenue
            $rev=QrrRevenue::where('qrr_id',$id)->first();
            $greenfield=GreenfieldEmp::where('qrr_id',$id)->first();
            $dva=QrrDva::where('qrr_id',$id)->first();
            // $matprev=DvaBreakdownMatPrev::where('qrr_id',$id)->get();
            $mat=DvaBreakdownMat::where('qrr_id',$id)->get();
            // $serprev=DvaBreakdownSerPrev::where('qrr_id',$id)->get();
            $ser=DvaBreakdownSer::where('qrr_id',$id)->get();

            //Project Progress
            $address=ManufactureLocation::where('app_id',$qrrData->app_id)
            ->where('qtr_id',$qrrData->qtr_id)->where('type','green')->get();

            $proposeInvest=InvestmentDetails::join('investment_particulars','investment_details.prt_id','=','investment_particulars.id')
            ->where('investment_details.app_id',$qrrData->app_id)->get();


            $physicalProg=PhysicalProgress::where('qrr_id',$id)->first();
            $statusLand=StatusOfLand::where('qrr_id',$id)->get();
            $finProg=FinancialProgress::where('qrr_id',$id)->first();

            //Uploads
            $contents =  $contents = DocumentUploads::where('app_id',$qrrData->app_id)
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

                if ($content->mime == "image/png") {
                    $mime='png'; $docs[$content->doc_id] = "data:application/png;base64," . base64_encode($doc);
                }elseif ($content->mime == "image/jpeg"||$contents->mime == "image/jpg") {
                    $mime='jpeg'; $docs[$content->doc_id] = "data:application/jpeg;base64," . base64_encode($doc);
                }
            }

            $approvalsDetails=ApprovalsRequired::where('qrr_id',$id)->get();
            
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

            if($oldQrr){
                $qrr_id = DB::table('qrr_master')->where('app_id',$app_id)->where('qtr_id',$oldQrr)->first();
                if($qrr_id !=null){
                    $matprev=DvaBreakdownMat::where('qrr_id',$qrr_id->id)->select('id','qrr_id','mattparticulars as mattprevparticulars','mattcountry as mattprevcountry','mattquantity as mattprevquantity','mattamount as mattprevamount')->get();
                    // dd($oldQrr,$qrr_id->id,$matprev);

                    $serprev=DvaBreakdownSer::where('qrr_id',$qrr_id->id)->select('id','qrr_id','serrparticulars as serrprevparticulars','serrcountry as serrprevcountry','serrquantity as serrprevquantity','serramount as serrprevamount')->get();
                }else{
                    $matprev=DvaBreakdownMat::where('qrr_id',$id)->select('id','qrr_id','mattparticulars as mattprevparticulars','mattcountry as mattprevcountry','mattquantity as mattprevquantity','mattamount as mattprevamount')->get();
                    // dd($oldQrr,$id,$matprev);

                    $serprev=DvaBreakdownSer::where('qrr_id',$id)->select('id','qrr_id','serrparticulars as serrprevparticulars','serrcountry as serrprevcountry','serrquantity as serrprevquantity','serramount as serrprevamount')->get();
                }
            }else{

                $matprev=DvaBreakdownMatPrev::where('qrr_id',$id)->get();
                $serprev=DvaBreakdownSerPrev::where('qrr_id',$id)->get();
                
            }
            // dd($matprev,)
            $oldcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($oldQrr))->first();
            $currcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($currQrr))->first();

            return view('user.qrr.preview',compact('contents','id','companyDet','prods','apps','qrrName','eva_det','proposal_det','qtr','green_mAddress','other_mAddress','prod_capacity','qrrData','mf','scod','app_id','rev','dva','greenfield','matprev','mat','ser','serprev','address','proposeInvest','physicalProg','statusLand','finProg','docids','docs','doc_names','approvalsDetails','oldcolumnName','currcolumnName','pd','year'));
        // }catch(Exception $e){
        //     alert()->error('Something went wrong', 'Attention!')->persistent('Close');
        //     return redirect()->back();
        // }

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
            $qrrData=QRRMasters::where('id',$id)->first();

            $companyDet=CompanyDetails::where('app_id',$qrrData->app_id)->where('created_by',Auth::user()->id)->first();
        
            $apps=DB::table('approved_apps')->where('id',$qrrData->app_id)->first();
            $prods = DB::table('eligible_products')
                ->where('id', $apps->eligible_product)->first();
            $eva_det=EvaluationDetails::where('app_id',$qrrData->app_id)->first();
            $proposal_det=ProposalDetails::where('app_id',$qrrData->app_id)->first();

        $app_id=$qrrData->app_id;
        $qtr=$qrrData->qtr_id;
        $mf=MeansOfFinance::where('qrr_id',$id)->first();
    
        $app_dt=DB::table('approved_apps_details')->where('id',$app_id)->first();
            
        $year = substr($app_dt->approval_dt,0,4);
    
        $scod=scod::where('qrr_id',$id)->first();
        $currqtrdata=DB::table('qtr_master')->where('qtr_id',$qtr)->first('qtr');
        $pre_qtr_id=DB::table('qtr_master')->where('qtr',$currqtrdata->qtr-1)->first('qtr_id');
            $qtr_prev = null;
            if(!empty($pre_qtr_id))
                $qtr_prev=DB::table('qrr_master')->where('qtr_id',$pre_qtr_id->qtr_id)->where('app_id',$app_id)->where('status', 'S')->select('id')->first();
            
            
            if($qtr_prev && $scod->committed_annual != 'yes')
            {
                $scod=scod::where('qrr_id',$qtr_prev->id)->first();

                if($scod->committed_annual=='yes')
                {
                    $scod=scod::where('qrr_id',$qtr_prev->id)->first();
                }else{
                    $scod=scod::where('qrr_id',$id)->first();
                }	
            }else{
                $scod=scod::where('qrr_id',$id)->first();
            }

        $pd=QrrPDDetails::where('qrr_id',$id)->first();
    
        $green_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
            ->where('app_id',$app_id)->where('type','green')->get();
            
            $other_mAddress=DB::table('manufacture_location')->where('qtr_id', $qtr)
            ->where('app_id',$app_id)->where('type','other')->get();

            return view('user.qrr.create_edit',compact('companyDet','prods','apps','eva_det','proposal_det','qtr','green_mAddress','other_mAddress','qrrData','mf','scod','pd','app_id','year','qtr_prev'));
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

            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->back();
            }
            $green_mAddress=DB::table('manufacture_location')->where('qtr_id', $qrrMast->qtr_id)
            ->where('app_id',$qrrMast->app_id)->where('type','green')->get('manufacture_location.id');

            if($green_mAddress->isEmpty()){
                alert()->error('Please add Green Field Manufacturing Location', 'Attention!')->persistent('Close');
                return redirect()->back();
            }

            $mf=MeansOfFinance::where('qrr_id',$id)->first();
            $sc=scod::where('qrr_id',$id)->first();
        
            $pd=QrrPDDetails::where('qrr_id',$id)->first();
            $mf->fill([
                'eAmount' => $request->eAmount,
                        'eStatus' => $request->eStatus,
                        'eRemarks' => $request->eRemarks,
                        'iAmount' => $request->iAmount,
                        'iStatus' => $request->iStatus,
                        'iRemarks' => $request->iRemarks,
                        'tAmount' => $request->tAmount,
                        'dAmount' => $request->dAmount,
                        'dStatus' => $request->dStatus,
                        'dRemarks' => $request->dRemarks,
                        'created_by' => Auth::user()->id
                ]);

            $sc->fill(['committed_annual' => $request->proCap,
            'commercial_op' => $request->dateCO,'created_by' => Auth::user()->id]);
            // dd($request->pd_capacity);

            DB::transaction(function () use ($mf,$sc,$pd,$id,$request) {
                if($pd == null){
                
                    $qrr_data = new QrrPDDetails;
                        $qrr_data->qrr_id=$id;
                        $qrr_data->annual_capacity=$request->pd_capacity;
                        $qrr_data->created_by=Auth::user()->id;
                    $qrr_data->save();
                }else{
                    
                    $pd->fill(['annual_capacity' => $request->pd_capacity,'created_by' => Auth::user()->id]);
                    $pd->save();
                }
                $mf->save();
                $sc->save();
                
            });

            alert()->success('QRR Details Saved', 'Success')->persistent('Close');
            return redirect()->route('qpr.edit',$id);
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


    }


    public function submit($id)
    {
        try{
            $qrrMast = QRRMasters::where('id', $id)->where('status', 'D')->first();
            if (!$qrrMast) {
                $qrrMast = QRRMasters::where('id', $id)->where('status', 'S')->first();
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',$qrrMast->qtr_id);
            }

            $stage = $qrrMast->qrrstages->pluck('stage')->toArray();


            $allStages = ['1', '2', '3','4','5'];
            $arrDiff1 = array_diff($stage, $allStages);
            $arrDiff2 = array_diff($allStages, $stage);
            $diff = array_merge($arrDiff1, $arrDiff2);
            if ($diff) {
                alert()->error('Please complete previous sections first!', 'Attention!')->persistent('Close');
                return redirect()->back();
            }

            $revision_dt = DB::table('qrr_open_history')->where('qrr_id',$id)->orderby('id','DESC')->first();
            if($qrrMast && $revision_dt == null){
                $qrrMast = QRRMasters::find($id);
                $qrrMast->status = 'S';
                $qrrMast->submitted_at = Carbon\Carbon::now();
            }elseif($qrrMast && $revision_dt){
                $qrrMast = QRRMasters::find($id);
                $qrrMast->status = 'S';
                $qrrMast->revision_dt = Carbon\Carbon::now();
            }
           
            DB::transaction(function () use ($qrrMast) {

                $qrrMast->save();

            //For mail [added by Ajaharuddin Ansari]
            $user1 = DB::table('qrr_master as qm')
                    ->join('approved_apps_details as aad','aad.id','=','qm.app_id')
                    ->whereRaw('is_normal_user(aad.user_id)=1')
                    ->join('qtr_master as qm2','qm2.qtr_id','=','qm.qtr_id','left')->where('qm.id',$qrrMast->id)
                    ->select('aad.name','aad.email','aad.product','qm2.month','qm2.year')->first();

                if($user1){
                    $data = array('name'=>$user1->name,'product'=>$user1->product,'email'=>$user1->email,'month'=>$user1->month,'year'=>$user1->year);

                    Mail::send('emails.qrrSubmit', $data, function($message) use($data) {
                    $message->to($data['email'],$data['name'])->subject
                    ('PLI Scheme for Bulk Drugs | QRR Submitted Succesfully');
                    $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
                    });
                }
            });
            alert()->success('QRR Details submitted successfully!', 'Success!')->persistent('Close');
            return redirect()->route('qpr.byname',$qrrMast->qtr_id);
        }catch(Exception $e){
            alert()->error('Once you checked internet connection and otherwise you can connect IT support team.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }


    public function getQrrByName($id)
    {
        // dd($id);
        $apps = DB::table('approved_apps')
        ->join('eligible_products','eligible_products.id','=','approved_apps.eligible_product')
        ->where('created_by', $this->user->id)
        ->whereNotNull('approved_apps.approval_dt')
        ->where('approved_apps.status','S')
        ->select('approved_apps.*','eligible_products.id as ep_id',
        'eligible_products.code','eligible_products.target_segment','eligible_products.product'
        ,'eligible_products.min_cap','eligible_products.short_name',
        DB::raw('row_number() OVER () rownum'))->get();

        $appsIds = DB::table('approved_apps')
        ->join('eligible_products','eligible_products.id','=','approved_apps.eligible_product')
        ->where('created_by', $this->user->id)
        ->whereNotNull('approved_apps.approval_dt')
        ->where('approved_apps.status','S')
        ->pluck('approved_apps.id');

        $qrrMast=DB::table('qrr_master')->where('qtr_id',$id)->whereIn('app_id',$appsIds)->get();

        $qrrName=$id;
        $qrrAppIds=$qrrMast->pluck('app_id')->toArray();
        $qrrMaster=null;
        foreach($qrrMast as $a){
            $qrrMaster[$a->id]=QRRMasters::where('id', $a->id)->get();
        }
        
        $currQrr=$qrrName;
        $currcolumnName=DB::table('qtr_master')->whereIn('qtr_id',array($currQrr))->first();

        // dd($id);
       
        $app_dt=DB::table('approved_apps_details')->where('user_id',Auth::user()->id)->first();
        $qtrMast=DB::select("select * from  qtr_master where status = 1 and fy >= fin_year('$app_dt->approval_dt')");
        // dd($app_dt);
        // $qtrMast=DB::table('qtr_master')->get();

        return view('user.qrr.index', compact( 'apps','qrrMast','qrrName','qrrMaster','qrrAppIds','currcolumnName','qtrMast'));
    }

    public static function getqrr() {
        
        $app_dt=DB::table('approved_apps_details')->where('user_id',Auth::user()->id)->first();
        // dd($app_dt);
        $qtrMast=DB::select("select qtr_master.qtr_id from  qtr_master where status = 1 and fy >= fin_year('$app_dt->approval_dt')");
        // dd($qtrMast);
        return $qtrMast[0]->qtr_id;
    }
}
