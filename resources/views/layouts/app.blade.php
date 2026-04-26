<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'EduGo') }}</title>
    
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

        /* --- SUPER 3D NAVBAR --- */
        .neu-navbar {
            background-color: var(--neu-bg) !important;
            box-shadow: 0 12px 30px var(--neu-shadow-dark) !important;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            border-radius: 0 0 35px 35px;
            padding-top: 25px !important; 
            padding-bottom: 25px !important;
        }

        /* Brand Logo Style */
        .neu-brand {
            padding: 15px 35px !important;
            border-radius: 25px !important;
            box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                        inset -6px -6px 12px var(--neu-shadow-light) !important;
            color: var(--neu-text) !important;
            text-decoration: none !important;
            font-size: 2rem !important; 
            font-weight: 800 !important;
            letter-spacing: 1px !important;
            margin-right: 50px !important; 
        }
        .neu-brand i {
            font-size: 2.5rem !important; 
            text-shadow: 3px 3px 6px var(--neu-shadow-dark);
        }

        /* 3D Nav Links as Floating Pills - MAXIMUM CHUNKY & SPACED */
        .custom-nav-link {
            display: inline-flex !important; 
            align-items: center !important; 
            gap: 15px !important; 
            padding: 18px 40px !important; /* තවත් ලොකු කළා */
            border-radius: 50px !important; 
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
            font-size: 1.3rem !important; /* අකුරු සයිස් එක තවත් වැඩි කළා */
            font-weight: 700 !important;
            color: var(--neu-text) !important; 
            background: var(--neu-bg) !important;
            box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                       -8px -8px 16px var(--neu-shadow-light) !important;
            text-decoration: none !important; 
        }
        .custom-nav-link i { font-size: 1.7rem !important; } 
        .custom-nav-link:hover { 
            transform: translateY(-5px) !important; 
            box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                       -10px -10px 20px var(--neu-shadow-light) !important;
            color: var(--neu-primary) !important; 
        }
        .custom-nav-link:active {
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light) !important;
            transform: translateY(2px) !important;
        }

        /* Notification Icon Styling */
        .neu-noti-btn {
            width: 70px !important; height: 70px !important; /* සයිස් එක ලොකු කළා */
            border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important;
            background-color: var(--neu-bg) !important; 
            box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                       -8px -8px 16px var(--neu-shadow-light) !important;
            color: #ffb547 !important; position: relative !important; transition: 0.3s !important; cursor: pointer !important;
        }
        .neu-noti-btn i { font-size: 2rem !important; }
        .neu-noti-btn:hover { transform: scale(1.1) !important; box-shadow: 10px 10px 20px var(--neu-shadow-dark) !important; }

        /* FIXED 3D NOTIFICATION DROPDOWN */
        .neu-dropdown-menu {
            background-color: var(--neu-bg) !important; 
            border: none !important; border-radius: 25px !important;
            box-shadow: 15px 15px 35px var(--neu-shadow-dark), -15px -15px 35px var(--neu-shadow-light) !important;
            padding: 20px !important; width: 420px !important; overflow: hidden; margin-top: 25px !important;
        }
        .neu-dropdown-item {
            border-radius: 18px !important; 
            margin-bottom: 15px !important; 
            transition: 0.3s !important; 
            padding: 20px !important;
            background: var(--neu-bg) !important; 
            color: var(--neu-text) !important;
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light) !important; 
            border: none !important;
            white-space: normal !important; display: block; text-decoration: none;
        }
        .neu-dropdown-item:hover { 
            box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light) !important;
            transform: scale(0.98); color: var(--neu-primary) !important; 
        }

        /* Logout Button */
        .neu-logout-btn {
            background-color: var(--neu-bg) !important; color: var(--neu-danger) !important; border-radius: 50px !important;
            padding: 18px 40px !important; font-weight: 800 !important; font-size: 1.3rem !important; /* සයිස් වැඩි කළා */
            box-shadow: 8px 8px 16px var(--neu-shadow-dark), -8px -8px 16px var(--neu-shadow-light) !important;
            display: inline-flex !important; align-items: center !important; gap: 15px !important; transition: 0.3s !important;
            text-decoration: none !important;
        }
        .neu-logout-btn i { font-size: 1.7rem !important; }
        .neu-logout-btn:hover {
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light) !important;
            color: #ff4d4d !important;
        }

        .floating-theme-btn {
            position: fixed; bottom: 30px; right: 30px; z-index: 1050; 
            background-color: var(--neu-bg); color: #ffb547; border: none;
            width: 65px; height: 65px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 7px 7px 14px var(--neu-shadow-dark), -7px -7px 14px var(--neu-shadow-light);
            transition: 0.3s; cursor: pointer;
        }
        .floating-theme-btn:active { box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light); }
    </style>
</head>
<body>

@php
    $isTeacher = Session::has('teacher_logged_in');
    $isAdmin = Session::has('admin_logged_in');
    $notifications = collect(); $unreadCount = 0;

    if($isTeacher || $isAdmin) {
        $notiQuery = \App\Models\Notification::query();
        if($isTeacher) { $notiQuery->where('type', 'teacher')->where('teacher_id', Session::get('teacher_id')); }
        else { $notiQuery->where('type', 'admin'); }
        $notifications = $notiQuery->latest()->take(5)->get(); 
        $unreadCount = $notiQuery->where('is_read', false)->count(); 
    }
@endphp

<nav class="navbar navbar-expand-xl neu-navbar mb-5 sticky-top">
    <div class="container-fluid px-xl-5"> 
        <a class="navbar-brand d-flex align-items-center gap-3 neu-brand" href="{{ Session::has('admin_logged_in') ? '/dashboard' : '/teacher-dashboard' }}">
            <i class="bi bi-rocket-takeoff-fill text-primary"></i> <span>EduGo</span>
        </a>
        
        <button class="navbar-toggler border-0 p-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-radius: 15px; box-shadow: 4px 4px 8px var(--neu-shadow-dark);">
            <i class="bi bi-list fs-1 text-neu"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex flex-column flex-xl-row ms-auto align-items-center mt-4 mt-xl-0" style="gap: 35px !important;"> 
                
                @if(Session::has('admin_logged_in'))
                    <a class="custom-nav-link" href="/courses"><i class="bi bi-journal-bookmark-fill text-warning"></i> Classes</a>
                    <a class="custom-nav-link" href="/register"><i class="bi bi-person-plus-fill text-info"></i> Add Student</a>
                    <a class="custom-nav-link" href="/students"><i class="bi bi-people-fill text-primary"></i> Student List</a>
                    <a class="custom-nav-link" href="/payment"><i class="bi bi-cash-coin text-success"></i> Payments</a>
                @elseif(Session::has('teacher_logged_in'))
                    <a class="custom-nav-link" href="/teacher-dashboard"><i class="bi bi-house-door text-success"></i> Dashboard</a>
                @endif

                <div class="d-none d-xl-block mx-2"><div style="width: 3px; height: 50px; background: var(--neu-shadow-dark); opacity: 0.3; border-radius: 5px;"></div></div>
                
                @if($isTeacher || $isAdmin)
                <div class="dropdown d-flex align-items-center">
                    <div class="neu-noti-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi {{ $unreadCount > 0 ? 'bi-bell-fill' : 'bi-bell' }}"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="border: 3px solid var(--neu-bg); font-size: 0.9rem; padding: 6px 10px;">{{ $unreadCount }}</span>
                        @endif
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end neu-dropdown-menu">
                        <li class="px-3 py-2 fw-bold text-neu mb-4 d-flex align-items-center justify-content-between border-bottom pb-3 fs-5">
                            <span><i class="bi bi-bell-fill text-warning me-2"></i>Notifications</span>
                            <span class="badge rounded-pill bg-primary fs-6 px-3 py-2">{{ $unreadCount }} New</span>
                        </li>
                        <div style="max-height: 450px; overflow-y: auto; padding-right: 10px; padding-left: 10px;">
                            @forelse($notifications as $noti)
                                <li>
                                    <a class="dropdown-item neu-dropdown-item" href="/notifications/{{ $noti->id }}/read">
                                        <div class="fw-bold text-neu mb-2 fs-6" style="line-height: 1.5;">{{ $noti->message }}</div>
                                        <small class="opacity-75 d-flex align-items-center fw-medium text-neu" style="font-size: 0.9rem;">
                                            <i class="bi bi-clock-history me-2 text-primary"></i> {{ $noti->created_at->diffForHumans() }}
                                        </small>
                                    </a>
                                </li>
                            @empty
                                <li class="text-center py-5 opacity-50">
                                    <i class="bi bi-bell-slash d-block display-3 mb-4"></i>
                                    <span class="fw-bold fs-5">No new updates</span>
                                </li>
                            @endforelse
                        </div>
                    </ul>
                </div>
                @endif

                @php $logoutUrl = Session::has('admin_logged_in') ? '/logout' : '/teacher-logout'; @endphp
                <a href="{{ $logoutUrl }}" class="neu-logout-btn"><i class="bi bi-power"></i> Logout</a>
                
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid px-xl-5 pb-5">
    @yield('content')
</div>

<button id="themeToggle" class="floating-theme-btn"><i class="bi bi-moon-fill fs-2"></i></button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggleBtn = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') { htmlElement.setAttribute('data-bs-theme', 'dark'); themeToggleBtn.innerHTML = '<i class="bi bi-sun-fill fs-2"></i>'; }
        themeToggleBtn.addEventListener('click', () => {
            const isDark = htmlElement.getAttribute('data-bs-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            themeToggleBtn.innerHTML = isDark ? '<i class="bi bi-moon-fill fs-2"></i>' : '<i class="bi bi-sun-fill fs-2"></i>';
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

</body>
</html>