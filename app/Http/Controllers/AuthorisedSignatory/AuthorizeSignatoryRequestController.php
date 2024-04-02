<?php

namespace App\Http\Controllers\AuthorisedSignatory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Excel;
use App\Exports\ChangeRequestExport;

// use App\Exports\UsersExport;
use Carbon\Carbon;
use App\AuthorizedPersonDetail;
use App\AuthorizedPersonUpload;
use App\DocumentMaster;
use App\DocumentUploads;
use Auth;
use Mail;
use App\AuthorizedCorporateDetail;
use App\AuthorizedRegisteredDetail;
use App\CompanyDetails;

// use App\Mail\AuthoriseSignatoryApproved;
// use App\Mail\AuthoriseSignatoryReject;

class AuthorizeSignatoryRequestController extends Controller
{


    // public function authorizeChangeListApplicant($app_id)
    // {
    //     $approvedApp=DB::table('approved_apps as a')
    //     ->where('a.app_id',$app_id)
    //     ->first();
    //     //dd($approvedApp);
    //     $user_id=$approvedApp->user_id;
    //     //echo $user_id;

    //     $authorisedPersonRows = DB::table('authorized_person_details as a')
    //     ->join('authorized_doc_mapping as b', 'b.user_id', '=', 'a.id')
    //     ->join('users as u', 'u.id', '=', 'a.user_id')
    //     ->where('a.status','S')
    //     ->where('a.user_id',$user_id)
    //     ->select('a.submitted_at','b.user_id','u.name','a.approved_at','a.old_contact_person','a.old_designation','a.old_email','a.old_mobile','a.new_contact_person','a.new_designation','a.new_mobile','a.new_email')
    //             ->groupBy('a.id','b.user_id','u.name','a.submitted_at')
    //     ->get();
    //     // dd($authorisedPersonRows);

    //     $authorisedPersonApprovedRows = DB::table('authorized_person_details as a')
    //     ->join('authorized_doc_mapping as b', 'b.user_id', '=', 'a.id')
    //     ->join('users as u', 'u.id', '=', 'a.user_id')
    //     ->orderBy('a.id','ASC')
    //     ->where('a.status','A')
    //     ->where('a.user_id',$user_id)
    //     ->select('b.user_id','u.name','a.approved_at','a.old_contact_person','a.old_designation','a.old_email','a.old_mobile','a.new_contact_person','a.new_designation','a.new_mobile','a.new_email')
    //     ->groupBy('a.id','b.user_id','u.name','a.approved_at')
    //     ->get();

    //     $approvedids=array();
    //     foreach($authorisedPersonApprovedRows as $authorisedPersonApprovedRow)
    //     {
    //         $approvedids[]=$authorisedPersonApprovedRow->user_id;
    //     }
    
    //     $lastid=end($approvedids);
   
    //     $arrnext=array();
    //     foreach($approvedids as $approvedid)
    //     {
    //         $index = array_search($approvedid, $approvedids);
    //         if($index !== false && $index < count($approvedids)-1) $next = $approvedids[$index+1];
    //         if($approvedid==$lastid)
    //         {
    //             $arrnext[$approvedid]='';
    //         }
    //         else{
    //             $arrnext[$approvedid]=$next;
    //         }
            
    //     }

    //     $validUptoarray=array();
    //     foreach($arrnext as $key=>$value)
    //     {

    //         if($value!='')
    //         {
    //         $authorisedPersonApprovedRow = DB::table('authorized_person_details as a')
    //         ->join('authorized_doc_mapping as b', 'b.user_id', '=', 'a.id')
    //         ->join('users as u', 'u.id', '=', 'a.user_id')
    //         ->orderBy('a.id','ASC')
    //         ->where('a.id',$value)
    //         ->where('a.status','A')
    //         ->first();
    //         $validUptoarray[$key]=$authorisedPersonApprovedRow->approved_at;
    //         }
    //     }

    //     return view('authorizedsignatory.authorizeChangeListApplicant',compact('validUptoarray','authorisedPersonRows','authorisedPersonApprovedRows'));

    // }

    public function authorizeChangeDetail($id,$change_type)
    {
        // dd('jhfksd');
        if($change_type == 'A'){
            $authorisedPersonRow = DB::table('authorized_person_details as a')
            ->join('authorized_doc_mapping as b', 'b.upload_doc_id', '=', 'a.id','left')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->where('a.id',$id)
            ->select('a.id as person_id','a.*','u.*','b.*')
            ->first();
            $doc_data ='';
        }elseif($change_type == 'C'){
            $authorisedPersonRow = DB::table('authorised_corporate_detail as a')
            ->join('users as u', 'u.id', '=', 'a.created_by')
            ->where('a.created_by',$id)
            ->select('a.id as person_id','a.*','u.*')
            ->take(1)
            ->orderBy('a.id','DESC')
            ->first();

            $doc_data =DB::select('select b.upload_doc_id,sum(b.corpletter) as corpletter,sum(b.corpproof) as corpproof from (select upload_doc_id,
            case when "b"."doc_id" = 5004 then "b"."upload_id" end as "corpletter" ,
            case when "b"."doc_id" = 5006 then "b"."upload_id" end as "corpproof"
            from authorized_doc_mapping b where upload_doc_id =? ) b group by b.upload_doc_id',[$authorisedPersonRow->person_id]);
       
        }elseif($change_type == 'R'){
            $authorisedPersonRow = DB::table('authorised_registered_detail as a')
            ->join('company_details as u', 'u.created_by', '=', 'a.created_by')
            ->join('users as ua', 'ua.id', '=', 'a.created_by')
            ->where('a.app_id',$id)
            ->select('a.id as person_id','a.*','u.*','ua.name','ua.cin_llpin','ua.pan')
            ->take(1)
            ->orderBy('a.id','DESC')
            ->first();
          
            // dd($authorisedPersonRow);
            $doc_data =DB::select('select b.upload_doc_id,sum(b.regletter) as regletter,sum(b.regproof) as regproof from (select upload_doc_id,
            case when "b"."doc_id" = 5005 then "b"."upload_id" end as "regletter" ,
            case when "b"."doc_id" = 5007 then "b"."upload_id" end as "regproof"
            from authorized_doc_mapping b where upload_doc_id =? ) b group by b.upload_doc_id',[$authorisedPersonRow->person_id]);

        }
     

        return view('authorizedsignatory.authorizeChangeDetail',compact('authorisedPersonRow','change_type','doc_data'));
    }

    public function updateAuthorization(request $request,$id,$change_type)
    {

        $this->validate($request, [
            'authorizationStatus' => 'required',
        ]);

        if($change_type == 'A'){
            $authorized_person_detailsRow = AuthorizedPersonDetail::find($id);
            $authorized_person_detailsRow->status = $request->authorizationStatus;
            $authorized_person_detailsRow->approved_at = Carbon::now();
            $authorized_person_detailsRow->approved_by =Auth::user()->id;
            $authorized_person_detailsRow->save();
            $user_id =  $authorized_person_detailsRow->user_id;
        }elseif($change_type == 'C'){
            
            $authorized_person_detailsRow = AuthorizedCorporateDetail::find($id);
            $authorized_person_detailsRow->status = $request->authorizationStatus;
            $authorized_person_detailsRow->approved_at = Carbon::now();
            $authorized_person_detailsRow->approved_by =Auth::user()->id;
            $authorized_person_detailsRow->save();
            $user_id =  $authorized_person_detailsRow->created_by;
        }elseif($change_type == 'R'){
            $authorized_person_detailsRow = AuthorizedRegisteredDetail::find($id);
            $authorized_person_detailsRow->status = $request->authorizationStatus;
            $authorized_person_detailsRow->approved_at = Carbon::now();
            $authorized_person_detailsRow->approved_by =Auth::user()->id;
            $authorized_person_detailsRow->save();
            $user_id =  $authorized_person_detailsRow->created_by;
        }

        if ($request->authorizationStatus == 'A') {
            if($change_type == 'A'){
                $authorized_person_detailsRow = AuthorizedPersonDetail::find($id);
                $useridd=$authorized_person_detailsRow->user_id;
                $user=User::find($useridd);
                $user->email=$authorized_person_detailsRow->new_email;
                $user->email_verified_at=NULL;
                $user->mobile=$authorized_person_detailsRow->new_mobile;
                $user->mobile_verified_at=NULL;
                $user->contact_person=$authorized_person_detailsRow->new_contact_person;
                $user->designation=$authorized_person_detailsRow->new_designation;
                $user->save();
                $user_id= Auth::user()->id;
                $user=User::where('id',$user_id)->first();
                $authorisedPersonRow=$authorized_person_detailsRow;

                $user1 = DB::table('approved_apps_details as aad')
                ->join('users as u','u.id','=','aad.user_id')
                ->where('aad.user_id',$authorized_person_detailsRow->user_id)
                ->first();

                $data = array('old_contact_person'=>$authorized_person_detailsRow->old_contact_person,
                'new_email'=>$authorized_person_detailsRow->new_email,
                'change_type'=>$change_type);

                Mail::send('emails.authoriseSignatoryApproved',$data,function($message) use($data) {
                    $message->to($data['new_email'],$data['old_contact_person'])->subject
                    ('PLI Scheme for Bulk Drugs | Request Approved Succesfully');
                    $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
                    });
    
                alert()->success('Authorization has been approved', 'Success')->persistent('Close');

            }elseif($change_type == 'C'){
                $authorized_person_detailsRow = AuthorizedCorporateDetail::find($id);
                $useridd=$authorized_person_detailsRow->created_by;
                $user=User::find($useridd);
                    $user->off_add=$authorized_person_detailsRow->new_off_add;
                    $user->off_state=$authorized_person_detailsRow->new_off_state;
                    $user->off_city=$authorized_person_detailsRow->new_off_city;
                    $user->off_pin=$authorized_person_detailsRow->new_off_pin;
                $user->save();
              
                $authorisedPersonRow=$authorized_person_detailsRow;
                $data = array('old_contact_person'=>$user->name,
                'email'=>$user->email,
                'change_type'=>$change_type);

                Mail::send('emails.authoriseSignatoryApproved',$data,function($message) use($data) {
                    $message->to($data['email'],$data['old_contact_person'])->subject
                    ('PLI Scheme for Bulk Drugs | Request Approved Succesfully');
                    $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
                    });
    
                alert()->success('Authorization has been approved', 'Success')->persistent('Close');

            }elseif($change_type == 'R'){

                $authorized_person_detailsRow = AuthorizedRegisteredDetail::find($id);
                $app_id=$authorized_person_detailsRow->app_id;
                $company_detail=CompanyDetails::where('app_id',$app_id)->first();
                $company_detail->fill([
                    'corp_add' => $authorized_person_detailsRow->new_corp_add,
                    'corp_state' => $authorized_person_detailsRow->new_corp_state,
                    'corp_city' => $authorized_person_detailsRow->new_corp_city,
                    'corp_pin' => $authorized_person_detailsRow->new_corp_pin,
                ]);
                $company_detail->save();
            
                $user1 = DB::table('approved_apps_details as aad')
                ->join('users as u','u.id','=','aad.user_id')
                ->where('aad.user_id',$company_detail->created_by)
                ->first();
            
                $data = array('old_contact_person'=>$user1->name,
                'new_email'=>$user1->email,
                'change_type'=>$change_type);

                Mail::send('emails.authoriseSignatoryApproved',$data,function($message) use($data) {
                    $message->to($data['new_email'],$data['old_contact_person'])->subject
                    ('PLI Scheme for Bulk Drugs | Request Approved Succesfully');
                    $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
                    });

                alert()->success('Authorization has been approved', 'Success')->persistent('Close');
            }
            } else {

                $user=User::find($user_id);
                // dd($user_id);
                $data = array('old_contact_person'=>$user->name,'email'=>$user->email,
                'change_type'=>$request->change_type
                );

                Mail::send('emails.authoriseSignatoryReject',$data,function($message) use($data) {
                    $message->to($data['email'])->subject
                    ('PLI Scheme for Bulk Drugs | Request Rejected.');
                    $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');
                    });


                alert()->success('Authorization has been rejected', 'Success')->persistent('Close');
        }
        return redirect()->route('admin.authoriseSignatorylist.admin_dash',[$change_type]);
        
    }

    public function downloadfile($id)
    {
        $maxId =  DB::table('document_uploads as a')->max('id');
       
        if((strlen($id)) > strlen($maxId)){
            $ids = decrypt($id);
        }else{
            $ids = $id;
        }

        $doc =  DB::table('document_uploads as a')->where('a.id',$ids)->first();

        ob_start();
        fpassthru($doc->uploaded_file);
        $docc= ob_get_contents();
        ob_end_clean();
        $ext = '';
        if($doc->mime == "application/pdf") {

            $ext = 'pdf';

        }elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {

            $ext = 'docx';

        }elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {

            $ext = 'xlsx';

        }
        elseif($doc->mime == "image/png")
        {
            $ext = 'png';
        }
        
        $doc_name = $doc->file_name;


        return response($docc)

        ->header('Cache-Control', 'no-cache private')

        ->header('Content-Description', 'File Transfer')

        ->header('Content-Type', $doc->mime)

        ->header('Content-length', strlen($docc))

        ->header('Content-Disposition', 'attachment; filename='.$doc_name.'.'.$ext)

        ->header('Content-Transfer-Encoding', 'binary');

    }

    public function authorizeSignatoryList($change_type)
    {
        
        if($change_type == 'A'){
            $authorisedPersonRows = DB::table('authorized_person_details as a')
            ->join('authorized_doc_mapping as b', 'b.user_id', '=', 'a.id','left')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->get(['a.id as person_id','a.*','u.*','b.*']);
        }elseif($change_type == 'C'){
            $authorisedPersonRows = DB::table('authorised_corporate_detail as a')
            ->join('users as u', 'u.id', '=', 'a.created_by')
            ->get(['a.id as corp_id','a.*','u.*']);
        }elseif($change_type == 'R'){
            $authorisedPersonRows = DB::table('authorised_registered_detail as a')
            ->join('users as u', 'u.id', '=', 'a.created_by')
            ->get(['a.id as reg_id','a.*','u.*']);
        }elseif($change_type == 'ALL'){
            $authorisedPersonRows =DB::select('select aad."name",acd.id as person_id,acd.change_type, acd.status, acd.created_at,acd.approved_at ,acd.approved_by,acd.approved_by,acd.created_by,acd.submitted_at 
            from authorised_corporate_detail acd join approved_apps_details aad on aad.user_id=acd.created_by 
            union 
            select aad."name",ard.app_id as person_id,ard.change_type, ard.status, ard.created_at,ard.approved_at ,ard.approved_by,ard.approved_by,ard.created_by,ard.submitted_at 
            from authorised_registered_detail ard join approved_apps_details aad on aad.id=ard.app_id
            union 
            select aad."name",apd.id as person_id,apd.change_type, apd.status, apd.created_at,apd.approved_at ,apd.approved_by,apd.approved_by,apd.user_id,apd.submitted_at 
            from authorized_person_details apd join approved_apps_details aad on aad.user_id=apd.user_id');
           
        }
        
        return view('authorizedsignatory.authorizeChangeList',compact('authorisedPersonRows','change_type'));
    }

    public function authorizeChangeView($id,$change_type)
    {
        if($change_type == 'A'){
            $authorisedPersonRow = DB::table('authorized_person_details as a')
            ->join('authorized_doc_mapping as b', 'b.upload_doc_id', '=', 'a.id','left')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->where('a.id',$id)
            ->select('a.id as person_id','a.*','u.*','b.*')
            ->first();
            $doc_data ='';
        }elseif($change_type == 'C'){
            // dd($id);
            $authorisedPersonRow = DB::table('authorised_corporate_detail as a')
            ->join('users as u', 'u.id', '=', 'a.created_by')
            ->where('a.id',$id)
            ->select('a.id as person_id','a.*','u.*')
            ->take(1)
            ->orderBy('a.id','DESC')
            ->first();
            // dd($authorisedPersonRow);
            $doc_data =DB::select('select b.upload_doc_id,sum(b.corpletter) as corpletter,sum(b.corpproof) as corpproof from (select upload_doc_id,
            case when "b"."doc_id" = 5004 then "b"."upload_id" end as "corpletter" ,
            case when "b"."doc_id" = 5006 then "b"."upload_id" end as "corpproof"
            from authorized_doc_mapping b where upload_doc_id =? ) b group by b.upload_doc_id',[$authorisedPersonRow->person_id]);
       
        }elseif($change_type == 'R'){

            $authorisedPersonRow = DB::table('authorised_registered_detail as a')
            ->join('company_details as u', 'u.created_by', '=', 'a.created_by')
            ->join('users as ua', 'ua.id', '=', 'a.created_by')
            ->where('u.app_id',$id)
            ->select('a.id as person_id','a.*','u.*','ua.name','ua.cin_llpin','ua.pan')
            ->take(1)
            ->orderBy('a.id','DESC')
            ->first();
          

            $doc_data =DB::select('select b.upload_doc_id,sum(b.regletter) as regletter,sum(b.regproof) as regproof from (select upload_doc_id,
            case when "b"."doc_id" = 5005 then "b"."upload_id" end as "regletter" ,
            case when "b"."doc_id" = 5007 then "b"."upload_id" end as "regproof"
            from authorized_doc_mapping b where upload_doc_id =? ) b group by b.upload_doc_id',[$authorisedPersonRow->person_id]);

        }
     

        return view('authorizedsignatory.authorizeChangeView',compact('authorisedPersonRow','change_type','doc_data'));
    }

    public function AuthExport($id,$change_type)
    {
        
        // $auth_signatory = DB::table('authorized_person_details')->where('change_type',$change_type)->get();
        // $auth_corporate = DB::table('authorised_corporate_detail')->where('change_type',$change_type)->get();
        // $auth_registered = DB::table('authorised_registered_detail')->where('change_type',$change_type)->get();


        return Excel::download(new ChangeRequestExport($change_type), 'Change'.'-'.'Request'.'.xlsx');

        
         
    }
}