<?php

namespace App\Http\Controllers\Admin\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\DocumentUploads;
use App\ClaimVariablemail;
use App\VariableInvoice;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Exists;
use Mail;

class ClaimVariableController extends Controller
{
    public function index(Request $request)
    {
        $getClaimVariableData = ClaimVariablemail::get();
        //dd($getClaimVariableData);

        //currentFinancialYear
        if (date('m') <= 6)
        {
            $year = (date('Y')-1) . '-' . date('Y');
        }
        else 
        {
            $year = date('Y') . '-' . (date('Y') + 1);
        }
         //currentQuarter 
         $curMonth = date("m", time());
         $quarter = ceil($curMonth/4);

         $qtr = DB::table('qtr_master')->distinct('fy')->get();

        return view('admin.mail.variable.index', compact(['qtr','quarter','year','getClaimVariableData']));
    }

    public function store(Request $request)
    {
       
        DB::transaction(function () use ($request) {
            $claimVariableId = $request->claimVariableId;
            $userId = Auth::user()->id;
            //mou file
            // $uploadId = array();
            if ($request->hasfile('mouFile')) {
                
                $newDoc = $request->file('mouFile');
               
                    $moudoc = new DocumentUploads;
                    $moudoc->doc_id = 5009;
                    $moudoc->mime = $newDoc->getMimeType();
                    $moudoc->file_size = $newDoc->getSize();
                    $moudoc->updated_at = Carbon::now();
                    $moudoc->user_id = $userId;
                    $moudoc->created_at = Carbon::now();
                    $moudoc->file_name = $newDoc->getClientOriginalName();
                    $moudoc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                    $moudoc->remarks = '';
                    $moudoc->save();
                // array_push($uploadId, $doc->id);
            }

            // $uploadId = array();
            
            $claimVariableDetail = ClaimVariablemail::find($claimVariableId);
            $claimVariableDetail->mou_upload_id = $moudoc->id;
            $claimVariableDetail->remark = $request->remark;
            $claimVariableDetail->dd = $request->dd;
            $claimVariableDetail->status = 'D';
            $claimVariableDetail->created_by = Auth::user()->id;
            $claimVariableDetail->updated_by = Auth::user()->id;
            $claimVariableDetail->save();
            
                 
                foreach($request->data as $value)
                {
                    
                        $docinvoice = new DocumentUploads;
                        $docinvoice->doc_id = 5009;
                        $docinvoice->mime = $value['file']->getMimeType();
                        $docinvoice->file_size = $value['file']->getSize();
                        $docinvoice->updated_at = Carbon::now();
                        $docinvoice->user_id = $userId;
                        $docinvoice->created_at = Carbon::now();
                        $docinvoice->file_name = $value['file']->getClientOriginalName();
                        $docinvoice->uploaded_file = fopen($value['file']->getRealPath(), 'r');
                        $docinvoice->remarks = '';
                        $docinvoice->save();

                        $variableInvoice = new VariableInvoice();
                        $variableInvoice->schedular_mail_claimvariable_id = $claimVariableDetail->id;
                        $variableInvoice->doc_upload_id = $docinvoice->id;
                        $variableInvoice->invoice_amt = $value['amt'];
                        $variableInvoice->invoice_date = $value['date'];
                        $variableInvoice->save();
                // array_push($uploadId, $doc->id);
            }
        });
        alert()->success('Claim Variable List has been Updated', 'Success')->persistent('Close');

        return redirect()->back();
    }

    public function edit($id)
    {
       $getClaimVariableData = ClaimVariablemail::where('id',$id)->first();
       $getVariableInvoiceData = VariableInvoice::where('schedular_mail_claimvariable_id',$id)->get();
       
       return [$getClaimVariableData, $getVariableInvoiceData]; 
       
    }

    public function update(Request $request)
    {

        // dd($request, $request->data);
        $userId = Auth::user()->id;
        if ($request->hasfile('mouFile')) {     
            $newDoc = $request->file('mouFile');
                $moudoc =DocumentUploads::find($request->mom_upload_id);
                // $moudoc->doc_id = 5009;
                $moudoc->mime = $newDoc->getMimeType();
                $moudoc->file_size = $newDoc->getSize();
                $moudoc->updated_at = Carbon::now();
                // $moudoc->user_id = $userId;
                // $moudoc->created_at = Carbon::now();
                $moudoc->file_name = $newDoc->getClientOriginalName();
                $moudoc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                $moudoc->remarks = '';
                $moudoc->save();
            // array_push($uploadId, $doc->id);
        }

        $claimVariableDetail = ClaimVariablemail::find($request->edit_claimVariableId);
        $claimVariableDetail->remark = $request->editremark;
        $claimVariableDetail->dd = $request->dd;
        $claimVariableDetail->updated_by = Auth::user()->id;
        $claimVariableDetail->save();

        foreach($request->data as $value)
                {
                    if (isset($value['id'])) {
                        $variableInvoice = VariableInvoice::find($value['id']);
                        $variableInvoice->schedular_mail_claimvariable_id = $request->edit_claimVariableId;
                        $variableInvoice->invoice_amt = $value['amt'];
                        $variableInvoice->invoice_date = $value['date'];
                        $variableInvoice->save();
                    }

                    if(isset($value['doc_upload_id']))
                    {
                        if(isset($value['file']))
                        {
                         $docinvoice =DocumentUploads::find($value['doc_upload_id']);
                         // $docinvoice->doc_id = 5009;
                         $docinvoice->mime = $value['file']->getMimeType();
                         $docinvoice->file_size = $value['file']->getSize();
                         $docinvoice->updated_at = Carbon::now();
                         // $docinvoice->user_id = $userId;
                         // $docinvoice->created_at = Carbon::now();
                         $docinvoice->file_name = $value['file']->getClientOriginalName();
                         $docinvoice->uploaded_file = fopen($value['file']->getRealPath(), 'r');
                         $docinvoice->remarks = '';
                         $docinvoice->save();
                        }
                    }else{
                        $docinvoice =New DocumentUploads;
                         $docinvoice->doc_id = 5009;
                         $docinvoice->mime = $value['file']->getMimeType();
                         $docinvoice->file_size = $value['file']->getSize();
                         $docinvoice->updated_at = Carbon::now();
                         $docinvoice->user_id = $userId;
                         $docinvoice->created_at = Carbon::now();
                         $docinvoice->file_name = $value['file']->getClientOriginalName();
                         $docinvoice->uploaded_file = fopen($value['file']->getRealPath(), 'r');
                         $docinvoice->remarks = '';
                         $docinvoice->save();
 
                         $variableInvoice =New VariableInvoice;
                         $variableInvoice->schedular_mail_claimvariable_id = $request->edit_claimVariableId;
                         $variableInvoice->doc_upload_id = $docinvoice->id;
                         $variableInvoice->invoice_amt = $value['amt'];
                         $variableInvoice->invoice_date = $value['date'];
                         $variableInvoice->save();
                       }
                       
                // array_push($uploadId, $doc->id);
            }

            alert()->success('Claim Variable List has been Updated', 'Success')->persistent('Close');

        return redirect()->back();
    }
    public function finalsubmit($id)
    {
        $claimVariableDetail = ClaimVariablemail::find($id);
        $claimVariableDetail->status = 'S';
        $claimVariableDetail->updated_by = Auth::user()->id;
        $claimVariableDetail->save();
        //below final submit mail 
        $data = ["hello"];
        Mail::send('emails.invoicemail', $data, function($message) use($data) {
            //$message->to($data['email'],$data['name'])->subject
            $message->to(['bdpli@ifciltd.com'])->subject
            ('Invoice Mail | PLI Scheme for Bulk Drugs | Reminder!');
            //$message->cc('mdpli@ifciltd.com','PLI Bulk Drugs');
            // $message->cc('mdpli@ifciltd.com','PLI Bulk Drugs');
        });
        alert()->success('Schedular Mail List has been Final Submitted', 'Success')->persistent('Close');
        return redirect()->back();
        
    }

    public function view($id)
    {
        $getClaimVariableData = ClaimVariablemail::where('id',$id)->first();
        $getVariableInvoiceData = VariableInvoice::where('schedular_mail_claimvariable_id',$id)->get();
        
        return [$getClaimVariableData, $getVariableInvoiceData]; 
    }
}
