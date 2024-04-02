<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Collection;
use App\ApplicationMast;
use App\Applications;
use Carbon;
use App\FeeDetails;
use Mail;
use App\Mail\AppSubmit;
use App\ProjectParticulars;
use App\InvestmentParticulars;
use App\DocumentUploads;


class AppMastController extends Controller
{
    public function index()
    {
        $prods = DB::table('eligible_products')
            ->whereIn('id', Auth::user()->eligible_product)
            ->get();

        // dd($prods,Auth::user()->eligible_product);

        $apps1 = Applications::where('created_by', Auth::user()->id)->select('applications.*')->get();

        $apps = ApplicationMast::where('created_by', Auth::user()->id)->get();

        $createdProdApps = ApplicationMast::where('created_by', Auth::user()->id)->pluck('eligible_product')->toArray();

        // dd($prods,$apps,$createdProdApps,$apps1,Auth::user()->id);

        return view('user.app.index', compact('prods', 'apps', 'createdProdApps','apps1'));
    }


    public function create($id)
    {
        $user = Auth::user();
        if (!in_array($id, $user->eligible_product)) {
            alert()->error('Eligible Product not selected', 'Attention!')->persistent('Close');
            return redirect()->route('home');
        } elseif (in_array($id, $user->eligible_product)) {
            //TODO: Check this logic again
            $app = ApplicationMast::where('created_by', Auth::user()->id)
                ->where('eligible_product', $id)
                ->first();

            if ($app) {
                alert()->error('Application already exists for this product', 'Attention!')->persistent('Close');
                return redirect()->route('home');
            } else {
                return redirect()->route('companydetails.create', $id);
            }
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function submit($id)
    {
        //  if(Carbon\Carbon::now()->gt(Carbon\Carbon::parse('2022-03-31 23:59:00')))
         if(Carbon\Carbon::now()->gt(Carbon\Carbon::parse('2023-06-30 23:59:00')))
         {
         alert()->error('Application Window closed!', 'Info')->persistent('Close');
         return redirect()->route('applications.index');

         }

		//  dd('Application Window closed');


		$eligible = FeeDetails::where('app_id', $id)->first();

        if ($eligible->payment == "N") {
            alert()->error('Fee details are mandatory before submitting application (refer Section 2 eligibility criteria) ', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }

        $appMast = ApplicationMast::where('id', $id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();
        if (!$appMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }

        $pro_short_name = DB::table('eligible_products')->where('id', $appMast->eligible_product)->pluck('short_name')->first();

        $stage = $appMast->stages->pluck('stage')->toArray();
        $allStages = ['1', '2', '3', '4', '5', '6', '7', '8'];
        $arrDiff1 = array_diff($stage, $allStages);
        $arrDiff2 = array_diff($allStages, $stage);
        $diff = array_merge($arrDiff1, $arrDiff2);
        if ($diff) {
            alert()->error('Please complete previous sections first!', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

        if ($appMast->app_no) {
            $app_no = $appMast->app_no;
        } else {
            $maxappno = (int) substr(ApplicationMast::max(DB::RAW("right(app_no,3)")), -3) + 1;

            $maxappno = str_pad($maxappno, 3, "0", STR_PAD_LEFT);

            // $app_no = 'IFCI/PLI-BD2/' . date('dmY', strtotime(Carbon\Carbon::now())) . '/' . $pro_short_name . '/' . $maxappno;
            $app_no = 'IFCI/PLI-BD3/' . date('dmY', strtotime(Carbon\Carbon::now())) . '/' . $pro_short_name . '/' . $maxappno;
        }

        //dd($app_no);

        $appMast->app_no = $app_no;
        $appMast->submitted_at = Carbon\Carbon::now();
        $appMast->status = 'S';

        $user = Auth::user();

        DB::transaction(function () use ($appMast, $user) {
            $appMast->save();
        });


        try {
            Mail::to($user->email)
                 ->cc('bdpli@ifciltd.com')
                 ->send(new AppSubmit($user, $appMast));
        } catch (\Exception $e) {
            return redirect()->route('applications.index');
        }

        alert()->success('Application submitted successfully!', 'Success!')->persistent('Close');
        return redirect()->route('applications.index');
    }

    public function preview($id)
    {
        // dd('');
        $appMast = ApplicationMast::where('id', $id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();
        
        if (!$appMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }
        $stage = $appMast->stages->pluck('stage')->toArray();
        $allStages = ['1', '2', '3', '4', '5', '6', '7', '8'];
        $arrDiff1 = array_diff($stage, $allStages);
        $arrDiff2 = array_diff($allStages, $stage);
        $diff = array_merge($arrDiff1, $arrDiff2);
        if ($diff) {
            alert()->error('Please complete previous sections first!', 'Attention!')->persistent('Close');
            return redirect()->back();
        }

        $user = Auth::user();
        $app = $appMast->details;

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

        return view('user.app.preview', compact(
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

    public function show($id)
    {
        
        // $appMast = ApplicationMast::where('id', $id)->where('created_by', Auth::user()->id)->where('status', 'S')->first();
        // if (!$appMast) {
        //     alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
        //     return redirect()->route('applications.index');
        // }
        $appMast = Applications::where('id', $id)->where('created_by', Auth::user()->id)->where('status', 'S')->first();
        // $stage = $appMast->stages->pluck('stage')->toArray();
        // $allStages = ['1', '2', '3', '4', '5', '6', '7', '8'];
        // $arrDiff1 = array_diff($stage, $allStages);
        // $arrDiff2 = array_diff($allStages, $stage);
        // $diff = array_merge($arrDiff1, $arrDiff2);
        // if ($diff) {
        //     alert()->error('Please complete previous sections first!', 'Attention!')->persistent('Close');
        //     return redirect()->back();
        // }
        $user = Auth::user();
        $app = $appMast->details;

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
        $old_reg_data = DB::Table('authorised_registered_detail')->where('app_id',$id)->where('created_by',Auth::user()->id)->first();
        $old_signatory = DB::Table('authorized_person_details')->where('user_id',Auth::user()->id)->where('status','A')->first();
        $old_corporate = DB::Table('authorised_corporate_detail')->where('created_by',Auth::user()->id)->where('status','A')->first();
        $proj = $appMast->projectVerticles;
        
        return view('user.app.show', compact(
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
            'ratings','old_reg_data','old_signatory','old_corporate'
        ));
    }
}
