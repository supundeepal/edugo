<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGo SaaS - Super Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- NEUMORPHISM THEME VARIABLES --- */
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
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--neu-bg) !important;
            color: var(--neu-text);
            transition: background-color 0.3s ease;
            height: 100vh;
            overflow: hidden;
        }

        /* 3D Card */
        .neu-card {
            background-color: var(--neu-bg) !important;
            border-radius: 20px;
            border: none !important;
            box-shadow: 7px 7px 14px var(--neu-shadow-dark), 
                       -7px -7px 14px var(--neu-shadow-light) !important; 
            transition: all 0.3s ease;
        }

        /* 3D Button / Sidebar Link */
        .neu-btn {
            background-color: var(--neu-bg);
            color: var(--neu-text);
            border: none;
            border-radius: 15px;
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                       -5px -5px 10px var(--neu-shadow-light);
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .neu-btn:hover {
            color: var(--neu-primary);
            transform: translateY(-2px);
        }

        /* Active/Pressed State */
        .neu-pressed {
            box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                         inset -5px -5px 10px var(--neu-shadow-light) !important;
            color: var(--neu-primary) !important;
        }

        .text-neu { color: var(--neu-text); }
        
        .sidebar-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                         inset -3px -3px 6px var(--neu-shadow-light);
        }

        /* ⭐ Hide scrollbar for the sidebar navigation but keep it scrollable */
        nav.overflow-y-auto::-webkit-scrollbar {
            display: none; 
        }
        nav.overflow-y-auto {
            -ms-overflow-style: none;  
            scrollbar-width: none;  
        }

        /* ⭐ Custom Thin Scrollbar for the main content area */
        main.overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        main.overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }
        main.overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: var(--neu-shadow-dark);
            border-radius: 10px;
        }
        main.overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background-color: var(--neu-primary);
        }

    </style>
</head>
<body class="d-flex">

    <div class="neu-card m-3 d-flex flex-column" style="width: 280px; z-index: 10;">
        
        <div class="p-4 text-center border-bottom" style="border-color: rgba(0,0,0,0.05) !important;">
            <h2 class="fw-bold mb-0" style="color: var(--neu-primary); letter-spacing: -0.5px;">EduGo <span class="text-neu">SaaS</span></h2>
            <p class="mb-0 text-neu" style="opacity: 0.6; font-size: 0.8rem;">Super Admin Portal</p>
        </div>

        <nav class="flex-grow-1 p-3 overflow-y-auto d-flex flex-column gap-3 mt-2">
            
            <a href="/superadmin/dashboard" class="neu-btn p-3 {{ Request::is('superadmin/dashboard') ? 'neu-pressed' : '' }}">
                <div class="sidebar-icon me-3 text-primary"><i class="bi bi-grid-fill"></i></div>
                Dashboard
            </a>

            <a href="/superadmin/institutes" class="neu-btn p-3 {{ Request::is('superadmin/institutes') ? 'neu-pressed' : '' }}">
                <div class="sidebar-icon me-3" style="color: var(--neu-success);"><i class="bi bi-buildings-fill"></i></div>
                Institutes
            </a>

            <a href="/superadmin/users" class="neu-btn p-3 {{ Request::is('superadmin/users') ? 'neu-pressed' : '' }}">
                <div class="sidebar-icon me-3" style="color: var(--neu-warning);"><i class="bi bi-people-fill"></i></div>
                Owners / Users
            </a>

            <a href="/superadmin/settings" class="neu-btn p-3 {{ Request::is('superadmin/settings') ? 'neu-pressed' : '' }}">
                <div class="sidebar-icon me-3" style="color: var(--neu-danger);"><i class="bi bi-gear-fill"></i></div>
                System Settings
            </a>

            <a href="/superadmin/sms-wallets" class="neu-btn p-3 {{ Request::is('superadmin/sms-wallets') ? 'neu-pressed' : '' }}">
                <div class="sidebar-icon me-3" style="color: #0dcaf0;"><i class="bi bi-wallet2"></i></div>
                SMS Wallets
            </a>

        </nav>

        <div class="p-3 mt-auto">
            <div class="neu-card p-3 d-flex align-items-center">
                <div class="sidebar-icon me-3 bg-primary text-white" style="box-shadow: none;">SA</div>
                <div>
                    <h6 class="mb-0 fw-bold text-neu">Supun</h6>
                    <a href="/superadmin/logout" class="text-danger text-decoration-none" style="font-size: 0.8rem;"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-grow-1 d-flex flex-column" style="height: 100vh;">
        
        <header class="neu-card m-3 mb-2 p-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-neu ms-2">@yield('title', 'Dashboard Overview')</h4>
            
            <div class="d-flex gap-3">
                <button id="darkModeToggle" class="neu-btn" style="width: 45px; height: 45px; justify-content: center;">
                    <i id="themeIcon" class="bi bi-moon-fill"></i>
                </button>
                <button class="neu-btn" style="width: 45px; height: 45px; justify-content: center; color: var(--neu-primary);">
                    <i class="bi bi-bell-fill"></i>
                </button>
            </div>
        </header>

        <main class="flex-grow-1 p-3 overflow-y-auto">
            @yield('content')
        </main>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('darkModeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement; 

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                themeIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
            }

            themeToggleBtn.addEventListener('click', function() {
                if (htmlElement.getAttribute('data-bs-theme') === 'dark') {
                    htmlElement.removeAttribute('data-bs-theme');
                    themeIcon.classList.replace('bi-sun-fill', 'bi-moon-fill');
                    localStorage.setItem('theme', 'light');
                } else {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    themeIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>