<?php

namespace App\Http\Controllers\Admin\Grievances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use Carbon\Carbon;


class GrievancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $g_det=DB::table('grievances')
                  ->join('users', 'users.id', '=', 'grievances.user_id')
                  ->select('grievances.*', 'users.name as app_name')
                  ->get();

        // dd($g_det);

        return view('admin.Grievances.listing'
                    , compact('g_det')
                );
    }



    public function respond($id)
    {
      
        $g_det=DB::table('grievances_view')
                  ->join('users', 'users.id', '=', 'grievances_view.user_id')
                  ->select('grievances_view.*', 'users.name as app_name')
                  ->where('grievances_view.id', $id)
                  ->first();

        // dd();

        return view('admin.Grievances.respond'
                    , compact('g_det')
                );
    }


    public function respondStore(Request $request )
    {

        $request->validate([
            'remarks' => 'required|max:1000',
            'close_date' => 'required',
        ]);


        DB::transaction(function () use ( $request) {

        DB::table('grievances')
            ->where('id', $request->qid)
            ->update([
                     'closing_remark' => $request->remarks,
                     'closing_date' => $request->close_date,
                     'closing_entry_time_stamp' => now(),
                     'status' => 1
                    ]);

                    // dd("ddd");

                });  


        alert()->success("Query Closed Succesfully. ", 'Success')->persistent('Close');
        return redirect()->route('admin.grievances_list');

    }




    public function downloadFile($id)
    {
        $doc = DB::table('document_uploads as du')
            ->join('document_master as dm','dm.doc_id','=','du.doc_id')
            ->where('du.id',$id)
            ->select('du.mime','du.file_name','du.uploaded_file','dm.doc_type')
        ->first();

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
        ->header('Content-Disposition', 'attachment; filename='.$doc->doc_type.'.'.$ext)
        ->header('Content-Transfer-Encoding', 'binary');
    }


    public function view($id)
    {

                $g_det=DB::table('grievances_view')
                ->join('users', 'users.id', '=', 'grievances_view.user_id')
                ->select('grievances_view.*', 'users.name as app_name')
                ->where('grievances_view.id', $id)
                ->first();

                // dd();

                return view('admin.Grievances.view'
                , compact('g_det')
                );

    }


   

    
}
