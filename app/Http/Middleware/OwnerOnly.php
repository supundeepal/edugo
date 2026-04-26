<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OwnerOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // ලොග් වෙලා ඉන්නේ 'owner' කෙනෙක් නම් විතරක් ඇතුළට යන්න දෙනවා
        if (Auth::check() && Auth::user()->role === 'owner') {
            return $next($request);
        }

        // Owner නෙවෙයි නම් (උදා: Staff), Error පේජ් එකකට හරි Dashboard එකට හරි විසි කරනවා
        abort(403, 'Unauthorized Access! You are not allowed to view this page.');
    }
}