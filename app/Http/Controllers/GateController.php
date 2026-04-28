<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Events\StudentScanned;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache; // 👈 ෆෝන් එකට සිග්නල් දෙන්න

class GateController extends Controller
{
    // ==============================================================
    // 1. අලුත් QR Scanner පිටුව පෙන්වීම (Web Camera Scan)
    // ==============================================================
    public function scanPage() {
        return view('scan-attendance');
    }

    // ==============================================================
    // 2. Web එකෙන් QR එක ස්කෑන් කළාම වෙන දේ (AJAX Process)
    // ==============================================================
    public function processScan(Request $request) {
        
        $scannedId = $request->student_id; 

        $student = Student::with('courses')
                    ->where('card_number', $scannedId)
                    ->orWhere('id', $scannedId)
                    ->first();
        
        if ($student) {
            Attendance::firstOrCreate([
                'student_id' => $student->id,
                'date' => Carbon::today()->toDateString(),
            ], [
                'time' => Carbon::now()->toTimeString()
            ]);

            $attendedDays = Attendance::where('student_id', $student->id)->distinct('date')->count('date');
            
            $billableDays = $attendedDays; 
            $totalArrears = 0;

            foreach ($student->courses as $course) {
                if (trim(strtolower($course->fee_type)) !== 'monthly') {
                    $paidAmount = Payment::where('student_id', $student->id)->where('course_id', $course->id)->sum('amount');
                    $totalExpected = $billableDays * $course->fee;
                    
                    $totalDue = $totalExpected - $paidAmount;
                    if ($totalDue > 0) {
                        $totalArrears += $totalDue; 
                    }
                }
            }

            $msg = 'Attendance Marked Successfully!';
            if ($totalArrears > 0) {
                $msg = 'Access Granted! (Arrears: Rs. ' . number_format($totalArrears, 2) . ')';
            }

            // 💥 මෙන්න මේකයි අලුත් කෑල්ල! ලැප් එකෙන් වැඩේ ඉවර කරපු ගමන් ෆෝන් එකට "Completed" කියලා යවනවා!
            Cache::put('scan_status_' . $scannedId, 'completed', now()->addMinutes(5));

            return response()->json([
                'status' => 'success', 
                'student_name' => $student->name, 
                'message' => $msg, 
                'arrears' => $totalArrears,
                'student' => $student
            ]);
        }
        
        return response()->json([
            'status' => 'error', 
            'message' => 'Invalid QR / Not Registered!'
        ]);
    }

    // ==============================================================
    // 3. Mobile Phone එකෙන් ස්කෑන් කරද්දී වැඩ කරන තැන
    // ==============================================================
    public function mobileScan(Request $request)
    {
        $cardNumber = $request->input('card_number');

        if($cardNumber) {
            try {
                // 💥 FIX: index_no කෑල්ල සම්පූර්ණයෙන්ම අයින් කළා!
                $student = Student::where('card_number', $cardNumber)
                                  ->orWhere('id', $cardNumber)
                                  ->first();
                
                // 2. ෆොටෝ එක හදාගන්නවා
                $photoUrl = ($student && $student->photo) ? '/storage/' . $student->photo : null;

                // 💥 FIX: ලැප් එකට යවන්නේ නියම Card Number එක! අමු QR කේතය නෙවෙයි.
                $broadcastNumber = $student ? $student->card_number : $cardNumber;
                
                // 3. ලැප් එකට ඉවෙන්ට් එක යවනවා (නියම Card Number එකෙන්)
                event(new StudentScanned($broadcastNumber));

                // 4. ෆෝන් එකට 'pending' කියලා සේව් කරනවා ලැප් එකෙන් ඉවර කරනකම්
                Cache::put('scan_status_' . $cardNumber, 'pending', now()->addMinutes(5));

                return response()->json([
                    'status' => 'success', 
                    'message' => 'Scan broadcasted successfully to laptop!',
                    'student_name' => $student ? $student->student_name : 'Unknown Student',
                    'photo_url' => $photoUrl
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Broadcast Error: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => 'error', 
            'message' => 'No card number found!'
        ], 400);
    }

    // ==============================================================
    // 3.5 ෆෝන් එකෙන් තත්පරෙන් තත්පරේ "ලැප් එකේ වැඩ ඉවරද" කියලා අහන තැන
    // ==============================================================
    public function checkMobileStatus($cardNumber) {
        // 💥 FIX: මෙතනත් index_no කෑල්ල සම්පූර්ණයෙන්ම අයින් කළා!
        $student = Student::where('card_number', $cardNumber)
                          ->orWhere('id', $cardNumber)
                          ->first();
                          
        $actualCardNumber = $student ? $student->card_number : $cardNumber;

        $status1 = Cache::get('scan_status_' . $cardNumber, 'pending');
        $status2 = Cache::get('scan_status_' . $actualCardNumber, 'pending');

        $finalStatus = ($status1 === 'completed' || $status2 === 'completed') ? 'completed' : 'pending';

        return response()->json(['status' => $finalStatus]);
    }

    // ==============================================================
    // 4. Mobile Phone එකෙන් ලොග් වෙන තැන (Login API)
    // ==============================================================
    public function mobileLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            
            $user = Auth::user();
            $token = $user->createToken('MobileScannerApp')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login Successful!',
                'token' => $token,
                'user' => [
                    'name' => $user->name,
                    'role' => $user->role,
                    'institute_id' => $user->institute_id ?? null 
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid Email or Password!'
        ], 401);
    }
}