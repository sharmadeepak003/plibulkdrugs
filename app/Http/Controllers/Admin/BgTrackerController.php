<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use Carbon\Carbon;


use App\BgTracker;
use App\DocumentMaster;
use App\DocumentUploads;
use Excel;
use App\Exports\BGExport;


// use App\Http\Controller\Admin\BgTrackerController;


class BgTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = DB::table('applications as a')
            ->leftJoin(
                'bg_trackers',
                function ($join) {
                    $join->on('bg_trackers.app_id', '=', 'a.id')
                        ->where('bg_trackers.submit', '=', 'Y');
                }
            )
            ->whereRaw('is_normal_user(a.created_by)=1')
            ->whereNotNull('a.app_no')
            ->whereNotNull('a.approval_dt')
            ->orwhereIn('a.id',array(43,126,125,270,35,269))
            ->where('a.status', '=', 'S')
            ->orderBy('bg_trackers.expiry_dt','asc')
            ->get(['a.*', 'bg_trackers.id as bg_id', 'bg_trackers.bg_no', 'bg_trackers.issued_dt', 'bg_trackers.expiry_dt', 'bg_trackers.bg_status', 'bg_trackers.bg_amount', 'bg_trackers.claim_dt']);
        // dd($apps );

        $date = Carbon::now()->addDay(15);
        $today = Carbon::now();
        // dd($date,$apps);

        return view('admin.bgtracker.bg_tracker_dashboard', compact('apps', 'date', 'today'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($app_no)
    {
        // dd($app_no);
        $appMast = DB::table('applications')->where('id', $app_no)->where('status', 'S')->first();

        $app = DB::table('company_details')->where('app_id', $appMast->id)->where('created_by',$appMast->created_by)->first();

        $eligible_pro = DB::table('eligible_products')->get();

        $user = DB::table('users')->where('id', $appMast->created_by)->first();

        return view('admin.bgtracker.bg_tracker_create', compact('appMast', 'app', 'eligible_pro', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();

        DB::transaction(function () use ($doctypes, $request) {
            BgTracker::where('app_id', $request->app_id)->update(['submit' => 'N']);
            $doc = null;
            foreach ($doctypes as $docid => $doctype) {
                if ($request->hasfile($doctype)) {
                    $newDoc = $request->file($doctype);
                    $doc = new DocumentUploads;
                    $doc->app_id = $request->app_id;
                    $doc->doc_id = $docid;
                    $doc->mime = $newDoc->getMimeType();
                    $doc->file_size = $newDoc->getSize();
                    $doc->updated_at = Carbon::now();
                    $doc->user_id = Auth::user()->id;
                    $doc->created_at = Carbon::now();
                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                    $doc->save();
                }
            }
            BgTracker::create([
                'app_id' => $request->app_id,
                'bank_name' => $request->bank_name,
                'branch_address' => $request->branch_address,
                'bg_no' => $request->bg_no,
                'bg_amount' => $request->bg_amount,
                'issued_dt' => $request->issued_dt,
                'expiry_dt' => $request->expiry_dt,
                'claim_dt' => $request->claim_dt,
                'bg_status' => $request->bg_status,
                'remark' => $request->remark,
                'bg_upload_id' => $doc->id,
            ]);
            alert()->success('BG Data Saved', 'Success')->persistent('Close');
        });
        return redirect()->route('admin.bgtracker.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($app_id, $bg_id)
    {
        // $app_id=decrypt($app_id);
        $bg_id=decrypt($bg_id);

        $today = Carbon::now();

        $bgview = DB::table('applications as a')
            ->join('bg_trackers', 'bg_trackers.app_id', '=', 'a.id')
            ->where('bg_trackers.id', $bg_id)
            ->where('a.id', $app_id)
            ->orderBy('bg_trackers.id', 'DESC')
            ->select('a.*', 'bg_trackers.*','bg_trackers.id as bg_id','bg_trackers.expiry_dt')
            ->get();

        $bgview1 = DB::table('applications as a')
            ->join('bg_trackers', 'bg_trackers.app_id', '=', 'a.id')
            ->where('a.id', $app_id)
            ->orderBy('bg_trackers.id', 'DESC')
            ->select('a.*', 'bg_trackers.*', 'bg_trackers.id as bg_id')
            ->get();

        $downloads = DocumentUploads::where('id', $bgview[0]->bg_upload_id)->get();

        $docs = [];
        $docids = [];
        $doc_names = [];
        $upload_id = [];

        foreach ($downloads as $key => $upload) {
            $docids[] = $upload->doc_id;
            $doc_names[$upload->doc_id] = $upload->file_name;
            $upload_id[] = $upload->id;

            ob_start();
            fpassthru($upload->uploaded_file);
            $doc = ob_get_contents();
            ob_end_clean();

            if ($upload->mime == "application/pdf") {
                $docs[$upload->doc_id] = "data:application/pdf;base64," . base64_encode($doc);
            } elseif ($upload->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                $docs[$upload->doc_id] = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64," . base64_encode($doc);
            } elseif ($upload->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                $docs[$upload->doc_id] = "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($doc);
            } elseif ($upload->mime == "image/png") {
                $mime = 'png';
                $docs[$upload->doc_id] = "data:application/png;base64," . base64_encode($doc);
            } elseif ($upload->mime == "image/jpeg" || $upload->mime == "image/jpg") {
                $mime = 'jpeg';
                $docs[$upload->doc_id] = "data:application/jpeg;base64," . base64_encode($doc);
            }
        }
        $date = Carbon::now()->addDay(15);
        $today = Carbon::now();
        return view('admin.bgtracker.bg_tracker_view', compact('bgview', 'bgview1', 'docs', 'docids', 'doc_names', 'date', 'today', 'upload_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($bg_id,$doc_id)
    {
        // $bg_id=decrypt($bg_id);
        $doc_id=decrypt($doc_id);

        $bgview = DB::table('applications as a')
            ->join('bg_trackers', 'bg_trackers.app_id', '=', 'a.id')
            ->where('bg_trackers.id', $bg_id)
            ->where('bg_trackers.bg_upload_id', $doc_id)
            ->select('a.*', 'bg_trackers.*')
            ->first();

        return view('admin.bgtracker.bg_tracker_edit', compact('bgview'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $app_id)
    {
        $bgupdate = BgTracker::where('id', $request->bg_id)->first();
        $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();
        // dd($request,$app_id);
        DB::transaction(function () use ($bgupdate, $doctypes, $request) {
            
            $bgupdate->fill([
                'bank_name' => $request->bank_name,
                'branch_address' => $request->branch_address,
                'bg_no' => $request->bg_no,
                'bg_amount' => $request->bg_amount,
                'issued_dt' => $request->issued_dt,
                'expiry_dt' => $request->expiry_dt,
                'claim_dt' => $request->claim_dt,
                'bg_status' => $request->bg_status,
                'remark' => $request->remark,
            ]);
            $bgupdate->save();

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
                    $doc->updated_at = Carbon::now();
                    $doc->user_id = Auth::user()->id;
                    $doc->created_at = Carbon::now();
                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                    $doc->save();
                }
            }
            alert()->success('Data Update', 'Success')->persistent('Close');
        });
        return redirect()->route('admin.bgtracker.index');
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
    public function bgExport()
    {
        return Excel::download(new BGExport, 'BG_Data.xlsx');
    }
}
