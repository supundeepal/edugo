<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. ඇප් එකෙන් එවන දේවල් හරියට තියෙනවද බලනවා
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // 2. ඒ නමයි පාස්වර්ඩ් එකයි තියෙන කෙනෙක් Database එකේ ඉන්නවද බලනවා
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            
            $user = Auth::user(); // ලොග් වුණ කෙනාගේ විස්තර ගන්නවා

            // 3. ලොග් වුණා නම් ඇප් එකට මේ විස්තර ටික යවනවා (JSON විදිහට)
            return response()->json([
                'success' => true,
                'message' => 'සුපිරි! Login වුණා.',
                'user_name' => $user->name,
                'role' => $user->role // මේකෙන් තමයි Owner ද Staff ද බලන්නේ
            ]);

        } else {
            // 4. පාස්වර්ඩ් වැරදි නම් මේක යවනවා
            return response()->json([
                'success' => false,
                'message' => 'Username හෝ Password වැරදියි!'
            ], 401);
        }
    }
}