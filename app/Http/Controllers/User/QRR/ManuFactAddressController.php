<?php

namespace App\Http\Controllers\User\QRR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\ManufactureLocation;
use App\ManufactureProductCapacity;
use App\QRRMasters;
use Exception;


class ManuFactAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$qtr,$type)
    {   
        try{
            $qrr=QRRMasters::where('app_id',$id)->where('qtr_id',$qtr)->first();
            
            $apps=DB::table('approved_apps')->where('id',$id)->first();

            $app_dt=DB::table('approved_apps_details')->where('id',$id)->first();

            $fin_Data =substr($app_dt->approval_dt,0,10);
            
            $fy_year = DB::select("SELECT fin_year(?)",[$fin_Data]);

            $year= substr((end($fy_year)->fin_year),0,4);
        
            $prods = DB::table('eligible_products')
                ->where('id', $apps->eligible_product)->first();
            $qtrid = DB::Table('qrr_master')->where('app_id',$id)->first();

            if($qtrid){
                $qtrid = DB::Table('qtr_master')->where('qtr_id',$qtr)->select('qtr_master.qtr')->first();
                $qtrid_prev = DB::Table('qtr_master')->where('qtr',$qtrid->qtr-1)->select('qtr_master.qtr_id')->first();

                $address = DB::table('manufacture_location')->where('qtr_id',$qtrid_prev->qtr_id)->where('type',$type)->where('app_id',$id)->select('manufacture_location.address as prop_man_add')->first();
            }else{
                $address=DB::table('proposal_details')->where('app_id',$id)->first();
            }   
            
            
            $manu_loc = DB::table('manufacture_location')->where('app_id',$id)->where('type',$type)->where('qtr_id',$qtr)->get();
            $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');

            return view('user.qrr.manufact_address',compact('address','qrr','id','prods','qtr','type','manu_loc','states'));
        }catch(Exception $e){
            alert()->error('Data fetch wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            DB::transaction(function () use ($request) {
                    $qprDet = ManufactureLocation::create([
                        'app_id' => $request->app_id,
                        'qtr_id' => $request->qtr,
                        'type' => $request->type,
                        'address' =>$request->address,
                        'state' => $request->state,
                        'city' => $request->city,
                        'pincode' => $request->pincode,
                        'created_by' => Auth::user()->id,
                    ]);
            });

            $maxId= ManufactureLocation::orderby('id','desc')->select('id')->first();

            DB::transaction(function () use ($request, $maxId) {
                foreach ($request->madd as $proCap  ) {
                    $det = ManufactureProductCapacity::create([
                        'm_id' => $maxId->id,
                        'product' => $proCap['product'],
                        'capacity' => $proCap['capacity'],
                        'created_by' => Auth::user()->id
                    ]);
                }
            });

            alert()->success('Data Saved', 'Success')->persistent('Close');
            $mast=QRRMasters::where('app_id',$request->app_id)->where('qtr_id',$request->qtr)
            ->first();

            if(!$mast)
            return redirect()->route('qpr.create',['id'=>$request->app_id,'qrrName'=>$request->qtr]);
            else
            return redirect()->route('qpr.edit',$mast->id);
        }catch(Exception $e){
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$qtr,$type)
    {
        try{
            $loc=ManufactureLocation::where('id',$id)->first();
            $loc_id =$loc['id'];
            $qtrid = DB::Table('qtr_master')->where('qtr_id',$qtr)->select('qtr_master.qtr')->first();

            // if($qtrid->qtr){

            //     $qtrid_prev = DB::Table('qtr_master')->where('qtr',$qtrid->qtr-1)->select('qtr_master.qtr_id')->first();
            //     $loc=ManufactureLocation::where('qtr_id',$qtrid_prev->qtr_id)->where('app_id',$loc_id)->where('type',$type)->first();
            //     dd($loc_id,$qtrid);

            // }else{
                $loc=ManufactureLocation::where('id',$id)->first();
            // } 

            // dd($loc); 
            $qrr=QRRMasters::where('app_id',$loc['app_id'])->where('qtr_id',$qtr)->first();
            $productCapacity=ManufactureProductCapacity::where('m_id',$loc['id'])->get();
        
            $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');

            $city = DB::table('pincodes')->whereNotNull('city')->orderBy('city')->select('state','city')->get()->unique('city');

            return view('user.qrr.manufact_address_edit',compact('qrr','id','qtr','type'
            ,'loc','productCapacity','states','city','loc_id'));
        }catch(Exception $e){
            alert()->error('Data fetch wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            DB::transaction(function () use ($request,$id) {

                $qprDet=ManufactureLocation::where('id',$id)->first();
            
                $det=ManufactureProductCapacity::where('m_id',$id)->get();
                $qprDet->fill([
                    'address' => $request->address,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                    'created_by' => Auth::user()->id,
                ]);
                $qprDet->save();
                foreach ($request->madd as $proCap) {
                    if (isset($proCap['id'])) {
                        $pro = ManufactureProductCapacity::find($proCap['id']);
                        $pro->product = $proCap['product'];
                        $pro->capacity = $proCap['capacity'];
                        $pro->created_by  =Auth::user()->id;
                        $pro->save();
                    }else{
                        $det = ManufactureProductCapacity::create([
                            'm_id' => $id,
                            'product' => $proCap['product'],
                            'capacity' => $proCap['capacity'],
                            'created_by' => Auth::user()->id,
                        
                    ]);
                    }
                }
                
            
            });
            alert()->success('Data Saved', 'Success')->persistent('Close');
            return redirect()->back();
        }catch(Exception $e){
            alert()->error('Something went during Updation.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
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

    public function delete($id)
    {
        try{
            $manuloc=ManufactureLocation::where('id',$id)->first();
            $procap=ManufactureProductCapacity::where('m_id',$id)->get();
            
            $qrr=QRRMasters::where('app_id',$manuloc->app_id)->where('qtr_id',$manuloc->qtr_id)->first();
            
            if($manuloc){
                $manuloc->delete();
            }
            foreach($procap as $p){
                if($p){
                    $p->delete();
                }

            }
            alert()->success(' Deleted Successfully', 'Success')->persistent('Close');
            if($qrr==null){
                return redirect()->route('qpr.create',['id'=>$manuloc->app_id,'qrrName'=>$manuloc->qtr_id]);
            }else {
                return redirect()->route('qpr.edit',$qrr->id);
            }
        }catch(Exception $e){
            alert()->error('Data is not deleting.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
    }

    public function deleteProduct($id)
    {
        
        $procap=ManufactureProductCapacity::where('id',$id)->first();
        
                $procap->delete();
            
        alert()->success(' Deleted Successfully', 'Success')->persistent('Close');
        return redirect()->back(); 
    }
}
