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

class RequestController extends Controller
{
    public function index()
    {
         $user_id=Auth::user()->id;
        $hasRole = Auth::user()->getRoleNames()->toArray();

        $users = DB::table('users')->first();

        // dd($hasRole);

         if($hasRole[0] == 'Admin' )
        {

        $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
        ->join('req_category','request_hd.cat_id','=','req_category.id')
        ->join('req_category_subtype','request_hd.cat_subtype','=','req_category_subtype.id')
        ->join('type_of_request','type_of_request.id','=','request_hd.type_of_req')
        // ->where('users.id',$user_id)
        ->orderby('request_hd.status','asc')
        ->orderby('request_hd.id','asc')
        ->get(['request_hd.*', 'users.name','req_category.category_desc','subtype_desc','type_of_request.type_desc']);

        }elseif($hasRole[0] == 'Admin-Meity'){
            $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
            ->join('req_category','request_hd.cat_id','=','req_category.id')
            ->join('req_category_subtype','request_hd.cat_subtype','=','req_category_subtype.id')
            ->join('type_of_request','type_of_request.id','=','request_hd.type_of_req')
            ->where('request_hd.visible',1)
            ->orWhere('request_hd.user_id',$user_id)
            ->orwhere('request_hd.raised_for_user',$user_id)
            ->orderby('request_hd.status','asc')
            ->orderby('request_hd.id','asc')
            ->get(['request_hd.*', 'users.name','req_category.category_desc','subtype_desc','type_of_request.type_desc']);

        }
        else{
        $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
        ->join('req_category','request_hd.cat_id','=','req_category.id')
        ->join('req_category_subtype','request_hd.cat_subtype','=','req_category_subtype.id')
        ->join('type_of_request','type_of_request.id','=','request_hd.type_of_req')
        ->where('request_hd.raised_for_user',$user_id)
        ->orWhere('request_hd.user_id',$user_id)
        ->orderby('request_hd.status','asc')
        ->orderby('request_hd.id','asc')
        ->get(['request_hd.*', 'users.name','req_category.category_desc','subtype_desc','type_of_request.type_desc'])
            ;
        }


    //   dd($user_id,$reqs);

        return view('new_correspondence.index',compact('reqs','hasRole','users'));
    }

    public function statuscheck($req_id,$checkid){
        // dd($checkid);

         $updatestatus = RequestHd::where('id',$req_id)->first();

           if($checkid == 1){

             $updatestatus->fill([
            'visible' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' =>  Carbon::now(),

            ]);
           }elseif($checkid == 0){

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

     public function statuscm($req_id,$checkid){
        // dd($checkid);

         $updatestatus = RequestHd::where('id',$req_id)->first();

           if($checkid == 1){

             $updatestatus->fill([
            'visible_com' => 1,
            'created_at' =>  Carbon::now(),
            'updated_at' =>  Carbon::now(),

            ]);
           }elseif($checkid == 0){

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
        $hasRole = Auth::user()->getRoleNames()->toArray();
    //    dd($hasRole);
        if($hasRole[0] == 'Admin-Meity' ){
             $valid_roles = DB::table('req_user as cum')
                ->join('roles', 'roles.id', '=', 'cum.role_id')
                ->whereNotIn('cum.id',[1,2,4])
                ->select('cum.name','cum.id')
                ->orderBy('roles.id')
                ->get();
        // dd($valid_roles);
        }elseif($hasRole[0] == 'Admin'){

            $valid_roles = DB::table('req_user as cum')
                ->join('roles', 'roles.id', '=', 'cum.role_id')
                ->whereNotIn('cum.id',[2,3])
                ->select('cum.name','cum.id')
                ->orderBy('roles.id')
                ->get();

        }
        else{
            $valid_roles = DB::table('req_user as cum')
            ->join('roles', 'roles.id', '=', 'cum.role_id')
            ->where('roles.id','2')
            ->select('cum.name','cum.id')
            ->orderBy('roles.id')
            ->get();
        }
        $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->get(['request_hd.*', 'users.name']);
        $moduleRows = DB::table('req_category')->where('active_flg','1')->get();
        $reqcats_sub = DB::table('req_category_subtype')->get();
        $typeOfReq = DB::table('type_of_request')->get();
        return view('new_correspondence.create',compact('reqs','moduleRows','reqcats_sub','typeOfReq','valid_roles'));
    }



      public function usersList($request_type)
    {
        $role_id = DB::table('req_user')->where('id',$request_type)->first();
        $users = DB::table('users as u')
        ->join('model_has_roles as mhr', 'mhr.model_id', '=', 'u.id')
        ->where('mhr.role_id',$role_id->role_id)
        ->select('u.name','u.id')
        ->get();
    //   console.log($user);
        return json_encode($users);
    }

    public function applicationNumberList($app_id)
    {
        $hasRole = Auth::user()->getRoleNames()->toArray();
        $getApplicatId = Auth::user()->id;
        if($hasRole[0] == 'Admin')
        {
            $applicant_id = $app_id;
            $applicantData = DB::table('users as u')
            ->join('approved_apps as aa', 'aa.created_by', '=', 'u.id')
            ->where('aa.created_by',$applicant_id)
            ->where('aa.status','S')
            ->whereRaw('is_normal_user(u.id) = 1')
            ->select('aa.id','aa.app_no')
            ->get();
        }
        else
        {
            
            $applicant_id = $getApplicatId;
            $applicantData = DB::table('users as u')
            ->join('approved_apps as aa', 'aa.created_by', '=', 'u.id')
            ->where('aa.created_by',$applicant_id)
            ->where('aa.status','S')
            ->select('aa.id','aa.app_no')
            ->get();
        }
         
       
        
    //dd($applicantData, $getApplicatId);
        return json_encode($applicantData);
    }


    public function store(Request $request)
    {
       

         $hasRole = Auth::user()->getRoleNames()->toArray();
            
         $role = DB::table('model_has_roles')->join('roles','roles.id','model_has_roles.role_id')
         ->where('model_has_roles.model_id', $request->request_to)->first();
//dd($request,$hasRole[0], $request->request_to, $role->name, Auth::user()->id);
        //  dd( $role);
     DB::transaction(function() use ($request ,$hasRole,$role){
         $files = $request->file('reqdoc');
        $reqdoc = $request->reqdoc;
        $reqHd = new RequestHd;
        $reqHd->user_id = Auth::user()->id;
        $reqHd->raised_for_user = $request->request_to;
        $reqHd->app_no = $request->application_number;
        $reqHd->first_applied_dt=Carbon::now();
        $reqHd->cat_id=$request->related_to;
        $reqHd->raise_by_role=$hasRole[0];
        $reqHd->cat_subtype=$request->catsubtype;
        $reqHd->type_of_req=$request->reqtype;
        $reqHd->raise_by_role = $hasRole[0];
        $reqHd->pending_with =$role->name;
        // if($hasRole[0] == 'Meity' || $hasRole[0] == 'ActiveUser' ){
        //      $reqHd->pending_with='Admin';
        //     $reqHd->raise_by_role='User';
        // }else{
        //     // dd('d');
        //      $reqHd->pending_with='User';
        //       $reqHd->raise_by_role=$hasRole[0];
        // }
        $reqHd->pending_since=Carbon::now();
        $reqHd->status='S';
        $dt = Carbon::parse($reqHd->first_applied_dt);
        $prvYear= DB::select(DB::raw("SELECT req_id_generate('$dt')"));
        foreach($prvYear as $values){
            $reqHd->req_id = $values->req_id_generate;
        }
     //   dd($reqHd);
        $reqHd->save();

        $DetailUploadId = array();
        if ($reqdoc){
        foreach($reqdoc as $value){
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
                $reqdet->msg =$request->msg;
                $reqdet->doc_id =$DetailUploadId;
                $reqdet->created_by = Auth::user()->id;
                // dd($reqdet);

            $reqdet->save();

          });
            alert()->success('Record Submitted', 'Success')->persistent('Close');
            return redirect()->route('newcorrespondence.index');
    }

    public function show($id)
    {
         $user_id=Auth::user()->id;
        $hasRole = Auth::user()->getRoleNames()->toArray();
         $reqHd =RequestHd::where('id',$id)->first();
        $reqDets=RequestDet::where('req_id',$id)->get();

         if($hasRole[0] == 'Admin' || $hasRole[0] == 'Admin-Meity')
        {
               $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
        ->join('req_category','request_hd.cat_id','=','req_category.id')
        ->join('req_category_subtype','request_hd.cat_subtype','=','req_category_subtype.id')
        ->join('type_of_request','request_hd.type_of_req','=','type_of_request.id')
        // ->where('request_hd.user_id',Auth::user()->id)
        // ->where('request_hd.raised_for_user',$user_id)
        ->where('request_hd.id',$id)
        ->get(['request_hd.*', 'users.name','users.email','users.mobile',
        'req_category.category_desc','subtype_desc','type_of_request.type_desc']);

        }else{
               $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
        ->join('req_category','request_hd.cat_id','=','req_category.id')
        ->join('req_category_subtype','request_hd.cat_subtype','=','req_category_subtype.id')
        ->join('type_of_request','request_hd.type_of_req','=','type_of_request.id')
        ->where('request_hd.id',$id)
        ->get(['request_hd.*', 'users.name','users.email','users.mobile',
        'req_category.category_desc','subtype_desc','type_of_request.type_desc']);
        // dd($reqs);
        }


        // $days=DB::table('cat_days_param')->get();
    //   dd($reqs,$id,$hasRole);

        $docs =RequestDocumentUploads::get();
                // dd($doc);
        return view('new_correspondence.preview', compact('reqHd', 'reqDets', 'docs','reqs'));

    }

    public function edit($id)
    {
        // dd('user_id',Auth::user()->id);

        $reqHd =RequestHd::where('id',$id)->first();
        $reqDets=RequestDet::where('req_id',$id)->get();

        // $a = $reqDets->join(DB::raw("SELECT get_user_role($reqDets.created_by) as new_model"));

        //   dd($a);

        $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
        ->join('req_category','request_hd.cat_id','=','req_category.id')
        ->join('req_category_subtype','request_hd.cat_subtype','=','req_category_subtype.id')
        ->where('request_hd.id',$id)
        ->get(['request_hd.*', 'users.name','users.email','users.mobile',
        'req_category.category_desc','subtype_desc']);

        $docs =RequestDocumentUploads::get();
                // dd($reqHd);
        return view('new_correspondence.edit', compact('reqHd', 'reqDets', 'docs','reqs'));

    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $reqdoc = $request->reqdoc;
        $user_id=Auth::user()->id;
        $hasRole = Auth::user()->getRoleNames()->toArray();
        // dd($request);
        $reqHd =RequestHd::where('id',$request->reqhd_id)->first();
        $x =  $reqHd->raise_by_role;
        $reqHd->raise_by_role = $reqHd->pending_with;
        $reqHd->pending_with =$x;

        // if($hasRole[0] == 'ActiveUser' || $hasRole[0] == 'Meity'){
        // $reqHd->pending_with=$reqHd->raise_by_role;
        // }else{
        // $reqHd->pending_with='User';
        // }
        $reqHd->pending_since=Carbon::now();
        $reqHd->status=$request->status;
        // dd($reqHd);
        $reqHd->save();
        $DetailUploadId = array();
      if ($reqdoc){
        foreach($reqdoc as $value){
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
                $reqdet->msg =$request->msg;
                $reqdet->doc_id =$DetailUploadId;
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
        $reqHd =RequestHd::find($request->reqhd_id);
        $reqHd->pending_with='Admin';
        $reqHd->pending_since=Carbon::now();
        $reqHd->status='S';
        // $reqHd->complaint_id='CM001';
        $reqHd->complaint_raised_on=Carbon::now();
        // dd($reqHd->pending_since);
        $dt = Carbon::parse($reqHd->complaint_raised_on);
        $prvYear= DB::select(DB::raw("SELECT complaint_id_generate('$dt')"));
        foreach($prvYear as $values){
            $reqHd->complaint_id = $values->complaint_id_generate;
        }
        $reqHd->save();
        $reqdet = new RequestDet;
        $reqdet->req_id = $request->reqhd_id;
        $reqdet->msg ='Complaint Raised';
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
            ->where('du.id',$id)
            ->select('du.mime','du.file_name','du.uploaded_file')
        ->first();
      // dd($doc);
        ob_start();
        fpassthru($doc->uploaded_file);
        $docc= ob_get_contents();
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
        ->header('Content-Disposition', 'attachment; filename='.$doc->file_name.'.'.$ext)
        ->header('Content-Transfer-Encoding', 'binary');
    }

}
