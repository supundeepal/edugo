<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Session වෙනුවට දැන් අපි පාවිච්චි කරන්නේ Auth එක

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // ලොග් වෙලා ඉන්නේ 'Owner' කෙනෙක්ද කියලා හරියටම Database එකෙන් බලනවා
        if (!Auth::check() || Auth::user()->role !== 'owner') {
            
            // ලොග් වෙලා නැත්නම්, අපි අලුතින් හදපු Owner Login පිටුවට විසි කරනවා
            return redirect('/owner-login')->with('error', 'Please securely login to access your institute dashboard!');
        }
        
        return $next($request);
    }
}