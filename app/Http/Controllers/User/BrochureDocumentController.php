<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\BrohureDocument;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use App\ApplicationMast;
use App\ApplicationMastRound1;

class BrochureDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $apps=DB::table('approved_apps')
        ->join('eligible_products', 'approved_apps.eligible_product', '=', 'eligible_products.id')
        ->join('users', 'approved_apps.created_by', '=', 'users.id')
        ->where('approved_apps.status','S')
        ->where(DB::RAW("is_normal_user(users.id)"), 1)
        ->where('approved_apps.created_by',Auth::user()->id)
        ->whereNotNULL('approved_apps.approval_dt')
        ->orderBy('approved_apps.id')
        ->groupBy('approved_apps.status','approved_apps.round','approved_apps.created_at','approved_apps.submitted_at', 'approved_apps.app_no','approved_apps.id','eligible_products.target_segment','users.name')
        ->get(['approved_apps.id','approved_apps.round','eligible_products.target_segment','approved_apps.app_no','approved_apps.status','approved_apps.created_at','approved_apps.submitted_at', 'users.name',DB::raw('ROW_NUMBER() OVER (ORDER BY approved_apps.id) rno')]);
        
        $eligible_pro = DB::table('eligible_products')->distinct('id')->get();
        
      // dd($apps, $eligible_pro);
         
        return view('user.brochure.dashboard', compact('apps','eligible_pro'));
    }


   

    public function brochureList($id)
    {
        $apps = DB::table("approved_apps")->where('created_by',Auth::user()->id)->where('status', 'S')->where('id', $id)->first();
      
        
    
        if (!$apps)
        {
            alert()->error('Applicant Not Submitted!', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

    

   
        $approved_prods = DB::table('approved_apps as aa')
        ->join('eligible_products as ep', 'ep.id', '=', 'aa.eligible_product')
        ->join('users as u', 'u.id', '=', 'aa.created_by')
        ->where('aa.status','S')
        // ->selectRaw('is_normal_user(u.id) = 1')
        ->where('aa.id', $id)
        ->get(['ep.*']);
        //dd($approved_prods);
       
        $contents = DB::table('brochure_uploads')
            ->join('eligible_products', 'eligible_products.id', '=', 'brochure_uploads.product_id')
             ->join('users', 'users.id', '=', 'brochure_uploads.admin_id')
            ->where('brochure_uploads.app_id', $id)
            ->select('brochure_uploads.*', 'eligible_products.product','users.name')->get();

            
        //dd($contents);

        $arr_brochure_product_id=array();
        foreach($contents as $doc_val)
        {
            $arr_brochure_product_id[] =$doc_val->product_id;
        }
        
        $getEligibleProdDetails = DB::table('approved_apps_details')->where('id',$id)->first();
        
        

        return view('user.brochure.document_listing', compact('apps','getEligibleProdDetails','approved_prods','contents','arr_brochure_product_id'));
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
        //dd($request,$request['doc_type']);
        DB::transaction(function () use ($request) {
        $doc = new BrohureDocument;
                $doc->app_id=$request->app_id;
                $doc->target_segment_id=$request->target_seg_id;
                $doc->websitelink=$request->websitelink;
                $doc->product_id= $request->product_id;
                $doc->prod_category=$request->prod_cat;
                $doc->admin_id=Auth::user()->id;
                $doc->file_name = $request['doc_type']->getClientOriginalName();
                $doc->mime = $request['doc_type']->getMimeType();
                $doc->file_size = $request['doc_type']->getSize();
                $doc->uploaded_file = fopen($request['doc_type']->getRealPath(), 'r');
                if(isset($request['broch_other_doc']))
                {
                    $doc->other_file_name = $request['broch_other_doc']->getClientOriginalName();
                    $doc->other_mime = $request['broch_other_doc']->getMimeType();
                    $doc->other_file_size = $request['broch_other_doc']->getSize();
                    $doc->other_uploaded_file = fopen($request['broch_other_doc']->getRealPath(), 'r');
                }    
                $doc->created_at = Carbon::now();
            $doc->save();

            alert()->success('Brochure doucment upload successfully', 'Success!')->persistent('Close');
        });
        return redirect()->route('app_brochure.brochure_list',$request->app_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BrohureDocument  $BrohureDocument
     * @return \Illuminate\Http\Response
     */
    public function show(BrohureDocument $BrohureDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BrohureDocument  $BrohureDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(BrohureDocument $BrohureDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BrohureDocument  $BrohureDocument
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, BrohureDocument $BrohureDocument)
    {
        //dd($request,$request['doc_type']);
        DB::transaction(function () use ($request) {
            $doc = BrohureDocument::find($request->brochure_id) ;
            $doc->app_id=$request->app_id;
            $doc->target_segment_id=$request->target_seg_id;
            $doc->product_id=$request->product_id;
            $doc->prod_category=$request->prod_cat;
            $doc->admin_id=Auth::user()->id;
            $doc->websitelink=$request->websitelink;

            if(isset($request['doc_type']))
            {
                $doc->file_name = $request['doc_type']->getClientOriginalName();
                $doc->mime = $request['doc_type']->getMimeType();
                $doc->file_size = $request['doc_type']->getSize();
                $doc->uploaded_file = fopen($request['doc_type']->getRealPath(), 'r');
            }
            if(isset($request['broch_other_doc']))
            {
                $doc->other_file_name = $request['broch_other_doc']->getClientOriginalName();
                $doc->other_mime = $request['broch_other_doc']->getMimeType();
                $doc->other_file_size = $request['broch_other_doc']->getSize();
                $doc->other_uploaded_file = fopen($request['broch_other_doc']->getRealPath(), 'r');
            }
            $doc->created_at = Carbon::now();
            //dd($doc);
            $doc->save();
            alert()->success('Brochure doucment upload successfully', 'Success!')->persistent('Close');
        });
        return redirect()->route('app_brochure.brochure_list',$request->app_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BrohureDocument  $BrohureDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(BrohureDocument $BrohureDocument)
    {
    
    }

    public function brochourDownload($id) {
        $id=decrypt($id);
        $doc = DB::table('brochure_uploads as a')->where('id',$id)->first();
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
        }
        return response($docc)->header('Cache-Control', 'no-cache private')->header('Content-Description', 'File Transfer')->header('Content-Type', $doc->mime)->header('Content-length', strlen($docc))->header('Content-Disposition', 'attachment; filename=' . $doc->file_name . '.' . $ext)->header('Content-Transfer-Encoding', 'binary');
    }

    public function brochureDestroy($id,$app_id)
    {
        $id=decrypt($id);
        $app_id=decrypt($app_id);
        $BrohureDocument=BrohureDocument::find($id);
        //dd($BrohureDocument, $app_id, $id);
        if(!is_null($BrohureDocument))
        {
            //$BrohureDocument->delete();
            BrohureDocument::destroy($id);
        }
        alert()->success('Brochure doucment delete successfully', 'Success!')->persistent('Close');
        return redirect()->route('app_brochure.brochure_list',$app_id);
    }

    public function brochourOtherDocDownload($id) {
        $id=decrypt($id);
        $doc = DB::table('brochure_uploads as a')->where('id',$id)->first();
        ob_start();
        fpassthru($doc->other_uploaded_file);
        $docc = ob_get_contents();
        ob_end_clean();
        $ext = '';
        if ($doc->other_mime == "application/pdf") {
            $ext = 'pdf';
        } elseif ($doc->other_mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            $ext = 'docx';
        } elseif ($doc->other_mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $ext = 'xlsx';
        }
        return response($docc)->header('Cache-Control', 'no-cache private')->header('Content-Description', 'File Transfer')->header('Content-Type', $doc->other_mime)->header('Content-length', strlen($docc))->header('Content-Disposition', 'attachment; filename=' . $doc->other_file_name . '.' . $ext)->header('Content-Transfer-Encoding', 'binary');
    }

    public function editDocumentListing($app_id,$id)
    {

        
        $appMast = DB::table("approved_apps")->where('id', $app_id)->first();
        if($appMast->round==1)
        {
            $apps = ApplicationMastRound1::where('id', $app_id)->where('status', 'S')->first();
        }
        else{
            $apps = ApplicationMast::where('id', $app_id)->where('status', 'S')->first();
        }
        if (!$apps) {
            alert()->error('Applicant Not Submitted!', 'Attention!')->persistent('Close');
            return redirect()->route('adminshared.apps.dash');
        }

        // $approved_prods=DB::select("select distinct on (u.name,aa.target_segment,a.product_name)
        //             a.p_id, a.product_name
        //             from approved_apps aa
        //             left join users u on u.id=aa.created_by
        //             left join (select  productname as product_name, apd.app_id, apd.p_id
        //             from add_product_det apd where
        //             apd.approve='Y' and apd.p_id!=9999) as a on a.app_id=aa.id 
        //             WHERE is_normal_user(u.id) = 1 and aa.id=$app_id");

        $approved_prods = DB::table('approved_apps as aa')
        ->join('eligible_products as ep', 'ep.id', '=', 'aa.eligible_product')
        ->join('users as u', 'u.id', '=', 'aa.created_by')
        ->where('aa.status','S')
        // ->selectRaw('is_normal_user(u.id) = 1')
        ->where('aa.id', $app_id)
        ->get(['ep.*']);

        //dd($approved_prods);

        $brochure_doc = DB::table('brochure_uploads')
            ->join('eligible_products', 'eligible_products.id', '=', 'brochure_uploads.product_id')
            ->join('users', 'users.id', '=', 'brochure_uploads.admin_id')
            ->where('brochure_uploads.app_id', $app_id)
            ->where('brochure_uploads.id', $id)
            ->select('brochure_uploads.*', 'eligible_products.product','users.name')->first();

        $contents = DB::table('brochure_uploads')
            ->join('eligible_products', 'eligible_products.id', '=', 'brochure_uploads.product_id')
             ->join('users', 'users.id', '=', 'brochure_uploads.admin_id')
            ->where('brochure_uploads.app_id', $app_id)
            ->select('brochure_uploads.*', 'eligible_products.product','users.name')->get();
        //dd($contents[0]->product_id);

        $arr_brochure_product_id=array();
        foreach($contents as $doc_val)
        {
            $arr_brochure_product_id[] = $doc_val->product_id;
        }
       
        $getEligibleProdDetails = DB::table('approved_apps_details')->where('id',$app_id)->first();
        //dd($app_id, $id, $getEligibleProdDetails);
        //dd($arr_brochure_product_id);

        return view('user.brochure.edit_document_listing', compact('apps','getEligibleProdDetails','approved_prods','contents','arr_brochure_product_id','brochure_doc'));
    }
}
