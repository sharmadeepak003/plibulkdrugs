<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Excel;
use App\AuthorizedPersonDetail;
use App\Exports\UsersExport;
use App\DocumentUploads;
use Carbon\Carbon;
use Auth;
use App\Exports\UsersExportRound1;
use App\Http\Requests\admin\UserUpdate;
use Mail;
use App\Mail\UserActive;
use Exception;

class UsersController extends Controller
{

    //Change by Ajaharuddin Ansari
    public function __construct()
    {
        $this->middleware(['role:Admin'], ['only' => ['update']]);
    }
    //!  Ajaharuddin Ansari


    public function index()
    {
        $users = User::orderBy('id', 'ASC')
        ->whereNotIn('id', [68,69,70,74])
        ->whereRaw('is_normal_user(users.id)=1')
        ->get(['users.*', DB::raw('ROW_NUMBER() OVER (ORDER BY id) rno')]);
        //dd($users);

        return view('admin.users.dashboard', compact('users'));
    }

   public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.view',compact('user'));
    }

    public function edit($id)
    {
        
        $user = User::find($id);
        $prods = DB::table('eligible_products')->orderBy('id')->get();

        return view('admin.users.edit',compact('user','prods'));
    }

    public function update(UserUpdate $request, $id)
    {
        $this->validate($request, [
            'userStatus' => 'required',
        ]);

        $user = User::find($id);
        $user->isapproved = $request->userStatus;
        $user->remarks = $request->remarks;
        $user->save();

        if($request->userStatus == 'Y')
        {
            $user->assignRole('Applicant');
            Mail::to($user->email)
            ->cc('bdpli@ifciltd.com')
            ->send(new UserActive($user));
        }
        elseif($request->userStatus == 'N')
        {
            $user->removeRole('ActiveUser');
            $user->removeRole('Applicant');
        }

        alert()->success('Applicant login status saved', 'Success')->persistent('Close');
        return redirect()->route('admin.users.index');
    }

    public function usersExport()
    {
        //dd('something');
        return Excel::download(new UsersExport, 'usersRound2.xlsx');
    }

    public function usersExportRound1()
    {
        //dd('something');
        return Excel::download(new UsersExportRound1, 'usersRound1.xlsx');
    }

    public function destroy($id)
    {
        //
    }

    //edit authorised signatory
    public function EditAuthorisedSignatory($id)
    {
        $userDetails  = User::findOrFail($id);
        $authPersons = AuthorizedPersonDetail::join('users','users.id','=','authorized_person_details.admin_created_by')
                       ->select('authorized_person_details.*','users.email as admin_email')
                       ->where('authorized_person_details.user_id', $id)->get();

        $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');
        
       $city = DB::table('pincodes')->where('state',$userDetails->off_state)->whereNotNull('city')->orderBy('city')->select('state','city')->get()->unique('city');

        return view('admin.users.authorizeChangeDetail', compact('userDetails','authPersons','states','city'));
    }

    public function UpdateAuthorization(Request $request)
    {
        try{
            DB::transaction(function () use ($request) {
                $User = User::find($request->user_id);
    
                $uploadId = array();
    
                if ($request->hasfile('authorizationLetter')) {
                    $newDoc = $request->file('authorizationLetter');
                    
                    $doc = new DocumentUploads;
                        $doc->doc_id = 73;
                        $doc->doc_id = 73;
                        $doc->mime = $newDoc->getMimeType();
                        $doc->file_size = $newDoc->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->user_id = $request->user_id;
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $newDoc->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                        $doc->remarks = '';
                    $doc->save();
                    array_push($uploadId, $doc->id);
                }

                $authDetail = new AuthorizedPersonDetail();
                    $authDetail->user_id = $request->user_id;
                    $authDetail->new_contact_person = $request->contact_person;
                    $authDetail->new_designation = $request->designation;
                    $authDetail->new_email = $request->email;
                    $authDetail->new_mobile = $request->mobile;
                    $authDetail->upload_id =  $uploadId;
                    $authDetail->old_contact_person = $User->contact_person;
                    $authDetail->old_designation = $User->designation;
                    $authDetail->old_email = $User->email;
                    $authDetail->old_mobile = $User->mobile;
                    $authDetail->approved_at = Carbon::now();
                    $authDetail->change_type = 'A';
                    $authDetail->status='A';
                    $authDetail->admin_created_by = Auth::user()->id;
                    $authDetail->admin_created_at = Carbon::now();
                $authDetail->save();
    
                $User->email = $request->email;
                $User->email_verified_at = null;
                $User->mobile = $request->mobile;
                $User->mobile_verified_at = null;
                $User->contact_person = $request->contact_person;
                $User->designation = $request->designation;
                $User->save(); 
              
            });
            alert()->success('Authorization Details has been Updated', 'Success')->persistent('Close');
        }catch(Exception $e){
            alert()->error('Email is already exists', 'Attention!')->persistent('Close');
            return redirect()->route('admin.users.index');
        }
    }

    public function DownloadAuthorizationLetter($upload_id)
    {
        $upload_id = decrypt($upload_id);
        $doc =  DocumentUploads::where('id', $upload_id)->first();
        
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
        } elseif ($doc->mime == "image/png") {
            $ext = 'png';
        } elseif ($doc->mime == "image/jpeg") {
            $ext = 'jpg';
        }
        $doc_name = 'authorizationLetter';
        
        return response($docc)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', $doc->mime)
            ->header('Content-length', strlen($docc))
            ->header('Content-Disposition', 'attachment; filename='.$doc_name.'.'.$ext)
        ->header('Content-Transfer-Encoding', 'binary');
    }

}
