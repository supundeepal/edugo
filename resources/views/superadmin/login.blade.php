<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - EduGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #e0e5ec;
            color: #4d5b6b;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .neu-card {
            background-color: #e0e5ec;
            border-radius: 20px;
            box-shadow: 10px 10px 20px #a3b1c6, -10px -10px 20px #ffffff;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border: none;
        }
        .neu-input {
            background-color: #e0e5ec;
            border: none;
            border-radius: 12px;
            box-shadow: inset 4px 4px 8px #a3b1c6, inset -4px -4px 8px #ffffff;
            color: #4d5b6b;
            padding: 15px;
            width: 100%;
            margin-bottom: 25px;
        }
        .neu-input:focus { outline: none; box-shadow: inset 6px 6px 12px #a3b1c6, inset -6px -6px 12px #ffffff; }
        .neu-btn {
            background-color: #e0e5ec; border: none; border-radius: 12px;
            box-shadow: 5px 5px 10px #a3b1c6, -5px -5px 10px #ffffff;
            color: #dc3545; font-weight: bold; padding: 14px; width: 100%; transition: all 0.2s ease;
        }
        .neu-btn:hover { transform: translateY(-2px); }
        .neu-btn:active { box-shadow: inset 3px 3px 6px #a3b1c6, inset -3px -3px 6px #ffffff; }
    </style>
</head>
<body>

    <div class="neu-card text-center">
        <i class="bi bi-shield-lock-fill mb-2" style="font-size: 3.5rem; color: #dc3545; text-shadow: 2px 2px 5px #a3b1c6;"></i>
        <h3 class="fw-bold mb-1" style="color: #dc3545;">Master Portal</h3>
        <p class="mb-4 fw-bold" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">SUPER ADMIN SECURE LOGIN</p>

        @if(session('error'))
            <div class="alert alert-danger" style="border-radius: 10px; font-size: 0.85rem; font-weight: bold;"><i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success" style="border-radius: 10px; font-size: 0.85rem; font-weight: bold;"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
        @endif

        <form action="/superadmin/login" method="POST">
            @csrf
            <div class="text-start">
                <label class="fw-bold mb-2 ps-2" style="font-size: 0.85rem; color: #dc3545;">Master Email</label>
                <input type="email" name="email" class="neu-input" value="admin@edugo.lk" required>
            </div>
            <div class="text-start">
                <label class="fw-bold mb-2 ps-2" style="font-size: 0.85rem; color: #dc3545;">Passcode</label>
                <input type="password" name="password" class="neu-input" placeholder="••••••••" required>
            </div>
            <button type="submit" class="neu-btn mt-2"><i class="bi bi-key-fill me-2" style="font-size: 1.2rem;"></i> Authorize Access</button>
        </form>
    </div>

</body>
</html>