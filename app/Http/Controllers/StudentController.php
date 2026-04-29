<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Course;
use App\Models\Teacher; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache; 

class StudentController extends Controller
{
    // ==========================================
    // 2. Dashboard
    // ==========================================
    public function dashboard() {
        $institute_id = Auth::user()->institute_id;

        // --- OWNER ට පේන මුළු විස්තර ---
        $totalStudents = Student::where('institute_id', $institute_id)->count();
        
        $todayAttendance = Attendance::where('institute_id', $institute_id)
                                     ->whereDate('created_at', Carbon::today())
                                     ->count();
        
        $totalIncome = Payment::where('institute_id', $institute_id)->sum('amount');
        
        $totalTeachers = DB::table('institute_teacher')
                           ->where('institute_id', $institute_id)
                           ->count();

        $attendanceData = Attendance::where('institute_id', $institute_id)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();


        // --- ⭐ STAFF ට පේන අද දවසේ එකතුව ---
        $my_today_collection = 0;
        $my_today_payments_count = 0;

        if (Auth::user()->role === 'staff') {
            $user_id = Auth::id(); // ලොග් වෙලා ඉන්න Staff කෙනාගේ ID එක
            
            // මේ Staff කෙනා අද දවසේ එකතු කරපු මුළු මුදල
            $my_today_collection = Payment::where('institute_id', $institute_id)
                ->where('user_id', $user_id) 
                ->whereDate('created_at', Carbon::today())
                ->sum('amount');

            // මේ Staff කෙනා අද දවසේ කඩපු බිල් ගාණ
            $my_today_payments_count = Payment::where('institute_id', $institute_id)
                ->where('user_id', $user_id)
                ->whereDate('created_at', Carbon::today())
                ->count();
        }

        return view('dashboard', compact(
            'totalStudents', 
            'todayAttendance', 
            'totalIncome', 
            'totalTeachers', 
            'attendanceData',
            'my_today_collection', 
            'my_today_payments_count' 
        ));
    }

    // ==========================================
    // 3. Student Registration 
    // ==========================================
    public function index()
    {
        $institute_id = Auth::user()->institute_id;
        $courses = Course::where('institute_id', $institute_id)->get();
        
        // --- ඊළඟ ළමයාගේ අංකය Auto හදන කෑල්ල ---
        $lastStudent = Student::where('institute_id', $institute_id)->orderBy('id', 'desc')->first();
        
        $lastNumber = $lastStudent ? intval(preg_replace('/[^0-9]/', '', $lastStudent->card_number)) : 0; 
        
        $nextCardNumber = sprintf('%03d', $lastNumber + 1);

        return view('register', compact('courses', 'nextCardNumber'));
    }

    public function store(Request $request) {
        $institute_id = Auth::user()->institute_id;

        $request->validate([
            'card_number' => [
                'required',
                Rule::unique('students', 'card_number')->where('institute_id', $institute_id)
            ],
            'student_name' => 'required',
        ], [
            'card_number.unique' => 'This card number is already in use in your institute!!',
        ]);

        $data = $request->except('phone');
        $data['parent_phone'] = $request->phone;
        
        $data['institute_id'] = $institute_id; 

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/student_photos'), $filename);
            $data['photo'] = 'student_photos/' . $filename;
        }
        
        $student = Student::create($data);
        
        if($request->has('courses')) { 
            $student->courses()->attach($request->courses); 
        }
        return redirect('/students')->with('success', 'Student registered successfully!');
    }

    // ==========================================
    // 4. Student List
    // ==========================================
    public function list(Request $request) {
        $institute_id = Auth::user()->institute_id;
        $query = Student::with('courses')->where('institute_id', $institute_id);
        
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('student_name', 'like', '%' . $request->search . '%')
                  ->orWhere('card_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('course') && $request->course != '') {
            $query->whereHas('courses', function($q) use ($request) {
                $q->where('courses.id', $request->course); 
            });
        }

        if ($request->has('teacher') && $request->teacher != '') {
            $query->whereHas('courses', function($q) use ($request) {
                $q->where('teacher_id', $request->teacher); 
            });
        }

        $students = $query->get();
        
        $courses = Course::where('institute_id', $institute_id)->get(); 
        
        $teachers = Teacher::join('institute_teacher', 'teachers.id', '=', 'institute_teacher.teacher_id')
                           ->where('institute_teacher.institute_id', $institute_id)
                           ->select('teachers.*')
                           ->get();

        return view('list', compact('students', 'courses', 'teachers'));
    }

    // ==========================================
    // 5. Profile & ID Card
    // ==========================================
    public function showProfile($id) {
        $student = Student::with(['courses', 'attendances', 'payments.course'])
                          ->where('institute_id', Auth::user()->institute_id)
                          ->findOrFail($id);
        $payments = $student->payments; 
        return view('profile', compact('student', 'payments'));
    }

    public function generateIDCard($id) {
        $student = Student::where('institute_id', Auth::user()->institute_id)->findOrFail($id); 
        return view('id_card', compact('student'));
    }

    // ==========================================
    // 6. Edit, Update & Delete Student 
    // ==========================================
    public function edit($id)
    {
        $student = Student::with('courses')->where('institute_id', Auth::user()->institute_id)->findOrFail($id);
        $courses = Course::where('institute_id', Auth::user()->institute_id)->get();
        return view('edit_student', compact('student', 'courses'));
    }

    public function update(Request $request, $id) {
        $student = Student::where('institute_id', Auth::user()->institute_id)->findOrFail($id); 
        
        $data = $request->except('phone');
        if ($request->has('phone')) {
            $data['parent_phone'] = $request->phone;
        }
        
        if ($request->hasFile('photo')) {
            if ($student->photo && file_exists(public_path('storage/' . $student->photo))) { 
                unlink(public_path('storage/' . $student->photo)); 
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/student_photos'), $filename);
            $data['photo'] = 'student_photos/' . $filename;
        }

        $student->update($data);
        
        if($request->has('courses')) { 
            $student->courses()->sync($request->courses); 
        }
        return redirect('/students')->with('success', 'Student details updated!');
    }

    public function destroy($id) {
        $student = Student::where('institute_id', Auth::user()->institute_id)->find($id);
        if ($student) {
            if ($student->photo && file_exists(public_path('storage/' . $student->photo))) { 
                unlink(public_path('storage/' . $student->photo)); 
            }
            $student->delete();
            return redirect('/students')->with('success', 'Student deleted successfully!');
        }
        return redirect('/students')->with('error', 'Student not found or access denied.');
    }

    // ==========================================
    // 7. Payment System
    // ==========================================
    public function showPaymentForm(Request $request) { 
        $query = Student::where('institute_id', Auth::user()->institute_id);
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('student_name', 'like', '%' . $request->search . '%')
                  ->orWhere('card_number', 'like', '%' . $request->search . '%');
            });
        }
        $students = $query->get(); 
        $courses = Course::where('institute_id', Auth::user()->institute_id)->get(); 
        return view('payment', compact('students', 'courses')); 
    }
    
    public function storePayment(Request $request) {
        $payment = Payment::create([
            'student_id' => $request->student_id, 
            'course_id' => $request->course_id,
            'amount' => $request->amount, 
            'payment_type' => date('F'),
            'payment_date' => Carbon::today()->toDateString(), 
            'institute_id' => Auth::user()->institute_id, 
            'user_id' => Auth::id() 
        ]);
        
        $student = Student::find($request->student_id);
        $phone = $student->parent_phone ?? $student->phone;

        if ($student && $phone) {
            $now = Carbon::now('Asia/Colombo');
            $msg = "Smart Institute: Payment of Rs.{$request->amount} received for {$student->student_name} on {$now->format('Y-m-d')}. Thank you!";
            $this->sendSMS($phone, $msg);
        }
        
        return redirect()->back()
            ->with('success', 'Payment Processed Successfully!')
            ->with('payment_id', $payment->id);
    }

    public function showReceipt($id) {
        $payment = Payment::with(['student', 'course'])
                          ->where('institute_id', Auth::user()->institute_id)
                          ->findOrFail($id); 
        return view('receipt', compact('payment'));
    }

    // ==========================================
    // 8. Manual Punch & Attendance
    // ==========================================
    public function showPunchCard() { 
        return view('punch'); 
    }

   public function getStudentInfo(Request $request) {
        $student = Student::with('courses')
                          ->where('card_number', $request->card_number)
                          ->where('institute_id', Auth::user()->institute_id)
                          ->first();
        
        if ($student) {
            foreach ($student->courses as $course) {
                $attendedDays = Attendance::where('student_id', $student->id)->where('course_id', $course->id)->distinct('date')->count('date');
                $hasAttendedThisCourseToday = Attendance::where('student_id', $student->id)->where('course_id', $course->id)->whereDate('date', Carbon::today())->exists();

                $billableDays = $attendedDays;
                if (!$hasAttendedThisCourseToday) { $billableDays += 1; }

                if (trim(strtolower($course->fee_type)) !== 'monthly') {
                    $paidAmount = Payment::where('student_id', $student->id)->where('course_id', $course->id)->sum('amount');
                    $totalDue = ($billableDays * $course->fee) - $paidAmount;
                    $course->total_due_today = ($totalDue < 0) ? 0 : $totalDue;
                    
                    $course->arrears = ($hasAttendedThisCourseToday) ? $course->total_due_today : ($course->total_due_today - $course->fee);
                    if ($course->arrears < 0) $course->arrears = 0;
                } else {
                    $course->total_due_today = $course->fee;
                    $course->arrears = 0;
                }
                $course->attended_today = $hasAttendedThisCourseToday; 
            }
            return response()->json(['status' => 'success', 'student' => $student]);
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid Card Number or Not Registered in this Institute!']);
    }

    public function punchPayAttend(Request $request) {
        try {
            $student = Student::find($request->student_id);

            $alreadyAttended = Attendance::where('student_id', $request->student_id)
                                         ->where('course_id', $request->course_id)
                                         ->whereDate('date', Carbon::today())
                                         ->exists();

            // 💥 වෙනස්කම 1: හැම විදිහටම (Card Number, ID) Cache එක සේව් කළා. එතකොට කොහෙන් හෙව්වත් අහු වෙනවා!
            if ($alreadyAttended && $request->amount == 0) {
                if ($student) {
                    Cache::put('scan_status_' . $student->card_number, 'completed', now()->addMinutes(5));
                    Cache::put('scan_status_' . $student->id, 'completed', now()->addMinutes(5));
                    Cache::put('scan_status_' . $request->student_id, 'completed', now()->addMinutes(5));
                }
                return response()->json(['status' => 'already_attended', 'message' => 'ALREADY ATTENDED TODAY!']);
            }

            $payment_id = null;
            if ($request->amount > 0) {
                $payment = Payment::create([
                    'student_id' => $request->student_id,
                    'course_id' => $request->course_id,
                    'amount' => $request->amount,
                    'payment_type' => (trim(strtolower($request->fee_type)) == 'monthly') ? date('F') : 'Daily',
                    'payment_date' => Carbon::today()->toDateString(), 
                    'institute_id' => Auth::user()->institute_id, 
                    'user_id' => Auth::id() 
                ]);
                $payment_id = $payment->id;
            }

            if (!$alreadyAttended) {
                Attendance::create([
                    'student_id' => $request->student_id,
                    'course_id' => $request->course_id,
                    'date' => Carbon::today()->toDateString(),
                    'card_number' => $student->card_number,
                    'institute_id' => Auth::user()->institute_id, 
                    'user_id' => Auth::id() 
                ]);
            }

            $phone = $student->parent_phone ?? $student->phone;
            $sms_status = 'No Number Found';

            if ($student && $phone && (!$alreadyAttended || $request->amount > 0)) {
                $now = Carbon::now('Asia/Colombo');
                $msg = "Smart Institute: {$student->student_name} arrived at class on {$now->format('Y-m-d')} at {$now->format('h:i A')}.";
                if ($request->amount > 0) { $msg .= " Payment of Rs.{$request->amount} received."; }
                
                $sms_status = $this->sendSMS($phone, $msg);
            }

            // 💥 වෙනස්කම 2: මෙතනත් හැම විදිහටම (Card Number, ID) Cache එක සේව් කළා!
            if ($student) {
                Cache::put('scan_status_' . $student->card_number, 'completed', now()->addMinutes(5));
                Cache::put('scan_status_' . $student->id, 'completed', now()->addMinutes(5));
                Cache::put('scan_status_' . $request->student_id, 'completed', now()->addMinutes(5));
            }

            return response()->json([
                'status' => 'success', 
                'message' => 'Attendance & Payment Marked!',
                'payment_id' => $payment_id,
                'sms_status' => $sms_status
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // ==========================================
    // 9. Gate Scanner Logic
    // ==========================================
   public function gateScan(Request $request) {

        $student = Student::with('courses')
                          ->where('card_number', $request->card_number)
                          ->where('institute_id', Auth::user()->institute_id)
                          ->first();
                          
        if (!$student) return response()->json(['status' => 'error', 'message' => 'Invalid Card Number or Not Registered in this Institute!']);
        
        $today = Carbon::today()->toDateString();
        $hasAttendedToday = Attendance::where('student_id', $student->id)->whereDate('date', $today)->exists();
        $sms_status = 'Already Attended';

        if (!$hasAttendedToday) {
            Attendance::create([
                'student_id' => $student->id,
                'course_id' => $student->courses->first()->id ?? null,
                'date' => $today,
                'card_number' => $student->card_number, 
                'institute_id' => Auth::user()->institute_id, 
                'user_id' => Auth::id() 
            ]);

            $phone = $student->parent_phone ?? $student->phone;
            if ($phone) {
                $now = Carbon::now('Asia/Colombo');
                $msg = "Smart Institute: {$student->student_name} arrived at class on {$now->format('Y-m-d')} at {$now->format('h:i A')}.";
                $sms_status = $this->sendSMS($phone, $msg);
            } else {
                $sms_status = 'No Number Found';
            }
        }

        return response()->json([
            'status' => 'success', 
            'student' => $student,
            'message' => 'Access Granted!',
            'sms_status' => $sms_status
        ]);
    }
    // ==========================================
    // 10. HELPER: SEND SMS
    // ==========================================
    private function sendSMS($phone, $message) {
        $userId = '31067'; 
        $apiKey = 'dXi6fDQSUm4bhhOIHuu7';
        $senderId = 'NotifyDEMO'; 
        
        $formattedPhone = preg_replace('/^0/', '94', trim($phone)); 

        try {
            $url = "https://app.notify.lk/api/v1/send?user_id={$userId}&api_key={$apiKey}&sender_id={$senderId}&to={$formattedPhone}&message=" . urlencode($message);
            $response = Http::get($url);
            if ($response->successful()) { return 'SMS Sent ✅'; } 
            else { return 'SMS Failed ❌'; }
        } catch (\Exception $e) {
            Log::error("SMS Sending Failed: " . $e->getMessage()); 
            return 'SMS Error ⚠️';
        }
    }

    // ==========================================
    // 11. SMS Broadcast System
    // ==========================================
    public function showSmsForm() {
        $institute_id = Auth::user()->institute_id;
        $courses = Course::withCount('students')->where('institute_id', $institute_id)->get();
        
        $currentBalance = \Illuminate\Support\Facades\DB::table('institutes')->where('id', $institute_id)->value('sms_balance');
        
        $smsHistories = \App\Models\SmsHistory::where('institute_id', $institute_id)
                                              ->latest()
                                              ->take(10)
                                              ->get();

        return view('sms', compact('courses', 'smsHistories', 'currentBalance'));
    }

    public function sendBulkSms(Request $request) {
        $request->validate([
            'course_id' => 'required',
            'recipient_type' => 'required',
            'message' => 'required'
        ]);

        $institute_id = Auth::user()->institute_id;
        $institute = \Illuminate\Support\Facades\DB::table('institutes')->where('id', $institute_id)->first();

        $students = Student::whereHas('courses', function($q) use ($request) {
            $q->where('courses.id', $request->course_id);
        })->where('institute_id', $institute_id)->get();

        $numbers = [];
        foreach ($students as $student) {
            if (in_array($request->recipient_type, ['parent', 'both']) && !empty($student->parent_phone)) {
                $numbers[] = $student->parent_phone;
            }
            if (in_array($request->recipient_type, ['student', 'both']) && !empty($student->phone)) {
                $numbers[] = $student->phone;
            }
        }

        $uniqueNumbers = array_unique($numbers);
        $totalRecipients = count($uniqueNumbers);

        if ($totalRecipients == 0) {
            return back()->with('error', 'No valid phone numbers found for the selected category.');
        }

        $isUnicode = preg_match('/[^\x00-\x7F]/', $request->message);
        $length = mb_strlen($request->message, 'UTF-8');
        $partLimit = $isUnicode ? 70 : 160;
        $multiPartLimit = $isUnicode ? 67 : 153;
        $parts = ($length <= $partLimit) ? 1 : ceil($length / $multiPartLimit);
        
        $expectedCost = $totalRecipients * $parts;

        if ($institute->sms_balance < $expectedCost) {
            return back()->with('error', "Insufficient SMS Balance! You need Rs. {$expectedCost} but your balance is Rs. {$institute->sms_balance}. Please contact Admin to top-up.");
        }

        $successCount = 0;
        foreach ($uniqueNumbers as $phone) {
            $status = $this->sendSMS($phone, $request->message);
            if ($status == 'SMS Sent ✅') { $successCount++; }
        }

        $actualCost = $successCount * $parts;

        if ($actualCost > 0) {
            \Illuminate\Support\Facades\DB::table('institutes')
                ->where('id', $institute_id)
                ->decrement('sms_balance', $actualCost); 

            \App\Models\SmsHistory::create([
                'institute_id' => $institute_id,
                'course_name' => Course::find($request->course_id)->course_name ?? 'Unknown',
                'recipient_type' => $request->recipient_type,
                'message' => $request->message,
                'audience_count' => $successCount,
                'sms_parts' => $parts,
                'total_cost' => $actualCost
            ]);
        }

        $newBalance = $institute->sms_balance - $actualCost;
        return back()->with('success', "SMS Broadcast Sent! Deducted: Rs. {$actualCost} | New Balance: Rs. {$newBalance}");
    }
}