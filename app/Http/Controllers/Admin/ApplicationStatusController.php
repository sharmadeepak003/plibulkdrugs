<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

use App\Exports\ApplicationStatusExport;
use Maatwebsite\Excel\Facades\Excel;

use App\ApplicationMast;
use App\ApplicationMastRound1;
use App\ApplicationMastRound2;
use App\Applications;
use App\ApplicationStatus;

class ApplicationStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin'], ['only' => ['create','store','edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps=DB::table('applications')
                ->join('application_statuses','application_statuses.app_id','=','applications.id','left')
                ->join('application_status_role','application_status_role.id','=','application_statuses.flage_id','left')
                // ->join('model_has_roles','model_has_roles.model_id','=','applications.created_by')
                // ->where('model_has_roles.model_id','!=',10)
                ->whereRaw('is_normal_user(applications.created_by)=1')
                ->select('applications.*','application_statuses.flage_id','application_status_role.flag_name')
                ->get();
    // dd($apps);
        return view('admin.appstatus.ApplicationStatus',compact('apps',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $appMast = Applications::where('id', $id)
                ->where('status', 'S')
                ->first();
        // dd($appMast);
        return view('admin.appstatus.ApplicationStatus_create',compact('appMast'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::transaction(function () use ($request) {
            
            if($request->approval_dt){
                $round_data=DB::table('applications')->where('id',$request->app_id)->select('applications.round')->first();

                if($round_data->round== 4){
                    $approval_dt= DB::table('application_mast')->where('id', $request->app_id)->update([
                        'approval_dt' =>$request->approval_dt,
                    ]);
                }elseif($round_data->round==3){
                    $approval_dt= DB::table('application_mast')->where('id', $request->app_id)->update([
                        'approval_dt' =>$request->approval_dt,
                    ]);
                
                }elseif($round_data->round==1){
            
                    $approval_dt= DB::table('application_mast_round1')->where('id', $request->app_id)->update([
                        'approval_dt' =>$request->approval_dt,
                    ]);
                }elseif($round_data->round==2){
            
                    $approval_dt= DB::table('application_mast_round2')->where('id', $request->app_id)->update([
                        'approval_dt' =>$request->approval_dt,
                    ]);
                }
            }

            ApplicationStatus::create([
                'app_id' =>$request->app_id,
                'created_by'=>$request->created_by,
                'flage_id' => $request->flage_id,
                'remarks'=>($request->remarks) ? $request->remarks : null,
                'old_approval_dt' => null,
            ]);

            alert()->success('!! Data Save !!', 'Success')->persistent('Close');
        });
        return redirect()->route('admin.appstatus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApplicationStatus  $applicationStatus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    //    dd($id);

    $apps=DB::table('applications')
        ->join('application_statuses','application_statuses.app_id','=','applications.id')
        ->join('application_status_role','application_status_role.id','=','application_statuses.flage_id')
        ->where('applications.status','S')
        ->where('applications.id',$id)
        ->select('applications.id','applications.name','applications.product','applications.app_no','applications.status','applications.target_segment','applications.created_at','applications.submitted_at','application_status_role.flag_name','applications.approval_dt','application_statuses.remarks')
        ->first();

    // dd($apps);

        return view('admin.appstatus.ApplicationStatus_view',compact('apps'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplicationStatus  $applicationStatus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $appMast=DB::table('applications')
            ->join('application_statuses','application_statuses.app_id','=','applications.id')
            ->join('application_status_role','application_status_role.id','=','application_statuses.flage_id')
            ->where('applications.status','S')
            ->where('applications.id',$id)
            ->select('applications.id','applications.name','applications.product','applications.app_no','applications.status','applications.target_segment','applications.created_at','applications.submitted_at','application_status_role.flag_name','applications.approval_dt')
            ->first();
        return view('admin.appstatus.ApplicationStatus_edit',compact('appMast'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplicationStatus  $applicationStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $appstatus=ApplicationStatus::where('app_id',$id)->first();

        DB::transaction(function () use ($appstatus,$request,$id) {
            $round_data=DB::table('applications')->where('id',$id)->select('applications.round')->first();
            
            if($round_data->round==3){
                if($request->approval_dt){
                    $old_dt=null;
                    $approval_dt= DB::table('application_mast')->where('id', $id)->update([
                        'approval_dt' =>$request->approval_dt,
                    ]);
                }else{

                    $withdrawn=DB::table('application_mast')->where('id',$id)->select('application_mast.approval_dt')->first();
                    $old_dt=$withdrawn->approval_dt;
                    $approval_dt= DB::table('application_mast')->where('id', $id)->update([
                        'approval_dt' =>null,
                    ]);
                }
            }elseif($round_data->round==1){
                if($request->approval_dt){
                    $old_dt=null;
                    $approval_dt= DB::table('application_mast_round1')->where('id', $id)->update([
                        'approval_dt' =>$request->approval_dt,
                    ]);
                }else{
                    $withdrawn=DB::table('application_mast_round1')->where('id',$id)->select('application_mast_round1.approval_dt')->first();
                    $old_dt=$withdrawn->approval_dt;
                    $approval_dt= DB::table('application_mast_round1')->where('id', $id)->update([
                        'approval_dt' =>null,
                    ]);
                }
            }elseif($round_data->round==2){
                if($request->approval_dt){
                    $old_dt=null;
                    $approval_dt= DB::table('application_mast_round2')->where('id', $id)->update([
                        'approval_dt' =>$request->approval_dt,
                    ]);
                }else{
                    $withdrawn=DB::table('application_mast_round2')->where('id',$id)->select('application_mast_round2.approval_dt')->first();
                    $old_dt=$withdrawn->approval_dt;
                    $approval_dt= DB::table('application_mast_round2')->where('id', $id)->update([
                        'approval_dt' =>null,
                    ]);
                }

                // dd('hello bye');

            }

            $appstatus->fill([
                'app_id' =>$request->app_id,
                'created_by'=>$request->created_by,
                'flage_id' => $request->flage_id,
                'remarks'=>($request->remarks) ? $request->remarks : null,
                'old_approval_dt' => $old_dt,
            ]);

            $appstatus->save();
        });
        alert()->success('Data Update', 'Success')->persistent('Close');

        return redirect()->route('admin.appstatus.index');
    }



    public function appstatusExport()
    {
        // dd("Hello");
        return Excel::download(new  ApplicationStatusExport, 'ApplicationStatus.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplicationStatus  $applicationStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationStatus $applicationStatus)
    {
        //
    }
}
