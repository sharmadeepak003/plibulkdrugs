<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //approved_apps
        $appDetail=DB::table('approved_apps_details')
        ->whereRaw('is_normal_user(approved_apps_details.user_id)=1')->get();
        $totalapproved= $appDetail->pluck('app_no')->count();

        //target_segment
        $ts1= $appDetail->where('target_segment_id',1)->pluck('app_no')->count();
        $ts2= $appDetail->where('target_segment_id',2)->pluck('app_no')->count();
        $ts3= $appDetail->where('target_segment_id',3)->pluck('app_no')->count();
        $ts4= $appDetail->where('target_segment_id',4)->pluck('app_no')->count();

        //employment
        $emp=DB::table('approved_apps')->join('employments','employments.app_id','=','approved_apps.id','left')->whereNotNull('approved_apps.app_no')->whereRaw('is_normal_user(approved_apps.created_by)=1')->distinct('approved_apps.app_no')->get('employments.fy28');
        $emp1=$emp->pluck('fy28')->toArray();
        $employment=array_sum($emp1);

        //Committed Investment
        $com=DB::table('approved_apps')->join('evaluation_details','evaluation_details.app_id','=','approved_apps.id','left')->whereRaw('is_normal_user(approved_apps.created_by)=1')
        ->whereNotNull('approved_apps.app_no')->distinct('approved_apps.app_no')->get('evaluation_details.investment');
        $com1=$com->pluck('investment')->toArray();
        $committedInvestment=number_format(array_sum($com1),2);

        //actual_investment
        $data = DB::table('qrr_master as qm')
            ->join('financial_progress as fp', 'fp.qrr_id', '=', 'qm.id')
            ->where('qm.status', 'S')
        ->get(['qm.id', 'qm.app_id', 'qm.qtr_id', 'fp.totcurrExpense']);
        $apps = DB::table('approved_apps')->whereRaw('is_normal_user(approved_apps.created_by)=1')->whereNotNull('app_no')->pluck('id')->toArray();
        $qtrs = DB::table('qtr_master')->orderBy('qtr_id', 'DESC')->pluck('qtr_id')->toArray();
        $acutual_sum = 0;
        foreach($apps as $app){
            foreach($qtrs as $qtr)
            {
                if($data->where('app_id', $app)->where('qtr_id', $qtr)->first()){
                    $act = $data->where('app_id', $app)->where('qtr_id', $qtr)->first();
                    $acutual_sum += $act->totcurrExpense;
                    break;
                }
            }
        }
        return view('admin.home',compact('appDetail','totalapproved','ts1','ts2','ts3','ts4','employment','acutual_sum','committedInvestment'));
    }
}
