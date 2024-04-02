<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

class BlockApplication
{
    // To block Application Editing and Submission after a certain date
    public function handle($request, Closure $next)
    {

            $checkDate = Carbon::parse('2022-08-24 23:59:00');
            if(Carbon::now()->gt($checkDate))
            {

                alert()->error('Application Window closed!', 'Info')->persistent('Close');
                return redirect()->route('applications.index');
            }
            else
            {

                return $next($request);
            }


    }
}
