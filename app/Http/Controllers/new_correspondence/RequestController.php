<?php

namespace App\Http\Controllers\new_correspondence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\RequestHd;
use App\RequestDet;
use App\RequestDocumentUploads;
use App\User;
use Carbon\Carbon;
use DB;
use App\SubmissionSms;
use App\AdminSubmissionSms;
use Str;

class RequestController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $moduleRows = DB::table('req_category')->where('active_flg', '1')->get();
        $users = DB::table('approved_apps')->join('users', 'users.id', '=', 'approved_apps.created_by')->select('users.*')->orderby('users.name')->where(DB::RAW("is_normal_user(users.id)"), 1)->get();
        $hasRole = Auth::user()->getRoleNames()->toArray();
        if(in_array("CorresReply", $hasRole) || in_array("SuperAdmin", $hasRole) || in_array("Admin", $hasRole)){
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'type_of_request.id', '=', 'request_hd.type_of_req')
                // ->where('users.id',$user_id)
                ->orderby('request_hd.status', 'asc')
                ->orderby('request_hd.id', 'asc')
                ->get(['request_hd.*', 'users.name', 'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc']);
        } elseif ($hasRole[0] == 'Admin-Meity') {
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'type_of_request.id', '=', 'request_hd.type_of_req')
                ->where('request_hd.visible', 1)
                ->orWhere('request_hd.user_id', $user_id)
                ->orwhere('request_hd.raised_for_user', $user_id)
                ->orderby('request_hd.status', 'asc')
                ->orderby('request_hd.id', 'asc')
                ->get(['request_hd.*', 'users.name', 'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc']);
        } else {
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'type_of_request.id', '=', 'request_hd.type_of_req')
                ->where('request_hd.raised_for_user', $user_id)
                ->orWhere('request_hd.user_id', $user_id)
                ->orderby('request_hd.status', 'asc')
                ->orderby('request_hd.id', 'asc')
                ->get(['request_hd.*', 'users.name', 'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc']);
        }

        return view('new_correspondence.index', compact('reqs', 'hasRole', 'users', 'moduleRows'));
    }


    public function statuscheck($req_id, $checkid)
    {
        // dd($checkid);

        $updatestatus = RequestHd::where('id', $req_id)->first();

        if ($checkid == 1) {

            $updatestatus->fill([
                'visible' => 1,
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),

            ]);
        } elseif ($checkid == 0) {

            $updatestatus->fill([
                'visible' => null,
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),

            ]);
        }


        DB::transaction(function () use ($updatestatus) {
            $updatestatus->save();
        });
        alert()->success('Details Updated', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function statuscm($req_id, $checkid)
    {
        // dd($checkid);

        $updatestatus = RequestHd::where('id', $req_id)->first();

        if ($checkid == 1) {

            $updatestatus->fill([
                'visible_com' => 1,
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),

            ]);
        } elseif ($checkid == 0) {

            $updatestatus->fill([
                'visible_com' => null,
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),

            ]);
        }


        DB::transaction(function () use ($updatestatus) {
            $updatestatus->save();
        });
        alert()->success('Details Updated', 'Success')->persistent('Close');
        return redirect()->back();
    }



    public function create()
    {

        $hasRole = Auth::user()->hasRole('CorresReply');
        
        if($hasRole == 'CorresReply'){   
            
            $valid_roles = DB::table('req_user as cum')
            ->join('roles', 'roles.id', '=', 'cum.role_id')
            //->where('roles.id', 11)
            ->whereNotIn('cum.id', [2, 3])
            ->select('cum.name', 'cum.id')
            ->orderBy('roles.id')
            ->get();
            //dd($valid_roles);
            
          
        } 
        elseif ($hasRole == 'Admin-Meity') {
            $valid_roles = DB::table('req_user as cum')
                ->join('roles', 'roles.id', '=', 'cum.role_id')
                ->whereNotIn('cum.id', [1, 2, 4])
                ->select('cum.name', 'cum.id')
                ->orderBy('roles.id')
                ->get();
            // dd($valid_roles);
        } elseif ($hasRole == 'Admin') {

            $valid_roles = DB::table('req_user as cum')
                ->join('roles', 'roles.id', '=', 'cum.role_id')
                ->whereNotIn('cum.id', [2, 3])
                ->select('cum.name', 'cum.id')
                ->orderBy('roles.id')
                ->get();
        }else {
            $valid_roles = DB::table('req_user as cum')
                ->join('roles', 'roles.id', '=', 'cum.role_id')
                ->where('roles.id', '2')
                ->select('cum.name', 'cum.id')
                ->orderBy('roles.id')
                ->get();
        }
        $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
            ->where('users.id', Auth::user()->id)
            ->get(['request_hd.*', 'users.name']);
        $moduleRows = DB::table('req_category')->where('active_flg', '1')->get();
        $reqcats_sub = DB::table('req_category_subtype')->get();
        $typeOfReq = DB::table('type_of_request')->get();
        return view('new_correspondence.create', compact('reqs', 'moduleRows', 'reqcats_sub', 'typeOfReq', 'valid_roles'));
    }



    public function usersList($request_type)
    {
      
        $role_id = DB::table('req_user')->where('id', $request_type)->first();
        // dd($role_id);

        if($request_type==3)
        {
        $users = DB::table('users as u')
            ->join('model_has_roles as mhr', 'mhr.model_id', '=', 'u.id')
            ->where('mhr.role_id', 11)
            ->select('u.name', 'u.id')
            ->get();
            //dd($users,'dd');
        }
    else{
            $users = DB::table('users as u')
            ->join('model_has_roles as mhr', 'mhr.model_id', '=', 'u.id')
            ->where('mhr.role_id', $role_id->role_id)
            ->select('u.name', 'u.id')
            ->get();
            //dd($role_id->role_id);

        }


        return json_encode($users);
    }

    public function applicationNumberList($app_id)
    {
        
        // $hasRole = Auth::user()->getRoleNames()->toArray();
        $hasRole = Auth::user()->hasRole('CorresReply');
        //dd($hasRole);
        $getApplicatId = Auth::user()->id;
        if ($hasRole == 'CorresReply') {
            $applicant_id = $app_id;
            $applicantData = DB::table('users as u')
                ->join('approved_apps as aa', 'aa.created_by', '=', 'u.id')
                ->where('aa.created_by', $applicant_id)
                ->where('aa.status', 'S')
                ->whereRaw('is_normal_user(u.id) = 1')
                ->select('aa.id', 'aa.app_no')
                ->get();
        }
        elseif ($hasRole == 'Admin') {
            $applicant_id = $app_id;
            $applicantData = DB::table('users as u')
                ->join('approved_apps as aa', 'aa.created_by', '=', 'u.id')
                ->where('aa.created_by', $applicant_id)
                ->where('aa.status', 'S')
                ->whereRaw('is_normal_user(u.id) = 1')
                ->select('aa.id', 'aa.app_no')
                ->get();
        } else {

            $applicant_id = $getApplicatId;
            $applicantData = DB::table('users as u')
                ->join('approved_apps as aa', 'aa.created_by', '=', 'u.id')
                ->where('aa.created_by', $applicant_id)
                ->where('aa.status', 'S')
                ->select('aa.id', 'aa.app_no')
                ->get();
        }

        
        $applicant_data_vw = [
            'applicantData' => $applicantData
        ];

        return json_encode($applicant_data_vw);
    }


    public function store(Request $request)
    {

        
        $hasRole = Auth::user()->getRoleNames()->toArray();

        $role = DB::table('model_has_roles')->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $request->request_to)->first();
        if (isset($request->claim_no)) {
            $claim_id = $request->claim_no;
        } else {
            $claim_id = NULL;
        }

     
        DB::transaction(function () use ($request, $hasRole, $role, $claim_id) {
            $files = $request->file('reqdoc');
            $reqdoc = $request->reqdoc;
            $reqHd = new RequestHd;
            $reqHd->user_id = Auth::user()->id;
            $reqHd->raised_for_user = $request->request_to;
            $reqHd->app_no = $request->application_number;
            $reqHd->claim_id =  $claim_id;
            $reqHd->first_applied_dt = Carbon::now();
            $reqHd->cat_id = $request->related_to;
            $reqHd->raise_by_role = $hasRole[0];
            $reqHd->cat_subtype = $request->catsubtype;
            $reqHd->type_of_req = $request->reqtype;
            $reqHd->raise_by_role = $hasRole[0];
            $reqHd->pending_with = $role->name;
            
            $reqHd->pending_since = Carbon::now();
            $reqHd->status = 'S';
            $dt = Carbon::parse($reqHd->first_applied_dt);
            $prvYear = DB::select(DB::raw("SELECT req_id_generate('$dt')"));
            foreach ($prvYear as $values) {
                $reqHd->req_id = $values->req_id_generate;
            }
           
            $reqHd->save();

            $DetailUploadId = array();
            if ($reqdoc) {
                foreach ($reqdoc as $value) {
                    $newDoc = $value;
                    $doc = new RequestDocumentUploads;
                    $doc->req_id = $reqHd->id;
                    $doc->mime = $newDoc->getMimeType();
                    $doc->file_size = $newDoc->getSize();
                    $doc->updated_at = Carbon::now();
                    $doc->user_id = Auth::user()->id;
                    $doc->created_at = Carbon::now();
                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                   
                    $doc->save();
                    array_push($DetailUploadId, $doc->id);
                }
            }
           
            $reqdet = new RequestDet;
            $reqdet->req_id = $reqHd->id;
            $reqdet->msg = $request->msg;
            $reqdet->doc_id = $DetailUploadId;
            $reqdet->created_by = Auth::user()->id;
           

            $reqdet->save();
        });

        $recipientRow = User::where('id', $request->request_to)->first();

        
        $request_type = DB::table('type_of_request')->where('id', $request->reqtype)->first();
        

        $moduleRow = DB::select("select * from req_category where id=" . $request->related_to);

        $module_name = $moduleRow[0]->category_desc;
        
        $userTypeRows = DB::select('select * from req_user where id=' . $request->user_type);
        $user_type = $userTypeRows[0]->name;
       
        $portal_name = env('APP_NAME');

        // SMS code for correspondence module
        $hasRole = Auth::user()->getRoleNames()->toArray();
        if($hasRole[0] == 'CorresReply')
        {
            $admin_number = DB::table('users')->where('email', 'dgm.md@ifciltd.com')->first();
            $SMS = new SubmissionSms();
            $module = "Correspondance";
            $app_no = Str::replaceFirst('IFCI/', '', $request->application_number);
            $message = array($app_no);
            //$smsResponse = $SMS->sendSMS(Auth::user()->mobile, $message, $module);
            
        }
        else{

            $admin_number = DB::table('users')->where('email', 'dgm.md@ifciltd.com')->first();
            $SMS = new SubmissionSms();
            $module = "Correspondance";
            $app_no = Str::replaceFirst('IFCI/', '', $request->application_number);
            $message = array($app_no);
            //$smsResponse = $SMS->sendSMS(Auth::user()->mobile, $message, $module);
            

            
        }
        // end SMD for correspondence module
        $data = array('email' => $recipientRow->email, 'user_name' => $recipientRow->name, 'module_name' => $module_name, 'user_type' => $user_type, 'request_type' => $request_type->type_desc, 'user_name' => Auth::user()->name, 'body_message' => $request->msg, 'status' => 'open');
        Mail::send('emails.requestsubmit', $data, function ($message) use ($data, $portal_name) {
            $message->to($data['email'])->subject("PLI Scheme for Bulk Drugs || Query Submitted Succesfully");
            $message->cc('bdpli@ifciltd.com', 'PLI Bulk Drugs');
        });

        /**
         * For DGM
         */
        if($request->hasFile('reqdoc')){
        $docMsg  = 'Documents Available';
        } else {
        $docMsg  = 'No Documents';
        }  

        $reg = '';
        if(in_array('Admin', Auth::user()->getRoleNames()->toArray()))
        {
            $reg = 'DGM-IFCI';
        }





        $userDetails = DB::table('users')->where('id',$request->request_to)->first();
        $data = array('name'=>$userDetails->name,'app_no'=>$request->application_no,
                    'email'=>$userDetails->email,'msg'=>$request->msg,'docExist'=>$docMsg,'reg'=> $reg );




        //  dd($data);
                Mail::mailer('ifcidgm')
                ->send('emails.correspondence', $data, function($message) use($data) {
                    $message->to($data['email'],$data['name'])->subject
                    ('PLIBD - Correspondence');
                    $message->cc('bdpli@ifciltd.com', 'PLIBD');
            });


        alert()->success('Record Submitted', 'Success')->persistent('Close');
        return redirect()->route('newcorrespondence.index');
    }

    public function show($id)
    {
        $user_id = Auth::user()->id;
        $hasRole = Auth::user()->getRoleNames()->toArray();
        $reqHd = RequestHd::where('id', $id)->first();
        $reqDets = RequestDet::where('req_id', $id)->get();

        if ($hasRole[0] == 'Admin' || $hasRole[0] == 'Admin-Meity') {
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'request_hd.type_of_req', '=', 'type_of_request.id')
                // ->where('request_hd.user_id',Auth::user()->id)
                // ->where('request_hd.raised_for_user',$user_id)
                ->where('request_hd.id', $id)
                ->get([
                    'request_hd.*', 'users.name', 'users.email', 'users.mobile',
                    'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc'
                ]);
        } else {
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'request_hd.type_of_req', '=', 'type_of_request.id')
                ->where('request_hd.id', $id)
                ->get([
                    'request_hd.*', 'users.name', 'users.email', 'users.mobile',
                    'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc'
                ]);
            // dd($reqs);
        }


        // $days=DB::table('cat_days_param')->get();
        //   dd($reqs,$id,$hasRole);

        $docs = RequestDocumentUploads::get();
        // dd($doc);
        return view('new_correspondence.preview', compact('reqHd', 'reqDets', 'docs', 'reqs'));
    }

    public function edit($id)
    {
        // dd('user_id',Auth::user()->id);

        $reqHd = RequestHd::where('id', $id)->first();
        $reqDets = RequestDet::where('req_id', $id)->get();

        // $a = $reqDets->join(DB::raw("SELECT get_user_role($reqDets.created_by) as new_model"));

        //   dd($a);

        $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
            ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
            ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
            ->where('request_hd.id', $id)
            ->get([
                'request_hd.*', 'users.name', 'users.email', 'users.mobile',
                'req_category.category_desc', 'subtype_desc'
            ]);

        $docs = RequestDocumentUploads::get();
        // dd($reqHd);
        return view('new_correspondence.edit', compact('reqHd', 'reqDets', 'docs', 'reqs'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $reqdoc = $request->reqdoc;
        $user_id = Auth::user()->id;
        $hasRole = Auth::user()->getRoleNames()->toArray();
        // dd($request);
        $reqHd = RequestHd::where('id', $request->reqhd_id)->first();
        $x =  $reqHd->raise_by_role;
        $reqHd->raise_by_role = $reqHd->pending_with;
        $reqHd->pending_with = $x;

        // if($hasRole[0] == 'ActiveUser' || $hasRole[0] == 'Meity'){
        // $reqHd->pending_with=$reqHd->raise_by_role;
        // }else{
        // $reqHd->pending_with='User';
        // }
        $reqHd->pending_since = Carbon::now();
        $reqHd->status = $request->status;
        // dd($reqHd);
        $reqHd->save();
        $DetailUploadId = array();
        if ($reqdoc) {
            foreach ($reqdoc as $value) {
                $newDoc = $value;
                $doc = new RequestDocumentUploads;
                $doc->req_id = $reqHd->id;
                $doc->mime = $newDoc->getMimeType();
                $doc->file_size = $newDoc->getSize();
                $doc->updated_at = Carbon::now();
                $doc->user_id = Auth::user()->id;
                $doc->created_at = Carbon::now();
                $doc->file_name = $newDoc->getClientOriginalName();
                $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                // dd($doc);
                $doc->save();
                array_push($DetailUploadId, $doc->id);
            }
        }
        // dd($DetailUploadId);
        $reqdet = new RequestDet;
        $reqdet->req_id = $reqHd->id;
        $reqdet->msg = $request->msg;
        $reqdet->doc_id = $DetailUploadId;
        $reqdet->created_by = Auth::user()->id;
        // dd($reqdet);
        $reqdet->save();
        alert()->success('Record Submitted', 'Success')->persistent('Close');
        return redirect()->route('newcorrespondence.index');
    }

    public function destroy($id)
    {
        //
    }
    public function raisecomp(Request $request)
    {
        $reqHd = RequestHd::find($request->reqhd_id);
        $reqHd->pending_with = 'Admin';
        $reqHd->pending_since = Carbon::now();
        $reqHd->status = 'S';
        // $reqHd->complaint_id='CM001';
        $reqHd->complaint_raised_on = Carbon::now();
        // dd($reqHd->pending_since);
        $dt = Carbon::parse($reqHd->complaint_raised_on);
        $prvYear = DB::select(DB::raw("SELECT complaint_id_generate('$dt')"));
        foreach ($prvYear as $values) {
            $reqHd->complaint_id = $values->complaint_id_generate;
        }
        $reqHd->save();
        $reqdet = new RequestDet;
        $reqdet->req_id = $request->reqhd_id;
        $reqdet->msg = 'Complaint Raised';
        $reqdet->created_by = Auth::user()->id;
        // dd($reqdet);
        $reqdet->save();
        alert()->success('Complaint Raised Successfully', 'Success')->persistent('Close');
        return redirect()->route('index');
    }

    public function reqDownload($id)
    {
        // dd($id);
        $doc = DB::table('request_document_uploads as du')
            ->where('du.id', $id)
            ->select('du.mime', 'du.file_name', 'du.uploaded_file')
            ->first();
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
        } elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.presentationml.presentation") {
            $ext = '.pptx';
        } elseif ($doc->mime == "image/png") {
            $ext = 'png';
        } elseif ($doc->mime == "image/jpeg") {
            $ext = 'jpg';
        }

        return response($docc)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', $doc->mime)
            ->header('Content-length', strlen($docc))
            ->header('Content-Disposition', 'attachment; filename=' . $doc->file_name . '.' . $ext)
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function corres_filter_data(Request $request)
    {
        $moduleRows = DB::table('req_category')->where('active_flg', '1')->get();
        $users = DB::table('approved_apps')->join('users', 'users.id', '=', 'approved_apps.created_by')->select('users.*')->orderby('users.name')->where(DB::RAW("is_normal_user(users.id)"), 1)->get();
        $hasRole = Auth::user()->getRoleNames()->toArray();
        $user_id = Auth::user()->id;
        $company_id = $request->input('company_id');
        $category_type = $request->input('category_type');
        if ($hasRole[0] == 'Admin') {
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'type_of_request.id', '=', 'request_hd.type_of_req')
                ->orderBy('request_hd.status', 'asc')
                ->orderBy('request_hd.id', 'asc');
            if ($category_type !== 'all') {
                $reqs->where('req_category.id', $category_type);
            }
            if ($company_id !== 'all') {
                $reqs->where('request_hd.user_id', $company_id);
            }
            $reqs = $reqs->get(['request_hd.*', 'users.name', 'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc']);
        }
        return view('new_correspondence.index', compact('reqs', 'hasRole', 'users', 'moduleRows', 'company_id', 'category_type'));
    }

    public function claimcorrespondence($claim_id)
    {
        $user_id = Auth::user()->id;
        

        $moduleRows = DB::table('req_category')->where('active_flg', '1')->get();
        $users = DB::table('approved_apps')->join('users', 'users.id', '=', 'approved_apps.created_by')->select('users.*')->orderby('users.name')->where(DB::RAW("is_normal_user(users.id)"), 1)->get();
        $hasRole = Auth::user()->getRoleNames()->toArray();
        if ($hasRole[0] == 'Admin') {
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'type_of_request.id', '=', 'request_hd.type_of_req')
                ->where('request_hd.claim_id', $claim_id)
                ->orderby('request_hd.status', 'asc')
                ->orderby('request_hd.id', 'asc')
                ->get(['request_hd.*', 'users.name', 'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc']);
        } elseif ($hasRole[0] == 'Admin-Meity') {
            $reqs = RequestHd::join('users', 'request_hd.user_id', '=', 'users.id')
                ->join('req_category', 'request_hd.cat_id', '=', 'req_category.id')
                ->join('req_category_subtype', 'request_hd.cat_subtype', '=', 'req_category_subtype.id')
                ->join('type_of_request', 'type_of_request.id', '=', 'request_hd.type_of_req')
                ->where('request_hd.visible', 1)
                ->orWhere('request_hd.user_id', $user_id)
                ->orwhere('request_hd.raised_for_user', $user_id)
                ->orderby('request_hd.status', 'asc')
                ->orderby('request_hd.id', 'asc')
                ->get(['request_hd.*', 'users.name', 'req_category.category_desc', 'subtype_desc', 'type_of_request.type_desc']);
        }
        return view('new_correspondence.index', compact('reqs', 'hasRole', 'users', 'moduleRows', 'claim_id'));
    }

    public function ClaimNumberList($app_id)
    {
        

        $userId = $app_id;
        $hasRole = Auth::user()->hasRole('CorresReply');
        if ($hasRole == 'CorresReply') 
        {
            $app_id = $userId;
        }
        else
        {
            $app_id = Auth::user()->id;
        }

        $claim_no = DB::table('plibd.claims_masters as cm')
            ->join('qtr_master', 'qtr_master.qtr', '=', 'cm.id')
            // ->join('qtr_master as qtr_master1', 'qtr_master1.qtr_id', '=', 'cm.id')
            ->select(DB::raw("CONCAT('Claim-', qtr_master.fy, ' (',qtr_master.start_month,'-',qtr_master.month,')') AS claim_number"), 'cm.id as claim_id', 'cm.app_id')
            ->where('created_by', $app_id)
            ->get();
        //dd($claim_no);


        $applicant_data_vw = [
            'claim_no' => $claim_no
        ];

        //dd($claim_no, $applicant_data_vw);

        return json_encode($applicant_data_vw);
    }
}
