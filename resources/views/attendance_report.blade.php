<!DOCTYPE html>
<html lang="si" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    
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
            --neu-primary: #0d6efd;
            --neu-success: #10b981;
        }

        [data-bs-theme="dark"] {
            --neu-bg: #242731; 
            --neu-shadow-dark: #15171d; 
            --neu-shadow-light: #2a2d38; /* <--- අර සුදු ගතිය අයින් කළා */
            --neu-text: #e0e5ec;
            --neu-primary: #4facfe;
            --neu-success: #05cd99;
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
            max-width: 1000px;
            border: none;
        }

        /* 3D Icon Box */
        .neu-icon-box-success {
            width: 60px; 
            height: 60px;
            border-radius: 50%;
            display: flex; 
            justify-content: center; 
            align-items: center;
            background-color: var(--neu-bg);
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                        inset -4px -4px 8px var(--neu-shadow-light);
            font-size: 28px;
            color: var(--neu-success);
        }

        /* 3D Buttons */
        .neu-btn {
            background-color: var(--neu-bg);
            color: var(--neu-text);
            border: none;
            border-radius: 15px;
            font-weight: 700;
            padding: 12px 20px;
            /* ෂැඩෝ එක පොඩ්ඩක් අඩු කළා */
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                       -5px -5px 10px var(--neu-shadow-light);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .neu-btn:hover { transform: translateY(-2px); }
        .neu-btn:active {
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                        inset -3px -3px 6px var(--neu-shadow-light);
            transform: translateY(2px);
        }

        /* --- 3D Table Rows --- */
        .neu-table {
            border-collapse: separate;
            border-spacing: 0 15px; 
            width: 100%;
        }
        .neu-table th {
            border: none;
            padding: 12px 20px;
            color: var(--neu-text);
            opacity: 0.6;
            font-weight: 700;
            font-size: 1rem;
        }
        .neu-table td {
            background-color: var(--neu-bg);
            border: none;
            padding: 18px 20px;
            vertical-align: middle;
            color: var(--neu-text);
            font-size: 1.05rem;
        }
        .neu-table td:first-child { border-top-left-radius: 15px; border-bottom-left-radius: 15px; }
        .neu-table td:last-child { border-top-right-radius: 15px; border-bottom-right-radius: 15px; }
        .neu-table tr.neu-row {
            /* ටේබල් එකේ පේළි වල ෂැඩෝ එක සිනිඳු කළා */
            box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                       -4px -4px 8px var(--neu-shadow-light);
            transition: all 0.3s ease;
        }
        .neu-table tr.neu-row:hover {
            transform: translateY(-3px);
            box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                       -6px -6px 12px var(--neu-shadow-light);
        }

        /* Badges */
        .neu-badge {
            background-color: var(--neu-bg);
            padding: 6px 15px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), 
                        inset -2px -2px 5px var(--neu-shadow-light);
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="neu-card">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        
        <div class="d-flex align-items-center">
            <div class="neu-icon-box-success me-3">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <h2 class="fw-bold mb-0 text-neu" style="color: var(--neu-success) !important;">අද දින පැමිණීමේ වාර්තාව</h2>
        </div>

        <div class="d-flex gap-3">
            <a href="/punch" class="neu-btn" style="color: var(--neu-primary);">
                <i class="bi bi-upc-scan me-2"></i> Punch Screen
            </a>
            <a href="/students" class="neu-btn">
                <i class="bi bi-people-fill me-2"></i> Student List
            </a>
        </div>
        
    </div>

    <div class="table-responsive px-2 pb-2">
        <table class="neu-table text-center">
            <thead>
                <tr>
                    <th class="ps-4 text-start">වේලාව</th>
                    <th class="text-start">ළමයාගේ නම</th>
                    <th class="pe-4 text-end">කාඩ් අංකය</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendance as $entry)
                <tr class="neu-row">
                    <td class="ps-4 text-start fw-medium" style="opacity: 0.8;">
                        <i class="bi bi-clock me-2"></i>{{ $entry->created_at->format('H:i A') }}
                    </td>
                    <td class="fw-bold text-start" style="color: var(--neu-primary);">
                        {{ $entry->student_name }}
                    </td>
                    <td class="pe-4 text-end">
                        <span class="neu-badge">{{ $entry->card_number }}</span>
                    </td>
                </tr>
                @empty
                <tr class="neu-row">
                    <td colspan="3" class="py-5 text-neu" style="opacity: 0.6;">
                        <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                        <h4 class="fw-bold">තවම කිසිම ළමයෙක් අද දින පැමිණ නැත.</h4>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>