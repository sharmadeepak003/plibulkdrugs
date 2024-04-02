<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //Overriding default email login with PAN login
    public function username()
    {
        $identity = request()->get('identity');
        $fieldname = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'pan';
        request()->merge([$fieldname => $identity]);
        return $fieldname;
    }

    protected function validateLogin(Request $request)
    {
        if ($this->username() == 'pan') {
            $validator = Validator::make($request->all(), [
                $this->username() => [
                    'required',
                    'size:10',
                    function ($attribute, $value, $fail) {
                        $user = User::where('pan', $value)->first();
                        if ($user && $user->isapproved == 'Y') {
                            return true;
                        }

                        return $fail('These credentials do not match our records.');
                    },
                ],
                'password' => 'required|string',
            ]);

            $validator->validate();
        } elseif ($this->username() == 'email') {
            $validator = Validator::make($request->all(), [
                $this->username() => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        $user = User::where('email', $value)->first();
                        if ($user && $user->hasRole(['Admin', 'Admin-Ministry']) && $user->isapproved == 'Y') {
                            return true;
                        }

                        return $fail('These credentials do not match our records.');
                    },
                ],
                'password' => 'required|string',
            ]);

            $validator->validate();
        }
    }

    protected function authenticated()
    {
        auth()->user()->update(['isotpverified' => 0]);
        if (Auth::user()->hasRole('Admin') or Auth::user()->hasRole('Admin-Ministry')) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('home');
    }
}
