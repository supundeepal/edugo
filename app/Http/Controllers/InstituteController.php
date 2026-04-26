<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstituteController extends Controller
{
    // අලුත් ආයතනයක් Database එකට සේව් කරන function එක
    public function store(Request $request)
    {
        // 1. එන ඩේටා ටික හරිද කියලා චෙක් කරනවා
        $request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
        ]);

        // 2. Database එකේ 'institutes' ටේබල් එකට ඩේටා ටික දානවා
        DB::table('institutes')->insert([
            'name' => $request->name,
            'owner_name' => $request->owner_name,
            'phone' => $request->phone,
            'city' => $request->city,
            'status' => 'Active', // අලුතින් හැදෙන ඒවා ඔටෝ Active වෙනවා
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. වැඩේ ඉවර වුණාම ආපහු කලින් පිටුවටම යනවා
        return redirect()->back()->with('success', 'Institute added successfully!');
    }// ආයතනයක විස්තර අප්ඩේට් කරන ෆන්ක්ෂන් එක
    public function update(Request $request, $id)
    {
        DB::table('institutes')->where('id', $id)->update([
            'name' => $request->name,
            'owner_name' => $request->owner_name,
            'phone' => $request->phone,
            'city' => $request->city,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Institute Updated Successfully!');
    }

    // ආයතනයක් සිස්ටම් එකෙන් මකලා දාන ෆන්ක්ෂන් එක
    public function destroy($id)
    {
        DB::table('institutes')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Institute Deleted Successfully!');
    }
}