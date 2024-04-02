<?php

namespace App\Http\Controllers\Admin\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\DocumentUploads;
use App\SchedularMailFixed;
use Carbon\Carbon;
use Mail;

class MailSchedularController extends Controller
{
    public function index()
    {

        if (date('m') <= 6) {//Upto June 2014-2015
            $financial_year = (date('Y')-1) . '-' . date('Y');
        } else {//After June 2015-2016
            $financial_year = date('Y') . '-' . (date('Y') + 1);
        }
        

        $curMonth = date("m", time());
        $quarter = ceil($curMonth/4);
        
        //$quarter = 3;
        $detail = '';
        $qtr = DB::table('qtr_master')->distinct('fy')->get();
        $year = $financial_year;

        $getSchedularMailFixiedData = SchedularMailFixed::get();
        //dd($getSchedularMailFixiedData);
        return view('admin.mail.index', compact(['qtr','quarter','detail','qtr','year','getSchedularMailFixiedData']));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $schedular_mail_id = $request->schedular_mail_id;
            $userId = Auth::user()->id;
            $userName = Auth::user()->name;
            // $uploadId = array();
            if ($request->hasfile('formFile')) {
                
                $newDoc = $request->file('formFile');
               
                    $doc = new DocumentUploads;
                    $doc->doc_id = 5009;
                    $doc->mime = $newDoc->getMimeType();
                    $doc->file_size = $newDoc->getSize();
                    $doc->updated_at = Carbon::now();
                    $doc->user_id = $userId;
                    $doc->created_at = Carbon::now();
                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                    $doc->remarks = '';
                    $doc->save();
                // array_push($uploadId, $doc->id);
            }
                $schedularMailListDetail = SchedularMailFixed::find($schedular_mail_id);
                $schedularMailListDetail->doc_upload_id = $doc->id;
                $schedularMailListDetail->invoice_amt = $request->invoiceAmount;
                $schedularMailListDetail->invoice_date = $request->invoiceDate;
                $schedularMailListDetail->remark = $request->remark;
                $schedularMailListDetail->status = 'D';
                $schedularMailListDetail->created_by = Auth::user()->id;
                $schedularMailListDetail->updated_by = Auth::user()->id;
                $schedularMailListDetail->save();
        });
        alert()->success('Schedular Mail List has been Updated', 'Success')->persistent('Close');

        return redirect()->back();
    }

    public function edit($id)
    {
       $getMailSchedularData = SchedularMailFixed::where('id',$id)->first();
       return json_encode($getMailSchedularData); 
       
    }

    public function view($id)
    {
       $getMailSchedularData = SchedularMailFixed::where('id',$id)->first();
       return json_encode($getMailSchedularData); 
       
    }

    public function update(Request $request)
    {
        DB::transaction(function () use ($request) {
        if($request->hasfile('formFile'))
        {
            $doc =DocumentUploads::find($request->doc_upload_id);
            $doc->mime = $request->formFile->getMimeType();
            $doc->file_size = $request->formFile->getSize();
            $doc->updated_at = Carbon::now();
            $doc->user_id = Auth::user()->id;
            $doc->file_name = $request->formFile->getClientOriginalName();
            $doc->uploaded_file = fopen($request->formFile->getRealPath(), 'r');
            $doc->remarks = null;
            $doc->save();
        }
       
    
            $schedularMailListDetail = SchedularMailFixed::find($request->schedular_mail_id);
            $schedularMailListDetail->invoice_amt = $request->invoiceAmount;
            $schedularMailListDetail->invoice_date = $request->invoiceDate;
            $schedularMailListDetail->remark = $request->remark;
            $schedularMailListDetail->Save();
        // }
    });
        alert()->success('Schedular Mail List has been Updated', 'Success')->persistent('Close');

        return redirect()->back();
    }

    public function finalsubmit($id)
    {
        $schedularMailListDetail = SchedularMailFixed::find($id);
        $schedularMailListDetail->status = 'S';
        $schedularMailListDetail->Save();
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
   
    

}
