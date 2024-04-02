<?php

namespace App\Http\Controllers\AuthorisedSignatory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\Qpr;
use App\Http\Requests\QprStore;
use Carbon\Carbon;
use App\User;
use App\AuthorizedPersonDetail;
use App\AuthorizedPersonUpload;
use App\DocumentMaster;
use App\DocumentUploads;
use Illuminate\Support\Facades\Validator;
use App\AuthorizedRegisteredDetail;
use App\AuthorizedCorporateDetail;

use Mail;
// use App\Mail\AuthoriseSignatoryUpdate;
use App\Http\Requests\AuthorizeSignatory;
use Illuminate\Validation\Rule;

class AuthoriseSignatoryController extends Controller
{
    public function auth_dash()
    {
        $corporate_add = DB::Table('users as u')->where('id', Auth::user()->id)->select('u.id','u.off_add' ,'u.off_state','u.off_city', 'u.off_pin')->first();

        $registered_add = DB::Table('company_details as cd')->join('approved_apps_details as aad','cd.app_id','=','aad.id')->where('cd.created_by', Auth::user()->id)->select('cd.id','cd.app_id', 'cd.corp_add', 'cd.corp_state', 'cd.corp_city', 'cd.corp_pin','cd.created_by','aad.app_no','aad.name','aad.product','aad.target_segment')->get();

        return view('authorizedsignatory.dashboard',compact('registered_add','corporate_add'));
    }
    
    public function authoriseSignatory($change_type,$id)
    {
        $user_id = Auth::user()->id;

        $authorisedPersonRow = DB::Table('authorized_person_details as apd')
        ->join('authorized_doc_mapping as adm','adm.upload_doc_id','=','apd.id')->where('apd.user_id', Auth::user()->id)->where('status', 'S')->select('apd.*','adm.doc_id','adm.upload_id')->first();

        $corporate_add = DB::Table('users as u')->where('id', Auth::user()->id)->select('u.id','u.off_add' ,'u.off_state','u.off_city', 'u.off_pin')->get();

        $corporate_add_change = DB::select('select * from (select upload_doc_id,max(case when doc_id = 5004 then upload_id end) upload_id_letter ,max(case when doc_id = 5006 then upload_id end) upload_id_proof
        from authorized_doc_mapping group by upload_doc_id)a join authorised_corporate_detail as acd on acd.id =a.upload_doc_id where acd.created_by = ? order by acd.id',[Auth::user()->id]);
        

        $registered_add = DB::Table('company_details as cd')->join('approved_apps_details as aad','cd.app_id','=','aad.id')->where('cd.created_by', Auth::user()->id)->where('cd.app_id', $id)->select('cd.id','cd.app_id', 'cd.corp_add', 'cd.corp_state', 'cd.corp_city', 'cd.corp_pin','cd.created_by','aad.app_no','aad.name','aad.product','aad.target_segment')->get();
        // dd($registered_add);

        $registered_add_change = DB::select('select * from (select upload_doc_id,max(case when doc_id = 5005 then upload_id end) upload_id_letter ,max(case when doc_id = 5007 then upload_id end) upload_id_proof
        from authorized_doc_mapping group by upload_doc_id)a join authorised_registered_detail as acd on acd.id =a.upload_doc_id where acd.created_by = ? and acd.app_id=? order by acd.id',[Auth::user()->id,$id]);
       

        $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');
        $city = DB::table('pincodes')->whereNotNull('city')->orderBy('city')->select('state','city')->get()->unique('city');
        
        return view('authorizedsignatory.authorise_signatory', compact('authorisedPersonRow','change_type','corporate_add','registered_add','states','city','corporate_add_change','registered_add_change'));
    }


    public function storeAuthoriseSignatory(Request $request)
    {
        $authorisedRequest = AuthorizedPersonDetail::where('user_id', Auth::user()->id)->take(1)->orderBy('id','DESC')->where('status', 'S')->first();
        $registerRequest = AuthorizedRegisteredDetail::where('app_id', $request->app_id)->take(1)->orderBy('id','DESC')->where('status', 'S')->first();
        $corpRequest = AuthorizedCorporateDetail::where('created_by', Auth::user()->id)->take(1)->orderBy('id','DESC')->where('status', 'S')->first();
        
        $data = DB::table('company_details')->where('app_id',$request->app_id)->first();

        $data_id ='';

        DB::transaction(function () use ($request,$data,$corpRequest,$registerRequest,$authorisedRequest) {
            
            $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();

            if($request->change_type=='R' && empty($registerRequest)){
                $register_data = new AuthorizedRegisteredDetail;
                $register_data->app_id = $request->app_id;
                $register_data->created_by = Auth::user()->id;
                $register_data->corp_add = $data->corp_add;
                $register_data->corp_state = $data->corp_state;
                $register_data->corp_city = $data->corp_city;
                $register_data->corp_pin = $data->corp_pin;
                $register_data->new_corp_add = $request->addr;
                $register_data->new_corp_state = $request->state;
                $register_data->new_corp_city = $request->city;
                $register_data->new_corp_pin = $request->pincode;
                $register_data->change_type = $request->change_type;
                $register_data->submitted_at = Carbon::now();
                $register_data->save();
                $data_id = $request->app_id;

                foreach ($doctypes as $docid => $doctype) {
                    if ($request->hasfile($doctype)) {
                        $newDoc = $request->file($doctype);
                        $doc = new DocumentUploads;
                        $doc->doc_id = $docid;
                        $doc->app_id = $request->app_id;
                        $doc->mime = $newDoc->getMimeType();
                        $doc->file_size = $newDoc->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->user_id = Auth::user()->id;
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                        $doc->save();

                        $apdUpload = new AuthorizedPersonUpload;
                        $apdUpload->user_id = Auth::user()->id;
                        $apdUpload->doc_id = $docid;
                        $apdUpload->change_type = $request->change_type;
                        $apdUpload->upload_id = $doc->id;
                        $apdUpload->updated_at = Carbon::now();
                        $apdUpload->created_at = Carbon::now();
                        $apdUpload->upload_doc_id = $register_data->id;
                        $apdUpload->save();
                    }
                }
                
                $data = array('organization_name'=>Auth::user()->name,'email'=>Auth::user()->email,
                'change_type'=>$request->change_type);
                
                Mail::send('emails.addAuthorizeSignatory',$data,function($message) use($data) {
                    $message->to('bdpli@ifciltd.com',$data['organization_name'])->subject
                    ('PLI Scheme for Bulk Drugs | Request Submitted Succesfully');
                    $message->cc($data['email'],'PLI Bulk Drugs');
                    });

                alert()->success('Your Details Submitted', 'Success')->persistent('Close');

            }elseif($request->change_type=='C' && empty($corpRequest)){

                $approved_data = DB::table('approved_apps_details')->where('user_id',Auth::user()->id)->first();

                $register_data = new AuthorizedCorporateDetail;
                $register_data->created_by = Auth::user()->id;
                $register_data->off_add = Auth::user()->off_add;
                $register_data->off_state = Auth::user()->off_state;
                $register_data->off_city = Auth::user()->off_city;
                $register_data->off_pin = Auth::user()->off_pin;
                $register_data->new_off_add = $request->addr;
                $register_data->new_off_state = $request->state;
                $register_data->new_off_city = $request->city;
                $register_data->new_off_pin = $request->pincode;
                $register_data->change_type = $request->change_type;
                $register_data->submitted_at = Carbon::now();
                $register_data->save();
                $data_id = Auth::user()->id;

                foreach ($doctypes as $docid => $doctype) {
                    if ($request->hasfile($doctype)) {
                        $newDoc = $request->file($doctype);
                        $doc = new DocumentUploads;
                        $doc->doc_id = $docid;
                        $doc->app_id = $approved_data->id;
                        $doc->mime = $newDoc->getMimeType();
                        $doc->file_size = $newDoc->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->user_id = Auth::user()->id;
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                        $doc->save();

                        $apdUpload = new AuthorizedPersonUpload;
                        $apdUpload->user_id = Auth::user()->id;
                        $apdUpload->doc_id = $docid;
                        $apdUpload->change_type = $request->change_type;
                        $apdUpload->upload_id = $doc->id;
                        $apdUpload->updated_at = Carbon::now();
                        $apdUpload->created_at = Carbon::now();
                        $apdUpload->upload_doc_id = $register_data->id;
                        $apdUpload->save();
                    }
                }

                
                $data = array('organization_name'=>Auth::user()->name,'email'=>Auth::user()->email,
                'change_type'=>$request->change_type);
                
                Mail::send('emails.addAuthorizeSignatory',$data,function($message) use($data) {
                    $message->to('bdpli@ifciltd.com',$data['organization_name'])->subject
                    ('PLI Scheme for Bulk Drugs | Request Submitted Succesfully');
                    $message->cc($data['email'],'PLI Bulk Drugs');
                    });

                alert()->success('Your Details Submitted', 'Success')->persistent('Close');

            }elseif($request->change_type=='A' && empty($authorisedRequest)){
                
                $approved_data = DB::table('approved_apps_details')->where('user_id',Auth::user()->id)->first();

                $validated = $request->validate([
                    'email' => [
                        'required',
                        Rule::unique('users')->where(function ($query) {
                            $query->where('email', '!=', Auth::user()->email);
                        })
                    ],
                    'mobile' => [
                        'required',
                        Rule::unique('users')->where(function ($query) {
                            $query->where('mobile', '!=', Auth::user()->mobile);
                        })
                    ],
                ]);
        

                $apd = new AuthorizedPersonDetail;
                $apd->user_id = Auth::user()->id;
                $apd->new_contact_person = $request->authorise_user_name;
                $apd->new_designation = $request->designation;
                $apd->new_email = $request->email;
                $apd->new_mobile = $request->mobile;
                $apd->change_type = $request->change_type;
                $apd->old_contact_person = Auth::user()->contact_person;
                $apd->old_designation = Auth::user()->designation;
                $apd->old_email = Auth::user()->email;
                $apd->old_mobile = Auth::user()->mobile;
                $apd->submitted_at = Carbon::now();
                $apd->save();
                $data_id = Auth::user()->id;

                foreach ($doctypes as $docid => $doctype) {
                    if ($request->hasfile($doctype)) {
                        $newDoc = $request->file($doctype);
                        $doc = new DocumentUploads;
                        $doc->doc_id = $docid;
                        $doc->app_id = $approved_data->id;
                        $doc->mime = $newDoc->getMimeType();
                        $doc->file_size = $newDoc->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->user_id = Auth::user()->id;
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                        $doc->save();

                        $apdUpload = new AuthorizedPersonUpload;
                        $apdUpload->user_id = Auth::user()->id;
                        $apdUpload->doc_id = $docid;
                        $apdUpload->change_type = $request->change_type;
                        $apdUpload->upload_id = $doc->id;
                        $apdUpload->updated_at = Carbon::now();
                        $apdUpload->created_at = Carbon::now();
                        $apdUpload->upload_doc_id = $apd->id;
                        $apdUpload->save();
                    }
                }
                
                $user_id = Auth::user()->id;
                $user = User::where('id', $user_id)->first();
                $authorized_person_detailsRow = AuthorizedPersonDetail::find($apd->id);

                $user1 = DB::table('approved_apps_details as aad')
                ->join('users as u','u.id','=','aad.user_id')
                ->where('aad.user_id',Auth::user()->id)
                ->first();

                $data = array('old_contact_person'=>$authorized_person_detailsRow->old_contact_person,'old_designation'=>$authorized_person_detailsRow->old_designation,'old_mobile'=>$authorized_person_detailsRow->old_mobile,'old_email'=>$authorized_person_detailsRow->old_email,'new_contact_person'=>$authorized_person_detailsRow->new_contact_person,'new_designation'=>$authorized_person_detailsRow->new_designation,'new_mobile'=>$authorized_person_detailsRow->new_mobile,'new_email'=>$authorized_person_detailsRow->new_email,
                'change_type'=>$request->change_type);
                

                Mail::send('emails.addAuthorizeSignatory',$data,function($message) use($data) {
                    $message->to('bdpli@ifciltd.com',$data['old_contact_person'])->subject
                    ('PLI Scheme for Bulk Drugs | Request Submitted Succesfully');
                    $message->cc($data['new_email'],'PLI Bulk Drugs');
                    });

                alert()->success('Your Details Submitted', 'Success')->persistent('Close');
            }else{
               
                alert()->success('Your request already pending for Approval', 'Cancel')->persistent('Close');
            }
        });
        if($request->change_type == 'A'){
            $data_id = Auth::user()->id;

        }elseif($request->change_type == 'C'){
            $data_id = Auth::user()->id;

        }elseif($request->change_type == 'R'){
            $data_id = $request->app_id;

        }

        return redirect()->route('admin.authoriseSignatory',[$request->change_type,$data_id]);
    }
}
