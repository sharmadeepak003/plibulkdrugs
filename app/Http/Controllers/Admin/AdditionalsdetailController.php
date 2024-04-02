<?php

namespace App\Http\Controllers\Admin;

// use App\Addtionalsdetail;
use App\Http\Controllers\Controller;
use App\ProposalDetails;
use App\EvaluationDetails;
use Illuminate\Http\Request;
use App\DocumentUploads;
use DB;
use Mail;
use Artisan;
use Auth;
use Carbon\Carbon;
use App\User;
use App\Applications;
use Illuminate\Support\Facades\DB as FacadesDB;

class AdditionalsdetailController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Admin'], ['only' => ['create','store','edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps=DB::table('applications')->whereNotNull('approval_dt')
        ->whereRaw('is_normal_user(applications.created_by)=1')->distinct('id')->get();
        return view('admin.additionaldetail.additional_dashboard',compact('apps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
         $apps=DB::table('approved_apps_details')->where('id',$id)->first();
         $additional=DB::table('additional_detail')->orderby('id')->get();

         $revenue=DB::table('revenues')->where('app_id',$id)->get();
// dd($revenue);
         return view('admin.additionaldetail.detail_edit',compact('apps','additional','revenue'));
    }


    public function store(Request $request)
    {
        //store
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Addtionalsdetail $addtionalsdetail)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Addtionalsdetail  $addtionalsdetail
     * @return \Illuminate\Http\Response
     */
    // public function show(Addtionalsdetail $addtionalsdetail)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Addtionalsdetail  $addtionalsdetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$task_id)
    {
        $task_id=decrypt($task_id);
        
        $apps=DB::table('approved_apps_details')->where('id',$id)->first();
        // dd($task_id,$id, $apps);
        if($task_id==1)
        {
             //Revenue
            $revenue=DB::table('revenues')->where('app_id',$id)->get();
            return view('admin.additionaldetail.projected_sales',compact('apps','revenue','task_id'));

        }elseif($task_id==2)
        {
             //Employment
            $employment=DB::table('employments')->where('app_id',$id)->get();
            return view('admin.additionaldetail.employment',compact('apps','employment','task_id'));

        }elseif($task_id==3)
        {
             //Committed Investment
            $cominvest=DB::table('evaluation_details')->where('app_id',$id)->first();
            return view('admin.additionaldetail.committed_investment',compact('apps','cominvest','task_id'));
        }elseif($task_id==4)
        {
            //Particular Investment
            $particular_inv=DB::table('investment_particulars')->orderby('id')->get();
            $inv_detail=DB::table('investment_details')->where('app_id',$id)->orderby('id')->get();
            return view('admin.additionaldetail.majorhead_investment',compact('apps','particular_inv','inv_detail','task_id'));
        }elseif($task_id==5)
        {
            $propdetail=DB::table('proposal_details')->where('app_id',$id)->first();
            return view('admin.additionaldetail.scod_edit',compact('apps','propdetail','task_id'));
        }
        elseif($task_id==6)
        {
            $committed_inv=DB::table('evaluation_details')->where('app_id',$id)->first();
            return view('admin.additionaldetail.scod_edit',compact('apps','committed_inv','task_id'));
        }
        elseif($task_id==7)
        {
            $quoted_sp=DB::table('evaluation_details')->where('app_id',$id)->first();
            return view('admin.additionaldetail.scod_edit',compact('apps','quoted_sp','task_id'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Addtionalsdetail  $addtionalsdetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            $doc_types = DB::table('document_master')->where('doc_name','EditDoc')->pluck('doc_type','doc_id')->toArray();
            $docids=null;
            $doc_upload_id=null;

            DB::transaction(function () use ($doc_types, $request,$docids,$doc_upload_id) {
                foreach ($doc_types as $docid => $doctype) {
                    if ($request->hasfile($doctype)) { 
                        foreach ($request->file($doctype) as $newDoc) {
                            $doc = new DocumentUploads;
                            $doc->app_id = $request->app_id;
                            $doc->doc_id = $docid;
                            $doc->user_id = Auth::user()->id;
                            $doc->mime = $newDoc->getMimeType();
                            $doc->file_size = $newDoc->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $newDoc->getClientOriginalName();
                            $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                            $doc->save();

                            $docids=$doc->doc_id;
                            $doc_upload_id=$doc->id;
                        }
            
                    } 
                    
                }

                if($request->task_id==1)
                {
               
                    $revenue= DB::table('revenues')->where('app_id', $request->app_id)->update([
                        'app_id' => $request->app_id,
                        'expfy20' =>$request->expfy20,
                        'expfy21' =>$request->expfy21,
                        'expfy22' =>$request->expfy22,
                        'expfy23' =>$request->expfy23,
                        'expfy24' =>$request->expfy24,
                        'expfy25' =>$request->expfy25,
                        'expfy26' =>$request->expfy26,
                        'expfy27' =>$request->expfy27,
                        'expfy28' =>$request->expfy28,
                        'domfy20' =>$request->domfy20,
                        'domfy21' =>$request->domfy21,
                        'domfy22' =>$request->domfy22,
                        'domfy23' =>$request->domfy23,
                        'domfy24' =>$request->domfy24,
                        'domfy25' =>$request->domfy25,
                        'domfy26' =>$request->domfy26,
                        'domfy27' =>$request->domfy27,
                        'domfy28' =>$request->domfy28,
                        'edited_by' =>Auth::user()->id,
                        'edited_at' =>Carbon::now(),
                        'edit_remark' =>$request->revremark,
                    ]);
              
            }elseif($request->task_id==2)
            {
                
                $employment= DB::table('employments')->where('app_id', $request->app_id)->update([
                    'app_id' => $request->app_id,
                    'fy20' =>$request->empfy20,
                    'fy21' =>$request->empfy21,
                    'fy22' =>$request->empfy22,
                    'fy23' =>$request->empfy23,
                    'fy24' =>$request->empfy24,
                    'fy25' =>$request->empfy25,
                    'fy26' =>$request->empfy26,
                    'fy27' =>$request->empfy27,
                    'fy28' =>$request->empfy28,
                    'edited_by' =>Auth::user()->id,
                    'edited_at' =>Carbon::now(),
                    'edit_remark' =>$request->empremark,
                ]);

               

            }elseif($request->task_id==3)
            {
                $evaluation_details= DB::table('evaluation_details')->where('app_id', $request->app_id)->update([
                    'app_id' => $request->app_id,
                    'investment' =>$request->investment,
                    'edited_by' =>Auth::user()->id,
                    'edited_at' =>Carbon::now(),
                    'edit_remark' =>$request->invremark,
                ]);
               

            }elseif($request->task_id==4)
            {
                foreach($request->val as $key => $value)
                {
                    $investment_details= DB::table('investment_details')->where('id', $value['id'])->update([
                        'amt' =>$value['amount'],
                        'edited_by' =>Auth::user()->id,
                        'edited_at' =>Carbon::now(),
                        'edit_remark' =>$request->partremark,
                    ]);
                }

                
            }elseif($request->task_id == 5){
                $proposal_details=ProposalDetails::where('app_id', $request->app_id)->first();
                $proposal_details->prod_date=$request->prod_date;
                $proposal_details->changes_by=Auth::user()->id;
                $proposal_details->changes_at=Carbon::now();
                $proposal_details->remarks=$request->reason;
                $proposal_details->scod_doc_id=($docids = 1061) ? $docids : null;
                $proposal_details->scod_upload_id=($docids = 1061) ? $doc_upload_id : null;
                $proposal_details->save();

                
            }elseif($request->task_id == 6){
               
                $evaluaion_capacity=EvaluationDetails::where('app_id', $request->app_id)->first();
                $evaluaion_capacity->capacity=$request->capacity;
                $evaluaion_capacity->edited_by=Auth::user()->id;
                $evaluaion_capacity->edited_at=Carbon::now();
                $evaluaion_capacity->edit_remark=$request->reason;
                $evaluaion_capacity->cc_doc_id=($docids = 1062) ? $docids : null;
                $evaluaion_capacity->cc_upload_id=($docids = 1062) ? $doc_upload_id : null;
                $evaluaion_capacity->save();

               
            }elseif($request->task_id == 7){
              
                $evaluaion_QSP=EvaluationDetails::where('app_id', $request->app_id)->first();
                $evaluaion_QSP->price=$request->price;
                $evaluaion_QSP->edited_by=Auth::user()->id;
                $evaluaion_QSP->edited_at=Carbon::now();
                $evaluaion_QSP->edit_remark=$request->reason;
                $evaluaion_QSP->qsp_doc_id=($docids = 1063) ? $docids : null;
                $evaluaion_QSP->qsp_upload_id=($docids = 1063) ? $doc_upload_id : null;
                $evaluaion_QSP->save();

            }
            alert()->success('Data Update', 'Success')->persistent('Close');

            });
            return redirect()->route('admin.additionaldetail.create', $request->app_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Addtionalsdetail  $addtionalsdetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addtionalsdetail $addtionalsdetail)
    {
        //
    }

    public function downloadfile($id)
    {
        dd('dfljhsk');
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

}
