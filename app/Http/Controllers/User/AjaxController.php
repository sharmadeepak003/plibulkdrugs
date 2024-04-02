<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AjaxController extends Controller
{
    public function getSegments($data)
    {
        $prods = explode(',',$data);
        $segs = DB::table('eligible_products')->whereIn('id', $prods)->orderBy('target_segment')->select('target_segment')->distinct('target_segment')->pluck('target_segment')->toArray();
        //dd($segs);
        return json_encode($segs);
    }

    public function getCity($state)
    {
        $cities = DB::table('pincodes')->where('state', $state)->orderBy('city')->get()->unique('city')->pluck('city', 'city');
        return json_encode($cities);
    }


    public function getPincode($city)
    {
        $pincodes = DB::table('pincodes')->where('city', $city)->orderBy('pincode')->get()->unique('pincode')->pluck('pincode');
        return json_encode($pincodes);
    }
}
