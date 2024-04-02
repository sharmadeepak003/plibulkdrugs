<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\ApplicationMast;
use App\SMS;
use DB;
use App\Mail\NewRegistration;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->assignRole('ActiveUser');

        try {
            Mail::to($user->email)
                ->cc('bdpli@ifciltd.com')
                ->send(new NewRegistration($user));
        } catch (\Exception $e) {
            return redirect()->route('verifyUser');
        }

        dd('haha');
    }
}
