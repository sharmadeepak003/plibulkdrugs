<?php

namespace App\Http\Controllers\User\Claims;

use App\ClaimApplicantDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClaimMaster;
use App\ClaimManufLoc;
use App\ClaimStage;
use App\ClaimShareHoldingPattern;
use App\DocumentMaster;
use App\DocumentUploads;
use App\ClaimShareHoldingDoc;
use App\ClaimStatutoryAuditor;
use App\ClaimQuestionUserResponse;
use DB;
use Exception;
use Carbon\Carbon;
use Auth;

class ClaimApplicantDetailController extends Controller
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
    public function create($id)
    {

       
        try{
            $claimAppDetail= ClaimMaster::where('id', $id)->where('status','D')->first();

            $fy_id = $claimAppDetail->fy;

            $fy = DB::table('fy_master')->where('status',1)->where('id',$fy_id)->first();

            $stage = ClaimStage::where('claim_id', $id)->where('stages', 1)->first();
            
            if  ($stage) {
                 return redirect()->route('claimsapplicantdetail.edit',$stage->claim_id);
                
            }


            $shareholder=DB::table('promoter_details')->where('app_id',$claimAppDetail->app_id)->get();

            $appMast = DB::table('approved_apps_details')->where('id',$claimAppDetail->app_id)->where('id',$id)->first();
            
            $users = DB::table('users as u')
            ->join('approved_apps_details as aad','u.id','=','aad.user_id')
            ->where('aad.id',$claimAppDetail->app_id)
            ->select('u.*')->first();
        
            $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');

            return view('user.claims.applicant_detail', compact('fy_id','appMast','users','fy','shareholder','states'));
        }catch(Exception $e){
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
            
        try{
            if(isset($request->quarterly_claim) && $request->claim_period==1)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->quarterly_claim);
            }
            elseif(isset($request->half_hearly_claim) && $request->claim_period==2)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->half_hearly_claim);
            }
            elseif(isset($request->nine_months_claim) && $request->claim_period==3)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->nine_months_claim);
            }
            elseif(isset($request->annual_claim) && $request->claim_period==4)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->annual_claim);
            }

            DB::transaction(function () use ($request,$from_qtr,$to_qtr) {
                $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();
            
                $claimMaster = new ClaimMaster;
                    $claimMaster->app_id=$request->app_id;
                    $claimMaster->created_by=Auth::user()->id;
                    $claimMaster->status='D';
                    $claimMaster->fy=$request->fy_id;
                    $claimMaster->submitted_at=null;
                    $claimMaster->save();
                
                foreach($request->applicant_data as $applicant){
                    $applicant_data = new ClaimApplicantDetails;
                        $applicant_data->app_id=$request->app_id;
                        $applicant_data->created_by=Auth::user()->id;
                        $applicant_data->claim_id=$claimMaster->id;
                        $applicant_data->hsn=$applicant['hsn'];
                        $applicant_data->committed_capacity=$applicant['committted_capacity'];
                        $applicant_data->quoted_sales=$applicant['quoted_sales'];
                        $applicant_data->incentive_from_date=$from_qtr;
                        $applicant_data->incentive_to_date=$to_qtr;
                        $applicant_data->claim_fill_period=$request->claim_period;
                    $applicant_data->save();
                }

                foreach($request->loc as $location){
                    $claimManufLoc = new ClaimManufLoc;
                        $claimManufLoc->app_id=$request->app_id;
                        $claimManufLoc->created_by=Auth::user()->id;
                        $claimManufLoc->claim_id=$claimMaster->id;
                        $claimManufLoc->address=$location['addr'];
                        $claimManufLoc->city=$location['city'];
                        $claimManufLoc->state=$location['state'];
                        $claimManufLoc->pincode=$location['pincode'];
                    $claimManufLoc->save();
                }
                
                if($request->value[0]=='Y'){
                    foreach($request->shareholding as $shareholding){
                        $claimShareHolding = new ClaimShareHoldingPattern;
                        $claimShareHolding->app_id=$request->app_id;
                        $claimShareHolding->created_by=Auth::user()->id;
                        $claimShareHolding->claim_id=$claimMaster->id;
                        $claimShareHolding->ques_id=$request->ques[0];
                        $claimShareHolding->new_shareholder_name=$shareholding['new_sh_name'];
                        $claimShareHolding->new_equity_share=$shareholding['new_sh_eq_share'];
                        $claimShareHolding->new_percentage=$shareholding['new_sh_per'];
                        $claimShareHolding->date_of_change=$request->reason_date;
                        $claimShareHolding->reason_for_change=$request->reason_shareholding;
                    $claimShareHolding->save();
                    }
                }

                foreach($request->ques as $key=>$id){

                    $claimQuestion=DB::table('claim_question')->where('id',$id)->first();
                    $claimUserResponse = new ClaimQuestionUserResponse;
                    $claimUserResponse->app_id=$request->app_id;
                    $claimUserResponse->created_by=Auth::user()->id;
                    $claimUserResponse->claim_id=$claimMaster->id;
                    $claimUserResponse->ques_id=$claimQuestion->id; 
                    $claimUserResponse->response=$request->value[$key];
                    $claimUserResponse->save();
                }

                if($request->value[2]=='Y'){
                
                    foreach ($request->shareHoldingPattern as $key => $newDoc) {
                    
                        $doc = new DocumentUploads;
                        $doc->app_id=$request->app_id;
                        $doc->doc_id = 5001;
                        $doc->mime = $newDoc['doc']->getMimeType();
                        $doc->file_size = $newDoc['doc']->getSize();
                        $doc->user_id = Auth::user()->id;
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc['doc']->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc['doc']->getRealPath(), 'r');
                        $doc->save();
                        $upload = new ClaimShareHoldingDoc();    
                        $upload->fill([
                            'app_id' => $request->app_id,
                            'created_by' => Auth::user()->id,
                            'claim_id' =>$claimMaster->id,
                            'ques_id' => $request->ques[2],
                            'doc_id' => 5001,
                            'upload_id' => $doc->id
                        ]);
                        $upload->save();  
                    }   
                }

                $stat_auditor = new ClaimStatutoryAuditor;
                    $stat_auditor->app_id=$request->app_id;
                    $stat_auditor->created_by =Auth::user()->id;
                    $stat_auditor->claim_id =$claimMaster->id;
                    $stat_auditor->firm_name=$request->firm_name;
                    $stat_auditor->date_of_appointment=$request->appt_date;
                    $stat_auditor->appointment_valid_upto=$request->appt_valid;
                    $stat_auditor->date_of_certificate=$request->sa_date;
                    $stat_auditor->email=$request->sa_email;
                    $stat_auditor->udin=$request->udin;
                    $stat_auditor->partner_name=$request->partner_name;
                    $stat_auditor->mobile_signing_partner=$request->partner_cont_no;
                $stat_auditor->save();
                
                
                ClaimStage::create([
                    'app_id'=>$request->app_id,
                    'created_by' =>Auth::user()->id,
                    'claim_id' =>$claimMaster->id,
                    'stages' =>1,
                    'status'=>'D'
                    ]);

                alert()->success('Claim Application Details Saved', 'Success!')->persistent('Close');

            });
        
            $claimMaster = DB::table('claims_masters')->where('app_id',$request->app_id)->first();

            return redirect()->route('claimsapplicantdetail.edit',$claimMaster->id);
        }catch(Exception $e){
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClaimApplicantDetails  $claimApplicantDetails
     * @return \Illuminate\Http\Response
     */
    public function show(ClaimApplicantDetails $claimApplicantDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClaimApplicantDetails  $claimApplicantDetails
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //dd($id);
        try{
                $claimMast=DB::table('claims_masters')->where('id',$id)->first();
                
                
                $applicant_detail=DB::table('claim_applicant_details')->where('claim_id',$id)->first();
                
                $shareholder=DB::table('claim_share_holding_patterns')->where('claim_id',$id)->get();
                $old_shareholder=DB::table('promoter_details')->where('app_id',$claimMast->app_id)->get();
                $appMast = DB::table('approved_apps_details')->where('id',$claimMast->app_id)->where('user_id',Auth::user()->id)->first();
                $users = DB::table('users')->where('id',$appMast->user_id)->first();
                $manuf_loc=DB::table('claim_manuf_locs')->where('claim_id',$id)->get();
                $sh_patterns=DB::table('claim_share_holding_patterns')->where('claim_id',$id)->get();
                $shareholding_change=DB::table('claim_share_holding_patterns')->where('claim_id',$id)->first();

                $statutory_auditor=DB::table('claim_statutory_auditors')->where('claim_id',$id)->first();
                $sh_docs=DB::table('claim_share_holding_docs')->where('claim_id',$id)->get();
                $fy=DB::table('fy_master')->where('status',1)->where('id', $claimMast->fy)->first();
                $claimUserResponse = DB::table('claim_question_user_responses')->where('claim_id',$id)->get();
                $arr_qtr=DB::table('qtr_master')->where('fy',$fy->fy_name)->where('status','1')->orderby('qtr')->get();
                
                $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');
                
                $city = DB::table('pincodes')->whereNotNull('city')->orderBy('city')->select('state','city')->get()->unique('city');
                $fy_id = $claimMast->fy;
                return view('user.claims.applicant_detail_edit',compact('fy_id','claimMast','fy','appMast','users','shareholder','manuf_loc','sh_patterns','statutory_auditor','sh_docs','shareholding_change','old_shareholder','claimUserResponse','states','city', 'applicant_detail','arr_qtr'));
            }catch(Exception $e){
                alert()->error('Something went wrong', 'Attention!')->persistent('Close');
                return redirect()->back();
            }
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClaimApplicantDetails  $claimApplicantDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  dd($id);
       
        // try{
            if(isset($request->quarterly_claim) && $request->claim_period==1)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->quarterly_claim);
            }
            elseif(isset($request->half_hearly_claim) && $request->claim_period==2)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->half_hearly_claim);
            }
            elseif(isset($request->nine_months_claim) && $request->claim_period==3)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->nine_months_claim);
            }
            elseif(isset($request->annual_claim) && $request->claim_period==4)
            {
                list($from_qtr,$to_qtr)=explode('@_@',$request->annual_claim);
            }

            $claimMast = ClaimMaster::where('id', $id)->where('status', 'D')->first(); 
            
            // dd($request, $claimMast,$from_qtr,$to_qtr, $request->claim_period);
            // dd($claimMast);
        
            DB::transaction(function () use ($request, $claimMast,$from_qtr,$to_qtr) {
                
                if($request->claim_id){
                
                    $claimMast = ClaimMaster::find($claimMast->id);
                        // $claimMast->fy = '1'; comment by deepak sharma 2202024
                        $claimMast->fy = $request->fy_id;
                        $claimMast->save();

                    foreach($request->applicant_data as $applicant){
                        $applicant_detail = ClaimApplicantDetails::find($applicant['id']);
                            $applicant_detail->committed_capacity=$applicant['committted_capacity'];
                            $applicant_detail->quoted_sales=$applicant['quoted_sales'];
                            $applicant_detail->hsn=$applicant['hsn'];
                            $applicant_detail->incentive_from_date=$from_qtr;
                            $applicant_detail->incentive_to_date=$to_qtr;
                            $applicant_detail->claim_fill_period=$request->claim_period;
                        $applicant_detail->save();
                    }

                    foreach($request->loc as $locs){
                        if(array_key_exists('id',$locs)){
                            $location = ClaimManufLoc::find($locs['id']);
                                $location->address=$locs['addr'];
                                $location->state=$locs['state'];
                                $location->city=$locs['city'];
                                $location->pincode=$locs['pincode'];
                            $location->save();
                        }else{
                            $claimManufLoc = new ClaimManufLoc;
                                $claimManufLoc->app_id=$request->app_id;
                                $claimManufLoc->created_by=Auth::user()->id;
                                $claimManufLoc->claim_id=$request->claim_id;
                                $claimManufLoc->address=$locs['addr'];
                                $claimManufLoc->city=$locs['city'];
                                $claimManufLoc->state=$locs['state'];
                                $claimManufLoc->pincode=$locs['pincode'];
                            $claimManufLoc->save();
                        }
                    }

                    
                    if($request->value[0] == 'Y'){
                    
                        foreach($request->shareholding as $shareholdings){
                            if(array_key_exists('id',$shareholdings)){
                                $shareholder = ClaimShareHoldingPattern::find($shareholdings['id']);
                                $shareholder->new_shareholder_name=$shareholdings['new_sh_name'];
                                $shareholder->new_equity_share=$shareholdings['new_sh_eq_share'];
                                $shareholder->new_percentage=$shareholdings['new_sh_per'];
                                $shareholder->date_of_change=$request->reason_date;
                                $shareholder->reason_for_change=$request->reason_shareholding;
                                $shareholder->save();
                            }else{
                            
                                $claimShareHolding = new ClaimShareHoldingPattern;
                                    $claimShareHolding->app_id=$request->app_id;
                                    $claimShareHolding->claim_id=$request->claim_id;
                                    $claimShareHolding->created_by=Auth::user()->id;
                                    $claimShareHolding->ques_id=$request->ques[0];
                                    $claimShareHolding->new_shareholder_name=$shareholdings['new_sh_name'];
                                    $claimShareHolding->new_equity_share=$shareholdings['new_sh_eq_share'];
                                    $claimShareHolding->new_percentage=$shareholdings['new_sh_per'];
                                    $claimShareHolding->date_of_change=$request->reason_date;
                                    $claimShareHolding->reason_for_change=$request->reason_shareholding;
                                $claimShareHolding->save();
                                
                            
                            }
                            $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[0])->first();
                                $resp->fill([
                                    'ques_id' => $request->ques[0],
                                    'response' => $request->value[0],
                                    'update_at' => Carbon::now(),
                                ]);
                            $resp->save();
                            
                        }
                
                    }else{

                            if(!empty( $request->shareholding)){
                                foreach($request->shareholding as $key => $shareholder_pattern){
                                    $q1=ClaimShareHoldingPattern::where('claim_id',$request->claim_id)
                                    ->where('id',$shareholder_pattern['id'])
                                    ->first();
                                    if(!empty( $q1)){
                                            $q1->delete();
                                    }
                                }
                            }

                            $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[0])->first();
                            $resp->fill([
                                'ques_id' => $request->ques[0],
                                'response' => $request->value[0],
                                'update_at' => Carbon::now(),
                            ]);

                            $resp->save();
                        // }

                    }

                    if($request->value[2]=='Y'){                    
                        foreach($request->shareHoldingPattern as $sharedocs){
                        
                            if(array_key_exists('doc',$sharedocs)){
                            
                                if(array_key_exists('upload_id',$sharedocs)){
                                    $doc=DocumentUploads::find($sharedocs['upload_id']);
                                    $doc->mime = $sharedocs['doc']->getMimeType();
                                    $doc->file_size = $sharedocs['doc']->getSize();
                                    $doc->updated_at = Carbon::now();
                                    $doc->user_id = Auth::user()->id;
                                    $doc->file_name = $sharedocs['doc']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($sharedocs['doc']->getRealPath(), 'r');
                                    $doc->save();
                                
                                    $upload = ClaimShareHoldingDoc::find($sharedocs['id']);
                                        $upload->upload_id=$doc->id;
                                        $upload->save();
                                }else{
                                
                                    $doc = new DocumentUploads;
                                    $doc->app_id=$request->app_id;
                                    $doc->doc_id = 5001;
                                    $doc->mime = $sharedocs['doc']->getMimeType();
                                    $doc->file_size = $sharedocs['doc']->getSize();
                                    $doc->user_id = Auth::user()->id;
                                    $doc->updated_at = Carbon::now();
                                    $doc->created_at = Carbon::now();
                                    $doc->file_name = $sharedocs['doc']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($sharedocs['doc']->getRealPath(), 'r');
                                    $doc->save();
                                    $upload = new ClaimShareHoldingDoc();    
                                    $upload->fill([
                                        'app_id' => $request->app_id,
                                        'created_by' => Auth::user()->id,
                                        'claim_id' =>$request->claim_id,
                                        'ques_id' => $request->ques[2],
                                        'doc_id' => 5001,
                                        'upload_id' => $doc->id
                                    ]);
                                    $upload->save();  
                                }
                                $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[2])->first();
                                $resp->fill([
                                    'ques_id' => $request->ques[2],
                                    'response' => $request->value[2],
                                    'update_at' => Carbon::now(),
                                ]);
                                $resp->save();
                            }
                            
                        }
                    }else{
                        
                        ClaimShareHoldingDoc::where('claim_id',$request->claim_id)->where('ques_id',$request->ques[2])->delete();

                        $resp= ClaimQuestionUserResponse::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->where('ques_id',$request->ques[2])->first();
                            $resp->fill([
                                'app_id' => $request->app_id,
                                'claim_id' =>$request->claim_id,
                                'created_by' => Auth::user()->id,
                                'ques_id' => $request->ques[2],
                                'response' => $request->value[2],
                                'update_at' => Carbon::now(),
                            ]);
                            
                            $resp->save();
                    }
                
                    if($request->stat_auditor){
                        $auditor = ClaimStatutoryAuditor::find($request->stat_auditor);
                            $auditor->firm_name=$request->firm_name;
                            $auditor->date_of_appointment=$request->appt_date;
                            $auditor->appointment_valid_upto=$request->appt_valid;
                            $auditor->date_of_certificate=$request->sa_date;
                            $auditor->udin=$request->udin;
                            $auditor->partner_name=$request->partner_name;
                            $auditor->email=$request->sa_email;
                            $auditor->mobile_signing_partner=$request->partner_cont_no;
                        $auditor->save();
                    }
                
                }
                alert()->success('Application Edit Saved', 'Success!')->persistent('Close');
            });
        
             return redirect()->route('claimsapplicantdetail.edit',$claimMast->id);
            //return redirect()->route('claimsapplicantdetail.edit', ['claim_id' => $request->claim_id, 'fy_id' => $request->fy_id]);
        // }catch(Exception $e){
        //     alert()->error('Something went wrong', 'Attention!')->persistent('Close');
        //     return redirect()->back();
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClaimApplicantDetails  $claimApplicantDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClaimApplicantDetails $claimApplicantDetails)
    {
        //
    }
}
