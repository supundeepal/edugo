<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student ID - {{ $student->student_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        /* --- NEUMORPHISM ID CARD THEME --- */
        :root {
            --neu-bg: #e0e5ec;
            --neu-shadow-dark: #a3b1c6;
            --neu-shadow-light: #ffffff;
            --brand-primary: #0d6efd;
            --brand-danger: #dc3545;
            --text-dark: #2d3436;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--neu-bg); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            color: var(--text-dark);
        }

        /* 3D Floating ID Card Container */
        .id-card-wrapper {
            padding: 30px;
            border-radius: 40px;
            background-color: var(--neu-bg);
            box-shadow: 20px 20px 40px var(--neu-shadow-dark), 
                       -20px -20px 40px var(--neu-shadow-light);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* The actual ID Card */
        .id-card { 
            width: 340px; 
            height: 540px; /* කාඩ් එකේ උස පොඩ්ඩක් වැඩි කළා ඉඩ එන්න */
            background: #ffffff; 
            border-radius: 20px; 
            overflow: hidden; 
            position: relative; 
            text-align: center; 
            box-shadow: inset 5px 5px 15px rgba(0,0,0,0.03); 
            border: 1px solid rgba(0,0,0,0.05);
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        /* ID Card Header */
        .header { 
            background: linear-gradient(135deg, var(--brand-primary), #0dcaf0); 
            height: 125px; 
            padding-top: 25px; 
            color: white; 
            position: relative;
        }
        .header h2 { margin: 0; font-size: 26px; font-weight: 800; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(0,0,0,0.2); }
        .header p { margin: 0; font-size: 11px; font-weight: 600; opacity: 0.9; letter-spacing: 3px; text-transform: uppercase; }

        /* Photo Area */
        .photo-area { 
            margin-top: -60px; 
            position: relative;
            z-index: 10;
        }
        .photo-area img { 
            width: 130px; 
            height: 130px; 
            border-radius: 50%; 
            border: 6px solid #ffffff; 
            object-fit: cover; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.15); 
            background-color: #fff;
        }

        /* Details Section */
        .details { padding: 15px 25px 0; }
        
        .index-box {
            display: inline-block;
            background-color: #f8f9fa;
            padding: 6px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #555;
            border: 1px solid #e9ecef;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .index-box span { color: var(--brand-danger); font-size: 18px; margin-left: 5px; letter-spacing: 1px;}

        .details h3 { margin: 0 0 15px 0; color: #222; font-size: 22px; font-weight: 800; line-height: 1.2; text-transform: uppercase; }
        
        /* Fast-Scan QR Code Area */
        .qr-area { 
            padding: 10px; 
            background: #ffffff; 
            display: inline-block; 
            border-radius: 15px; 
            border: 2px dashed #ced4da;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        
        /* QR කෝඩ් එක ගාණට මැදට වෙන්න හැදුවා */
        .qr-area img { width: 110px; height: 110px; display: block; }

        /* Footer */
        .footer { 
            position: absolute; 
            bottom: 0; 
            width: 100%; 
            background: #1e272e; 
            color: white; 
            padding: 15px 0; 
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
        }

        /* Neumorphism Print Button */
        .print-btn { 
            position: fixed; 
            top: 30px; 
            right: 30px; 
            padding: 15px 30px; 
            background: var(--neu-bg); 
            color: var(--brand-primary); 
            border: none; 
            border-radius: 15px; 
            cursor: pointer; 
            font-weight: 700; 
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                       -8px -8px 16px var(--neu-shadow-light);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
        }
        .print-btn:hover { transform: translateY(-3px); color: #0b5ed7; }
        .print-btn:active {
            box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                        inset -5px -5px 10px var(--neu-shadow-light);
            transform: translateY(2px);
        }

        /* --- PRINT STYLES --- */
        @media print { 
            body { background: none; display: flex; align-items: flex-start; justify-content: flex-start; padding: 20px; } 
            .id-card-wrapper { padding: 0; box-shadow: none; border-radius: 0; background: none; }
            .id-card { 
                box-shadow: none; 
                border: 1px solid #ccc; 
                margin: 0; 
                border-radius: 10px; 
                page-break-inside: avoid;
            } 
            .photo-area img { box-shadow: none; border: 4px solid #fff; }
            .qr-area { box-shadow: none; border: 1px solid #ddd; }
            .print-btn { display: none; } 
        }
    </style>
</head>
<body>

<button class="print-btn" onclick="window.print()">
    <i class="bi bi-printer-fill fs-5"></i> Print ID Card
</button>

<div class="id-card-wrapper">
    <div class="id-card">
        
        <div class="header">
            <h2>EduGo</h2>
            <p>Path to Excellence</p>
        </div>
        
        <div class="photo-area">
            @if($student->photo)
                <img src="{{ asset('storage/'.$student->photo) }}" alt="Student Photo">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->student_name) }}&background=0D6EFD&color=fff&size=200" alt="Avatar">
            @endif
        </div>

        <div class="details">
            <div class="index-box">INDEX: <span>{{ $student->card_number }}</span></div>
            <h3>{{ $student->student_name }}</h3>
            
            <div class="qr-area">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $student->card_number }}&margin=0" alt="QR Code">
            </div>
        </div>

        <div class="footer">
            VALID UNTIL DEC 2026 | EDUGO
        </div>
        
    </div>
</div>

</body>
</html>