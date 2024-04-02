<?php

namespace App\Http\Controllers\new_correspondence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class RequestSubtypeController extends Controller
{

    public function getSubtype($catid)
    {
        // dd($catid);
        $subtype = DB::table('req_category_subtype')
                    ->where('cat_id', $catid)
                    ->orderBy('cat_id')
                    ->get()
                    ->unique('subtype_desc')->pluck('id', 'subtype_desc');
                    // dd($subtype);
        return json_encode($subtype);
    }
    public function getSubtypeEmail($catid)
    {
        // dd($catid);
        $catRole=DB::table('category_role')->where('cat_id',$catid)
        ->where('user_id',Auth::user()->id)
        ->pluck('cat_subtype');
        $subtype = DB::table('req_category_subtype')
        ->where('cat_id', $catid)
        ->whereIn('id',$catRole)
        ->orderBy('cat_id')
        ->get()
        ->unique('subtype_desc')
        ->pluck('id', 'subtype_desc');
        // dd($subtype);
        return json_encode($subtype);
    }

    public function getReqType($catid,$subtype)
    {
        // dd($catid);
        $reqtype = DB::table('type_of_request')
                    ->where('cat_id', $catid)
                    ->where('cat_subtype', $subtype)
                    ->where('status','Y')
                    ->where('req_type','R')
                    ->orderBy('id')
                    ->get()
                    ->unique('type_desc')->pluck('id', 'type_desc');
        return json_encode($reqtype);
    }
public function getUserEmail($mobile)
    {
        // dd($catid);
        $reqtype = DB::table('users')
                    ->where('mobile', $mobile)
                    ->get()
                    ->pluck('id', 'email');
                    // dd($reqtype);
        return json_encode($reqtype);
    }


}
