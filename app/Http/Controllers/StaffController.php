<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // User මොඩල් එක පාවිච්චි කරනවා
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    // Staff ලිස්ට් එක පෙන්වනවා
    public function index() {
        $staffs = User::where('institute_id', Auth::user()->institute_id)
                      ->where('role', 'staff')
                      ->get();
        return view('staff', compact('staffs'));
    }

    // අලුත් Staff කෙනෙක්ව සේව් කරනවා
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email', // Laravel default users table එකේ email තියෙන නිසා
            'password' => 'required|min:6'
        ], [
            'email.unique' => 'This Username/Email is already taken!'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password), // Password එක encrypt කරනවා
            'role' => 'staff', // ⭐ Role එක 'staff' විදිහට සේව් කරනවා
            'institute_id' => Auth::user()->institute_id
        ]);

        return back()->with('success', 'Staff account created successfully!');
    }

    // Staff ව අයින් කරනවා
    public function destroy($id) {
        User::where('institute_id', Auth::user()->institute_id)
            ->where('id', $id)
            ->where('role', 'staff')
            ->delete();
            
        return back()->with('success', 'Staff account deleted!');
    }
}