<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGo Mobile Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#151521">
<link rel="apple-touch-icon" href="/icon.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <style>
        /* =========================================
           DARK MODE (Default Variables)
           ========================================= */
        :root {
            --bg-color: #151521;
            --card-bg: #1e1e2d;
            --card-grad: linear-gradient(145deg, #1e1e2d, #1a1a28);
            --border-color: #2b2b40;
            --text-main: #ffffff;
            --text-muted: #92929f;
            --blue: #3699ff;
            --green: #1bc5bd;
            --red: #f64e60;
            --yellow: #ffa800;
            
            --input-bg: #12121c;
            --nav-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.05);
            --btn-3d-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05);
            --btn-dark-grad: linear-gradient(145deg, #1b1b29, #151521);
            --btn-text-shadow: 0 2px 5px rgba(0,0,0,0.5);
            --icon-bg: linear-gradient(145deg, #1e1e2d, #151521);
        }
        
        /* =========================================
           LIGHT MODE (Overrides)
           ========================================= */
        body.light-mode {
            --bg-color: #f3f6f9;
            --card-bg: #ffffff;
            --card-grad: linear-gradient(145deg, #ffffff, #f8f9fa);
            --border-color: #ebedf3;
            --text-main: #181c32;
            --text-muted: #a1a5b7;
            
            --input-bg: #ffffff;
            --nav-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            --btn-3d-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.5);
            --btn-dark-grad: linear-gradient(145deg, #ffffff, #f3f6f9);
            --btn-text-shadow: none;
            --icon-bg: linear-gradient(145deg, #ffffff, #f3f6f9);
        }

        /* Base Styles with Smooth Transition */
        body { 
            background-color: var(--bg-color); 
            color: var(--text-main);
            font-family: 'Poppins', sans-serif; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: background-color 0.4s ease, color 0.4s ease;
        }
        
        /* Top Navigation */
        .navbar-custom {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 20px;
            box-shadow: var(--nav-shadow);
            z-index: 10;
            transition: all 0.4s ease;
        }
        
        .navbar-brand { font-weight: 700; color: var(--text-main) !important; font-size: 1.3rem; letter-spacing: 0.5px; }
        .nav-icon { color: var(--blue); margin-right: 8px; text-shadow: 0 0 10px rgba(54, 153, 255, 0.4); }
        
        /* Theme & Logout Buttons */
        .theme-toggle-btn {
            background: transparent;
            color: var(--text-muted);
            border: none;
            font-size: 1.2rem;
            padding: 5px 10px;
            transition: color 0.3s ease;
        }
        .theme-toggle-btn:hover { color: var(--blue); }

        .logout-btn-nav {
            background: rgba(246, 78, 96, 0.1);
            color: var(--red);
            border: 1px solid rgba(246, 78, 96, 0.2);
            border-radius: 8px;
            padding: 6px 14px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Container */
        .app-container { 
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            padding-bottom: 12vh; 
        }

        /* Cards */
        .custom-card { 
            background: var(--card-grad); 
            border-radius: 20px; 
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            padding: 40px 25px; 
            width: 100%;
            max-width: 420px;
            z-index: 5;
            transition: all 0.4s ease;
        }

        /* Inputs */
        .form-control, .input-group-text {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 16px 15px; 
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
        }
        .form-control:focus {
            background-color: var(--input-bg);
            border-color: var(--blue);
            color: var(--text-main);
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05), 0 0 10px rgba(54, 153, 255, 0.2);
        }
        .input-group-text { border-right: none; color: var(--text-muted); }
        .form-control { border-left: none; }

        /* Buttons */
        .btn-3d {
            border-radius: 12px;
            padding: 16px; 
            font-weight: 600;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
        }
        .btn-3d:active { transform: translateY(3px); }

        .btn-primary-custom {
            background: linear-gradient(145deg, rgba(54, 153, 255, 0.15), rgba(54, 153, 255, 0.05));
            color: var(--blue);
            border: 1px solid rgba(54, 153, 255, 0.3);
            box-shadow: 0 6px 15px rgba(54, 153, 255, 0.2), var(--btn-3d-shadow);
        }

        .btn-scanner {
            background: var(--btn-dark-grad);
            color: var(--green);
            border: 1px solid rgba(27, 197, 189, 0.3);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1), var(--btn-3d-shadow);
        }

        .btn-history {
            background: var(--btn-dark-grad);
            color: var(--blue);
            border: 1px solid rgba(54, 153, 255, 0.3);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1), var(--btn-3d-shadow);
        }

        .badge-role {
            background: linear-gradient(145deg, rgba(255, 168, 0, 0.2), rgba(255, 168, 0, 0.05));
            color: var(--yellow);
            border: 1px solid rgba(255, 168, 0, 0.2);
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .profile-icon-box {
            background: var(--icon-bg); 
            width: 55px; 
            height: 55px; 
            border-radius: 12px; 
            display:flex; 
            align-items:center; 
            justify-content:center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1), var(--btn-3d-shadow);
            border: 1px solid var(--border-color);
            transition: all 0.4s ease;
        }

        #reader { 
            width: 100%; 
            border-radius: 12px; 
            overflow: hidden; 
            border: 2px dashed rgba(27, 197, 189, 0.5);
        }
        #reader__dashboard_section_csr span { color: var(--text-main) !important; }

        .app-footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            opacity: 0.7;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
    <div class="navbar-brand mb-0">
        <i class="fa-solid fa-rocket nav-icon"></i> EduGo
    </div>
    <div class="d-flex align-items-center gap-3">
        <button onclick="toggleTheme()" class="theme-toggle-btn" id="theme-btn">
            <i class="fa-solid fa-sun" id="theme-icon"></i>
        </button>
        <button id="nav-logout-btn" onclick="logout()" class="logout-btn-nav d-none">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
    </div>
</nav>

<div class="app-container">
    
    <div id="login-section" class="custom-card w-100">
        <div class="text-center mb-5">
            <h3 class="fw-bold mb-2" style="color: var(--text-main); text-shadow: var(--btn-text-shadow);">System Login</h3>
            <p class="small" style="color: var(--text-muted);">Sign in to your EduGo account</p>
        </div>
        <div class="mb-4">
            <label class="small fw-bold mb-2" style="color: var(--text-muted); letter-spacing: 0.5px;">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" id="email" class="form-control" placeholder="staff@edugo.com">
            </div>
        </div>
        <div class="mb-5">
            <label class="small fw-bold mb-2" style="color: var(--text-muted); letter-spacing: 0.5px;">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" id="password" class="form-control" placeholder="******">
            </div>
        </div>
        <button onclick="login()" class="btn-3d btn-primary-custom w-100 mt-2">Login to System</button>
    </div>

    <div id="menu-section" class="custom-card w-100 d-none">
        <div class="d-flex align-items-center mb-4 pb-4 border-bottom" style="border-color: var(--border-color) !important;">
            <div class="me-3">
                <div class="profile-icon-box">
                    <i class="fa-solid fa-user" style="color: var(--blue); font-size: 1.4rem;"></i>
                </div>
            </div>
            <div>
                <div class="fw-bold mb-2" id="user-name" style="font-size: 1.15rem; text-shadow: var(--btn-text-shadow);">Welcome, User</div>
                <span class="badge-role" id="user-role">STAFF</span>
            </div>
        </div>

        <div class="mb-2 mt-2">
            <h4 class="fw-bold mb-3" style="color: var(--blue);">Gate Check-In System</h4>
            <p class="small mb-4 pb-3" style="color: var(--text-muted); line-height: 1.6;">
                Open the QR scanner to mark attendance and collect payments securely.
            </p>
            
            <button onclick="openScanner()" class="btn-3d btn-scanner w-100 mb-4">
                <i class="fa-solid fa-mobile-screen"></i> Mobile Scanner
            </button>

            <button onclick="checkHistory()" class="btn-3d btn-history w-100">
                <i class="fa-solid fa-desktop"></i> View Laptop Screen
            </button>
        </div>
    </div>

    <div id="scanner-section" class="custom-card w-100 d-none">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0" style="color: var(--green);"><i class="fa-solid fa-qrcode"></i> Scanning...</h5>
            <button onclick="closeScanner()" class="btn btn-sm" style="background: rgba(246, 78, 96, 0.1); color: var(--red); border: 1px solid rgba(246, 78, 96, 0.3); border-radius: 8px;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <div id="reader" class="mb-4"></div>
        
        <button onclick="closeScanner()" class="btn-3d w-100 mt-3" style="background: var(--input-bg); color: var(--text-muted); border: 1px solid var(--border-color); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            Stop Scanning
        </button>
    </div>

</div>

<div class="app-footer">
    <i class="fa-solid fa-shield-halved me-1"></i> Powered by EduGo Systems &copy; 2026
</div>

<script>
    let html5QrCode;
    const API_BASE = window.location.origin + '/api';

    // 🌙 Theme Toggle Logic
    window.onload = function() {
        const savedTheme = localStorage.getItem('theme');
        const icon = document.getElementById('theme-icon');
        
        // Load saved theme
        if (savedTheme === 'light') {
            document.body.classList.add('light-mode');
            icon.classList.replace('fa-sun', 'fa-moon');
        }

        // Check if user is logged in
        const token = localStorage.getItem('mobile_token');
        if (token) { showMenu(); }
    };

    function toggleTheme() {
        const body = document.body;
        const icon = document.getElementById('theme-icon');
        
        body.classList.toggle('light-mode');
        
        if (body.classList.contains('light-mode')) {
            icon.classList.replace('fa-sun', 'fa-moon');
            localStorage.setItem('theme', 'light');
        } else {
            icon.classList.replace('fa-moon', 'fa-sun');
            localStorage.setItem('theme', 'dark');
        }
    }

    // Smart SweetAlert (Changes color based on current theme)
    function getSwal() {
        const isLight = document.body.classList.contains('light-mode');
        return Swal.mixin({
            background: isLight ? '#ffffff' : '#1e1e2d',
            color: isLight ? '#181c32' : '#ffffff',
            confirmButtonColor: '#3699ff',
            cancelButtonColor: '#f64e60'
        });
    }

    // App Logic
    function login() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        getSwal().fire({ title: 'Logging in...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });

        fetch(`${API_BASE}/mobile-login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ email, password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                localStorage.setItem('mobile_token', data.token);
                localStorage.setItem('user_name', data.user.name);
                localStorage.setItem('user_role', data.user.role.toUpperCase());
                Swal.close();
                showMenu();
            } else {
                getSwal().fire('Error', data.message || 'Invalid Credentials', 'error');
            }
        });
    }

    function showMenu() {
        document.getElementById('login-section').classList.add('d-none');
        document.getElementById('scanner-section').classList.add('d-none');
        document.getElementById('menu-section').classList.remove('d-none');
        document.getElementById('nav-logout-btn').classList.remove('d-none'); 
        
        document.getElementById('user-name').innerText = "Welcome, " + localStorage.getItem('user_name');
        document.getElementById('user-role').innerText = localStorage.getItem('user_role') || 'STAFF';
    }

    function openScanner() {
        document.getElementById('menu-section').classList.add('d-none');
        document.getElementById('scanner-section').classList.remove('d-none');
        document.getElementById('nav-logout-btn').classList.add('d-none'); 
        document.getElementById('theme-btn').classList.add('d-none'); // Hide theme btn while scanning
        
        html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        html5QrCode.start({ facingMode: "environment" }, config, (decodedText) => {
            sendScanData(decodedText);
        }).catch(err => {
            getSwal().fire('Camera Error', 'Please allow camera permissions.', 'error');
            closeScanner();
        });
    }

    function closeScanner() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => { 
                document.getElementById('theme-btn').classList.remove('d-none');
                showMenu(); 
            }).catch(() => { showMenu(); });
        } else {
            document.getElementById('theme-btn').classList.remove('d-none');
            showMenu();
        }
    }

    function sendScanData(scannedId) {
        html5QrCode.pause(true); 
        const token = localStorage.getItem('mobile_token');

        fetch(`${API_BASE}/mobile-scan`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`, 
                'Accept': 'application/json'
            },
            body: JSON.stringify({ card_number: scannedId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                getSwal().fire({ 
                    title: '<span style="color:#1bc5bd">Scanned!</span>', 
                    text: 'ID: ' + scannedId, 
                    icon: 'success', 
                    timer: 1200, 
                    showConfirmButton: false 
                });
            } else {
                getSwal().fire('Failed', 'Error sending data', 'error');
            }
            setTimeout(() => { html5QrCode.resume(); }, 1500);
        });
    }

    function checkHistory() {
        getSwal().fire('Info', 'Watch your laptop screen to see scan results.', 'info');
    }

    function logout() {
        getSwal().fire({
            title: 'Logout?',
            text: "Are you sure you want to exit?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem('mobile_token');
                window.location.reload();
            }
        });
    }
    // ==========================================
    // 🚀 PWA AUTO INSTALL POPUP LOGIC
    // ==========================================
    let deferredPrompt;

    // Service Worker එක Register කිරීම (මේක නැතුව Pop-up එන්නේ නෑ)
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js');
        });
    }

    // Chrome එකෙන් Install කරන්න ලෑස්ති වුණාම මේක අල්ලගන්නවා
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault(); // Browser එකේ නෝමල් එක එන එක නවත්තනවා
        deferredPrompt = e; // ඒක අපේ Pop-up එකට පාවිච්චි කරන්න සේව් කරගන්නවා

        // කෙනෙක් ලොග් වෙලා ඉන්නවා නම් විතරක් Pop-up එක පෙන්නනවා
        if (localStorage.getItem('mobile_token')) {
            setTimeout(showInstallPrompt, 2000); // ලොග් වෙලා තත්පර 2කින් එන්න හදලා තියෙන්නේ
        }
    });

    function showInstallPrompt() {
        if (!deferredPrompt) return;

        // ලස්සන SweetAlert Pop-up එකක් යටින් එන්න හදනවා
        getSwal().fire({
            title: 'Install EduGo App',
            text: 'Add to home screen for faster scanning!',
            icon: 'info',
            position: 'bottom', // ෆෝන් එකේ යටින් එන්න
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-download"></i> Install Now',
            cancelButtonText: 'Later',
            toast: false,
            customClass: {
                popup: 'rounded-4 mb-4' // පොඩි කර්ව් ගතියක් දුන්නා ලස්සන වෙන්න
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // කස්ටමර් Install එබුවොත් ඔරිජිනල් Chrome Pop-up එක දෙනවා
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    deferredPrompt = null; // වැඩේ ඉවරයි
                });
            }
        });
    }
</script>
</body>
</html>