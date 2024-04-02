<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Excel;
use App\AdminClaimIncentive;
use App\Exports\ClaimIncentiveExport;
use App\DocumentUploads;
use Carbon\Carbon;
use Exception;
use Auth;

class ClaimIncentiveController extends Controller
{
    public function claimIncentive($fy_id = 1){

        $fys = DB::table('fy_master')->where('status',1)->get();
        DB::select('call admin_claim_incentive_data()');
        
        if($fy_id == 'ALL'){
            $claimData =  DB::table('admin_claim_incentive')->orderby('id','ASC')->get();
        }else{
            $claim_fy = DB::table('fy_master')->where('id',$fy_id)->where('status',1)->first();
            $claimData =  DB::table('admin_claim_incentive')->where('claim_fy',$claim_fy->fy_name)->orderby('id','ASC')->get();
        }

       

        return view('adminshared.claims.incentive',compact('fy_id','fys','claimData'));
    }
    public function claimIncentiveUpdate(Request $request,$fy){
        // dd($request,$fy);
        DB::transaction(function () use ($request) {
            if(isset($request->claim )){
            foreach($request->claim as $claim){
                // dd($claim);
            //     $diff_in_days = null;
            //     $diff_in_days1 = null;
            // if($claim['filingDate']!=null && $claim['reportInfo']!=null && $claim['reportMeitytoPMA']!=null){

            //     $f = Carbon::parse($claim['filingDate']);
            //     $g = Carbon::parse($claim['reportInfo']);
            //     $h = Carbon::parse($claim['reportMeitytoPMA']);

            //     $diff_in_days = $h->diffInDays($f);
            //     $diff_in_days1 = $h->diffInDays($g);
            // }
            // dd($diff_in_days,$diff_in_days1);

                $claimIncentive = AdminClaimIncentive::find($claim['id']);
                    $claimIncentive->incentive_amount=$claim['incAmount'];
                    $claimIncentive->expsubdate_reportinfo=$claim['reportInfo'];
                    $claimIncentive->expsubdate_reportmeitytopma=$claim['reportMeitytoPMA'];
                    $claimIncentive->daysbetween_submandreport=$claim['noOfDaysSubReport'];
                    $claimIncentive->daysbetween_dataandreport=$claim['noOfDaysCompData'];
                    $claimIncentive->status=array_key_exists('status',$claim)?$claim['status']:null;
                    $claimIncentive->remarks=(array_key_exists('status',$claim))?$claim['remarks']:null;
                    $claimIncentive->appr_date=$claim['apprDate'];
                    $claimIncentive->processed_amount = $claim['processed_amount'];

                    $claimIncentive->date_of_disbursal_claim_pma=$claim['date_of_disbursal_claim_pma'];
                    $claimIncentive->total_duration_disbursal=$claim['total_duration_disbursal'];
                    $claimIncentive->appr_amount=$claim['apprAmount'];
		      $claimIncentive->created_by= Auth::user()->id;
                $claimIncentive->save();
            }
        }
        });

        alert()->success('Data has been Saved')->persistent('Close');
        return redirect()->route('admin.claims.incentive',$fy);
    }

    public function claimIncentiveExport()
    {
        return Excel::download(new ClaimIncentiveExport, 'claim_incentive_export.xlsx');
    }

    public function claimSummaryReportView()
    {
        // $claim_summary_report = DB::table('incentive_summary_overview_view')
        // ->select('scheme','hod','totclaim','totamount','timeallowed','head','noofclaim','claimamount')
        // ->orderby('id','asc')->get();
        $heads = DB::table('time_slots')->orderby('id','asc')->pluck('head','id');
        $schemeDetails = DB::table('incentive_summary_report')->first();
        // dd($schemeDetails);
        $summary = DB::table('incentive_summary_report_view')->get();

        // dd($summary->where('head_id' = 1)->get()->claim_id);
        return view('adminshared.claims.summaryReport',compact('summary','heads','schemeDetails'));
    }

    public function addCorrespondance(request $request ,$id) {
        
        $claim_id = decrypt($id);

        try{
        DB::transaction(function () use ($request,$claim_id) {
        // dd($request,$claim_id);
        foreach($request->corres as $data){
            
            // if (empty($data['raise_date'])) {
            //     // Raise date is null, show alert and redirect back
            //     alert()->error('Raise Date cannot be null', 'Error!')->persistent('Close');
            //     return redirect()->back();
            // }

            if(array_key_exists('image',$data)){
            $doc = new DocumentUploads;
            $doc->app_id = $request->app_id;
            $doc->doc_id = '5008';
            $doc->user_id =  $request->user_id;
            $doc->file_name = $data['image']->getClientOriginalName();
            $doc->mime = $data['image']->getMimeType();
            $doc->file_size = $data['image']->getSize();
            $doc->uploaded_file = fopen($data['image']->getRealPath(), 'r');
            $doc->created_at =Carbon::now();
            $doc->save();
            // dd($doc);
            }
            DB::table('claim_incentive_correspondence')->insert([
                'user_id' => $request->user_id,	
                'app_id'=> $request->app_id,
                'claim_id'	=>$claim_id,
                'raise_date'=>$data['raise_date'],	
                'response_date'	=>$data['response_date'],
                'message'	=> $data['message'],
                'doc_id'	=> array_key_exists('image',$data)?$doc->id:null,
                'created_at'=>Carbon::now(),
            ]);
           
        }
    });
        alert()->success('Data Added Successfully', 'Success')->persistent('Close');
        return redirect()->route('admin.claims.incentive',['fy'=>'1']);
    }
    catch(Exception $e){
        // dd($e);
        alert()->error('Something Went Wrong', 'Error!')->persistent('Close');
        return redirect()->back();
    }
    }

    public function editCorrespondance($id) {
        $claim_id = decrypt($id);

        $claim_corres = DB::table('claim_incentive_correspondence')->where('claim_id',$claim_id)->get();

        return view('adminshared.claims.correspondenceEdit',compact('claim_corres','claim_id'));
    }
    public function updateCorres(request $request, $id)  {
        $claim_id = decrypt($id);
        try{
        DB::transaction(function () use ($request,$claim_id) {
        // dd($request);
        foreach($request->corres as $data){
            if(array_key_exists('id',$data)){
            if(array_key_exists('image',$data)){
                $doc = DocumentUploads::where('id', $data['doc_id'])->first();
                $doc->mime = $data['image']->getMimeType();
                $doc->file_size = $data['image']->getSize();
                $doc->updated_at = Carbon::now();
                $doc->file_name = $data['image']->getClientOriginalName();
                $doc->uploaded_file = fopen($data['image']->getRealPath(), 'r');
                $doc->save();
                   
                DB::table('claim_incentive_correspondence')->where('id',$data['id'])->update([
                    'raise_date'=>$data['raise_date'],	
                    'response_date'	=>$data['response_date'],
                    'message'	=> $data['message'],
                    'doc_id'=>$doc->id,
                    'updated_at'=>Carbon::now(),
                ]); 
            }

            DB::table('claim_incentive_correspondence')->where('id',$data['id'])->update([
                'raise_date'=>$data['raise_date'],	
                'response_date'	=>$data['response_date'],
                'message'	=> $data['message'],
                'updated_at'=>Carbon::now(),
            ]);
        }
        else{
            if(array_key_exists('image',$data)){
            $doc = new DocumentUploads;
            $doc->app_id = $request->app_id;
            $doc->doc_id = '5008';
            $doc->user_id =  $request->user_id;
            $doc->file_name = $data['image']->getClientOriginalName();
            $doc->mime = $data['image']->getMimeType();
            $doc->file_size = $data['image']->getSize();
            $doc->uploaded_file = fopen($data['image']->getRealPath(), 'r');
            $doc->created_at =Carbon::now();
            $doc->save();
            DB::table('claim_incentive_correspondence')->insert([
                'user_id' => $request->user_id,	
                'app_id'=> $request->app_id,
                'claim_id'	=>$claim_id,
                'raise_date'=>$data['raise_date'],	
                'response_date'	=>$data['response_date'],
                'message'	=> $data['message'],
                'doc_id'	=> $doc->id,
                'created_at'=>Carbon::now(),
            ]);
            }   
            DB::table('claim_incentive_correspondence')->insert([
                'user_id' => $request->user_id,	
                'app_id'=> $request->app_id,
                'claim_id'	=>$claim_id,
                'raise_date'=>$data['raise_date'],	
                'response_date'	=>$data['response_date'],
                'message'	=> $data['message'],
                'created_at'=>Carbon::now(),
            ]);
        } 
        }
    });
        alert()->success('Data Updated Successfully', 'Success')->persistent('Close');
        return redirect()->route('admin.claims.incentive',['fy'=>'1']);
    }
    catch(Exception $e){
        alert()->error('Something Went Wrong', 'Error!')->persistent('Close');
        return redirect()->back();
    }
    }
    public function correspondanceView($id) {
        $claim_id = decrypt($id);
        $claim_corres = DB::table('claim_incentive_correspondence')->where('claim_id',$claim_id)->get();

        return view('adminshared.claims.correspondanceView',compact('claim_id','claim_corres'));
    }
}