<?php

namespace App\Http\Controllers\User\QRR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DocumentUploads;
use App\DocumentMaster;
use Carbon\Carbon;
use App\QRRMasters;
use App\QrrStage;
use Auth;
use Exception;
use App\Http\Requests\UploadsStore;

class UploadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$qrr)
    {
        $qrrMast = QRRMasters::where('id', $qrr)
        ->where('app_id',$id)->where('status', 'D')->first();
        $app_dt=DB::table('approved_apps_details')->where('id',$id)->first();
        
        $fin_Data =substr($app_dt->approval_dt,0,10);
            
        $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);

        $year= substr((end($fy_year)->fin_year),0,4);

        if (!$qrrMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('qpr.byname',$year.'01');
        }

        $stage = QrrStage::where('qrr_id', $qrr)->where('stage', 4)->first();

        if ($stage) {
            return redirect()->route('uploads.edit', $qrr);
        }

        return view('user.qrr.Uploads',compact('id','qrr','year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();
            $qrr=QRRMasters::where('id',$request->qrr)->first();

            DB::transaction(function () use ($doctypes, $request,$qrr) {

                foreach ($doctypes as $docid => $doctype) {

                    if ($request->hasfile($doctype)) {
                    

                        $newDoc = $request->file($doctype);
                    
                        $doc = DocumentUploads::where('app_id',$qrr->app_id)->where('doc_id', $docid)->first();

                        
                        if (empty($doc)) {
                            $doc = new DocumentUploads;
                            $doc->app_id=$qrr->app_id;
                            $doc->doc_id = $docid;
                        }
                        $doc->mime = $newDoc->getMimeType();
                        $doc->file_size = $newDoc->getSize();
                        $doc->updated_at = Carbon::now();

                        //$doc->created_by = Auth::user()->id;
                        $doc->created_at = Carbon::now();

                        // $doc->remarks = $request->remarks[$doctype];

                        $doc->file_name = $newDoc->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');

                        $doc->save();

                    }
                }
                QrrStage::create(['qrr_id' => $request->qrr, 'stage' => 4, 'status' => 'D']);
            });
            
            alert()->success('Data Saved', 'Success!')->persistent('Close');
            return redirect()->route('qpr.byname',$qrr->qtr_id);
        }catch(Exception $e){
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $qrrMast = QRRMasters::where('id', $id)->where('status', 'D')->first();
        
        if (!$qrrMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('qpr.byname',202101);
        }
        $app_id=$qrrMast->app_id;
        $stage = QrrStage::where('qrr_id', $id)->where('stage', 4)->first();
        if (!$stage) {
            return redirect()->route('uploads.create', ['id' => $app_id, 'qrr' => $id]);
        }


        $contents = DocumentUploads::where('app_id',$qrrMast->app_id)
        ->whereIn('doc_id',array(22,23,24,25,26,27))->get();
         
        //dd($contents);
        $docs = [];
        $docids = [];
        $doc_names = [];

        $app_dt=DB::table('approved_apps_details')->where('id',$app_id)->first();
        // dd($app_dt);
        $fin_Data =substr($app_dt->approval_dt,0,10);
            
        $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);

        $year= substr((end($fy_year)->fin_year),0,4);

        foreach ($contents as $key => $content) {
            //dd($contents,$content,$content->doc_id);
        $docids[] = $content->doc_id;
        $doc_names[$content->doc_id] = $content->file_name;

        ob_start();
        fpassthru($content->uploaded_file);
        $doc = ob_get_contents();
        ob_end_clean();

        //dd($content->mime);
        if ($content->mime == "application/pdf") {
            $docs[$content->doc_id] = "data:application/pdf;base64," . base64_encode($doc);
        } elseif ($content->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            $docs[$content->doc_id] = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64," . base64_encode($doc);
        } elseif ($content->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $docs[$content->doc_id] = "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($doc);
        }elseif ($content->mime == "image/png") {
            $mime='png'; $docs[$content->doc_id] = "data:application/png;base64," . base64_encode($doc);
        }elseif ($content->mime == "image/jpeg"||$contents->mime == "image/jpg") {
            $mime='jpeg'; $docs[$content->doc_id] = "data:application/jpeg;base64," . base64_encode($doc);
        }
    }
    //$remarks = DB::table('document_uploads')->select('remarks','doc_id')->where('app_id',$appMast->id)->pluck('remarks','doc_id')->toArray();
    //dd($remarks);

        //dd($docids,$doc_names);
        
        return view('user.qrr.Uploads_edit',compact('app_id','id','docids','docs','doc_names','year'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $qrrMast = QRRMasters::where('id', $id)->where('status', 'D')->first();
            
            if (!$qrrMast) {
                alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
                return redirect()->route('qpr.byname',202101);
            }

            $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();

            DB::transaction(function () use ($doctypes, $request,$qrrMast) {

            foreach ($doctypes as $docid => $doctype) {

                if ($request->hasfile($doctype)) {

                    $newDoc = $request->file($doctype);

                    $doc = DocumentUploads::where('app_id',$qrrMast->app_id)->where('doc_id', $docid)->first();

                    
                    if (empty($doc)) {
                        $doc = new DocumentUploads;
                        $doc->app_id=$qrrMast->app_id;
                        $doc->doc_id = $docid;
                    }
                    $doc->mime = $newDoc->getMimeType();
                    $doc->file_size = $newDoc->getSize();
                    $doc->updated_at = Carbon::now();

                    $doc->created_at = Carbon::now();


                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');

                    $doc->save();

                }
            }
            });

            alert()->success('Uploads Saved', 'Success')->persistent('Close');
            return redirect()->route('uploads.edit',$id);
        }catch(Exception $e){
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
