<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\ApplicationMast;
use Excel;
use App\Exports\ApplicationExport;
use Carbon;
use App\ProjectParticulars;
use App\InvestmentParticulars;
use App\DocumentUploads;
use App\FeeDetails;

class AppsController extends Controller
{
    public function index()
    {
        $apps = ApplicationMastRound1::orderBy('id')
            ->get();

        $eligible_pro = DB::table('eligible_products')->get();

        return view('admin.apps.dashboard', compact('apps','eligible_pro'));
    }



    public function appsExport()
    {
        return Excel::download(new ApplicationExport, 'applications.xlsx');
    }
	
    public function preview($id)
    {
        $appMast = ApplicationMast::where('id', $id)->where('status', 'S')->first();
      //  dd($appMast);
        

       // $user = Auth::user();
        $app = $appMast->details;
        $user = DB::table('users')->where('id',$app->created_by)->first();
        //dd($user);
        $promoters = $appMast->promoters;

        $ratings = $appMast->ratings;

        $prods = DB::table('eligible_products')->orderBy('id')->get();
        $others = $appMast->otherShareholders;
        $gstins = $appMast->gstins;
        $auditors = $appMast->auditors;
        $profiles = $appMast->profiles;
        $kmps = $appMast->kmps;

        $elgb = $appMast->eligibility;
        $groups = $appMast->groups;
        $fees = $appMast->fees;

        $fin = $appMast->financials;

        $propDet = $appMast->proposalDetails;
        $proj_prt = ProjectParticulars::orderBy('id')->get();
        $projDet = $appMast->projectDetails;

        $rev = $appMast->revenues;
        $emp = $appMast->employments;

        $dvas = $appMast->dvas;
        $krms = $appMast->krms;

        $evalDet = $appMast->evaluations;
        $invDet = $appMast->investments;
        $fundDet = $appMast->fundings;
        $inv_prt = InvestmentParticulars::where('type', 'Investment')->orderBy('id')->get();
        $fund_prt = InvestmentParticulars::where('type', 'Funding')->orderBy('id')->get();

        $und = $appMast->undertakings;
        $contents = DocumentUploads::where('app_id', $appMast->id)
            ->orderby('doc_id')
            ->get();
        $docs = [];
        $docids = [];
        $docRem = [];
        foreach ($contents as $key => $content) {

            $docids[] = $content->doc_id;
            $docRem[$content->doc_id] = $content->remarks;


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


        $proj = $appMast->projectVerticles;

        return view('admin.apps.preview', compact(
            'prods',
            'others',
            'gstins',
            'auditors',
            'profiles',
            'kmps',
            'elgb',
            'groups',
            'fees',
            'fin',
            'propDet',
            'proj_prt',
            'projDet',
            'emp',
            'rev',
            'dvas',
            'krms',
            'evalDet',
            'invDet',
            'fundDet',
            'inv_prt',
            'fund_prt',
            'docids',
            'docs',
            'docRem',
            'appMast',
            'user',
            'app',
            'promoters',
            'ratings'
        ));
    }

    public function print($id)
    {
        $appMast = ApplicationMast::where('id', $id)->where('status', 'S')->first();
        //dd($appMast);
        

       // $user = Auth::user();
        $app = $appMast->details;
        $user = DB::table('users')->where('id',$app->created_by)->first();
        $promoters = $appMast->promoters;

        $ratings = $appMast->ratings;

        $prods = DB::table('eligible_products')->orderBy('id')->get();
        $others = $appMast->otherShareholders;
        $gstins = $appMast->gstins;
        $auditors = $appMast->auditors;
        $profiles = $appMast->profiles;
        $kmps = $appMast->kmps;

        $elgb = $appMast->eligibility;
        $groups = $appMast->groups;
        $fees = $appMast->fees;

        $fin = $appMast->financials;

        $propDet = $appMast->proposalDetails;
        $proj_prt = ProjectParticulars::orderBy('id')->get();
        $projDet = $appMast->projectDetails;

        $rev = $appMast->revenues;
        $emp = $appMast->employments;

        $dvas = $appMast->dvas;
        $krms = $appMast->krms;

        $evalDet = $appMast->evaluations;
        $invDet = $appMast->investments;
        $fundDet = $appMast->fundings;
        $inv_prt = InvestmentParticulars::where('type', 'Investment')->orderBy('id')->get();
        $fund_prt = InvestmentParticulars::where('type', 'Funding')->orderBy('id')->get();

        $und = $appMast->undertakings;
        $contents = DocumentUploads::where('app_id', $appMast->id)
            ->orderby('doc_id')
            ->get();
        $docs = [];
        $docids = [];
        $docRem = [];
        foreach ($contents as $key => $content) {

            $docids[] = $content->doc_id;
            $docRem[$content->doc_id] = $content->remarks;


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


        $proj = $appMast->projectVerticles;

        return view('admin.apps.print', compact(
            'prods',
            'others',
            'gstins',
            'auditors',
            'profiles',
            'kmps',
            'elgb',
            'groups',
            'fees',
            'fin',
            'propDet',
            'proj_prt',
            'projDet',
            'emp',
            'rev',
            'dvas',
            'krms',
            'evalDet',
            'invDet',
            'fundDet',
            'inv_prt',
            'fund_prt',
            'docids',
            'docs',
            'docRem',
            'appMast',
            'user',
            'app',
            'promoters',
            'ratings'
        ));
    }
}
