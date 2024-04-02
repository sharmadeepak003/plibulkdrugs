<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Registration;
use Auth;
use Mail;
use App\Mail\NewRegistration;
use DB;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/verifyuser';

    public function __construct()
    {
        $this->middleware('guest');
		$this->middleware('BlockApplication');
    }

    public function showRegistrationForm()
    {
        $tar_seg =  DB::table('eligible_products')->select('target_segment')->distinct()->orderBy('target_segment')->pluck('target_segment');
        $prods = DB::table('eligible_products')->where('round',4)->get();
		
        // dd($prods);
        return view('auth.register', compact('prods', 'tar_seg'));
    }

    protected function validator(array $data)
    {
        //For Debugging, Go to network tab in browser Devtools
        return Validator::make($data, Registration::$rules);
    }

    protected function create(array $data)
    {
        // dd($data);
        // dd('Application Window Closed');
        if ($data['existing_manufacturer'] == 'N' and $data['setup_project'] == 'N') {
            alert()->error('Registration formality cannot be allowed', 'Error!')->persistent('Close');
            return redirect()->route('register');
        }
        return User::create([
            'name' => strtoupper($data['name']),
            'type' => $data['type'],
            'pan' => strtoupper($data['pan']),
            'cin_llpin' => strtoupper($data['cin_llpin']),
            'off_add' => strtoupper($data['off_add']),
            'off_city' => strtoupper($data['off_city']),
            'off_state' => strtoupper($data['off_state']),
            'off_pin' => $data['off_pin'],
            'existing_manufacturer' => $data['existing_manufacturer'],
            'business_desc' => $data['business_desc'] ?? '',
            'applicant_desc' => $data['applicant_desc'] ?? '',
            'eligible_product' => $data['eligible_product'],
            'contact_person' => strtoupper($data['contact_person']),
            'designation' => strtoupper($data['designation']),
            'contact_add' => strtoupper($data['contact_add']),
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'isapproved' => 'Y',
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $user->assignRole('ActiveUser');

        try {
            Mail::to($user->email)
                ->cc('bdpli@ifciltd.com')
                ->send(new NewRegistration($user));
        } catch (\Exception $e) {
            return redirect()->route('/verifyuser');
        }
    }
}
