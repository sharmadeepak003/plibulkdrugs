<?php

namespace App\Http\Controllers\Admin\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\DocumentUploads;
use App\ParkClaimVariableList;
use App\ParkClaimVariableListInvoice;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Exists;
use Mail;


class ParkClaimVariableController extends Controller
{
    public function index(Request $request)
    {
        $getParkClaimVariableData = ParkClaimVariableList::get();
        if (date('m') <= 6)
        {
            $year = (date('Y')-1) . '-' . date('Y');
        }
        else 
        {
            $year = date('Y') . '-' . (date('Y') + 1);
        }
         
         $curMonth = date("m", time());
         $quarter = ceil($curMonth/4);
         $quarter = intval($quarter);
         return view('admin.mail.park.index', compact(['quarter','year','getParkClaimVariableData']));
    }

    public function store(Request $request)
    {
       
        DB::transaction(function () use ($request) {
            $parkClaimVariableId = $request->parkClaimVariableId;
            $userId = Auth::user()->id;
            
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
                
            }

          
            
            $parkClaimVariableDetail = ParkClaimVariableList::find($parkClaimVariableId);
            $parkClaimVariableDetail->mou_upload_id = $moudoc->id;
            $parkClaimVariableDetail->remark = $request->remark;
            $parkClaimVariableDetail->dd = $request->dd;
            $parkClaimVariableDetail->status = 'D';
            $parkClaimVariableDetail->created_by = Auth::user()->id;
            $parkClaimVariableDetail->updated_by = Auth::user()->id;
            $parkClaimVariableDetail->save();
            
                 
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

                        $parkClaimVariavleInvoice = new ParkClaimVariableListInvoice();
                        $parkClaimVariavleInvoice->parkclaimvariable_id = $parkClaimVariableDetail->id;
                        $parkClaimVariavleInvoice->doc_upload_id = $docinvoice->id;
                        $parkClaimVariavleInvoice->invoice_amt = $value['amt'];
                        $parkClaimVariavleInvoice->invoice_date = $value['date'];
                        $parkClaimVariavleInvoice->save();
             
            }
        });
        alert()->success('Park Claim Variable List has been Updated', 'Success')->persistent('Close');

        return redirect()->back();
    }
    
    //editParkclaimVariableId
    public function edit($id)
    {
       $getParkClaimVariableData = ParkClaimVariableList::where('id',$id)->first();
       $getParkVariableInvoiceData = ParkClaimVariableListInvoice::where('parkclaimvariable_id',$id)->get();
       
       return [$getParkClaimVariableData, $getParkVariableInvoiceData]; 
       
    }

    public function update(Request $request)
    {

       
        $userId = Auth::user()->id;
        if ($request->hasfile('mouFile')) {     
            $newDoc = $request->file('mouFile');
                $moudoc =DocumentUploads::find($request->mom_upload_id);
                $moudoc->mime = $newDoc->getMimeType();
                $moudoc->file_size = $newDoc->getSize();
                $moudoc->updated_at = Carbon::now();
                $moudoc->file_name = $newDoc->getClientOriginalName();
                $moudoc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                $moudoc->remarks = '';
                $moudoc->save();
        }

        $claimVariableDetail = ParkClaimVariableList::find($request->editParkclaimVariableId);
        $claimVariableDetail->remark = $request->editremark;
        $claimVariableDetail->dd = $request->dd;
        $claimVariableDetail->updated_by = Auth::user()->id;
        $claimVariableDetail->save();

        foreach($request->data as $value)
                {
                    if (isset($value['id'])) {
                        $variableInvoice = ParkClaimVariableListInvoice::find($value['id']);
                        $variableInvoice->parkclaimvariable_id = $request->editParkclaimVariableId;
                        $variableInvoice->invoice_amt = $value['amt'];
                        $variableInvoice->invoice_date = $value['date'];
                        $variableInvoice->save();
                    }

                    if(isset($value['doc_upload_id']))
                    {
                        if(isset($value['file']))
                        {
                         $docinvoice =DocumentUploads::find($value['doc_upload_id']);
                         $docinvoice->mime = $value['file']->getMimeType();
                         $docinvoice->file_size = $value['file']->getSize();
                         $docinvoice->updated_at = Carbon::now();
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
 
                         $variableInvoice =New ParkClaimVariableListInvoice;
                         $variableInvoice->parkclaimvariable_id = $request->editParkclaimVariableId;
                         $variableInvoice->doc_upload_id = $docinvoice->id;
                         $variableInvoice->invoice_amt = $value['amt'];
                         $variableInvoice->invoice_date = $value['date'];
                         $variableInvoice->save();
                       }
              
            }

            alert()->success('Park Claim Variable List has been Updated', 'Success')->persistent('Close');

        return redirect()->back();
    }


    public function finalsubmit($id)
    {
        
        $parkClaimVariableDetail = ParkClaimVariableList::find($id);
        $parkClaimVariableDetail->status = 'S';
        $parkClaimVariableDetail->updated_by = Auth::user()->id;
        $parkClaimVariableDetail->save();
        //below final submit mail 
        //$data = ["hello"];
        //Mail::send('emails.parkclaimvariable', $data, function($message) use($data) {
            //$message->to($data['email'],$data['name'])->subject
            //$message->to(['bdpli@ifciltd.com'])->subject
            //('Invoice Mail | PLI Scheme for Medical Devices | Reminder!');
            //$message->cc('mdpli@ifciltd.com','PLI Medical Devices');
            // $message->cc('mdpli@ifciltd.com','PLI Medical Devices');
        //});
        alert()->success('Park Claim Variable List has been Final Submitted', 'Success')->persistent('Close');
        return redirect()->back();
        
    }

    public function view($id)
    {
        $getParkClaimVariableListData = ParkClaimVariableList::where('id',$id)->first();
        $getParkVariableListInvoiceData = ParkClaimVariableListInvoice::where('parkclaimvariable_id',$id)->get();
        
        return [$getParkClaimVariableListData, $getParkVariableListInvoiceData]; 
    }
}
