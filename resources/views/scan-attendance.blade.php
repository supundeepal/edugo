@extends('layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .neu-card {
        background-color: var(--neu-bg);
        border-radius: 25px;
        border: none;
        box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                   -10px -10px 20px var(--neu-shadow-light);
    }

    /* කැමරා කොටුව වටේට ඩිසයින් එක */
    #reader {
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        border: 4px solid var(--neu-bg) !important;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
    }

    #reader video {
        border-radius: 15px;
        object-fit: cover;
    }

    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-primary);
        border: none;
        border-radius: 12px;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        font-weight: 700;
        padding: 12px 25px;
        transition: 0.2s;
        width: 100%;
    }
    .neu-btn:hover { transform: translateY(-2px); }
    .neu-btn:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(1px);
    }

    .result-box {
        background-color: var(--neu-bg);
        border-radius: 15px;
        padding: 20px;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        display: none; /* මුලින් පේන්නෙ නෑ, ස්කෑන් කරාම පේනවා */
    }
</style>

<div class="container mt-4 mb-5 px-xl-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="neu-card p-4 text-center">
                <h4 class="fw-bold mb-4" style="color: var(--neu-primary);">
                    <i class="bi bi-qr-code-scan me-2"></i> Desktop Scanner
                </h4>

                <!-- කැමරාව පෙන්වන කොටුව -->
                <div id="reader" class="mb-4"></div>

                <!-- ස්කෑන් කරාට පස්සේ පෙන්වන ප්‍රතිඵලය -->
                <div id="result-container" class="result-box mt-3 text-center">
                    <div id="status-icon">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                    
                    <h5 class="fw-bold text-neu mt-2" id="student-name">Name</h5>
                    <p class="text-success fw-bold mb-0" id="success-msg">Message</p>
                </div>

                <button id="resume-btn" class="neu-btn mt-4" style="display: none;" onclick="resumeScanning()">
                    <i class="bi bi-arrow-clockwise me-2"></i> Scan Next Card
                </button>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let html5QrCode;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Beep සද්දය හදන Function එක
    function playBeep() {
        const context = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = context.createOscillator();
        const gainNode = context.createGain();
        oscillator.type = 'sine';
        oscillator.frequency.value = 800; // සද්දෙ pitch එක
        oscillator.connect(gainNode);
        gainNode.connect(context.destination);
        oscillator.start();
        gainNode.gain.exponentialRampToValueAtTime(0.00001, context.currentTime + 0.1);
    }

    // Backend එකට දත්ත යවන පොදු Function එක
    function processScannedNumber(scannedNumber) {
        
        // Desktop කැමරාව ඔන් වෙලා තියෙනවා නම් ඒක තාවකාලිකව නවත්තනවා
        if(html5QrCode && html5QrCode.getState() === 2) { // 2 = SCANNING
            html5QrCode.pause();
        }
        
        playBeep(); 

        fetch('/process-scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ student_id: scannedNumber })
        })
        .then(response => response.json())
        .then(data => {
            const resultBox = document.getElementById('result-container');
            const iconBox = document.getElementById('status-icon');
            const msgBox = document.getElementById('success-msg');
            const nameBox = document.getElementById('student-name');

            resultBox.style.display = 'block';
            document.getElementById('resume-btn').style.display = 'block';

            if(data.status === 'success') {
                iconBox.innerHTML = '<i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>';
                nameBox.innerText = data.student_name;
                msgBox.innerText = data.message;
                msgBox.className = "text-success fw-bold mb-0";
                
                // හිඟ මුදල් තියෙනවා නම් පාට වෙනස් කරනවා (කහ පාට)
                if(data.arrears > 0) {
                    iconBox.innerHTML = '<i class="bi bi-exclamation-circle-fill text-warning" style="font-size: 3rem;"></i>';
                    msgBox.className = "text-warning fw-bold mb-0";
                }
            } else {
                iconBox.innerHTML = '<i class="bi bi-x-circle-fill text-danger" style="font-size: 3rem;"></i>';
                nameBox.innerText = "Error!";
                msgBox.innerText = data.message;
                msgBox.className = "text-danger fw-bold mb-0";
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. Desktop Scanner එක ඔන් කිරීම
        html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        const onScanSuccess = (decodedText, decodedResult) => {
            // Desktop කැමරාවෙන් ස්කෑන් වුණාම
            processScannedNumber(decodedText);
        };

        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
        .catch(err => {
            console.log("Camera Error: ", err);
        });
    });

    // ඊළඟ ළමයාගේ එක ස්කෑන් කරන්න ආයෙත් කැමරාව ඔන් කිරීම (හෝ පේජ් එක රීසෙට් කිරීම)
    function resumeScanning() {
        document.getElementById('result-container').style.display = 'none';
        document.getElementById('resume-btn').style.display = 'none';
        
        // කැමරාව තියෙනවා නම් ඒක ආයේ ඔන් කරනවා
        if(html5QrCode && html5QrCode.getState() === 3) { // 3 = PAUSED
            html5QrCode.resume();
        }
    }
</script>
@endsection