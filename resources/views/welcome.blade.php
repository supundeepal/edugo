<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smart Institute - Welcome</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <style>
            /* --- GLOBAL NEUMORPHISM VARIABLES --- */
            :root {
                --neu-bg: #e0e5ec;
                --neu-shadow-dark: #a3b1c6;
                --neu-shadow-light: #ffffff;
                --neu-text: #333333;
                --neu-primary: #0d6efd;
            }

            [data-bs-theme="dark"] {
                --neu-bg: #242731; 
                --neu-shadow-dark: #17191f;
                --neu-shadow-light: #313543;
                --neu-text: #e0e5ec;
                --neu-primary: #4facfe;
            }

            body { 
                font-family: 'Inter', sans-serif; 
                background-color: var(--neu-bg) !important;
                color: var(--neu-text) !important;
                transition: background-color 0.3s ease, color 0.3s ease;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                margin: 0;
                padding: 0;
            }

            .poppins { font-family: 'Poppins', sans-serif; }

            /* 3D Main Card */
            .neu-card {
                background-color: var(--neu-bg);
                border-radius: 30px;
                box-shadow: 15px 15px 30px var(--neu-shadow-dark), 
                           -15px -15px 30px var(--neu-shadow-light);
                padding: 50px;
                width: 100%;
                max-width: 900px;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            /* 3D Icon Box */
            .neu-icon-box {
                width: 100px; 
                height: 100px;
                border-radius: 50%;
                display: flex; 
                justify-content: center; 
                align-items: center;
                background-color: var(--neu-bg);
                box-shadow: inset 8px 8px 16px var(--neu-shadow-dark), 
                            inset -8px -8px 16px var(--neu-shadow-light);
                font-size: 50px;
                color: var(--neu-primary);
                margin-bottom: 30px;
            }

            /* 3D Buttons */
            .neu-btn {
                background-color: var(--neu-bg);
                color: var(--neu-text);
                border: none;
                border-radius: 15px;
                font-weight: 700;
                font-family: 'Poppins', sans-serif;
                font-size: 1.1rem;
                padding: 15px 40px;
                box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                           -6px -6px 12px var(--neu-shadow-light);
                transition: all 0.2s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
            }
            .neu-btn:hover {
                transform: translateY(-3px);
                color: var(--neu-primary);
            }
            .neu-btn:active {
                box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                            inset -4px -4px 8px var(--neu-shadow-light);
                transform: translateY(2px);
            }
            .neu-btn-primary { color: var(--neu-primary); }

            /* Grid Features (Inset boxes) */
            .neu-feature {
                background-color: var(--neu-bg);
                border-radius: 20px;
                padding: 25px;
                box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                            inset -5px -5px 10px var(--neu-shadow-light);
                text-align: center;
                height: 100%;
            }

            /* Floating Theme Toggle Button (3D Circle) */
            .floating-theme-btn {
                position: fixed;
                bottom: 30px; 
                right: 30px;  
                z-index: 1050; 
                background-color: var(--neu-bg); 
                color: #ffb547;
                border: none;
                width: 55px;
                height: 55px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                           -6px -6px 12px var(--neu-shadow-light);
                transition: all 0.2s ease;
                cursor: pointer;
            }
            .floating-theme-btn:hover { transform: translateY(-3px); color: var(--neu-primary); }
            .floating-theme-btn:active {
                box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                            inset -4px -4px 8px var(--neu-shadow-light);
                transform: translateY(2px);
            }

            /* Responsive Layout */
            .btn-container { display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; margin-top: 30px; }
            .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; width: 100%; margin-top: 50px; }
        </style>
    </head>
    <body>

        <button id="themeToggle" class="floating-theme-btn" title="Toggle Dark Mode">
            <i class="bi bi-moon-fill" style="font-size: 1.5rem;"></i>
        </button>

        <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center; padding: 20px;">
            
            <div class="neu-card">
                
                <div class="neu-icon-box">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>

                <h1 class="poppins" style="font-size: 2.8rem; font-weight: 700; margin-bottom: 10px; color: var(--neu-text);">Smart Institute</h1>
                <p style="font-size: 1.2rem; opacity: 0.7; margin-bottom: 20px; max-width: 600px;">
                    Advanced Gate Check-In, Payment Management, and Analytics Ecosystem.
                </p>

                <div class="btn-container">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="neu-btn neu-btn-primary">
                                <i class="bi bi-speedometer2"></i> Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="neu-btn neu-btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="neu-btn">
                                    <i class="bi bi-person-plus"></i> Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <div class="features-grid">
                    <div class="neu-feature">
                        <i class="bi bi-qr-code-scan" style="font-size: 2rem; color: var(--neu-primary); opacity: 0.8;"></i>
                        <h3 class="poppins" style="margin: 15px 0 5px; font-size: 1.2rem; font-weight: 600;">Fast Scanning</h3>
                        <p style="font-size: 0.9rem; opacity: 0.6; margin: 0;">Instant QR barcode punch tracking.</p>
                    </div>
                    <div class="neu-feature">
                        <i class="bi bi-cash-stack" style="font-size: 2rem; color: #10b981; opacity: 0.8;"></i>
                        <h3 class="poppins" style="margin: 15px 0 5px; font-size: 1.2rem; font-weight: 600;">Payments</h3>
                        <p style="font-size: 0.9rem; opacity: 0.6; margin: 0;">Manage fees, arrears, and payouts.</p>
                    </div>
                    <div class="neu-feature">
                        <i class="bi bi-bar-chart-fill" style="font-size: 2rem; color: #ffb547; opacity: 0.8;"></i>
                        <h3 class="poppins" style="margin: 15px 0 5px; font-size: 1.2rem; font-weight: 600;">Analytics</h3>
                        <p style="font-size: 0.9rem; opacity: 0.6; margin: 0;">Detailed monthly and daily reports.</p>
                    </div>
                </div>

            </div>
        </div>

        <script>
            // Simple Theme Toggle Script for Welcome Page
            document.addEventListener('DOMContentLoaded', () => {
                const themeToggleBtn = document.getElementById('themeToggle');
                const htmlElement = document.documentElement;
                
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'dark') {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    themeToggleBtn.innerHTML = '<i class="bi bi-sun-fill" style="font-size: 1.5rem;"></i>';
                }

                themeToggleBtn.addEventListener('click', () => {
                    if (htmlElement.getAttribute('data-bs-theme') === 'light') {
                        htmlElement.setAttribute('data-bs-theme', 'dark');
                        localStorage.setItem('theme', 'dark');
                        themeToggleBtn.innerHTML = '<i class="bi bi-sun-fill" style="font-size: 1.5rem;"></i>';
                    } else {
                        htmlElement.setAttribute('data-bs-theme', 'light');
                        localStorage.setItem('theme', 'light');
                        themeToggleBtn.innerHTML = '<i class="bi bi-moon-fill" style="font-size: 1.5rem;"></i>';
                    }
                });
            });
        </script>
    </body>
</html>