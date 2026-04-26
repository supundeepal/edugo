<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\TeacherPayment;
use App\Models\Teacher;
use App\Models\Expense; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Response; 
use Illuminate\Support\Facades\Auth; // ⭐ අලුතින් දැම්මා

class ReportController extends Controller
{
    // ==========================================
    // ADMIN ගේ පැත්තේ වැඩ ටික
    // ==========================================

    public function index(Request $request) {
        // අර පරණ Session Check එක අයින් කළා!

        $now = Carbon::now('Asia/Colombo');
        $filterType = $request->input('filter_type', 'month');
        $startDate = null; $endDate = null; $displayTitle = "";

        if ($filterType == 'today') {
            $startDate = $now->copy()->startOfDay();
            $endDate = $now->copy()->endOfDay();
            $displayTitle = "Today (" . $now->format('M d, Y') . ")";
        } elseif ($filterType == 'week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate = $now->copy()->endOfWeek();
            $displayTitle = "This Week";
        } elseif ($filterType == 'custom') {
            $startDate = Carbon::parse($request->input('start_date', $now->toDateString()))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date', $now->toDateString()))->endOfDay();
            $displayTitle = $startDate->format('M d') . " to " . $endDate->format('M d, Y');
        } else {
            $selectedMonth = $request->input('month', $now->format('Y-m'));
            $startDate = Carbon::parse($selectedMonth)->startOfMonth();
            $endDate = Carbon::parse($selectedMonth)->endOfMonth();
            $displayTitle = Carbon::parse($selectedMonth)->format('F Y');
        }

        // ⭐ තමන්ගේ ආයතනයට විතරක් ෆිල්ටර් කරනවා
        $institute_id = Auth::user()->institute_id;

        $totalIncome = Payment::where('institute_id', $institute_id)
                              ->whereBetween('created_at', [$startDate, $endDate])
                              ->sum('amount');
                              
        $grossProfit = $totalIncome * 0.20; 
        $teachersShare = $totalIncome * 0.80;   
        
        $expenses = Expense::where('institute_id', $institute_id)
                           ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                           ->orderBy('date', 'desc')
                           ->get();
                           
        $totalExpenses = $expenses->sum('amount');
        
        $netProfit = $grossProfit - $totalExpenses;
        
        $totalAttendance = Attendance::where('institute_id', $institute_id)
                                     ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                                     ->count();
                                     
        $payments = Payment::with(['student', 'course'])
                           ->where('institute_id', $institute_id)
                           ->whereBetween('created_at', [$startDate, $endDate])
                           ->orderBy('created_at', 'desc')
                           ->get();

        $attendances = Attendance::with(['student', 'course'])
                                 ->where('institute_id', $institute_id)
                                 ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                                 ->get();
                                 
        $defaulters = [];
        $groupedAttendances = $attendances->groupBy(function($item) { return $item->student_id . '-' . $item->course_id; });

        foreach($groupedAttendances as $key => $records) {
            $student = $records->first()->student;
            $course = $records->first()->course;
            if(!$student || !$course) continue;

            $attendedDays = $records->unique('date')->count();
            
            $paidAmount = Payment::where('student_id', $student->id)
                                 ->where('course_id', $course->id)
                                 ->whereBetween('created_at', [$startDate, $endDate])
                                 ->sum('amount');

            $expectedAmount = (trim(strtolower($course->fee_type)) === 'monthly') ? $course->fee : ($attendedDays * $course->fee);
            $arrears = $expectedAmount - $paidAmount;

            if ($arrears > 0) {
                $defaulters[] = (object)['student' => $student, 'course' => $course, 'attended_days' => $attendedDays, 'expected' => $expectedAmount, 'paid' => $paidAmount, 'arrears' => $arrears];
            }
        }
        usort($defaulters, function($a, $b) { return $b->arrears <=> $a->arrears; });

        return view('reports', compact('totalIncome', 'grossProfit', 'teachersShare', 'totalExpenses', 'netProfit', 'expenses', 'totalAttendance', 'payments', 'defaulters', 'filterType', 'displayTitle'));
    }

    public function storeExpense(Request $request) {
        $categoryName = $request->category;
        if ($categoryName === 'Custom') {
            $categoryName = $request->custom_category;
        }

        Expense::create([
            'category' => $categoryName,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
            'institute_id' => Auth::user()->institute_id // ⭐ ආයතනය
        ]);
        
        return back()->with('success', 'Expense Added Successfully!');
    }

    public function backupDatabase() {
        // අර පරණ Session Check එක අයින් කළා!

        $tables = DB::select('SHOW TABLES');
        $sql = "-- Smart Institute Database Backup\n-- Date: " . now('Asia/Colombo')->format('Y-m-d h:i A') . "\n\n";
        
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
            $sql .= array_values((array)$createTable)[1] . ";\n\n";
            
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function($value) {
                    return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                }, array_values((array)$row));
                $sql .= "INSERT INTO `$tableName` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n\n";
        }
        
        $filename = 'Smart_Institute_Backup_' . date('Y_m_d_H_i_s') . '.sql';
        return Response::make($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function teacherList() {
        // අර පරණ Session Check එක අයින් කළා!
        
        // ⭐ තමන්ගේ ආයතනයේ ගුරුවරු විතරක් පෙන්වනවා
        $teachers = Teacher::join('institute_teacher', 'teachers.id', '=', 'institute_teacher.teacher_id')
                           ->where('institute_teacher.institute_id', Auth::user()->institute_id)
                           ->select('teachers.*')
                           ->get();
                           
        return view('teacher-salaries', compact('teachers'));
    }

    public function teacherCourses($teacher_id) {
        // අර පරණ Session Check එක අයින් කළා!
        $teacher = Teacher::findOrFail($teacher_id);
        
        // ⭐ තමන්ගේ ආයතනයේ පන්ති විතරක් ගන්නවා
        $courses = Course::where('teacher_id', $teacher_id)
                         ->where('institute_id', Auth::user()->institute_id)
                         ->get();
                         
        return view('teacher_courses', compact('courses', 'teacher'));
    }

    public function teacherSalaryDetails(Request $request, $course_id) {
        // අර පරණ Session Check එක අයින් කළා!

        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedMonth)->endOfMonth();

        // ⭐ තමන්ගේ ආයතනයේ පන්තියක්ද කියලා බලනවා
        $course = Course::where('institute_id', Auth::user()->institute_id)->findOrFail($course_id);
        
        $totalCollected = Payment::where('course_id', $course->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $salaryData = null;

        if ($totalCollected > 0) {
            $teacherShare = $totalCollected * 0.80; 
            $instituteShare = $totalCollected * 0.20; 

            $isPaid = TeacherPayment::where('course_id', $course->id)
                ->where('month', $selectedMonth)
                ->exists();

            $salaryData = (object)[
                'total_collected' => $totalCollected,
                'teacher_share' => $teacherShare,
                'institute_share' => $instituteShare,
                'is_paid' => $isPaid
            ];
        }

        return view('teacher_salary_details', compact('course', 'salaryData', 'selectedMonth'));
    }

    public function payTeacher(Request $request) {
        TeacherPayment::create([
            'course_id' => $request->course_id,
            'month' => $request->month,
            'amount' => $request->amount,
            'institute_id' => Auth::user()->institute_id // ⭐ ආයතනය
        ]);
        return back()->with('success', 'Teacher Payment Recorded Successfully!');
    }


    // ==========================================
    // TEACHER ගේ පැත්තේ වැඩ ටික
    // ==========================================

    public function myEarnings(Request $request) {
        // Teacher ගේ පැත්තෙත් පරණ Session එක අයින් කරලා Auth පාවිච්චි කරමු
        if (!Auth::guard('teacher')->check()) { return redirect('/teacher-login'); }
        $teacher_id = Auth::guard('teacher')->id(); 

        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedMonth)->endOfMonth();

        $courses = Course::where('teacher_id', $teacher_id)->get();
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
}