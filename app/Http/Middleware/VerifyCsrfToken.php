<?php

namespace App\Http\Middleware;
use Symfony\Component\HttpFoundation\Cookie;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    
    protected $except = [
        //
    ];


    protected function addCookieToResponse($request, $response)
    {
        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN',
                $request->session()->token(),
                time() + 60 * 120,
                '/',
                null,
                true, // Set this to true for secure.
                true // Set this to true for httponly.
            )
        );
        return $response;
    }


}
