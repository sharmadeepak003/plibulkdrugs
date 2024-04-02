<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ManufactureLocation;
use App\QRRMasters;
use DB;
use Auth;
use App\ManufactureProductCapacity;

class QrrLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd('hello');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$qtr_id)
    {

        $appdata=QrrMasters::join('approved_apps_details as a','a.id','=','qrr_master.app_id')
        ->join('qtr_master','qtr_master.qtr_id','=','qrr_master.qtr_id')
        ->where('qrr_master.qtr_id',$qtr_id)
        ->where('qrr_master.id',$id)
        ->where('qtr_master.qtr_id',$qtr_id)
        ->whereNotNull('a.app_no')
	    ->distinct()
        ->select('a.app_no','a.name','a.target_segment','a.product','qrr_master.qtr_id','qtr_master.month','qtr_master.year')
        ->get();

        $qrr=QRRMasters::where('id',$id)->where('qtr_id',$qtr_id)->first();
        
        $loc=ManufactureLocation::where('app_id',$qrr->app_id)->where('qtr_id',$qtr_id)->where('type','green')->first();
        // dd($id,$qtr_id,$qrr->app_id,$loc);
        // $productCapacity=ManufactureProductCapacity::where('m_id',$loc['id'])->get();
        //dd($qtr,$id,$qrr,$loc,$productCapacity);
        $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');

        $city = DB::table('pincodes')->whereNotNull('city')->orderBy('city')->get()->unique('city')->pluck('city', 'city');

        return view('admin.qrr.qrr_location',compact('qrr','id','qtr_id','loc','states','city','appdata'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        
        //  dd(Auth::user()->id,$request->remarks);
        DB::transaction(function () use ($request,$id) {
            $qprDet=ManufactureLocation::where('id',$id)->first();
            $qprDet->fill([
                'address' => $request->address,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'changes_by' => Auth::user()->id,
                'remarks' => $request->remarks,
            ]);
            $qprDet->save();
            
        });
        alert()->success('Data Saved', 'Success')->persistent('Close');
       
        return redirect()->back();
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
