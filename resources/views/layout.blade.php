<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @php
        $instituteName = 'EduGo Admin'; 
        if(Auth::check() && in_array(Auth::user()->role, ['owner', 'staff'])) {
            $instituteName = \Illuminate\Support\Facades\DB::table('institutes')
                                ->where('id', Auth::user()->institute_id)
                                ->value('name');
        }
    @endphp
    <title>{{ $instituteName }} | {{ config('app.name', 'EduGo') }}</title>
    
    <link rel="icon" type="image/png" href="{{ asset('app-icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --neu-bg: #e0e5ec;
            --neu-shadow-dark: #a3b1c6;
            --neu-shadow-light: #ffffff;
            --neu-text: #333333;
            --neu-primary: #0d6efd;
            --neu-success: #198754;
            --neu-warning: #ffb547;
            --neu-danger: #dc3545;
        }

        [data-bs-theme="dark"] {
            --neu-bg: #242731; 
            --neu-shadow-dark: #15171d; 
            --neu-shadow-light: #2a2d38; 
            --neu-text: #e0e5ec;
            --neu-primary: #4facfe;
            --neu-success: #05cd99;
            --neu-danger: #ef4444;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--neu-bg) !important;
            color: var(--neu-text) !important;
            transition: all 0.3s ease;
        }

        .neu-navbar {
            background-color: var(--neu-bg) !important;
            box-shadow: 0 10px 25px var(--neu-shadow-dark) !important;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            border-radius: 0 0 25px 25px;
            padding-top: 15px !important;
            padding-bottom: 20px !important;
            margin-bottom: 40px !important;
        }

        .neu-common-btn {
            display: inline-flex !important; 
            align-items: center !important; 
            justify-content: center !important;
            gap: 10px !important; 
            padding: 0 22px !important; 
            margin: 0 !important; 
            height: 48px !important; 
            border-radius: 12px !important; 
            transition: all 0.3s ease !important;
            font-size: 0.95rem !important; 
            font-weight: 700 !important;
            background: var(--neu-bg) !important;
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                       -5px -5px 10px var(--neu-shadow-light) !important;
            text-decoration: none !important; 
            border: none !important;
            color: var(--neu-text) !important; 
        }
        
        .neu-common-btn:hover { 
            transform: translateY(-2px) !important; 
            box-shadow: 7px 7px 14px var(--neu-shadow-dark) !important;
        }
        
        .neu-common-btn:active {
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                         inset -4px -4px 8px var(--neu-shadow-light) !important;
            transform: translateY(1px) !important;
        }

        .neu-border-btn {
            border: 1.5px solid var(--btn-color) !important; 
            flex: 1 1 0%; 
            min-width: 160px; 
        }
        .neu-border-btn i {
            color: var(--btn-color) !important; 
            font-size: 1.1rem;
        }

        .icon-primary { color: var(--neu-primary) !important; }
        .icon-success { color: var(--neu-success) !important; }
        .icon-warning { color: var(--neu-warning) !important; }
        .icon-danger { color: var(--neu-danger) !important; }
        .icon-info { color: #0dcaf0 !important; }
        .icon-secondary { color: #6c757d !important; }

        .neu-icon-only {
            width: 48px !important; height: 48px !important; 
            padding: 0 !important;
            border-radius: 50% !important; 
            font-size: 1.2rem;
        }

        .neu-brand {
            font-size: 1.4rem !important; 
            font-weight: 800 !important;
            letter-spacing: 0.5px !important;
        }
        .neu-brand i { font-size: 1.6rem !important; text-shadow: 2px 2px 4px var(--neu-shadow-dark); margin-right: 5px;}

        .neu-dropdown-menu {
            background-color: var(--neu-bg) !important; 
            border: none !important; border-radius: 15px !important;
            box-shadow: 12px 12px 24px var(--neu-shadow-dark) !important;
            padding: 15px !important; width: 350px !important; margin-top: 20px !important;
        }
        .neu-dropdown-item {
            border-radius: 12px !important; margin-bottom: 10px !important; padding: 15px !important;
            background: var(--neu-bg) !important; color: var(--neu-text) !important;
            box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light) !important; 
            display: block; text-decoration: none; transition: 0.3s !important;
        }
        .neu-dropdown-item:hover { box-shadow: inset 4px 4px 8px var(--neu-shadow-dark) !important; transform: scale(0.98); color: var(--neu-primary) !important; }

        .neu-welcome-text {
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);
            display: inline-flex; align-items: center; gap: 10px; 
            padding: 0 20px; 
            margin: 0 !important;
            height: 48px; 
            border-radius: 12px; font-weight: 600; font-size: 0.95rem;
        }
        .neu-welcome-role {
            font-size: 0.7rem; text-transform: uppercase; font-weight: 800;
            padding: 4px 8px; border-radius: 6px; background: var(--neu-bg);
            box-shadow: 2px 2px 4px var(--neu-shadow-dark), -2px -2px 4px var(--neu-shadow-light);
        }
        .role-owner { color: var(--neu-warning); }
        .role-staff { color: var(--neu-success); }
        .role-teacher { color: var(--neu-primary); }
    </style>
</head>
<body>

@php
    $isOwner = Auth::check() && Auth::user()->role === 'owner';
    $isStaff = Auth::check() && Auth::user()->role === 'staff';
    $isTeacher = Session::has('teacher_logged_in'); 
    
    $userName = 'User';
    $userRole = 'Guest';
    
    if($isOwner || $isStaff) {
        $userName = Auth::user()->name;
        $userRole = Auth::user()->role;
    } elseif ($isTeacher) {
        $userName = Session::get('teacher_name', 'Teacher');
        $userRole = 'teacher';
    }
    
    $notifications = collect(); $unreadCount = 0;

    if($isTeacher || $isOwner || $isStaff) {
        $notiQuery = \App\Models\Notification::query();
        if($isTeacher) { $notiQuery->where('type', 'teacher')->where('teacher_id', Session::get('teacher_id')); }
        else { $notiQuery->where('type', 'admin'); }
        $notifications = $notiQuery->latest()->take(5)->get(); 
        $unreadCount = $notiQuery->where('is_read', false)->count(); 
    }
@endphp

<header class="neu-navbar">
    <div class="container-fluid px-4 px-xl-5">
        
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-4" style="border-bottom: 2px solid rgba(163, 177, 198, 0.15); gap: 16px;">
            
            <div class="d-flex align-items-center" style="gap: 16px;">
                <a class="neu-common-btn neu-brand" href="{{ $isTeacher ? '/teacher-dashboard' : ($isOwner ? '/owner/dashboard' : '/staff/dashboard') }}">
                    <i class="bi bi-rocket-takeoff-fill icon-primary"></i> <span>EduGo</span>
                </a>
                
                @if($isOwner || $isStaff)
                    <div class="neu-common-btn d-none d-md-flex" style="cursor: default;">
                        <i class="bi bi-buildings-fill icon-primary"></i> {{ $instituteName }}
                    </div>
                @endif
            </div>
            
            <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
                
                @if(!$isTeacher)
                    <a class="neu-common-btn" href="/sms-broadcast">
                        <i class="bi bi-chat-left-text-fill icon-secondary"></i> <span class="d-none d-sm-inline">SMS Broadcast</span>
                    </a>
                @endif

                <button id="themeToggle" class="neu-common-btn neu-icon-only" title="Toggle Dark Mode">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>

                @if($isTeacher || $isOwner || $isStaff)
                <div class="dropdown">
                    <button class="neu-common-btn neu-icon-only" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi {{ $unreadCount > 0 ? 'bi-bell-fill icon-warning' : 'bi-bell' }}"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end neu-dropdown-menu">
                        <li class="px-3 py-2 fw-bold text-neu mb-3 d-flex align-items-center justify-content-between border-bottom pb-3" style="font-size: 1.1rem;">
                            <span><i class="bi bi-bell-fill text-warning me-2"></i>Notifications</span>
                            <span class="badge rounded-pill bg-primary px-3 py-1">{{ $unreadCount }} New</span>
                        </li>
                        <div style="max-height: 400px; overflow-y: auto; padding: 0 5px;">
                            @forelse($notifications as $noti)
                                <li>
                                    <a class="dropdown-item neu-dropdown-item" href="/admin-materials">
                                        <div class="fw-bold text-neu mb-1" style="font-size: 0.95rem; line-height: 1.4;">{{ $noti->message }}</div>
                                        <small class="opacity-75 d-flex align-items-center fw-medium text-neu" style="font-size: 0.8rem;">
                                            <i class="bi bi-clock-history me-2 text-primary"></i> {{ $noti->created_at->diffForHumans() }}
                                        </small>
                                    </a>
                                </li>
                            @empty
                                <li class="text-center py-4 opacity-50">
                                    <i class="bi bi-bell-slash d-block mb-3" style="font-size: 40px;"></i>
                                    <span class="fw-bold" style="font-size: 1.1rem;">No new updates</span>
                                </li>
                            @endforelse
                        </div>
                    </ul>
                </div>
                @endif

                @if(Auth::check() || $isTeacher)
                <div class="neu-welcome-text d-none d-lg-flex">
                    Welcome, {{ strtok($userName, " ") }} 👋
                    <span class="neu-welcome-role role-{{ $userRole }}">{{ $userRole }}</span>
                </div>
                @endif
                
                @php $logoutUrl = ($isOwner || $isStaff) ? '/owner-logout' : '/teacher-logout'; @endphp
                <a href="{{ $logoutUrl }}" class="neu-common-btn" style="color: var(--neu-danger) !important;">
                    <i class="bi bi-box-arrow-right icon-danger"></i> <span class="d-none d-sm-inline">Logout</span>
                </a>
            </div>
        </div>

        @if($isOwner || $isTeacher)
        <div class="d-flex flex-wrap align-items-center w-100" style="gap: 16px;">
            
            @if($isOwner)
                <a class="neu-common-btn neu-border-btn" style="--btn-color: var(--neu-danger);" href="/manage-staff">
                    <i class="bi bi-person-badge-fill"></i> Manage Staff
                </a>
                <a class="neu-common-btn neu-border-btn" style="--btn-color: var(--neu-warning);" href="/courses">
                    <i class="bi bi-journal-bookmark-fill"></i> Classes
                </a>
                <a class="neu-common-btn neu-border-btn" style="--btn-color: #0dcaf0;" href="/register">
                    <i class="bi bi-person-plus-fill"></i> Add Student
                </a>
                <a class="neu-common-btn neu-border-btn" style="--btn-color: var(--neu-primary);" href="/students">
                    <i class="bi bi-people-fill"></i> Student List
                </a>
                <a class="neu-common-btn neu-border-btn" style="--btn-color: var(--neu-success);" href="/payment">
                    <i class="bi bi-cash-coin"></i> Payments
                </a>
            @endif

        </div>
        @endif

    </div>
</header>

<div class="container pb-5">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;
        
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') { 
            htmlElement.setAttribute('data-bs-theme', 'dark'); 
            themeIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
        }

        themeToggleBtn.addEventListener('click', () => {
            const isDark = htmlElement.getAttribute('data-bs-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            if(isDark) {
                themeIcon.classList.replace('bi-sun-fill', 'bi-moon-fill');
            } else {
                themeIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMsg = "{{ session('success') }}";
        const errorMsg = "{{ session('error') }}";
        if (successMsg || errorMsg) {
            Swal.fire({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                background: 'var(--neu-bg)', color: 'var(--neu-text)',
                icon: successMsg ? 'success' : 'error', title: successMsg || errorMsg
            });
        }
    });
</script>

@yield('scripts')

<!-- ========================================== -->
<!-- ⭐ මෙන්න අලුත් Global Scanner කෑල්ල! ⭐ -->
<!-- ========================================== -->
@vite(['resources/js/app.js'])
<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            if (window.Echo) {
                console.log("Global Scanner Listening... Ready for mobile scans!");
                
                window.Echo.channel('gate-scanner')
                    .listen('.student.scanned', (e) => {
                        let mobileNumber = e.cardNumber;
                        
                        // 💥 මෙන්න නියම බෙහෙත! දැනට ඉන්නේ /punch පේජ් එකේ නම් Redirect කරන්නේ නෑ
                        if (window.location.pathname.includes('/punch')) {
                            console.log("දැනටමත් ඉන්නේ Punch පේජ් එකේ. Redirect කරන්නේ නෑ.");
                            return; // මෙතනින්ම කෝඩ් එක නවත්වනවා (punch.blade.php එකට වැඩේ බාර දෙනවා)
                        }
                        
                        // වෙන පේජ් එකක ඉන්නවා නම් විතරක් SweetAlert පණිවිඩය දෙනවා
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Mobile Scan Detected! Redirecting...',
                            showConfirmButton: false,
                            timer: 1500,
                            background: 'var(--neu-bg)', 
                            color: 'var(--neu-text)'
                        });

                        // ඊට පස්සේ Punch පේජ් එකට පනිනවා
                        setTimeout(() => {
                            window.location.href = "/punch?student_id=" + mobileNumber;
                        }, 800);
                    });
            } else {
                console.error("Laravel Echo is not loaded!");
            }
        }, 1000);
    });
</script>

</body>
</html>