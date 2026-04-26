<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\StudyMaterial; 
use App\Models\Notification; 
use Illuminate\Support\Facades\Auth; // ⭐ Auth පාවිච්චි කරන්න මේක ඕනේ

class CourseController extends Controller
{
    // පන්ති හදන පිටුව සහ දැනට තියෙන පන්ති ලැයිස්තුව පෙන්වීම
    public function index() {
        // ⭐ තමන්ගේ ආයතනයේ ගුරුවරු විතරක් ගන්නවා
        if (Auth::check() && Auth::user()->role === 'owner') {
            $teachers = Teacher::join('institute_teacher', 'teachers.id', '=', 'institute_teacher.teacher_id')
                ->where('institute_teacher.institute_id', Auth::user()->institute_id)
                ->select('teachers.*')
                ->get();
                
            // ⭐ තමන්ගේ ආයතනයේ පන්ති විතරක් ගන්නවා
            $courses = Course::with('teacher')
                ->where('institute_id', Auth::user()->institute_id)
                ->get();
        } else {
            $teachers = Teacher::all(); 
            $courses = Course::with('teacher')->get(); 
        }
        
        return view('courses', compact('teachers', 'courses'));
    }

    // අලුත් පන්තියක් Database එකට සේව් කිරීම
    public function store(Request $request) {
        $request->validate([
            'course_name' => 'required',
            'teacher_id' => 'required',
            'fee' => 'required|numeric'
        ]);

        $teacher = Teacher::find($request->teacher_id);

        Course::create([
            'course_name' => $request->course_name,
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $teacher ? $teacher->name : 'Unknown', // ⭐ ගුරුවරයාගේ නම
            'fee' => $request->fee,
            'fee_type' => $request->fee_type ?? 'Monthly', // ⭐ ගෙවන විදිහ
            'institute_id' => Auth::user()->institute_id // ⭐ අනිවාර්යයෙන්ම Owner ගේ ආයතනය
        ]);

        return back()->with('success', 'Class created successfully!');
    }

    // ==========================================
    // ADMIN ට STUDY MATERIALS බලන්න 
    // ==========================================
    public function adminMaterials() {
        // ⭐ තමන්ගේ ආයතනයේ පන්ති වල Materials විතරක් බලන්න
        if (Auth::check() && Auth::user()->role === 'owner') {
            $courseIds = Course::where('institute_id', Auth::user()->institute_id)->pluck('id');
            $materials = StudyMaterial::with(['course', 'teacher'])
                            ->whereIn('course_id', $courseIds)
                            ->latest()
                            ->get();
        } else {
            $materials = StudyMaterial::with(['course', 'teacher'])->latest()->get();
        }
        
        return view('admin_materials', compact('materials'));
    }

    // ==========================================
    // ADMIN ෆයිල් එක DOWNLOAD කරන එක
    // ==========================================
    public function downloadMaterial($id) {
        $material = StudyMaterial::findOrFail($id);

        // Teacher ට Notification එක යවනවා
        Notification::create([
            'type' => 'teacher',
            'teacher_id' => $material->teacher_id,
            'message' => 'Admin viewed/downloaded your material: ' . $material->title
        ]);

        // ඊටපස්සේ ෆයිල් එක Download වෙන්න දෙනවා
        return response()->download(public_path($material->file_path));
    }
}