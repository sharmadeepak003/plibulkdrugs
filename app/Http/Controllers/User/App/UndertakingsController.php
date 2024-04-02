<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\DocumentMaster;
use App\DocumentUploads;
use App\UndertakingDetails;
use App\Http\Requests\UndertakingStore;
use App\Http\Requests\UndertakingUpdate;
use Carbon;

class UndertakingsController extends Controller
{
    public function index()
    {
        //
    }

    public function create($id)
    {
        $appMast = ApplicationMast::where('id', $id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();
        if (!$appMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }
		
		 $stage_check = $appMast->stages->where('app_id', $id)->where('stage', 3)->first();
		 
		 if (!$stage_check) {
            alert()->error('Please fill Section 3 Financial Details.')->persistent('Close');
            return redirect()->route('applications.index');
        }
		
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 4)->first();
        if ($stage) {
            return redirect()->route('undertakings.edit', $appMast->id);
        }

        return view('user.app.undertakings-create', compact('appMast'));
    }

    public function store(UndertakingStore $request)
    {
        //dd($request);

        $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();

        DB::transaction(function () use ($doctypes, $request) {            

            foreach ($doctypes as $docid => $doctype) {
                if ($request->hasfile($doctype)) {
                    $newDoc = $request->file($doctype);
                    $doc = DocumentUploads::where('app_id', $request->app_id)->where('doc_id', $docid)->first();
                    if (empty($doc)) {
                        $doc = new DocumentUploads;
                        $doc->app_id = $request->app_id;
                        $doc->doc_id = $docid;
                    }
                    $doc->mime = $newDoc->getMimeType();
                    $doc->file_size = $newDoc->getSize();
                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                    $docRemark = 'rem' . $docid;
                    $doc->remarks = $request->$docRemark;
                    $doc->updated_at = Carbon\Carbon::now();
                    $doc->save();
                }
            }

            AppStage::create(['app_id' => $request->app_id, 'stage' => 4, 'status' => 'D']);
        });

        alert()->success('Undertaking Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $appMast = ApplicationMast::where('created_by', Auth::user()->id)->where('id', $id)->where('status', 'D')->first();
        if (!$appMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 4)->first();
        if (!$stage) {
            return redirect()->route('undertakings.create', $id);
        }

        //$und = $appMast->undertakings;

        $contents = DocumentUploads::where('app_id', $appMast->id)
            ->orderby('doc_id')
            ->get();

            $docs = [];
            $docids = [];

        foreach ($contents as $key => $content) {
            /* This Method return direct pdf file from browser
            header("Content-Type: ".$content->mime);
            $doc = $content->uploaded_file;
            dd(fpassthru($doc));
            */

            $docids[] = $content->doc_id;

            ob_start();
            fpassthru($content->uploaded_file);
            $doc = ob_get_contents();
            ob_end_clean();

            if ($content->mime == "application/pdf") {
                $docs[$content->doc_id] = "data:application/pdf;base64," . base64_encode($doc);
            } elseif ($content->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                $docs[$content->doc_id] = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64," . base64_encode($doc);
            } elseif ($content->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                $docs[$content->doc_id] = "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($doc);
            }
        }
        $remarks = DB::table('document_uploads')->select('remarks','doc_id')->where('app_id',$appMast->id)->pluck('remarks','doc_id')->toArray();
        //dd($remarks);

        return view('user.app.undertakings-edit', compact('appMast', 'docids','docs','remarks'));
    }

    public function update(UndertakingUpdate $request, $id)
    {
        //dd($request->rem1);
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();

        

        $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();

        DB::transaction(function () use ($appMast, $doctypes, $request) {
            

            foreach ($doctypes as $docid => $doctype) {
                
                if ($request->hasfile($doctype)) {
                    $newDoc = $request->file($doctype);
                    $doc = DocumentUploads::where('app_id', $appMast->id)->where('doc_id', $docid)->first();
                    if (empty($doc)) {
                        $doc = new DocumentUploads;
                        $doc->app_id = $appMast->id;
                        $doc->doc_id = $docid;
                        $docRemark = 'rem' . $docid;
                   
                        $doc->remarks = $request->$docRemark;
                    }
                    
                    $doc->mime = $newDoc->getMimeType();
                    $doc->file_size = $newDoc->getSize();
                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                    $docRemark = 'rem' . $docid;
                   
                    $doc->remarks = $request->$docRemark;

                    $doc->save();
                }

                $doc = DocumentUploads::where('app_id', $appMast->id)->where('doc_id', $docid)->first();
                if (!empty($doc)) {
                    $docRemark = 'rem' . $docid;                   
                    $doc->remarks = $request->$docRemark;
                    $doc->save();
                }

            }
        });

        alert()->success('Undertaking Details Saved', 'Success')->persistent('Close');
        return redirect()->back();


    }

    public function destroy($id)
    {
        //
    }
}
