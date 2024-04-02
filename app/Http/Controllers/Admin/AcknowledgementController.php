<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\ApplicationMast;
use App\ApplicationMastRound1;
use App\ApplicationMastRound2;
use App\Applications;

class AcknowledgementController extends Controller
{
    public function index()
    {
        $apps=Applications::orderBy('app_no')
        ->where('status','S')
        ->whereRaw('is_normal_user(applications.created_by)=1')
        ->where('app_no', '!=' , '')
        ->select('applications.*')
        ->get();

        $user =DB::table('users')->get();
        $eligible_pro = DB::table('eligible_products')->get();


        return view('admin.acknowledgement.ackdashboard', compact('apps','eligible_pro','user'));
    }

    public function show($app_no)
    {
        $appMast=Applications::where('id', $app_no)->where('status', 'S')->first();

       // $app = $appMast->details;
        $app=DB::table('company_details')->where('app_id',$appMast->id)->where('created_by',$appMast->created_by)->first();

        $eligible_pro = DB::table('eligible_products')->get();
        $user = DB::table('users')->where('id',$appMast->created_by)->first();
        $elgb = $appMast->eligibility;
        $fees = $appMast->fees;
        $evalDet = $appMast->evaluations;
        //dd($app,$user,$elgb,$fees,$evalDet);
        return view('admin.acknowledgement.show', compact('appMast','app','user','eligible_pro','elgb','fees','evalDet'));
    }

    public function print($app_no)
    {

        $appMast=Applications::where('id', $app_no)->where('status', 'S')->first();
        //$app = $appMast->details;
        $app=DB::table('company_details')->where('app_id',$appMast->id)->where('created_by',$appMast->created_by)->first();

        $eligible_pro = DB::table('eligible_products')->get();
        $user = DB::table('users')->where('id',$appMast->created_by)->first();
        $elgb = $appMast->eligibility;
        $fees = $appMast->fees;
        $evalDet = $appMast->evaluations;
        return view('admin.acknowledgement.print', compact('appMast','app','user','eligible_pro','elgb','fees','evalDet'));
    }

}
