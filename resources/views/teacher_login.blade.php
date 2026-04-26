<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Teacher Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        /* --- NEUMORPHISM THEME VARIABLES --- */
        :root {
            --neu-bg: #e0e5ec;
            --neu-shadow-dark: #a3b1c6;
            --neu-shadow-light: #ffffff;
            --neu-text: #333333;
            --neu-primary: #05cd99; /* Teacher portal එකට ගැලපෙන කොළ පාට Accent එක */
            --neu-danger: #dc3545;
        }

        [data-bs-theme="dark"] {
            --neu-bg: #242731; 
            --neu-shadow-dark: #17191f;
            --neu-shadow-light: #313543;
            --neu-text: #e0e5ec;
            --neu-primary: #05cd99; /* Teacher Theme Color */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--neu-bg) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
            margin: 0;
            padding: 20px;
        }

        /* --- COMPACT LOGIN CARD --- */
        .login-card {
            background-color: var(--neu-bg);
            width: 100%;
            max-width: 420px; 
            padding: 40px 30px; 
            border-radius: 25px;
            box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                       -12px -12px 24px var(--neu-shadow-light);
            border: none;
            transition: all 0.3s ease;
        }

        /* --- NEU ELEMENTS --- */
        .neu-icon-box {
            width: 70px; height: 70px; 
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            background-color: var(--neu-bg);
            box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                        inset -6px -6px 12px var(--neu-shadow-light);
            font-size: 32px; color: var(--neu-primary);
            margin: 0 auto 15px; 
        }

        .neu-input-group {
            background-color: var(--neu-bg);
            border-radius: 12px;
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                        inset -4px -4px 8px var(--neu-shadow-light);
            margin-bottom: 18px; 
            overflow: hidden;
            border: none;
            display: flex;
            align-items: center;
            padding-left: 15px;
        }
        
        .neu-input-icon {
            color: var(--neu-primary);
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .neu-input {
            background-color: transparent !important;
            border: none !important;
            color: var(--neu-text) !important;
            padding: 12px 15px !important; 
            font-size: 1rem;
            width: 100%;
            outline: none;
        }
        .neu-input:focus { box-shadow: none !important; }

        .neu-btn {
            background-color: var(--neu-bg);
            color: var(--neu-primary);
            border: none;
            border-radius: 12px;
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                       -5px -5px 10px var(--neu-shadow-light);
            font-weight: 700; font-size: 1.05rem;
            padding: 12px;
            transition: 0.2s; width: 100%;
            letter-spacing: 0.5px;
        }
        .neu-btn:hover { transform: translateY(-2px); color: var(--neu-primary); }
        .neu-btn:active {
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                        inset -3px -3px 6px var(--neu-shadow-light);
            transform: translateY(1px);
        }

        .neu-alert {
            background-color: var(--neu-bg);
            border-radius: 10px;
            color: var(--neu-danger);
            box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), 
                        inset -2px -2px 5px var(--neu-shadow-light);
            border: 1px solid rgba(220, 53, 69, 0.2);
            padding: 10px 15px;
            font-size: 0.9rem; margin-bottom: 20px;
        }

        .text-neu { color: var(--neu-text); }
        .text-neu-muted { color: var(--neu-text); opacity: 0.7; }

        /* Dark Mode Toggle */
        .theme-toggle {
            position: fixed; bottom: 20px; right: 20px;
            width: 50px; height: 50px; border-radius: 50%;
            background-color: var(--neu-bg);
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                       -5px -5px 10px var(--neu-shadow-light);
            display: flex; justify-content: center; align-items: center;
            cursor: pointer; border: none; color: #ffb547; font-size: 20px; transition: 0.3s;
        }
        .theme-toggle:active {
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                        inset -3px -3px 6px var(--neu-shadow-light);
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <div class="neu-icon-box">
            <i class="bi bi-rocket-takeoff-fill"></i>
        </div>
        <h2 class="fw-bold mb-1" style="color: var(--neu-text); letter-spacing: -0.5px;">{{ config('app.name') }}</h2>
        <h6 class="fw-bold mb-3 opacity-75" style="color: var(--neu-primary);">Teacher Portal</h6>
        
        <p class="text-neu-muted mb-4" style="font-size: 0.9rem;">Welcome back! Please login to your portal.</p>

        @if(session('error'))
            <div class="neu-alert fw-medium">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form action="/teacher-login" method="POST">
            @csrf
            <div class="neu-input-group">
                <i class="bi bi-person-fill neu-input-icon"></i>
                <input type="text" name="username" class="neu-input" placeholder="Username" required>
            </div>
            <div class="neu-input-group">
                <i class="bi bi-lock-fill neu-input-icon"></i>
                <input type="password" name="password" class="neu-input" placeholder="Password" required>
            </div>
            
            <button type="submit" class="neu-btn mt-3 mb-1">
                LOGIN <i class="bi bi-box-arrow-in-right ms-2"></i>
            </button>
        </form>
    </div>

    <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
        <i class="bi bi-sun-fill" id="themeIcon"></i>
    </button>

    <script>
        const html = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        // Load saved theme (Default is Dark for Teacher Portal)
        const savedTheme = localStorage.getItem('theme') || 'dark';
        html.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            themeIcon.className = theme === 'light' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>