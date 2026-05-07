<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            // Prevents browsers from MIME-sniffing a response away from the declared content-type
            'X-Content-Type-Options', 'nosniff'
        );

        $response->headers->set(
            // Blocks the page from being put in an iframe — prevents clickjacking attacks
            'X-Frame-Options', 'SAMEORIGIN'
        );

        $response->headers->set(
            // Enables the browser's built-in XSS filter
            'X-XSS-Protection', '1; mode=block'
        );

        $response->headers->set(
            // Controls how much referrer info is included with requests
            'Referrer-Policy', 'strict-origin-when-cross-origin'
        );

        $response->headers->set(
            // Prevents the browser from loading any resources not explicitly allowed
            // Adjust these rules if you add external CDNs or APIs
            'Content-Security-Policy',
            implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' https://code.jquery.com https://cdnjs.cloudflare.com",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
                "font-src 'self' https://fonts.gstatic.com",
                "img-src 'self' data: https:",
                "connect-src 'self'",
                "frame-ancestors 'none'",
            ])
        );

        $response->headers->set(
            // Restricts browser features like camera, microphone, geolocation
            'Permissions-Policy', 'camera=(), microphone=(), geolocation=()'
        );

        return $response;
    }
}