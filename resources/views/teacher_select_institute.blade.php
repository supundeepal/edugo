<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Institute - EduGo SaaS</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- NEUMORPHISM DARK THEME --- */
        :root {
            --neu-bg: #242731; 
            --neu-shadow-dark: #15171d; 
            --neu-shadow-light: #2a2d38; 
            --neu-text: #e0e5ec;
            --neu-primary: #4facfe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--neu-bg);
            color: var(--neu-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        /* Netflix Style 3D Card */
        .institute-card {
            background-color: var(--neu-bg);
            border-radius: 25px;
            padding: 40px 20px;
            text-align: center;
            text-decoration: none;
            color: var(--neu-text);
            box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                       -8px -8px 16px var(--neu-shadow-light);
            transition: all 0.3s ease;
            display: block;
            height: 100%;
        }

        .institute-card:hover {
            transform: translateY(-8px);
            box-shadow: 12px 12px 20px var(--neu-shadow-dark), 
                       -12px -12px 20px var(--neu-shadow-light);
            color: var(--neu-primary);
        }

        .institute-card:active {
            transform: translateY(2px);
            box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                        inset -5px -5px 10px var(--neu-shadow-light);
        }

        /* Inner 3D Icon Box */
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px auto;
            border-radius: 50%;
            background: var(--neu-bg);
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                        inset -4px -4px 8px var(--neu-shadow-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: var(--neu-primary);
            transition: all 0.3s ease;
        }

        .institute-card:hover .icon-wrapper {
            transform: scale(1.1);
        }

        /* Logout Button */
        .logout-btn {
            background-color: var(--neu-bg);
            color: #dc3545;
            border: none;
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: 700;
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                       -5px -5px 10px var(--neu-shadow-light);
            transition: 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            color: #ff4d4d;
        }
    </style>
</head>
<body>

    <div class="container text-center">
        
        <div class="mb-5 pb-3">
            <h1 class="fw-bold mb-3" style="letter-spacing: -1px;">Welcome back, <span style="color: var(--neu-primary);">{{ session('teacher_name') }}</span>! 👋</h1>
            <p class="opacity-75 fs-5">Where are you teaching today? Select your institute to continue.</p>
        </div>

        <div class="row justify-content-center g-4 mb-5 pb-4" style="max-width: 900px; margin: 0 auto;">
            
            @foreach($institutes as $institute)
            <div class="col-6 col-md-4">
                <a href="/teacher/set-institute/{{ $institute->id }}" class="institute-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-buildings-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-truncate px-2">{{ $institute->name }}</h5>
                </a>
            </div>
            @endforeach

        </div>

        <div class="mt-4">
            <a href="/teacher/logout" class="logout-btn">
                <i class="bi bi-box-arrow-right me-2"></i> Log Out
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>