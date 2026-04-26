<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Payment;
use App\Models\TeacherPayment;
use App\Models\StudyMaterial; 
use App\Models\Notification; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   

class TeacherController extends Controller
{
    // ==========================================
    // TEACHERS LIST
    // ==========================================
    public function index() {
        if (Auth::check() && Auth::user()->role === 'owner') {
            $teachers = Teacher::join('institute_teacher', 'teachers.id', '=', 'institute_teacher.teacher_id')
                ->where('institute_teacher.institute_id', Auth::user()->institute_id)
                ->select('teachers.*')
                ->get();
        } else {
            $teachers = Teacher::all(); 
        }
        
        return view('teachers-list', compact('teachers')); 
    }

    public function create() {
        if (Auth::check() && Auth::user()->role === 'owner') {
            $teachers = Teacher::join('institute_teacher', 'teachers.id', '=', 'institute_teacher.teacher_id')
                ->where('institute_teacher.institute_id', Auth::user()->institute_id)
                ->select('teachers.*')
                ->get();
        } else {
            $teachers = Teacher::all(); 
        }
        
        return view('add_teacher', compact('teachers'));
    }

    // ⭐ 1. Phone Number එකෙන් සර්ව හොයන්න
    public function searchApi(Request $request) {
        $phone = $request->query('phone');
        $teacher = Teacher::where('phone', $phone)->first();

        if ($teacher) {
            return response()->json(['found' => true, 'teacher' => $teacher]);
        }
        return response()->json(['found' => false]);
    }

    // ⭐ 2. දැනට ඉන්න සර් කෙනෙක්ව තමන්ගේ ආයතනයට ලින්ක් කරන්න
    public function addExisting(Request $request) {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id'
        ]);

        if (Auth::check() && Auth::user()->role === 'owner') {
            $instituteId = Auth::user()->institute_id;
            $teacherId = $request->teacher_id;

            $exists = DB::table('institute_teacher')
                ->where('institute_id', $instituteId)
                ->where('teacher_id', $teacherId)
                ->exists();

            if (!$exists) {
                DB::table('institute_teacher')->insert([
                    'institute_id' => $instituteId,
                    'teacher_id' => $teacherId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                return redirect('/add-teacher')->with('success', 'Teacher linked to your institute successfully!');
            } else {
                return redirect('/add-teacher')->with('error', 'This teacher is already in your institute!');
            }
        }
        return redirect('/add-teacher')->with('error', 'Unauthorized action!');
    }

    // ⭐ 3. අලුත්ම සර් කෙනෙක්ව හදලා ලින්ක් කරන්න
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'username' => 'required|unique:teachers',
            'password' => 'required|min:4'
        ]);

        $teacher = Teacher::create([
            'name' => $request->name, 
            'phone' => $request->phone, 
            'username' => $request->username, 
            'password' => Hash::make($request->password)
        ]);

        if (Auth::check() && Auth::user()->role === 'owner') {
            DB::table('institute_teacher')->insert([
                'institute_id' => Auth::user()->institute_id,
                'teacher_id' => $teacher->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return redirect('/add-teacher')->with('success', 'New Teacher registered and added successfully!');
    }

    // ⭐ 4. තමන්ගේ ආයතනයෙන් විතරක් අයින් කිරීම
    public function remove($id) { 
        if (Auth::check() && Auth::user()->role === 'owner') {
            DB::table('institute_teacher')
                ->where('institute_id', Auth::user()->institute_id)
                ->where('teacher_id', $id)
                ->delete(); 
            
            return redirect('/add-teacher')->with('success', 'Teacher removed from your institute.');
        }
        return redirect('/add-teacher')->with('error', 'Unauthorized action!');
    }

    public function showLoginForm() { return view('teacher_login'); }
    
    // ==========================================
    // LOGIN & INSTITUTE SWITCHING (SMART LOGIC)
    // ==========================================
    public function login(Request $request) {
        $teacher = Teacher::where('username', $request->username)->first();
        
        if($teacher && Hash::check($request->password, $teacher->password)) {
            Session::flush(); 
            Session::put('teacher_logged_in', true);
            Session::put('teacher_name', $teacher->name);
            Session::put('teacher_id', $teacher->id);

            $institutes = $teacher->institutes;

            if ($institutes->count() == 0) {
                Session::flush();
                return redirect('/teacher-login')->with('error', 'You are not assigned to any institute yet!');
            } 
            else if ($institutes->count() == 1) {
                Session::put('current_institute_id', $institutes->first()->id);
                Session::put('current_institute_name', $institutes->first()->name);
                return redirect('/teacher-dashboard');
            } 
            else {
                return redirect('/teacher/select-institute');
            }
        }
        return redirect('/teacher-login')->with('error', 'Invalid Login!');
    }

    public function showSelectInstitute() {
        if(!Session::has('teacher_logged_in')) return redirect('/teacher-login');

        $teacher = Teacher::find(Session::get('teacher_id'));
        $institutes = $teacher->institutes;

        return view('teacher_select_institute', compact('institutes'));
    }

    public function setInstitute($id) {
        if(!Session::has('teacher_logged_in')) return redirect('/teacher-login');

        $institute = \App\Models\Institute::findOrFail($id);

        Session::put('current_institute_id', $institute->id);
        Session::put('current_institute_name', $institute->name);

        return redirect('/teacher-dashboard');
    }

    // ⭐ 5. මෙන්න මේක තමයි කලින් නැති වෙලා තිබුණේ!
    public function dashboard() {
        if(!Session::has('teacher_logged_in')) return redirect('/teacher-login');
        
        $currentInstitute = Session::get('current_institute_name');
        
        return view('teacher_dashboard', compact('currentInstitute'));
    }

    // ==========================================
    // ANNOUNCEMENTS, ATTENDANCE & MATERIALS
    // ==========================================
    public function showAnnouncements() {
        $teacherId = Session::get('teacher_id');
        if (!$teacherId) return redirect('/teacher-login');
        $courses = Course::where('teacher_id', $teacherId)->get();
        return view('teacher_announcements', compact('courses'));
    }

    public function sendAnnouncement(Request $request) {
        $request->validate([
            'course_id' => 'required',
            'message' => 'required|string|max:160'
        ]);

        $course = Course::with('students')->find($request->course_id);
        if (!$course) return back()->with('error', 'Course not found!');

        $students = $course->students;
        $successCount = 0; $failedCount = 0;

        foreach ($students as $student) {
            $phone = $student->parent_phone ?? $student->phone;
            if ($phone) {
                $status = $this->sendBulkSMS($phone, $request->message);
                if ($status) $successCount++; else $failedCount++;
            } else {
                $failedCount++;
            }
        }
        return back()->with('success', "Announcement Sent! ✅ Delivered: $successCount | ❌ Failed/No Number: $failedCount");
    }

    private function sendBulkSMS($phone, $message) {
        $userId = '31067'; 
        $apiKey = 'dXi6fDQSUm4bhhOIHuu7';
        $senderId = 'NotifyDEMO'; 
        $formattedPhone = preg_replace('/^0/', '94', trim($phone)); 

        try {
            $url = "https://app.notify.lk/api/v1/send?user_id={$userId}&api_key={$apiKey}&sender_id={$senderId}&to={$formattedPhone}&message=" . urlencode($message);
            $response = Http::get($url);
            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Bulk SMS Failed: " . $e->getMessage());
            return false;
        }
    }

    public function attendance(Request $request) {
        $teacherId = Session::get('teacher_id');
        if (!$teacherId) return redirect('/teacher-login');

        $courses = Course::where('teacher_id', $teacherId)->get();
        $selectedCourseId = $request->input('course_id');
        $selectedDate = $request->input('date', Carbon::today()->toDateString());

        $attendanceData = []; $presentCount = 0; $absentCount = 0; $totalStudents = 0;

        if ($selectedCourseId) {
            $course = Course::with('students')->find($selectedCourseId);
            if ($course) {
                $students = $course->students;
                $totalStudents = $students->count();

                $attendedStudentIds = \App\Models\Attendance::where('course_id', $selectedCourseId)
                    ->whereDate('created_at', $selectedDate) 
                    ->pluck('student_id')
                    ->toArray();

                foreach ($students as $student) {
                    $isPresent = in_array($student->id, $attendedStudentIds);
                    $attendanceData[] = (object)['student' => $student, 'is_present' => $isPresent];
                    if ($isPresent) $presentCount++; else $absentCount++;
                }
            }
        }
        return view('teacher_attendance', compact('courses', 'selectedCourseId', 'selectedDate', 'attendanceData', 'presentCount', 'absentCount', 'totalStudents'));
    }

    public function showMaterials() {
        $teacherId = session('teacher_id');
        $courses = Course::where('teacher_id', $teacherId)->get();
        $materials = StudyMaterial::where('teacher_id', $teacherId)->with('course')->latest()->get();
        return view('teacher_materials', compact('courses', 'materials'));
    }

    public function uploadMaterial(Request $request) {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx,jpg,png|max:5120', 
        ]);

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('uploads/materials'), $fileName);
            $filePath = 'uploads/materials/' . $fileName;

            StudyMaterial::create([
                'course_id' => $request->course_id,
                'teacher_id' => session('teacher_id'),
                'title' => $request->title,
                'file_path' => $filePath
            ]);

            Notification::create([
                'type' => 'admin',
                'message' => session('teacher_name') . ' uploaded a new material: ' . $request->title
            ]);

            return back()->with('success', 'Material uploaded successfully!');
        }
        return back()->with('error', 'File upload failed!');
    }

    public function deleteMaterial($id) {
        $material = StudyMaterial::findOrFail($id);
        if (file_exists(public_path($material->file_path))) unlink(public_path($material->file_path));
        $material->delete();
        return back()->with('success', 'Material deleted successfully!');
    }

    // ==========================================
    // OTHER EXISTING FUNCTIONS (Earnings, Edit, Update, Logout)
    // ==========================================
    public function myClasses() {
        $courses = Course::where('teacher_id', session('teacher_id'))->get();
        return view('teacher_classes', compact('courses'));
    }

    public function courseStudents($id) {
        $course = Course::with('students')->find($id);
        return view('teacher_students', compact('course'));
    }

    public function myEarnings(Request $request) {
        $teacherId = session('teacher_id');
        if (!$teacherId) return redirect('/teacher-login');

        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedMonth)->endOfMonth();

        $courses = Course::where('teacher_id', $teacherId)->get();
        $earningsData = [];

        foreach($courses as $course) {
            $totalCollected = Payment::where('course_id', $course->id)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            if ($totalCollected > 0) {
                $teacherShare = $totalCollected * 0.80; 
                $isPaid = TeacherPayment::where('course_id', $course->id)
                    ->where('month', $selectedMonth)
                    ->exists();

                $earningsData[] = (object)[
                    'course' => $course,
                    'teacher_share' => $teacherShare,
                    'is_paid' => $isPaid
                ];
            }
        }
        return view('teacher_earnings', compact('earningsData', 'selectedMonth'));
    }

    public function edit($id) {
        $teacher = Teacher::findOrFail($id);
        return view('edit_teacher', compact('teacher'));
    }

    public function update(Request $request, $id) {
        $teacher = Teacher::findOrFail($id);
        $teacher->name = $request->name;
        $teacher->phone = $request->phone;
        $teacher->username = $request->username;

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->password);
        }
        $teacher->save();
        return redirect('/teachers-list')->with('success', 'Teacher details updated successfully!');
    }

    public function logout() { 
        Session::flush(); 
        return redirect('/teacher-login'); 
    }
}