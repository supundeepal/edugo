@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR GATE SCANNER --- */
    .text-neu { color: var(--neu-text) !important; }

    :root {
        --neu-bg: #e0e5ec;
        --neu-shadow-dark: #a3b1c6;
        --neu-shadow-light: #ffffff;
        --neu-text: #333333;
        --neu-primary: #0d6efd;
    }

    [data-bs-theme="dark"] {
        --neu-bg: #242731; 
        --neu-shadow-dark: #15171d; 
        --neu-shadow-light: #2a2d38; 
        --neu-text: #e0e5ec;
        --neu-primary: #4facfe;
    }

    body {
        background-color: var(--neu-bg) !important;
    }
    
    .gate-bg { background-color: var(--neu-bg) !important; }

    /* ⭐ Scanner Action Buttons (Mobile, USB, Manual) */
    .scanner-action-btn {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
        border-radius: 15px;
        padding: 12px 25px;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        cursor: pointer;
    }
    
    .scanner-action-btn:hover {
        transform: translateY(-2px);
    }
    
    .scanner-action-btn:active {
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        transform: translateY(1px);
    }

    .btn-mobile { color: var(--neu-primary) !important; }
    .btn-usb { color: #10b981 !important; } /* Green */
    .btn-manual { color: #f59e0b !important; } /* Orange */

    /* 3D Main Card (Result Box) */
    #result_card {
        background-color: var(--neu-bg) !important;
        border-radius: 30px;
        border: none !important;
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light) !important;
        transition: all 0.3s ease;
    }

    /* 3D Barcode Input */
    #barcode_input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 20px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light) !important;
        transition: all 0.2s ease;
    }
    #barcode_input:focus {
        outline: none;
        box-shadow: inset 8px 8px 16px var(--neu-shadow-dark), 
                    inset -8px -8px 16px var(--neu-shadow-light) !important;
    }
    #barcode_input::placeholder {
        color: var(--neu-text) !important;
        opacity: 0.5;
    }

    /* 3D Avatar Frame (Student Photo) */
    #student_photo {
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--neu-bg) !important;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light) !important;
        padding: 5px;
        background-color: var(--neu-bg);
    }

    /* Checkbox & Text Colors */
    .text-muted { color: var(--neu-text) !important; opacity: 0.6; }
    #student_name { color: var(--neu-text) !important; }
    .text-primary { color: var(--neu-primary) !important; }

    /* 3D Manual Mode Checkbox */
    .form-check-input {
        appearance: none;
        -webkit-appearance: none;
        width: 40px !important;
        height: 20px !important;
        border-radius: 10px !important;
        background-color: var(--neu-bg) !important;
        border: none !important;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light) !important;
        cursor: pointer;
        position: relative;
        outline: none;
    }
    .form-check-input::after {
        content: ''; position: absolute; width: 16px; height: 16px; border-radius: 50%;
        background-color: var(--neu-text); opacity: 0.5; top: 2px; left: 2px; transition: 0.2s;
        box-shadow: 2px 2px 4px var(--neu-shadow-dark);
    }
    .form-check-input:checked::after {
        left: 22px; background-color: var(--neu-primary); opacity: 1;
    }

    /* Customizing Alerts for 3D Look */
    .alert {
        border: none !important; border-radius: 15px !important;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light) !important;
        background-color: transparent !important;
    }
    .alert-success { color: #10b981 !important; }
    .alert-danger { color: #dc3545 !important; }
</style>

<div class="container-fluid vh-100 d-flex flex-column justify-content-center align-items-center gate-bg">
    
    <div class="text-center mb-4">
        <h1 class="display-4 fw-bold text-primary"><i class="bi bi-upc-scan me-3"></i>GATE SCANNER</h1>
        <p class="text-muted fs-5 mb-4">Smart Attendance Gate System</p>

        <!-- ⭐ අලුත් බටන්ස් 3 -->
        <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
            <a href="/scan-attendance" class="scanner-action-btn btn-mobile">
                <i class="bi bi-phone-vibrate-fill fs-5"></i> Mobile Scanner
            </a>
            
            <button onclick="document.getElementById('barcode_input').focus()" class="scanner-action-btn btn-usb">
                <i class="bi bi-upc-scan fs-5"></i> USB Scanner
            </button>
            
            <button onclick="openManualPunch()" class="scanner-action-btn btn-manual">
                <i class="bi bi-keyboard-fill fs-5"></i> Manual Punch
            </button>
        </div>
    </div>

    <!-- USB Scanner Input -->
    <input type="text" id="barcode_input" class="form-control form-control-lg text-center fw-bold shadow-sm w-50 mb-3" placeholder="Waiting for USB Scan..." autofocus autocomplete="off" style="font-size: 24px; padding: 15px;">

    <div class="form-check form-switch fs-5 mb-4 text-muted">
        <input class="form-check-input shadow-sm border-secondary" type="checkbox" id="manual_mode_cb" style="cursor: pointer;">
        <label class="form-check-label fw-bold user-select-none" for="manual_mode_cb" style="cursor: pointer;">
            Manual Mode <small>(Click anywhere to clear)</small>
        </label>
    </div>

    <div id="result_card" class="card shadow-lg border-0 rounded-4 p-4 text-center d-none" style="width: 100%; max-width: 600px; cursor: pointer;" title="Click anywhere to clear">
        
        <img id="student_photo" src="" alt="Student Photo" class="rounded-circle mx-auto mb-3 shadow" style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #fff;">
        
        <h2 id="student_name" class="fw-bold mb-1 text-dark"></h2>
        <p id="student_id" class="text-muted fs-5 mb-3"></p>
        
        <div id="status_alert" class="alert fw-bold fs-4 mb-3"></div>

        <div id="arrears_box" class="alert alert-danger d-none border-danger shadow-sm">
            <h3 class="fw-bold mb-0 text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>PENDING DUES: Rs. <span id="arrears_amount"></span></h3>
            <p class="mb-0 mt-1" style="color: #842029;">Please inform the student to clear the payments.</p>
        </div>
        
        <p id="click_to_continue" class="text-muted mt-3 mb-0 fw-bold d-none"><i class="bi bi-mouse me-1"></i> Click anywhere to continue...</p>
    </div>

</div>

<script>
    const input = document.getElementById('barcode_input');
    const resultCard = document.getElementById('result_card');
    const studentPhoto = document.getElementById('student_photo');
    const studentName = document.getElementById('student_name');
    const studentId = document.getElementById('student_id');
    const statusAlert = document.getElementById('status_alert');
    const arrearsBox = document.getElementById('arrears_box');
    const arrearsAmount = document.getElementById('arrears_amount');
    const manualModeCb = document.getElementById('manual_mode_cb');
    const clickToContinue = document.getElementById('click_to_continue');

    let resetTimer;

    // පොඩි Function එකක් Manual Punch එකට (ඔයාට ඕන විදිහට වෙනස් කරන්න පුළුවන්)
    function openManualPunch() {
        let cardNo = prompt("Enter Student Card Number or Index:");
        if (cardNo) {
            input.value = cardNo;
            triggerScan(cardNo);
        }
    }

    function resetScanner() {
        resultCard.classList.add('d-none');
        input.value = '';
        input.focus();
    }

    document.addEventListener('click', function(e) {
        if (e.target.id !== 'manual_mode_cb' && !e.target.closest('.scanner-action-btn')) {
            input.focus();
        }

        if (manualModeCb.checked && !resultCard.classList.contains('d-none') && e.target.id !== 'manual_mode_cb' && !e.target.closest('.scanner-action-btn')) {
            clearTimeout(resetTimer);
            resetScanner();
        }
    });

    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const cardNo = this.value;
            triggerScan(cardNo);
        }
    });

    function triggerScan(cardNo) {
        if (cardNo.trim() === '') return;
        
        input.value = ''; 
        clearTimeout(resetTimer); 
        resultCard.classList.add('d-none');

        fetch('/gate-scan', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify({ card_number: cardNo })
        })
        .then(res => res.json())
        .then(data => {
            resultCard.classList.remove('d-none');
            
            if (data.status === 'success') {
                const student = data.student;
                studentPhoto.src = student.photo ? '/storage/' + student.photo : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                studentName.innerText = student.student_name;
                studentId.innerText = "Card: " + student.card_number;
                
                statusAlert.className = 'alert fw-bold fs-4 mb-3 alert-success';
                statusAlert.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> Access Granted!';

                if (data.arrears > 0) {
                    arrearsAmount.innerText = data.arrears.toFixed(2);
                    arrearsBox.classList.remove('d-none');
                } else {
                    arrearsBox.classList.add('d-none');
                }
            } else {
                studentPhoto.src = 'https://cdn-icons-png.flaticon.com/512/753/753345.png';
                studentName.innerText = "UNKNOWN";
                studentId.innerText = "Card: " + cardNo;
                
                statusAlert.className = 'alert fw-bold fs-4 mb-3 alert-danger';
                statusAlert.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i> ' + data.message;
                arrearsBox.classList.add('d-none');
            }

            if (manualModeCb.checked) {
                clickToContinue.classList.remove('d-none');
            } else {
                clickToContinue.classList.add('d-none');
                resetTimer = setTimeout(resetScanner, 3000);
            }
        })
        .catch(err => console.error(err));
    }
</script>
@endsection