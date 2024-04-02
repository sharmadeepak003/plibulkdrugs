<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\User;
use Mail;
use Illuminate\Support\Facades\Hash;

class LoginIDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_list =DB::table('users as u')->join('model_has_roles as mhr','u.id','=','mhr.model_id')->whereIn('mhr.role_id',['2','8'])->get();
        return view('admin.login',compact('admin_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role =DB::Table('roles')->whereIn('id',['2','8'])->get();

        return view('admin.login_create',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $email = User::where('email',$request->email_id)->first();
        $mobile = User::where('mobile',$request->mobile)->first();

        if($email || $mobile){
            alert()->error('Email or Mobile Number must be unique', 'Attention!')->persistent('Close');
            return redirect()->route('admin.login.create');
                    
        }

        DB::transaction(function () use ($request) {
            
            $user = User::create([
                'name'=>strtoupper($request->name),
                'email'=>$request->email_id,
                'mobile'=>$request->mobile,
                'email_verified_at'=>Carbon::now(),
                'mobile_verified_at'=>Carbon::now(),
                'password'=>Hash::make($request->password),
                'isapproved'=>'Y',
            ]);

            DB::insert('insert into model_has_roles values(?,?,?)',[$request->user_type,'App\User',$user->id]);

            $user = array('name' => strtoupper($request->name), 'email' => $request->email_id,'password'=>$request->password);

            Mail::send('emails.email_credentials', $user, function ($message) use ($user) {
                $message->to($user['email'])->subject('Your credentials for PLI Bulk Drugs portal');
                // $message->cc('bdpli@ifciltd.com');
            });

        });

        return redirect()->route('admin.create_id');
      
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
    public function edit($id)
    {
        //
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
        //
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

    public function update_status($status,$id)
    {
        $user = User::find($id);
            $user->isapproved= ($status == 'Y') ? 'N' : 'Y';
            $user->save();

        $val = ($status == 'Y') ? 'Deactive' : 'Active';

        alert()->success('ID has been '.$val.' successfully', 'Success!')->persistent('Close');

        return redirect()->route('admin.create_id');
    }
}
