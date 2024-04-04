<?php

namespace App\Http\Controllers\User\Claims;

use App\ClaimSalesDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClaimStage;
use App\DocumentMaster;
use App\DocumentUploads;
use App\ClaimSalesEpApproval;
use App\ClaimNetSales;
use App\ClaimBaseLineSales;
use App\ClaimSalesEpQrr;
use App\ClaimSalesDoc;
use App\ClaimSalesContractAgreement;
use App\ClaimSalesManufTsGoods;
use App\ClaimSalesReconciliation;
use App\ClaimQuestionUserResponse;
use App\ClaimDvaKeyMaterial;
use App\ClaimDvaOther;
use Carbon\Carbon;
use DB;
use Auth;
use App\ClaimSalesConsumption;
use Exception;

class ClaimSalesDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('hello sales');
        // return view('user.claims.sales_detail');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //dd($id);
        //try{

            $stage = ClaimStage::where('claim_id', $id)->where('stages', 2)->first();
            //dd($stage);
            if ($stage) {
                
                return redirect()->route('claimsalesdetail.edit',$stage->claim_id);
            }
            
            if($id){
                $amount_dva = DB::table('claim_sales_dva')->where('claim_id',$id)->where('prt_id',5)->get('amount');
            }
            
            $claimMaster = DB::table('claims_masters as cm')
            ->join('claim_applicant_details as cad', 'cad.claim_id','=','cm.id')
            ->join('fy_master as fy', 'fy.id','=', DB::raw('cm.fy:: INTEGER'))
            ->where('cm.id',$id)->select('cm.*','cad.incentive_from_date','cad.incentive_to_date','fy.fy_name')
            ->first();
            
        
            $qrr_data =DB::table('qrr_master as qm')->join('qrr_revenue as qr', 'qr.qrr_id','=','qm.id')
            ->join('qtr_master as qm2', 'qm2.qtr_id','=','qm.qtr_id')
            ->whereBetween('qm2.qtr_id',[$claimMaster->incentive_from_date,$claimMaster->incentive_to_date])
            ->where('qm.status','=','S')->where('qm.app_id','=',$claimMaster->app_id)
            ->select( DB::raw('(SUM(qr."gcDomCurrQuantity")/1000) as dom_qnty'),DB::raw('SUM(qr."gcDomCurrSales") as dom_sales'),DB::raw('(SUM(qr."gcExpCurrQuantity")/1000) as exp_qnty'),DB::raw('SUM(qr."gcExpCurrSales") as exp_sales'),DB::raw('(SUM(qr."gcCapCurrQuantity")/1000) as cons_qnty'),DB::raw('SUM(qr."gcCapCurrSales") as cons_sales'))
            ->groupBy('qm.app_id')->first();

            //dd($id, $claimMaster, $qrr_data);
        
            // dd($qrr_data,$claimMaster->incentive_from_date,$claimMaster->incentive_to_date);

            $hsn = DB::table('claim_applicant_details')->where('claim_id',$claimMaster->id)->first();
            $appMast = DB::table('approved_apps_details')->where('id',$claimMaster->app_id)->first();

            $eligible_product=DB::table('approved_apps_details')->where('id',$claimMaster->app_id)->get();
            $product=DB::table('approved_apps_details')->where('id',$claimMaster->app_id)->first('product');
            $claimSalesParticular = DB::table('claim_sales_particulars')->whereNotIn('id',[10])->orderby('id','ASC')->get();

        
            return view('user.claims.sales_detail',compact('id','claimSalesParticular','appMast','eligible_product','claimMaster','amount_dva','product','qrr_data','hsn'));
    
        // }catch(Exception $e){
        //     alert()->error('Something went wrong.', 'Attention!')->persistent('Close');
        //     return redirect()->back();
        // }
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

            $claimMaster = DB::table('claims_masters')->where('app_id',$request->app_id)->where('status','D')->first();
            
            $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();
            DB::transaction(function () use ($request,$claimMaster,$doctypes) {
                
                foreach($request->ques as $key=>$id){
                
                    $claimQuestion=DB::table('claim_question')->where('id',$id)->first();
                    
                        $claimUserResponse = new ClaimQuestionUserResponse;
                        $claimUserResponse->app_id=$request->app_id;
                        $claimUserResponse->created_by=Auth::user()->id;
                        $claimUserResponse->claim_id=$claimMaster->id;
                        $claimUserResponse->ques_id=$id; 
                        $claimUserResponse->response=$request->value[$key];
                    $claimUserResponse->save();
                }
            
                // dd($request);
                foreach($request->ep_approval_data as $key=>$approval_data){
                
                    $approval = new ClaimSalesEpApproval;
                        $approval->app_id=$request->app_id;
                        $approval->created_by=Auth::user()->id;
                        $approval->claim_id=$claimMaster->id;
                        $approval->quoted_sales_price=$approval_data['quoted_sales_price'];
                        $approval->hsn=$approval_data['hsn'];
                        $approval->cons_qnty=$approval_data['cons_qnty'];
                        $approval->cons_sales=$approval_data['cons_sales'];
                        $approval->cons_incentive=$approval_data['cons_incentive'];
                        $approval->dom_qty=$approval_data['dom_qnty'];
                        $approval->dom_sales=$approval_data['dom_sales'];
                        $approval->dom_incentive=$approval_data['dom_incentive'];
                        $approval->exp_qty=$approval_data['exp_qnty'];
                        $approval->exp_sales=$approval_data['exp_sales'];
                        $approval->exp_incentive=$approval_data['exp_incentive'];
                        $approval->ts_total_qnty=$approval_data['ts_total_qnty'];
                        $approval->ts_total_sales=$approval_data['ts_total_sales'];
                        $approval->ts_total_incentv=$approval_data['ts_total_considerd'];
                        $approval->product_name=$approval_data['name_of_product'];
                    $approval->save();
                }
            
                foreach($request->ep_qrr_data as $key=>$data){
                    $qrr_data = new ClaimSalesEpQrr;
                        $qrr_data->app_id=$request->app_id;
                        $qrr_data->created_by=Auth::user()->id;
                        $qrr_data->claim_id=$claimMaster->id;
                        $qrr_data->old_qrr_dom_qnty=$data['old_qrr_dom_qnty'];
                        $qrr_data->old_qrr_dom_sales=$data['old_qrr_dom_sales'];
                        $qrr_data->new_qrr_dom_qnty=$data['new_qrr_dom_qnty'];
                        $qrr_data->new_qrr_dom_sales=$data['new_qrr_dom_sales'];
                        $qrr_data->dom_reason_diff=$data['dom_reason_diff'];
                        $qrr_data->old_qrr_exp_qnty=$data['old_qrr_exp_qnty'];
                        $qrr_data->old_qrr_exp_sales=$data['old_qrr_exp_sales'];
                        $qrr_data->new_qrr_exp_qnty=$data['new_qrr_exp_qnty'];
                        $qrr_data->new_qrr_exp_sales=$data['new_qrr_exp_sales'];
                        $qrr_data->exp_reason_diff=$data['exp_reason_diff'];
                        $qrr_data->old_qrr_cons_qnty=$data['old_qrr_cons_qnty'];
                        $qrr_data->old_qrr_cons_sales=$data['old_qrr_cons_sales'];
                        $qrr_data->new_qrr_cons_qnty=$data['new_qrr_cons_qnty'];
                        $qrr_data->new_qrr_cons_sales=$data['new_qrr_cons_sales'];
                        $qrr_data->diff_dom_qnty=$data['diff_dom_qnty'];
                        $qrr_data->diff_dom_sales=$data['diff_dom_amount'];
                        $qrr_data->diff_exp_qnty=$data['diff_exp_qnty'];
                        $qrr_data->diff_exp_sales=$data['diff_exp_sales'];
                        $qrr_data->diff_cons_qnty=$data['diff_cons_qnty'];
                        $qrr_data->diff_cons_sales=$data['diff_cons_sales'];
                        $qrr_data->cons_reason_diff=$data['cons_reason_diff'];
                    $qrr_data->save();
                }
            

                if($request->value[3] == 'Y'){
                
                    foreach($request->ts_goods as $key=>$goods_data){
                    
                        $data = new ClaimSalesManufTsGoods;
                            $data->app_id=$request->app_id;
                            $data->created_by=Auth::user()->id;
                            $data->claim_id=$claimMaster->id;
                            $data->product_name=$goods_data['name_of_product'];
                            $data->related_party_name=$goods_data['name_of_related_party'];
                            $data->relationship=$goods_data['relationship'];
                            $data->quantity=$goods_data['ts_sales'];
                            $data->sales_ep=$goods_data['ep_sales'];
                            $data->ts_goods_total=$request->total_goods_amt;
                            $data->ques_id=$request->ques[3];
                        $data->save();
                    }
                }
                // dd($request);
                // if($request->part)
                foreach($request->part_0 as $key => $particular){

                    $ClaimRecSales = new ClaimSalesReconciliation;
                    $ClaimRecSales->app_id=$request->app_id;
                    $ClaimRecSales->created_by=Auth::user()->id;
                    $ClaimRecSales->claim_id=$claimMaster->id;
                    $ClaimRecSales->part_id=$request->part_0[$key];
                    $ClaimRecSales->particular_name=$request->part_name_0[$key];
                    $ClaimRecSales->amount=$request->amount_0[$key];
                    $ClaimRecSales->ts_goods_total=$request->grand_total;
                    $ClaimRecSales->save();
                }
            
                
                foreach($request->breakup as $key => $particular){
                
                    $ClaimRecSales = new ClaimSalesReconciliation;
                    $ClaimRecSales->app_id=$request->app_id;
                    $ClaimRecSales->created_by=Auth::user()->id;
                    $ClaimRecSales->claim_id=$claimMaster->id;
                    $ClaimRecSales->part_id=$particular['particular'];
                    $ClaimRecSales->amount=$particular['amount'];
                    $ClaimRecSales->particular_name=$particular['particular_name'];
                    $ClaimRecSales->ts_goods_total=$request->grand_total;
                    $ClaimRecSales->save();
                }

                
            
                $base_line = new ClaimBaseLineSales;
                    $base_line->app_id=$request->app_id;
                    $base_line->created_by=Auth::user()->id;
                    $base_line->claim_id=$claimMaster->id;
                    $base_line->amount=$request->baseline_amount;
                    $base_line->response=$request->baseline_tick;
                $base_line->save();
                
                if($request->value[4]=='Y'){
                    foreach ($request->SalesConsumption as $key => $newDoc) {
                            $doc = new DocumentUploads;
                            $doc->app_id=$request->app_id;
                            $doc->doc_id = 1032;
                            $doc->mime = $newDoc['upload']->getMimeType();
                            $doc->file_size = $newDoc['upload']->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $newDoc['upload']->getClientOriginalName();
                            $doc->uploaded_file = fopen($newDoc['upload']->getRealPath(), 'r');
                            $doc->save();
                            
                            $ClaimSalesDoc = new ClaimSalesDoc;    
                                $ClaimSalesDoc->fill([
                                    'app_id' => $request->app_id,
                                    'created_by' => Auth::user()->id,
                                    'claim_id' =>$claimMaster->id,
                                    'ques_id' => $request->ques[4],
                                    'doc_id' => 1032,
                                    'upload_id' => $doc->id,
                                    'response'=>$request->value[4],
                                ]);
                            $ClaimSalesDoc->save();  

                            $consumption = new ClaimSalesConsumption;    
                                $consumption->fill([
                                    'app_id' => $request->app_id,
                                    'created_by' => Auth::user()->id,
                                    'claim_id' =>$claimMaster->id,
                                    'ques' => $request->ques[4],
                                    'doc_id' => 1032,
                                    'product_name_utilised'=>$request->product_utilised_name,
                                    'quantity_of_ep'=>$request->quantity_of_ep,
                                    'cost_production'=>$request->cost_production,
                                    'response'=>$request->value[4],
                                ]);
                            $consumption->save();
                    }
                }
            
                if($request->value[5]=='Y'){
                    foreach ($request->unsettled as $key => $newDoc) {
                        $doc = new DocumentUploads;
                        $doc->app_id=$request->app_id;
                        $doc->doc_id = 201;
                        $doc->mime = $newDoc['upload']->getMimeType();
                        $doc->file_size = $newDoc['upload']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc['upload']->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc['upload']->getRealPath(), 'r');
                        $doc->save();
                        $ClaimSalesDoc = new ClaimSalesDoc;    
                        $ClaimSalesDoc->fill([
                            'app_id' => $request->app_id,
                            'created_by' => Auth::user()->id,
                            'claim_id' =>$claimMaster->id,
                            'ques_id' => $request->ques[5],
                            'doc_id' => 201,
                            'upload_id' => $doc->id,
                            'response'=>$request->value[5],
                        ]);
                        $ClaimSalesDoc->save();  
                    }
                }

                if($request->value[6]=='N'){
                
                    foreach ($request->creditnotes as $key => $newDoc) {
                    
                        $doc = new DocumentUploads;
                        $doc->app_id=$request->app_id;
                        $doc->doc_id = 202;
                        $doc->mime = $newDoc['upload']->getMimeType();
                        $doc->file_size = $newDoc['upload']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc['upload']->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc['upload']->getRealPath(), 'r');
                        $doc->save();
                        $ClaimSalesDoc = new ClaimSalesDoc;    
                            $ClaimSalesDoc->fill([
                                'app_id' => $request->app_id,
                                'created_by' => Auth::user()->id,
                                'claim_id' =>$claimMaster->id,
                                'ques_id' => $request->ques[6],
                                'doc_id' => 202,
                                'upload_id' => $doc->id,
                                'response'=>$request->value[6],
                            ]);
                            $ClaimSalesDoc->save();  
                    }
                }

                if($request->value[7]=='N'){
                    
                    foreach ($request->salesconsideration as $key => $newDoc) {
                            $doc = new DocumentUploads;
                            $doc->app_id=$request->app_id;
                            $doc->doc_id = 203;
                            $doc->mime = $newDoc['upload']->getMimeType();
                            $doc->file_size = $newDoc['upload']->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $newDoc['upload']->getClientOriginalName();
                            $doc->uploaded_file = fopen($newDoc['upload']->getRealPath(), 'r');
                            $doc->save();
                        $ClaimSalesDoc = new ClaimSalesDoc;    
                            $ClaimSalesDoc->fill([
                                'app_id' => $request->app_id,
                                'created_by' => Auth::user()->id,
                                'claim_id' =>$claimMaster->id,
                                'ques_id' => $request->ques[7],
                                'doc_id' => 203,
                                'upload_id' => $doc->id,
                                'response'=>$request->value[7],
                            ]);
                            $ClaimSalesDoc->save();  
                    }
                }

                if($request->value[8]=='Y'){
                    
                    foreach ($request->contractagreement as $key => $newDoc) {
                    
                        $doc = new DocumentUploads;
                        $doc->app_id=$request->app_id;
                        $doc->doc_id = 204;
                        $doc->mime = $newDoc['doc_upload']->getMimeType();
                        $doc->file_size = $newDoc['doc_upload']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc['doc_upload']->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc['doc_upload']->getRealPath(), 'r');
                        $doc->save();
                        $ClaimSalesContractAgreement = new ClaimSalesContractAgreement;    
                            $ClaimSalesContractAgreement->fill([
                                'app_id' => $request->app_id,
                                'created_by' =>Auth::user()->id,
                                'claim_id' =>$claimMaster->id,
                                'ques_id' => $request->ques[8],
                                'doc_id' => 204,
                                'upload_id' => $doc->id,
                                'response'=>$request->value[8],
                            ]);

                        $ClaimSalesContractAgreement->save();  
                    }
                }

                ClaimStage::create([
                    'app_id'=>$request->app_id,
                    'created_by' =>Auth::user()->id,
                    'claim_id' => $claimMaster->id,
                    'stages' =>2,
                    'status'=>'D',
                ]);

                alert()->success('Claim Sales Details Saved', 'Success!')->persistent('Close');

            });
            return redirect()->route('claimsalesdetail.edit',$claimMaster->id);
        }catch(Exception $e){
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClaimSalesDetail  $claimSalesDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ClaimSalesDetail $claimSalesDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClaimSalesDetail  $claimSalesDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try{
            $claimMaster = DB::table('claims_masters')->where('id',$id)->first();
            
            $claimMast = DB::table('claims_masters as cm')
            ->join('claim_applicant_details as cad', 'cad.claim_id','=','cm.id')
            // ->join('fy_master as fy', 'fy.status','=', DB::raw('cm.fy:: INTEGER')) before changed by Deepak Sharma 23022024
            ->join('fy_master as fy', 'fy.id','=', DB::raw('cm.fy:: INTEGER'))  // changed by Deepak Sharma 23022024
            ->where('cm.id',$id)->select('cm.*','cad.incentive_from_date','cad.incentive_to_date','fy.fy_name')
            ->first();
            //dd($claimMaster, $claimMast);
            $appMast = DB::table('approved_apps_details')->where('id',$claimMaster->app_id)->first();
            
            $claimSalesParticular = DB::table('claim_sales_particulars')->get();
            $claimApproval = DB::table('claim_sales_of_ep_approval')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->first();

            $hsn = DB::table('claim_applicant_details')->where('claim_id',$claimMaster->id)->pluck('hsn','hsn')->first();
        
            $claimAsQrr = DB::table('claim_sales_ep_qrr')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->first();

            $qrr_data =DB::table('qrr_master as qm')->join('qrr_revenue as qr', 'qr.qrr_id','=','qm.id')
            ->join('qtr_master as qm2', 'qm2.qtr_id','=','qm.qtr_id')
            ->whereBetween('qm2.qtr_id',[$claimMast->incentive_from_date,$claimMast->incentive_to_date])
            ->where('qm.status','=','S')->where('qm.app_id','=',$claimMast->app_id)
            ->select( DB::raw('(SUM(qr."gcDomCurrQuantity")/1000) as dom_qnty'),DB::raw('SUM(qr."gcDomCurrSales") as dom_sales'),DB::raw('(SUM(qr."gcExpCurrQuantity")/1000) as exp_qnty'),DB::raw('SUM(qr."gcExpCurrSales") as exp_sales'),DB::raw('(SUM(qr."gcCapCurrQuantity")/1000) as cons_qnty'),DB::raw('SUM(qr."gcCapCurrSales") as cons_sales'))
            ->groupBy('qm.app_id')->first();


            $claimSalesManufTsGoods = DB::table('claim_sales_manuf_ts_goods')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->get();


        
            $claimRecSales = DB::table('claim_sales_reconciliation')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->orderby('part_id','ASC')->get();

        
            $claimBaselineSales = DB::table('claim_baseline_sales')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->first();


            $claimSalesDoc = DB::table('claim_sales_doc')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->get();
            

            $eligible_product=DB::table('approved_apps_details')->where('id',$claimMaster->app_id)->get('product');

            $claimSalesConsumption = DB::table('claim_sales_consumption')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->first();


        
            $claimSalesContractAgreement = DB::table('claim_sales_contract_agreements')->where('claim_id',$claimMaster->id)->where('app_id',$claimMaster->app_id)->get();

            $claimUserResponse = DB::table('claim_question_user_responses')->where('claim_id',$claimMaster->id)->where('created_by',Auth::user()->id)->orderby('ques_id','ASC')->get();

            $product=DB::table('approved_apps_details')->where('id',$claimMaster->app_id)->first('product');
            // dd($product,$claimMaster->id,$claimMaster->app_id,$claimApproval,$claimAsQrr);
            return view('user.claims.salesdetail_edit',compact('appMast','claimMaster','claimSalesParticular','claimApproval','claimAsQrr','claimSalesManufTsGoods','claimRecSales','claimBaselineSales','claimSalesDoc','claimSalesContractAgreement','claimUserResponse','eligible_product','product','claimSalesConsumption','hsn','qrr_data'));
        }catch(Exception $e){
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClaimSalesDetail  $claimSalesDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
       try{
        $claimMaster = DB::table('claims_masters')->where('id',$id)->first();
        $claimApproval = DB::table('claim_sales_of_ep_approval')->where('app_id',$claimMaster->app_id)->where('claim_id',$claimMaster->id)->pluck('id')->first();
        $claimAsQrr = DB::table('claim_sales_ep_qrr')->where('app_id',$claimMaster->app_id)->where('claim_id',$claimMaster->id)->pluck('id')->first();
        
        $baseLine = DB::table('claim_baseline_sales')->where('app_id',$claimMaster->app_id)->where('claim_id',$claimMaster->id)->pluck('id')->first();

        $resp= DB::table('claim_question_user_responses')->where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->pluck('response','ques_id');
        
        $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();

            DB::transaction(function () use ($request,$claimMaster,$doctypes,$claimApproval,$claimAsQrr,$resp,$baseLine) {
                
                foreach($request->ep_approval_data as $key=>$approval_data){
                    $approval = ClaimSalesEpApproval::find($claimApproval);
                        $approval->hsn=$approval_data['hsn'];
                        $approval->ts_total_incentv=$approval_data['ts_total_considerd'];
                        $approval->cons_qnty=$approval_data['cons_qnty'];
                        $approval->cons_sales=$approval_data['cons_sales'];
                        $approval->cons_incentive=$approval_data['cons_incentive'];
                        $approval->dom_qty=$approval_data['dom_qnty'];
                        $approval->dom_sales=$approval_data['dom_sales'];
                        $approval->dom_incentive=$approval_data['dom_incentive'];
                        $approval->exp_qty=$approval_data['exp_qnty'];
                        $approval->exp_sales=$approval_data['exp_sales'];
                        $approval->exp_incentive=$approval_data['exp_incentive'];
                        $approval->ts_total_qnty=$approval_data['ts_total_qnty'];
                        $approval->ts_total_sales=$approval_data['ts_total_sales'];
                        $approval->quoted_sales_price=$approval_data['quoted_sales_price'];
                        $approval->product_name=$approval_data['name_of_product'];
                    $approval->save();
                }

                foreach($request->ep_qrr_data as $key=>$data){
                    $qrr_data = ClaimSalesEpQrr::find($claimAsQrr);
                        $qrr_data->old_qrr_dom_qnty=$data['old_qrr_dom_qnty'];
                        $qrr_data->old_qrr_dom_sales=$data['old_qrr_dom_sales'];
                        $qrr_data->new_qrr_dom_qnty=$data['new_qrr_dom_qnty'];
                        $qrr_data->new_qrr_dom_sales=$data['new_qrr_dom_sales'];
                        $qrr_data->dom_reason_diff=$data['dom_reason_diff'];
                        $qrr_data->old_qrr_exp_qnty=$data['old_qrr_exp_qnty'];
                        $qrr_data->old_qrr_exp_sales=$data['old_qrr_exp_sales'];
                        $qrr_data->new_qrr_exp_qnty=$data['new_qrr_exp_qnty'];
                        $qrr_data->new_qrr_exp_sales=$data['new_qrr_exp_sales'];
                        $qrr_data->exp_reason_diff=$data['exp_reason_diff'];
                        $qrr_data->old_qrr_cons_qnty=$data['old_qrr_cons_qnty'];
                        $qrr_data->old_qrr_cons_sales=$data['old_qrr_cons_sales'];
                        $qrr_data->new_qrr_cons_qnty=$data['new_qrr_cons_qnty'];
                        $qrr_data->new_qrr_cons_sales=$data['new_qrr_cons_sales'];
                        $qrr_data->diff_dom_qnty=$data['diff_dom_qnty'];
                        $qrr_data->diff_dom_sales=$data['diff_dom_amount'];
                        $qrr_data->diff_exp_qnty=$data['diff_exp_qnty'];
                        $qrr_data->diff_exp_sales=$data['diff_exp_sales'];
                        $qrr_data->diff_cons_qnty=$data['diff_cons_qnty'];
                        $qrr_data->diff_cons_sales=$data['diff_cons_sales'];
                        $qrr_data->cons_reason_diff=$data['cons_reason_diff'];
                    $qrr_data->save();
                }

                $resKey=$request->ques[3];

                if($resp[$resKey]=='Y' && $request->value[3]=='Y'){
                
                    foreach($request->ts_goods as $tsgoods){
                        if(array_key_exists('id',$tsgoods)){
                            $data =ClaimSalesManufTsGoods::find($tsgoods['id']);
                                $data->product_name=$tsgoods['name_of_product'];
                                $data->related_party_name=$tsgoods['name_of_related_party'];
                                $data->relationship=$tsgoods['relationship'];
                                $data->quantity=$tsgoods['ts_sales'];
                                $data->sales_ep=$tsgoods['ep_sales'];
                                $data->ts_goods_total=$request->total_goods_amt;
                                $data->ques_id=$request->ques[3];
                            $data->save();
                        }else{
                            $data = new ClaimSalesManufTsGoods;
                                $data->app_id=$request->app_id;
                                $data->created_by=Auth::user()->id;
                                $data->claim_id=$request->claim_id;
                                $data->product_name=$tsgoods['name_of_product'];
                                $data->related_party_name=$tsgoods['name_of_related_party'];
                                $data->relationship=$tsgoods['relationship'];
                                $data->quantity=$tsgoods['ts_sales'];
                                $data->sales_ep=$tsgoods['ep_sales'];
                                $data->ts_goods_total=$request->total_goods_amt;
                                $data->ques_id=$request->ques[3];
                            $data->save();
                        }

                        $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[3])->first();
                            $resp->fill([
                                'ques_id' => $request->ques[3],
                                'response' => $request->value[3],
                                'update_at' => Carbon::now(),
                            ]);
                        $resp->save();
                    }    
                }elseif($resp[$resKey]=='Y' && $request->value[3]=='N'){
                    foreach($request->ts_goods as $tsgoods){
                        
                        $q1=ClaimSalesManufTsGoods::where('claim_id',$request->claim_id)
                        ->where('id',$tsgoods['id'])
                        ->where('created_by',Auth::user()->id)->first();
                        
                        $q1->delete();

                    }
                    
                    $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[3])->first();
                        $resp->fill([
                            'ques_id' => $request->ques[3],
                            'response' => $request->value[3],
                            'update_at' => Carbon::now(),
                        ]);
                    $resp->save();
                }

                // dd($request->amount_0[16],$request->grand_total);
                foreach($request->part_0 as $key => $particular){
                    $ClaimRecSales = ClaimSalesReconciliation::where('part_id',$request->part_0[$key])->where('claim_id', $request->claim_id)->first();
                    $ClaimRecSales->part_id=$request->part_0[$key];
                    $ClaimRecSales->amount=$request->amount_0[$key];
                    $ClaimRecSales->ts_goods_total=$request->grand_total;
                    $ClaimRecSales->save();
                }
            
                foreach($request->breakup as $key => $particular){
                
                    if(array_key_exists('id',$particular)){
                        $ClaimRec = ClaimSalesReconciliation::find($particular['id']);
                            $ClaimRec->part_id=$particular['particular'];
                            $ClaimRec->particular_name=$particular['particular_name'];
                            $ClaimRec->amount=$particular['amount'];
                            $ClaimRecSales->ts_goods_total=$request->grand_total;
                            $ClaimRec->save();
                    }else{
                        $ClaimRecSales = new ClaimSalesReconciliation;
                        $ClaimRecSales->app_id=$request->app_id;
                        $ClaimRecSales->created_by=Auth::user()->id;
                        $ClaimRecSales->claim_id=$claimMaster->id;
                        $ClaimRecSales->part_id=$particular['particular'];
                        $ClaimRecSales->amount=$particular['amount'];
                        $ClaimRecSales->particular_name=$particular['particular_name'];
                        $ClaimRecSales->ts_goods_total=$request->grand_total;
                        $ClaimRecSales->save();
                    }
                    
                    
                }
            
                $base_line = ClaimBaseLineSales::find($baseLine);
                    $base_line->response=$request->baseline_tick;
                    $base_line->amount=$request->baseline_amount;
                $base_line->save();
            
                if($request->value[4]=='Y'){
                    foreach ($request->SalesConsumption as $key => $newDoc) {
                //    dd('by');
                    
                        if(array_key_exists('doc',$newDoc)){
                            $upload_id =DB::Table('claim_sales_doc')->where('claim_id',$request->claim_id)->where('id',$request->consumption_doc_id)->first('upload_id');
                        
                            if($upload_id){
                                
                                $doc=DocumentUploads::find($upload_id->upload_id);
                                $doc->mime = $newDoc['doc']->getMimeType();
                                $doc->file_size = $newDoc['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->user_id = Auth::user()->id;
                                $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();

                                $consumption = ClaimSalesConsumption::find($request->quamtity_ep_id);   
                                    $consumption->product_name_utilised=$request->product_utilised_name;
                                    $consumption->quantity_of_ep=$request->quantity_of_ep;
                                    $consumption->cost_production=$request->cost_production;
                                    $consumption->response=$request->value[4];
                                $consumption->save();

                            }
                            else{
                            
                                $doc = new DocumentUploads;
                                $doc->app_id=$request->app_id;
                                $doc->doc_id = 1032;
                                $doc->mime = $newDoc['doc']->getMimeType();
                                $doc->file_size = $newDoc['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->created_at = Carbon::now();
                                $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();
                                
                                $ClaimSalesDoc = new ClaimSalesDoc;    
                                    $ClaimSalesDoc->fill([
                                        'app_id' => $request->app_id,
                                        'created_by' => Auth::user()->id,
                                        'claim_id' =>$claimMaster->id,
                                        'ques_id' => $request->ques[4],
                                        'doc_id' => 1032,
                                        'upload_id' => $doc->id,
                                        'response'=>$request->value[4],
                                    ]);
                                $ClaimSalesDoc->save();  

                                $consumption = new ClaimSalesConsumption;    
                                    $consumption->fill([
                                        'app_id' => $request->app_id,
                                        'created_by' => Auth::user()->id,
                                        'claim_id' =>$claimMaster->id,
                                        'ques' => $request->ques[4],
                                        'doc_id' => 1032,
                                        'product_name_utilised'=>$request->product_utilised_name,
                                        'quantity_of_ep'=>$request->quantity_of_ep,
                                        'cost_production'=>$request->cost_production,
                                        'response'=>$request->value[4],
                                    ]);
                                $consumption->save();
                            }

                            $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[4])->first();
                                $resp->fill([
                                    'ques_id' => $request->ques[4],
                                    'response' => $request->value[4],
                                    'update_at' => Carbon::now(),
                                ]);
                            $resp->save();
                        }

                    } 
                }else{
                    
                    
                    $q1=ClaimSalesDoc::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('doc_id',1032)->first();
                    
                    if($q1){
                        $q1->delete();
                    }
                    
                    $q11=ClaimSalesConsumption::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->first();
                
                    if($q11){
                        $q11->delete();
                    }

                    $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[4])->first();
                        $resp->fill([
                            'ques_id' => $request->ques[4],
                            'response' => $request->value[4],
                            'update_at' => Carbon::now(),
                        ]);
                    $resp->save();
                    
                }

            
                if($request->value[5]=='Y'){
                    foreach ($request->unsettled as $key => $newDoc) {
                        if(array_key_exists('doc',$newDoc)){
                            if(array_key_exists('uplaod_id',$newDoc)){
                                $doc=DocumentUploads::find($newDoc['upload_id']);
                                $doc->mime = $newDoc['doc']->getMimeType();
                                $doc->file_size = $newDoc['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->user_id = Auth::user()->id;
                                $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();
                            }else{  
                                $doc = new DocumentUploads;
                                $doc->app_id=$request->app_id;
                                $doc->doc_id = 201;
                                $doc->mime = $newDoc['doc']->getMimeType();
                                $doc->file_size = $newDoc['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->created_at = Carbon::now();
                                $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();
                                $ClaimSalesDoc = new ClaimSalesDoc;    
                                $ClaimSalesDoc->fill([
                                    'app_id' => $request->app_id,
                                    'created_by' => Auth::user()->id,
                                    'claim_id' =>$request->claim_id,
                                    'ques_id' => $request->ques[5],
                                    'doc_id' => 201,
                                    'upload_id' => $doc->id,
                                    'response'=>$request->value[5],
                                ]);
                                $ClaimSalesDoc->save();  
                            }

                            $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[5])->first();
                                $resp->fill([
                                    'ques_id' => $request->ques[5],
                                    'response' => $request->value[5],
                                    'update_at' => Carbon::now(),
                                ]);
                            $resp->save();
                        }
                    } 
                }else{
                    $q1=ClaimSalesDoc::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[5])->first();
                    if($q1){
                        $q1->delete();
                    }
                    $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[5])->first();
                        $resp->fill([
                            'ques_id' => $request->ques[5],
                            'response' => $request->value[5],
                            'update_at' => Carbon::now(),
                        ]);
                    $resp->save();
                }
            
                if($request->value[6]=='N'){
                    foreach ($request->creditnotes as $key => $newDoc) {
                        if(array_key_exists('doc',$newDoc)){
                            if(array_key_exists('upload_id',$newDoc)){
                                $doc=DocumentUploads::find($newDoc['upload_id']);
                                $doc->mime = $newDoc['doc']->getMimeType();
                                $doc->file_size = $newDoc['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->user_id = Auth::user()->id;
                                $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();
                            }else{
                                $doc = new DocumentUploads;
                                $doc->app_id=$request->app_id;
                                $doc->doc_id = 202;
                                $doc->mime = $newDoc['doc']->getMimeType();
                                $doc->file_size = $newDoc['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->created_at = Carbon::now();
                                $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();
                                $ClaimSalesDoc = new ClaimSalesDoc;    
                                    $ClaimSalesDoc->fill([
                                        'app_id' => $request->app_id,
                                        'created_by' => Auth::user()->id,
                                        'claim_id' =>$request->claim_id,
                                        'ques_id' => $request->ques[6],
                                        'doc_id' => 202,
                                        'upload_id' => $doc->id,
                                        'response'=>$request->value[6],
                                    ]);
                                    $ClaimSalesDoc->save();  
                            }

                            $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[6])->first();
                            $resp->fill([
                                'ques_id' => $request->ques[6],
                                'response' => $request->value[6],
                                'update_at' => Carbon::now(),
                            ]);
                            $resp->save(); 
                        }    
                    }
                }else{

                    $q1=ClaimSalesDoc::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[6])->first();
                    if($q1){
                        $q1->delete();
                    }

                    $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[6])->first();
                        $resp->fill([
                            'ques_id' => $request->ques[6],
                            'response' => $request->value[6],
                            'update_at' => Carbon::now(),
                        ]);
                    $resp->save();
                }

                if($request->value[7]=='N'){
                    foreach ($request->salesconsideration as $key => $newDoc) {
                        if(array_key_exists('doc',$newDoc)){
                            if(array_key_exists('upload_id',$newDoc)){
                                $doc=DocumentUploads::find($newDoc['upload_id']);
                                    $doc->mime = $newDoc['doc']->getMimeType();
                                    $doc->file_size = $newDoc['doc']->getSize();
                                    $doc->updated_at = Carbon::now();
                                    $doc->user_id = Auth::user()->id;
                                    $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();
                            }else{
                                $doc = new DocumentUploads;
                                $doc->app_id=$request->app_id;
                                $doc->doc_id = 203;
                                $doc->mime = $newDoc['doc']->getMimeType();
                                $doc->file_size = $newDoc['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->created_at = Carbon::now();
                                $doc->file_name = $newDoc['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                                $doc->save();
                                $ClaimSalesDoc = new ClaimSalesDoc;    
                                    $ClaimSalesDoc->fill([
                                        'app_id' => $request->app_id,
                                        'created_by' => Auth::user()->id,
                                        'claim_id' =>$request->claim_id,
                                        'ques_id' => $request->ques[7],
                                        'doc_id' => 203,
                                        'upload_id' => $doc->id,
                                        'response'=>$request->value[7],
                                    ]);
                                    $ClaimSalesDoc->save();  
                            }
                            $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[7])->first();
                            $resp->fill([
                                'ques_id' => $request->ques[7],
                                'response' => $request->value[7],
                                'update_at' => Carbon::now(),
                            ]);
                            $resp->save(); 
                        }        
                    } 
                }else{
                    $q1=ClaimSalesDoc::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[7])->first();
                    if($q1){
                        $q1->delete();
                    }
                    $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[7])->first();
                        $resp->fill([
                            'ques_id' => $request->ques[7],
                            'response' => $request->value[7],
                            'update_at' => Carbon::now(),
                        ]);
                    $resp->save();
                    
                }

                if($request->value[8]=='Y'){
                    foreach ($request->contractagreement as $key => $newDoc) {
                        if(array_key_exists('doc_upload',$newDoc)){
                            if(array_key_exists('upload_id',$newDoc)){
                                $doc=DocumentUploads::find($newDoc['upload_id']);
                                $doc->mime = $newDoc['doc_upload']->getMimeType();
                                $doc->file_size = $newDoc['doc_upload']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->user_id = Auth::user()->id;
                                $doc->file_name = $newDoc['doc_upload']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc_upload']->getRealPath(), 'r');
                                $doc->save();
                            }else{
                                $doc = new DocumentUploads;
                                $doc->app_id=$request->app_id;
                                $doc->doc_id = 204;
                                $doc->mime = $newDoc['doc_upload']->getMimeType();
                                $doc->file_size = $newDoc['doc_upload']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->created_at = Carbon::now();
                                $doc->file_name = $newDoc['doc_upload']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['doc_upload']->getRealPath(), 'r');
                                $doc->save();
                                $ClaimSalesContractAgreement = new ClaimSalesContractAgreement;    
                                    $ClaimSalesContractAgreement->fill([
                                        'app_id' => $request->app_id,
                                        'created_by' =>Auth::user()->id,
                                        'claim_id' =>$request->claim_id,
                                        'ques_id' => $request->ques[8],
                                        'doc_id' => 204,
                                        'upload_id' => $doc->id,
                                        'response'=>$request->value[8],
                                    ]);

                                $ClaimSalesContractAgreement->save();
                            }

                            $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[8])->first();
                            $resp->fill([
                                'ques_id' => $request->ques[8],
                                'response' => $request->value[8],
                                'update_at' => Carbon::now(),
                            ]);
                            $resp->save(); 
                        }
                    }
                }else{
                    
                    $q1=claimSalesContractAgreement::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[8])->first();
                    
                    if($q1){
                        $q1->delete();
                    }

                    $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[8])->first();
                        $resp->fill([
                            'ques_id' => $request->ques[8],
                            'response' => $request->value[8],
                            'update_at' => Carbon::now(),
                        ]);
                    $resp->save();
                }
                alert()->success('Sales Edit Saved', 'Success!')->persistent('Close');
            });
            
            return redirect()->route('claimsalesdetail.edit',$id);
       }catch(Exception $e){
        alert()->error('Something went wrong', 'Attention!')->persistent('Close');
        return redirect()->back();
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClaimSalesDetail  $claimSalesDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClaimSalesDetail $claimSalesDetail)
    {
        //
    }

    public function claimsalesdva($claim_id)
    {
        try{
            $stage = ClaimStage::where('claim_id', $claim_id)->where('stages', 3)->first();
        
            if ($stage) {
                return redirect()->route('claimsalesdetail.dvaedit',$stage->claim_id);
            }

            
            $net_sales = ClaimSalesEpApproval::where('claim_id', $claim_id)
            ->where('created_by', Auth::user()->id)->select('ts_total_sales','ts_total_qnty')->first();
            
            return view('user.claims.sales_dva',compact('claim_id','net_sales'));
        }catch(Exception $e){
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    public function dvaStore(Request $request)
    {
        try{
            DB::transaction(function () use ($request) {
                
                $claimMaster = DB::table('claims_masters')->where('id',$request->claim_id)->first();
            
                foreach($request->dva_data as $val){
                    $amount = 
                    ClaimDvaKeyMaterial::create([
                        'app_id'=>$claimMaster->app_id,
                        'claim_id'=>$claimMaster->id,
                        'created_by'=>Auth::user()->id,
                        'raw_material'=>$val['raw_material'],
                        'country_origin'=>$val['country_origin'],
                        'supplier_name'=>$val['supplier_name'],
                        'quantity'=>$val['quantity'],
                        'amount'=>$val['amount'],
                        'goods_amt'=>$val['goods_amt'],
                    ]);
                } 

                if($request->service_obtained){
                    ClaimDvaKeyMaterial::create([
                        'app_id'=>$claimMaster->app_id,
                        'claim_id'=>$claimMaster->id,
                        'created_by'=>Auth::user()->id,
                        'raw_material'=>$request->service_obtained,
                        'country_origin'=>$request->country_origin,
                        'supplier_name'=>$request->supplier_name,
                        'quantity'=>null,
                        'amount'=>$request->ser_amount,
                        'goods_amt'=>$request->ser_goods_amt,
                    ]);
                }

                foreach($request->other_dva_data as $val){
                    
                    ClaimDvaOther::create([
                        'app_id'=>$claimMaster->app_id,
                        'claim_id'=>$claimMaster->id,
                        'created_by'=>Auth::user()->id,
                        'prt_id'=>$val['prt_id'],
                        'quantity'=>$val['quantity'],
                        'amount'=>$val['amount'],
                        'goods_amt'=>$val['goods_amt'],
                    ]);
                } 

                ClaimStage::create([
                    'app_id'=>$claimMaster->app_id,
                    'created_by' =>Auth::user()->id,
                    'claim_id' =>$claimMaster->id,
                    'stages' =>3,
                    'status'=>'D',
                ]);
            
            }); 

            alert()->success('Claim Dva details Saved', 'Success')->persistent('Close');

            return redirect()->route('claimsalesdetail.dvaedit',$request->claim_id); 
        }catch(Exception $e){
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }   

    public function dvaedit($id)
    {
        
        try{
            $raw_material = DB::table('claim_dva_key_material')->where('claim_id',$id)->orderby('id')->get();

            //$other_data = DB::table('claim_dva_other')->where('claim_id',$id)->orderby('prt_id','ASC')->get();
            $other_data = DB::select('select cdo.*,
            CASE
                WHEN cdo.prt_id = 8 THEN round(sum(ep."dom_qty" + ep."exp_qty" + ep."cons_qnty"), 2) 
            END AS prev_qnty from claim_dva_other cdo join claim_sales_of_ep_approval ep on ep.claim_id =cdo.claim_id  where cdo.claim_id = ? group by cdo.id order by cdo.prt_id ASC' ,[$id]);
            return view('user.claims.salesdva_edit',compact('id', 'raw_material','other_data'));
        }catch(Exception $e){
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }   

    public function dva_update(Request $request, $id)
    {
        try{
            $claimMaster = DB::table('claims_masters')->where('id', $id)->first();

            DB::transaction(function () use ($request,$claimMaster,$id) {

                foreach($request->dva_data as $val){
                
                    if(array_key_exists('id',$val)){
                        $key_data = ClaimDvaKeyMaterial::find($val['id']);
                            $key_data->raw_material=$val['raw_material'];
                            $key_data->country_origin=$val['country_origin'];
                            $key_data->supplier_name=$val['supplier_name'];
                            $key_data->quantity=$val['quantity'];
                            $key_data->amount=$val['amount'];
                            $key_data->goods_amt=$val['goods_amt'];
                        $key_data->save();  
                    }else{
                        ClaimDvaKeyMaterial::create([
                            'app_id'=>$claimMaster ->app_id,
                            'claim_id'=>$id,
                            'created_by'=>Auth::user()->id,
                            'raw_material'=>$val['raw_material'],
                            'country_origin'=>$val['country_origin'],
                            'supplier_name'=>$val['supplier_name'],
                            'quantity'=>$val['quantity'],
                            'amount'=>$val['amount'],
                            'goods_amt'=>$val['goods_amt'],
                        ]);
                    }
                    
                } 

                if($request->service_obtained){
                    $service_data = ClaimDvaKeyMaterial::where('id',$request->service_id)->first();
                        $service_data->raw_material=$request->service_obtained;
                        $service_data->country_origin=$request->country_origin;
                        $service_data->supplier_name=$request->supplier_name;
                        $service_data->quantity=null;
                        $service_data->amount=$request->ser_amount;
                        $service_data->goods_amt=$request->ser_goods_amt;
                    $service_data->save();
                }
            
                foreach($request->other_dva_data as $val){
                    $other_data = ClaimDvaOther::find($val['id']);     
                        $other_data->amount = $val['amount'];
                        $other_data->quantity = $val['quantity'];
                        $other_data->goods_amt = $val['goods_amt'];
                    $other_data->save();
                } 
            
            });
            
            alert()->success('DVA Saved', 'Success!')->persistent('Close');
            return redirect()->route('claimsalesdetail.dvaedit',$request->claim_id);
        }catch(Exception $e){
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        } 
    }   
}
