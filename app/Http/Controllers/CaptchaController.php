<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CaptchaController extends Controller
{
    public function generateCaptcha()
    {
        $captcha = $this->generateRandomString(6); // Adjust the length as needed

        // Store the CAPTCHA string in the session
        Session::put('captcha', $captcha);

        // Create a simple response with the CAPTCHA string
        // return response()->json(['captcha' => $captcha]);

            header("Content-type: image/png");
            // $captcha = $this->generateRandomString(6);
            $img_handle = ImageCreate (60, 22) or die ("Es imposible crear la imagen"); 
            $back_color = ImageColorAllocate($img_handle,102,102,153); 
            $txt_color = ImageColorAllocate($img_handle,255,255,255); 
            ImageString($img_handle, 31, 5, 0, $captcha, $txt_color); 
           
          
            Session::put('captcha', $captcha);
            // $_SESSION['img_number'] = $str;
            return  Imagepng($img_handle); 

            

    }

    private function generateRandomString($length)
    {
        return Str::random($length);
    }
}