<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Session එකේ ලොග් වෙලාද කියලා බලනවා
        if (!Session::has('superadmin_logged_in')) {
            // ලොග් වෙලා නැත්නම් ලොගින් පිටුවට විසි කරනවා
            return redirect('/superadmin/login')->with('error', 'Please login to access the dashboard!');
        }
        
        // ලොග් වෙලා නම් ඇතුළට යන්න දෙනවා
        return $next($request);
    }
}