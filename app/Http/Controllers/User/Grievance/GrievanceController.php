<?php

namespace App\Http\Controllers\User\Grievance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Grievance;
use App\DocumentUploads;
use App\DocumentMaster;
use App\User;
use DB;
use Auth;
use Mail;
use Carbon\Carbon;

class GrievanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.grievance.grievance');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request, $request->file('complaint_doc'));
        //  try
        //  {
            $user = User::find(Auth::user()->id);

            $doctypes = DocumentMaster::where('doc_id',5009)->pluck('doc_type', 'doc_id')->toArray();

            DB::transaction(function () use ($request, $doctypes){

                $Comp = new Grievance;
                    $Comp->name = $request->name;
                    $Comp->designation = $request->designation;
                    $Comp->email = $request->email;
                    $Comp->mobile = $request->mobile;
                    $Comp->compliant_det = $request->compliant_det;
                    $Comp->user_id = $request->user_id;

                foreach ($doctypes as $docid => $doctype) {
                    $uploadId = array();
                    if ($request->hasfile($doctype) && (in_array($doctype, array('complaint_doc')))){
                        $newDoc = $request->file($doctype);
                        $doc = new DocumentUploads;
                            $doc->doc_id =$docid;
                            $doc->mime = $newDoc->getMimeType();
                            $doc->file_size = $newDoc->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->user_id =  $request->user_id;
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $newDoc->getClientOriginalName();
                            $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                            $doc->remarks = '';
                        $doc->save();
                        array_push($uploadId, $doc->id);
                    }
                    $Comp[$doctype] = $uploadId;
                }
                $Comp->save();
            });
            $Comp=Grievance::where('name', $request->name)->first();
            $data = array('name'=>$user->name,'email'=>$user->email,'submitted_by'=>$Comp->name, 'compliant'=>$Comp->compliant_det, 'mobile'=>$Comp->mobile, 'email'=>$Comp->email, 'designation'=>$Comp->designation);

           
            Mail::send('emails.grievance', $data, function($message) use($data) {
                $message->to('pligrievance@ifciltd.com','PLIBD-Grievance')->subject
                ("PLI Scheme for Bulk Drugs");
            });
                alert()->success('Your Grievance Has Been Submitted', 'Success!')->persistent('Close');
                return redirect()->back();

        // }catch (\Exception $e)
        // {
        //     alert()->Warning('Something Went Wrong', 'Warning!')->persistent('Close');
        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function show(Grievance $grievance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function edit(Grievance $grievance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grievance $grievance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grievance $grievance)
    {
        //
    }
}
