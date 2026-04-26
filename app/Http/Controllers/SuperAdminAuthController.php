<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SuperAdminAuthController extends Controller
{
    // Super Admin ලොගින් පිටුව පෙන්වීම
    public function showLogin()
    {
        return view('superadmin.login');
    }

    // ඊමේල් පාස්වර්ඩ් චෙක් කිරීම
    public function login(Request $request)
    {
        // Super Admin ට විතරක් යන්න පුළුවන් Master Email එකයි Password එකයි
        if ($request->email == 'admin@edugo.lk' && $request->password == 'admin123') {
            
            // හරි නම් 'superadmin_logged_in' කියලා Session එකක් හදනවා
            Session::put('superadmin_logged_in', true);
            return redirect('/superadmin/dashboard');
        }

        // වැරදි නම් ආපහු හරවලා යවනවා
        return redirect()->back()->with('error', 'Invalid Credentials! Only Super Admin can access.');
    }

    // ලොග් අවුට් වීම
    public function logout()
    {
        Session::forget('superadmin_logged_in'); // ලොක් එක කඩලා දානවා
        return redirect('/superadmin/login')->with('success', 'Logged out successfully!');
    }
}