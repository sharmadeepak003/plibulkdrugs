<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Applications;
use App\ApplicationMast;
use App\ApplicationMastRound1;
use App\ApplicationMastRound2;
use Excel;
use App\Exports\ApplicationExport;
use App\Exports\EmploymentExport;
use Carbon;
use App\ProjectParticulars;
use App\InvestmentParticulars;
use App\DocumentUploads;
use App\FeeDetails;
use App\ApplicationStatus;

class AppsController extends Controller
{
    public function index()
    {
        $apps = DB::table('applications')
            ->join('application_statuses', 'application_statuses.app_id', '=', 'applications.id', 'left')
            ->join('application_status_role', 'application_status_role.id', '=', 'application_statuses.flage_id', 'left')
            ->select('applications.*', 'application_statuses.flage_id', 'application_status_role.flag_name')
            ->get();

        $target_segment = DB::table('eligible_products')->distinct('target_segment')->select('target_segment')->get();

        return view('admin.apps.dashboard', compact('apps', 'target_segment'));
    }

    public function getTp($name)
    {
        $products = DB::table('eligible_products')
            ->whereRaw("(substr(code,1,1) = ? OR '999' = ?)", [$name, $name])
            ->get();
        return json_decode($products);
    }

    public function getProductApps($product_id, $target)
    {

        if ($target == 999 && $product_id == 999) {

            $articles = Applications::join('application_statuses', 'application_statuses.app_id', '=', 'applications.id', 'left')
                ->join('application_status_role', 'application_status_role.id', '=', 'application_statuses.flage_id', 'left')
                ->select('applications.*', 'application_statuses.flage_id', 'application_status_role.flag_name')
                ->get();
        } else {
            $allTargetId = DB::table('eligible_products')
                ->whereRaw("(substr(code,1,1) = ?)", [$target])
                ->get('id')->toArray();

            $ids = [];
            if ($product_id == 999) {
                foreach ($allTargetId as $allTargetId) {
                    array_push($ids, $allTargetId->id);
                }
            } else {
                $ids[] = $product_id;
            }

            $articles = Applications::join('application_statuses', 'application_statuses.app_id', '=', 'applications.id', 'left')
                ->join('application_status_role', 'application_status_role.id', '=', 'application_statuses.flage_id', 'left')
                ->whereIn('applications.eligible_product', $ids)
                ->where('applications.status', 'S')
                ->select('applications.*', 'application_statuses.flage_id', 'application_status_role.flag_name')
                ->get();

        }
        return ($articles);
    }



    public function appsExport()
    {
        return Excel::download(new ApplicationExport, 'applications.xlsx');
    }

    public function empsExport()
    {
        return Excel::download(new EmploymentExport, 'employments.xlsx');
    }

    public function preview($id)
    {
      
        $appMast = Applications::where('status', 'S')->where('id', $id)->first();
        // dd($appMast);

        $app = DB::table('company_details')->where('app_id', $appMast->id)->where('created_by', $appMast->created_by)->first();
        //    dd($app);

        $user = DB::table('users')->where('id', $appMast->created_by)->first();
        // dd($user);

        $promoters = $appMast->promoters;
        // dd($promoters);

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
        // dd($emp);
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
        $appMast = Applications::where('status', 'S')->where('id', $id)->first();

        $app = DB::table('company_details')->where('app_id', $appMast->id)->where('created_by', $appMast->created_by)->first();

        $user = DB::table('users')->where('id', $appMast->created_by)->first();
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
