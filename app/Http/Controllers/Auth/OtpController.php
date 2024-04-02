<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OtpRequest;
use Carbon\Carbon;
use Redirect;
use Auth;
use Session;

class OtpController extends Controller
{
    public function verifyMobileForm()
    {
        $isVerified = Auth::user()->mobile_verified_at;
        if ($isVerified) {
            return redirect()->route('home');
        } else {
            return view('auth.verifyMobile');
        }
    }

    public function verifyMobile(OtpRequest $request)
    {
        $enteredOtp = (int)$request->input('otp');
        $userId = Auth::user()->id;

        if ($userId == "" || $userId == null) {
            $response['error'] = 1;
            $response['message'] = 'You are logged out, Login again.';
        } else {
            $OTP = $request->session()->get('verifyOTP');
            if ($OTP === $enteredOtp) {
                auth()->user()->update(['mobile_verified_at' => Carbon::now()]);
                auth()->user()->update(['isotpverified' => 1]);

                Session::forget('verifyOTP');
                $response['error'] = 0;

                if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Admin-Ministry')) {
                    return redirect()->route('admin.home');
                }

                return redirect()->route('home');
            } else {
                $response['error'] = 1;
                return Redirect::back()->withErrors(['otp' => ['OTP is invalid or expired']]);
            }
        }
    }

    public function getLoginOTP()
    {
        return view('auth.loginOTP');
    }

    public function verifyLoginOTP(OtpRequest $request)
    {
        //dd($request);
        $enteredOtp = (int)$request->input('otp');
        $userId = Auth::user()->id;

        if ($userId == "" || $userId == null) {
            $response['error'] = 1;
            $response['message'] = 'You are logged out, Login again.';
        } else {
            $OTP = $request->session()->get('loginOTP');
            if ($OTP === $enteredOtp) {
                auth()->user()->update(['isotpverified' => 1]);

                Session::forget('loginOTP');
                $response['error'] = 0;

                if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Admin-Ministry')) {
                    return redirect()->route('admin.home');
                }

                return redirect()->route('home');
            } else {
                $response['error'] = 1;
                return Redirect::back()->withErrors(['otp' => ['OTP is invalid or expired']]);
            }
        }
    }
}
