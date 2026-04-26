<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerAuthController extends Controller
{
    // ==========================================
    // Owner Login 
    // ==========================================
    public function login(Request $request)
    {
        // පරණ ෆෝම් එකේ සමහරවිට 'username' කියලා ඇති, නැත්නම් 'email' කියලා ඇති. අපි දෙකම අල්ලගන්නවා.
        $email = $request->input('username') ?? $request->input('email');
        $password = $request->input('password');

       // Database එකේ ඉන්න 'owner' කෙනෙක්ද කියලා බලනවා
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => 'owner'])) {
            $request->session()->regenerate();
            // හරි නම් Dashboard එකට යවනවා (මෙතන /owner/dashboard තිබුණ එක /dashboard කරන්න)
            return redirect('/owner/dashboard');
        }

        // වැරදි නම් ආපහු ලොගින් පිටුවටම යවනවා
        return redirect()->back()->with('error', 'Invalid Credentials or You are not an Owner!');
    }


    // ==========================================
    // Staff Login 
    // ==========================================
    public function showStaffLoginForm() {
        // Staff ලොග් වෙලා නම් කෙලින්ම Dashboard එකට යවනවා
        if (Auth::check() && Auth::user()->role === 'staff') {
            return redirect('/dashboard'); 
        }
        return view('staff-login');
    }

    public function staffLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Email එකෙන් හරි Username එකෙන් හරි ලොග් වෙන්න පුළුවන් විදිහට හදනවා
        $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // ලොග් වෙන්න හදන්නේ 'staff' කෙනෙක්ද කියලා බලනවා
        if (Auth::attempt([$field => $request->email, 'password' => $request->password, 'role' => 'staff'])) {
            $request->session()->regenerate();
            // Staff ලොග් වුණාම Dashboard එකට යවනවා (එතන Owner විස්තර හැංගිලා තියෙන්නේ)
           return redirect('/staff/dashboard')->with('success', 'Logged in successfully as Staff!');
        }

        return back()->with('error', 'Invalid Credentials or You are not a Staff member!')->withInput();
    }


    // ==========================================
    // Global Logout (For both Owner & Staff)
    // ==========================================
    public function logout(Request $request)
    {
        // ලොග් අවුට් වෙන්න කලින් බලනවා කවුද මේ කියලා (Owner ද Staff ද)
        $role = Auth::check() ? Auth::user()->role : 'owner'; 

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ඊටපස්සේ අදාළ තැනට යවනවා
        if ($role === 'staff') {
            return redirect('/staff-login')->with('success', 'Staff Logged Out Successfully!');
        } else {
            return redirect('/owner-login')->with('success', 'Owner Logged Out Successfully!');
        }
    }
}