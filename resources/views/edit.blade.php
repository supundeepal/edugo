<!DOCTYPE html>
<html lang="si" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - {{ $student->student_name }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

   <style>
        /* --- NEUMORPHISM THEME --- */
        :root {
            --neu-bg: #e0e5ec;
            --neu-shadow-dark: #a3b1c6;
            --neu-shadow-light: #ffffff;
            --neu-text: #333333;
            --neu-warning: #ffb547;
        }

        [data-bs-theme="dark"] {
            --neu-bg: #242731; 
            --neu-shadow-dark: #15171d; 
            --neu-shadow-light: #2a2d38; /* අර සුදු ගතිය අයින් කළා */
            --neu-text: #e0e5ec;
            --neu-warning: #f59e0b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--neu-bg);
            color: var(--neu-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        /* 3D Main Card */
        .neu-card {
            background-color: var(--neu-bg);
            border-radius: 25px;
            /* 24px තිබ්බ ෂැඩෝ එක 18px කළා සිනිඳු වෙන්න */
            box-shadow: 9px 9px 18px var(--neu-shadow-dark), 
                       -9px -9px 18px var(--neu-shadow-light);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            border: none;
        }

        /* 3D Icon Box */
        .neu-icon-box-warning {
            width: 70px; 
            height: 70px;
            border-radius: 50%;
            display: flex; 
            justify-content: center; 
            align-items: center;
            background-color: var(--neu-bg);
            box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                        inset -5px -5px 10px var(--neu-shadow-light);
            font-size: 30px;
            color: var(--neu-warning);
            margin: 0 auto 20px auto;
        }

        /* 3D Inputs (ඇතුළට එබිලා) */
        .neu-input {
            background-color: var(--neu-bg) !important;
            border: none !important;
            border-radius: 15px !important;
            color: var(--neu-text) !important;
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                        inset -4px -4px 8px var(--neu-shadow-light) !important;
            padding: 12px 18px;
            transition: all 0.2s ease;
            width: 100%;
        }
        .neu-input:focus {
            outline: none;
            box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                        inset -6px -6px 12px var(--neu-shadow-light) !important;
        }

        /* 3D Buttons */
        .neu-btn {
            background-color: var(--neu-bg);
            color: var(--neu-text);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 12px 20px;
            /* ෂැඩෝ එක පොඩ්ඩක් අඩු කළා */
            box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                       -4px -4px 8px var(--neu-shadow-light);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            width: 100%;
        }
        .neu-btn:hover { transform: translateY(-2px); }
        .neu-btn:active {
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                        inset -3px -3px 6px var(--neu-shadow-light);
            transform: translateY(2px);
        }
        .neu-btn-warning { color: var(--neu-warning); }

        /* Avatar */
        .neu-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--neu-bg);
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                       -5px -5px 10px var(--neu-shadow-light);
            margin-bottom: 15px;
        }
        
        label {
            font-weight: 600;
            opacity: 0.8;
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }
        
        /* Custom File Input (Choose File Button) */
        input[type="file"].neu-input::file-selector-button {
            background-color: var(--neu-bg);
            color: var(--neu-warning);
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            margin-right: 15px;
            font-weight: 600;
            box-shadow: 3px 3px 6px var(--neu-shadow-dark), 
                       -3px -3px 6px var(--neu-shadow-light);
            cursor: pointer;
            transition: 0.2s;
        }
        input[type="file"].neu-input::file-selector-button:active {
            box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), 
                        inset -2px -2px 4px var(--neu-shadow-light);
            transform: translateY(1px);
        }
    </style>
</head>
<body>

<div class="neu-card">
    <div class="neu-icon-box-warning">
        <i class="bi bi-pencil-square"></i>
    </div>
    <h3 class="text-center fw-bold mb-4" style="color: var(--neu-warning);">විස්තර වෙනස් කරන්න</h3>
    
    <form action="/students/update/{{ $student->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-4 text-center">
            @if($student->photo)
                <img src="{{ asset('storage/' . $student->photo) }}" class="neu-avatar mx-auto">
            @else
                <div class="neu-avatar mx-auto d-flex justify-content-center align-items-center" style="color: var(--neu-text); opacity: 0.5; font-size: 40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
            @endif
            <label class="mt-2">නව ඡායාරූපය (අවශ්‍ය නම් පමණි):</label>
            <input type="file" name="photo" class="form-control neu-input mt-2">
        </div>

        <div class="mb-4">
            <label>ළමයාගේ නම:</label>
            <input type="text" name="student_name" value="{{ $student->student_name }}" class="form-control neu-input fw-bold" required>
        </div>
        
        <div class="mb-4">
            <label>කාඩ් අංකය:</label>
            <input type="text" name="card_number" value="{{ $student->card_number }}" class="form-control neu-input fw-bold" required>
        </div>

        <div class="mb-5">
            <label>දුරකථන අංකය:</label>
            <input type="text" name="parent_phone" value="{{ $student->parent_phone }}" class="form-control neu-input fw-bold" required>
        </div>
        
        <div class="row g-3">
            <div class="col-6">
                <a href="/students" class="neu-btn w-100" style="color: var(--neu-text); opacity: 0.8;">
                    <i class="bi bi-x-circle me-2"></i> Cancel
                </a>
            </div>
            <div class="col-6">
                <button type="submit" class="neu-btn neu-btn-warning w-100">
                    <i class="bi bi-save-fill me-2"></i> Update
                </button>
            </div>
        </div>
    </form>
</div>

</body>
</html>