<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TeacherAuth
{
    public function handle(Request $request, Closure $next)
    {
        // ටීචර් ලොග් වෙලා නැත්නම්, ටීචර් ලොගින් එකට හරවලා යවනවා
        if (!Session::has('teacher_logged_in')) {
            return redirect('/teacher-login')->with('error', 'Please login to your portal!');
        }
        return $next($request);
    }
}