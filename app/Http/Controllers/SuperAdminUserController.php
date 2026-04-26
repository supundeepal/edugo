<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserController extends Controller
{
    public function store(Request $request)
    {
        // ඩේටා ටික Database එකේ users ටේබල් එකට දානවා
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            // Password එක අනිවාර්යයෙන්ම Hash (කේතනය) කරලා තමයි සේව් කරන්නේ ආරක්ෂාවට! 🔒
            'password' => Hash::make($request->password), 
            'role' => 'owner',
            'institute_id' => $request->institute_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'User Account Created Successfully!');
    }// User ගේ විස්තර අප්ඩේට් කරන ෆන්ක්ෂන් එක
    public function update(Request $request, $id)
    {
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'institute_id' => $request->institute_id,
            'updated_at' => now(),
        ];

        // පාස්වර්ඩ් එකක් අලුතින් ගහලා තියෙනවා නම් විතරක් ඒක අප්ඩේට් කරනවා
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($updateData);

        return redirect()->back()->with('success', 'User Updated Successfully!');
    }

    // User ව මකන ෆන්ක්ෂන් එක
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully!');
    }

// ==========================================
    // SMS Wallet Management
    // ==========================================
    public function smsWallets() {
        // ආයතන ටික සහ ඒවගේ දැනට තියෙන balance එක ගන්නවා
        $institutes = \Illuminate\Support\Facades\DB::table('institutes')->get();
        
        // අන්තිමට කරපු Top-ups ලිස්ට් එක ගන්නවා
        $recentTopups = \App\Models\SmsTopup::join('institutes', 'sms_topups.institute_id', '=', 'institutes.id')
                            ->select('sms_topups.*', 'institutes.name as institute_name')
                            ->latest()
                            ->take(10)
                            ->get();

        return view('superadmin.sms-wallets', compact('institutes', 'recentTopups'));
    }

    public function topupSmsWallet(\Illuminate\Http\Request $request) {
        $request->validate([
            'institute_id' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        // 1. ආයතනයේ sms_balance එකට සල්ලි එකතු කරනවා
        \Illuminate\Support\Facades\DB::table('institutes')
            ->where('id', $request->institute_id)
            ->increment('sms_balance', $request->amount);

        // 2. හිස්ට්‍රි එක සේව් කරනවා
        \App\Models\SmsTopup::create([
            'institute_id' => $request->institute_id,
            'amount' => $request->amount,
            'reference_note' => $request->reference_note ?? 'Admin Top-up',
        ]);

        return back()->with('success', 'SMS Wallet successfully topped up by Rs. ' . number_format($request->amount, 2));
    }    }