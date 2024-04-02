<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\RequestHd;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd($this->middleware('auth'));
        $this->middleware('auth');
    }

    public function index()
    {
         if (Auth::user()->hasrole('ActiveUser')) {

            $reqs =RequestHd::join('users','request_hd.user_id','=','users.id')
                            ->join('req_category','request_hd.cat_id','=','req_category.id')
                            ->join('req_category_subtype','request_hd.cat_subtype','=','req_category_subtype.id')
                            ->join('type_of_request','request_hd.type_of_req','=','type_of_request.id')
                            ->where('users.id',Auth::user()->id)
                            ->orderby('request_hd.status','desc')
                            ->orderby('request_hd.id')
                            ->get(['request_hd.*', 'users.name','req_category.category_desc','subtype_desc','type_of_request.type_desc']);
        // dd($reqs);

        return view('user.home',compact('reqs'));
         }else{
            $req_hd = RequestHd::where('user_id',Auth::user()->id);
            return view('admin.home');
         }

        // return view('home');
    }
}
