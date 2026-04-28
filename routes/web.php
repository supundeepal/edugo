<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{StudentController, TeacherController, CourseController, GateController, OwnerAuthController, InstituteController, SuperAdminUserController, SuperAdminAuthController, ReportController, StaffController, DashboardController};
use App\Http\Middleware\{TeacherAuth, SuperAdminMiddleware};
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// ==========================================
// --- PUBLIC & LOGIN ROUTES ---
// ==========================================

Route::get('/', function () { return redirect('/owner-login'); });
Route::get('/login', function () { return redirect('/owner-login'); })->name('login');

// Owner Login
Route::get('/owner-login', function () { return view('login'); })->name('owner.login'); 
Route::post('/owner-login', [OwnerAuthController::class, 'login']);
Route::get('/owner-logout', [OwnerAuthController::class, 'logout']);

// Staff Login
Route::get('/staff-login', [OwnerAuthController::class, 'showStaffLoginForm']);
Route::post('/staff-login', [OwnerAuthController::class, 'staffLogin']);

// Teacher Login
Route::get('/teacher-login', [TeacherController::class, 'showLoginForm']);
Route::post('/teacher-login', [TeacherController::class, 'login']);


// ==========================================
// --- ADMIN PORTAL (OWNER & STAFF) ---
// ==========================================
// මෙතනින් ඇතුළට යන්න අනිවාර්යයෙන්ම ලොග් වෙන්න ඕනේ ('auth' ගේට්ටුව)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'owner') { return redirect('/owner/dashboard'); } 
        elseif (Auth::user()->role === 'staff') { return redirect('/staff/dashboard'); }
        return redirect('/');
    });

    Route::get('/owner/dashboard', [StudentController::class, 'dashboard'])->name('owner.dashboard');
    Route::get('/staff/dashboard', [StudentController::class, 'dashboard'])->name('staff.dashboard');
    
    Route::get('/students', [StudentController::class, 'list']); 
    Route::get('/register', [StudentController::class, 'index']); 
    Route::post('/students', [StudentController::class, 'store']); 
    Route::get('/profile/{id}', [StudentController::class, 'showProfile']); 
    Route::get('/id-card/{id}', [StudentController::class, 'generateIDCard']); 
    Route::get('/students/{id}/edit', [StudentController::class, 'edit']); 
    Route::post('/students/{id}/update', [StudentController::class, 'update']);
    Route::get('/students/{id}/delete', [StudentController::class, 'destroy']); 

    Route::get('/payment', [StudentController::class, 'showPaymentForm']);
    Route::post('/payment', [StudentController::class, 'storePayment']);
    Route::get('/receipt/{id}', [StudentController::class, 'showReceipt']);

    Route::get('/punch', [StudentController::class, 'showPunchCard']);
    Route::post('/get-student-info', [StudentController::class, 'getStudentInfo']);
    Route::post('/punch-pay-attend', [StudentController::class, 'punchPayAttend']);

    Route::get('/notifications/{id}/read', function($id) {
        $notification = \App\Models\Notification::find($id);
        if($notification) { $notification->update(['is_read' => true]); }
        return back();
    });

    // ⭐ OWNER ට විතරක් යන්න පුළුවන් ලින්ක්ස් (Staff ට බෑ! - 'owner' ගේට්ටුව)
    Route::middleware(['owner'])->group(function () {
        
        Route::get('/manage-staff', [StaffController::class, 'index']);
        Route::post('/manage-staff', [StaffController::class, 'store']);
        Route::get('/manage-staff/{id}/delete', [StaffController::class, 'destroy']);
        
        Route::get('/courses', [CourseController::class, 'index']); 
        Route::post('/courses', [CourseController::class, 'store']); 
        Route::get('/admin-materials', [CourseController::class, 'adminMaterials']);
        Route::get('/admin-materials/{id}/download', [CourseController::class, 'downloadMaterial']);
        
        Route::get('/teachers-menu', function () { return view('teachers-menu'); });
        Route::get('/teachers-list', [TeacherController::class, 'index']);
        Route::get('/add-teacher', [TeacherController::class, 'create']);
        Route::post('/add-teacher', [TeacherController::class, 'store']);
        Route::get('/edit-teacher/{id}', [TeacherController::class, 'edit']);
        Route::post('/update-teacher/{id}', [TeacherController::class, 'update']);
        Route::get('/teachers/{id}/delete', [TeacherController::class, 'destroy']); 
        
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/teachers', function () {
            $teachers = \App\Models\Teacher::all();
            return view('teacher-salaries', compact('teachers'));
        });
        Route::get('/teachers/{teacher_id}/courses', [ReportController::class, 'teacherCourses']);
        Route::get('/teacher-salary/{course_id}', [ReportController::class, 'teacherSalaryDetails']);
        Route::post('/pay-teacher', [ReportController::class, 'payTeacher']);
        Route::post('/add-expense', [ReportController::class, 'storeExpense']);
        Route::get('/backup-database', [ReportController::class, 'backupDatabase']);

        // ⭐ SMS Broadcast (Owner විතරයි)
        Route::get('/sms-broadcast', [StudentController::class, 'showSmsForm']);
        Route::post('/sms-broadcast', [StudentController::class, 'sendBulkSms']);
    });
});


// ==========================================
// --- TEACHER PORTAL (Secured) ---
// ==========================================
Route::middleware([TeacherAuth::class])->group(function () {
    Route::get('/teacher-logout', [TeacherController::class, 'logout']);
    Route::get('/teacher-dashboard', [TeacherController::class, 'dashboard']);
    Route::get('/teacher-classes', [TeacherController::class, 'myClasses']);
    Route::get('/teacher-classes/{id}/students', [TeacherController::class, 'courseStudents']);
    Route::get('/teacher-earnings', [TeacherController::class, 'myEarnings']);
    
    Route::get('/teacher-announcements', [TeacherController::class, 'showAnnouncements']);
    Route::post('/teacher-announcements/send', [TeacherController::class, 'sendAnnouncement']);
    Route::get('/teacher-attendance', [TeacherController::class, 'attendance']);

    Route::get('/teacher-materials', [TeacherController::class, 'showMaterials']);
    Route::post('/teacher-materials/upload', [TeacherController::class, 'uploadMaterial']);
    Route::get('/teacher-materials/{id}/delete', [TeacherController::class, 'deleteMaterial']);
});

Route::get('/api/search-teacher', [\App\Http\Controllers\TeacherController::class, 'searchApi']);
Route::post('/add-existing-teacher', [\App\Http\Controllers\TeacherController::class, 'addExisting']);
Route::get('/teachers/{id}/remove', [\App\Http\Controllers\TeacherController::class, 'remove']);

Route::get('/teacher/select-institute', [\App\Http\Controllers\TeacherController::class, 'showSelectInstitute']);
Route::get('/teacher/set-institute/{id}', [\App\Http\Controllers\TeacherController::class, 'setInstitute']);

// ==========================================
// --- SUPER ADMIN PORTAL (Secured) ---
// ==========================================
Route::get('/superadmin/login', [SuperAdminAuthController::class, 'showLogin']);
Route::post('/superadmin/login', [SuperAdminAuthController::class, 'login']);
Route::get('/superadmin/logout', [SuperAdminAuthController::class, 'logout']);

Route::middleware([SuperAdminMiddleware::class])->group(function () {
    
    Route::get('/superadmin/dashboard', function () {
        $total_institutes = DB::table('institutes')->count();
        $total_users = DB::table('users')->where('role', 'owner')->count();
        return view('superadmin.dashboard', compact('total_institutes', 'total_users'));
    });

    Route::get('/superadmin/institutes', function () {
        $institutes = DB::table('institutes')->orderBy('id', 'desc')->get();
        return view('superadmin.institutes', compact('institutes'));
    });
    Route::post('/superadmin/institutes/store', [InstituteController::class, 'store']);
    Route::post('/superadmin/institutes/update/{id}', [InstituteController::class, 'update']);
    Route::get('/superadmin/institutes/delete/{id}', [InstituteController::class, 'destroy']);

    Route::get('/superadmin/users', function () {
        $institutes = DB::table('institutes')->get(); 
        $users = DB::table('users')
                    ->leftJoin('institutes', 'users.institute_id', '=', 'institutes.id')
                    ->select('users.*', 'institutes.name as institute_name')
                    ->where('users.role', 'owner')
                    ->orderBy('users.id', 'desc')
                    ->get();
        return view('superadmin.users', compact('institutes', 'users'));
    });
    Route::post('/superadmin/users/store', [SuperAdminUserController::class, 'store']);
    Route::post('/superadmin/users/update/{id}', [SuperAdminUserController::class, 'update']);
    Route::get('/superadmin/users/delete/{id}', [SuperAdminUserController::class, 'destroy']);

    Route::get('/superadmin/settings', function () { return view('superadmin.settings'); });
    Route::post('/superadmin/settings', function (\Illuminate\Http\Request $request) {
        return redirect()->back()->with('success', 'System Settings Updated Successfully!');
    });

    // ⭐ SMS Wallet Management (Super Admin) - දැන් හරි තැන!
    Route::get('/superadmin/sms-wallets', [SuperAdminUserController::class, 'smsWallets']);
    Route::post('/superadmin/sms-wallets/topup', [SuperAdminUserController::class, 'topupSmsWallet']);
});


// ==========================================
// --- OTHER UTILITIES ---
// ==========================================
Route::get('/gate-scanner', function () { return view('gate.scanner'); });
Route::post('/gate-scan', [StudentController::class, 'gateScan']);
Route::post('/gate-quick-pay', [StudentController::class, 'gateQuickPay']);
Route::post('/gate-skip-pay', [StudentController::class, 'gateSkipPay']);
Route::post('/gate-process-course', [StudentController::class, 'gateProcessCourse']); 

Route::get('/clear', function() {
    Artisan::call('optimize:clear');
    return 'Cache Cleared Successfully!';
});

// QR Scanner Page
Route::get('/scan-attendance', [GateController::class, 'scanPage']);

// QR Result Process (AJAX)
Route::post('/process-scan', [GateController::class, 'processScan']);

Route::get('/mobile', function () {
    return view('mobile-scanner');
});
Route::get('/mobile-scanner', function () {
    return view('mobile-scanner');
});