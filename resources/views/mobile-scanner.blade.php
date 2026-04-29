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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-color: #151521; --card-bg: #1e1e2d; --card-grad: linear-gradient(145deg, #1e1e2d, #1a1a28);
            --border-color: #2b2b40; --text-main: #ffffff; --text-muted: #92929f;
            --blue: #3699ff; --green: #1bc5bd; --red: #f64e60; --yellow: #ffa800;
            --input-bg: #12121c; --nav-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.05);
            --btn-3d-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05);
            --btn-dark-grad: linear-gradient(145deg, #1b1b29, #151521);
            --icon-bg: linear-gradient(145deg, #1e1e2d, #151521);
        }
        
        body.light-mode {
            --bg-color: #f3f6f9; --card-bg: #ffffff; --card-grad: linear-gradient(145deg, #ffffff, #f8f9fa);
            --border-color: #ebedf3; --text-main: #181c32; --text-muted: #a1a5b7;
            --input-bg: #ffffff; --nav-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            --btn-3d-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.5);
            --btn-dark-grad: linear-gradient(145deg, #ffffff, #f3f6f9);
            --icon-bg: linear-gradient(145deg, #ffffff, #f3f6f9);
        }

        body { background-color: var(--bg-color); color: var(--text-main); font-family: 'Poppins', sans-serif; min-height: 100vh; display: flex; flex-direction: column; transition: all 0.4s ease; }
        .navbar-custom { background-color: var(--card-bg); border-bottom: 1px solid var(--border-color); padding: 15px 20px; box-shadow: var(--nav-shadow); z-index: 10; }
        .navbar-brand { font-weight: 700; color: var(--text-main) !important; font-size: 1.3rem; }
        .nav-icon { color: var(--blue); margin-right: 8px; }
        .theme-toggle-btn { background: transparent; color: var(--text-muted); border: none; font-size: 1.2rem; padding: 5px 10px; }
        .logout-btn-nav { background: rgba(246, 78, 96, 0.1); color: var(--red); border: 1px solid rgba(246, 78, 96, 0.2); border-radius: 8px; padding: 6px 14px; font-weight: 600; font-size: 0.85rem; }
        .app-container { flex-grow: 1; display: flex; align-items: center; justify-content: center; padding: 20px; padding-bottom: 12vh; }
        .custom-card { background: var(--card-grad); border-radius: 20px; border: 1px solid var(--border-color); box-shadow: var(--card-shadow); padding: 40px 25px; width: 100%; max-width: 420px; z-index: 5; }
        .form-control, .input-group-text { background-color: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-main); padding: 16px 15px; }
        .form-control:focus { background-color: var(--input-bg); border-color: var(--blue); color: var(--text-main); }
        .btn-3d { border-radius: 12px; padding: 16px; font-weight: 600; font-size: 1.05rem; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s ease; }
        .btn-3d:active { transform: translateY(3px); }
        .btn-primary-custom { background: linear-gradient(145deg, rgba(54, 153, 255, 0.15), rgba(54, 153, 255, 0.05)); color: var(--blue); border: 1px solid rgba(54, 153, 255, 0.3); }
        .btn-scanner { background: var(--btn-dark-grad); color: var(--green); border: 1px solid rgba(27, 197, 189, 0.3); }
        .btn-history { background: var(--btn-dark-grad); color: var(--blue); border: 1px solid rgba(54, 153, 255, 0.3); }
        .badge-role { background: linear-gradient(145deg, rgba(255, 168, 0, 0.2), rgba(255, 168, 0, 0.05)); color: var(--yellow); border: 1px solid rgba(255, 168, 0, 0.2); border-radius: 6px; padding: 5px 10px; font-size: 0.75rem; font-weight: 700; }
        .profile-icon-box { background: var(--icon-bg); width: 55px; height: 55px; border-radius: 12px; display:flex; align-items:center; justify-content:center; border: 1px solid var(--border-color); }
        #reader { width: 100%; border-radius: 12px; overflow: hidden; border: 2px dashed rgba(27, 197, 189, 0.5); }
        .spinner-ring { width: 70px; height: 70px; border: 4px solid rgba(54, 153, 255, 0.1); border-top: 4px solid var(--blue); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .student-pic { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 4px solid var(--blue); box-shadow: 0 5px 15px rgba(54, 153, 255, 0.3); margin-bottom: 15px; }
    </style>
</head>
<body>

<audio id="beepSound" src="/sound/beep.mp3" preload="auto"></audio>
<audio id="successSound" src="/sound/success.mp3" preload="auto"></audio>

<nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
    <div class="navbar-brand mb-0"><i class="fa-solid fa-rocket nav-icon"></i> EduGo</div>
    <div class="d-flex align-items-center gap-3">
        <button onclick="toggleTheme()" class="theme-toggle-btn" id="theme-btn"><i class="fa-solid fa-sun" id="theme-icon"></i></button>
        <button id="nav-logout-btn" onclick="logout()" class="logout-btn-nav d-none"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
    </div>
</nav>

<div class="app-container">
    
    <div id="login-section" class="custom-card w-100">
        <div class="text-center mb-5"><h3 class="fw-bold mb-2">System Login</h3></div>
        <div class="mb-4">
            <div class="input-group"><span class="input-group-text"><i class="fa-solid fa-envelope"></i></span><input type="email" id="email" class="form-control" placeholder="Email"></div>
        </div>
        <div class="mb-5">
            <div class="input-group"><span class="input-group-text"><i class="fa-solid fa-lock"></i></span><input type="password" id="password" class="form-control" placeholder="Password"></div>
        </div>
        <button onclick="login()" class="btn-3d btn-primary-custom w-100 mt-2">Login</button>
    </div>

    <div id="menu-section" class="custom-card w-100 d-none">
        <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
            <div class="me-3"><div class="profile-icon-box"><i class="fa-solid fa-user" style="color: var(--blue); font-size: 1.4rem;"></i></div></div>
            <div><div class="fw-bold mb-2" id="user-name">Welcome</div><span class="badge-role" id="user-role">STAFF</span></div>
        </div>
        <div class="mb-2 mt-2">
            <button onclick="openScanner()" class="btn-3d btn-scanner w-100 mb-4"><i class="fa-solid fa-mobile-screen"></i> Mobile Scanner</button>
            <button onclick="checkHistory()" class="btn-3d btn-history w-100"><i class="fa-solid fa-desktop"></i> View Laptop Screen</button>
        </div>
    </div>

    <div id="scanner-section" class="custom-card w-100 d-none">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0" style="color: var(--green);"><i class="fa-solid fa-qrcode"></i> Scanning...</h5>
        </div>
        <div id="reader" class="mb-4"></div>
        <button onclick="closeScanner()" class="btn-3d w-100 mt-3" style="background: var(--input-bg); color: var(--text-muted); border: 1px solid var(--border-color);">Stop Scanning</button>
    </div>

    <div id="processing-section" class="custom-card w-100 text-center d-none">
        <div id="student-info-box">
            <img id="student-img" src="" class="student-pic" alt="Student">
            <h4 class="fw-bold mb-1" id="student-name">Loading...</h4>
            <p class="small mb-4" style="color: var(--text-muted);">ID: <span id="student-id-display">--</span></p>
        </div>
        
        <div class="spinner-ring mb-4"></div>
        <h5 class="fw-bold mb-2" style="color: var(--blue);">Please Wait...</h5>
        <p class="small mb-4" style="color: var(--text-muted);">Mark attendance on the laptop to continue.</p>

        <button onclick="cancelProcessing()" class="btn btn-sm py-2 w-100 mt-3" style="background: transparent; color: var(--red); border: 1px solid rgba(246, 78, 96, 0.3); border-radius: 12px; font-weight: 600;">
            Cancel & Scan Again
        </button>
    </div>

</div>

<script>
    let html5QrCode;
    // 💥 setInterval එක අයින් කරා!
    const API_BASE = window.location.origin + '/api';
    let wakeLock = null;
    let echoListenerAdded = false; // 💥 අලුත් Variable එකක්

    window.onload = function() {
        const savedTheme = localStorage.getItem('theme');
        const icon = document.getElementById('theme-icon');
        if (savedTheme === 'light') { document.body.classList.add('light-mode'); icon.classList.replace('fa-sun', 'fa-moon'); }
        if (localStorage.getItem('mobile_token')) { showMenu(); }
    };

    function toggleTheme() {
        const body = document.body; const icon = document.getElementById('theme-icon');
        body.classList.toggle('light-mode');
        if (body.classList.contains('light-mode')) { icon.classList.replace('fa-sun', 'fa-moon'); localStorage.setItem('theme', 'light'); } 
        else { icon.classList.replace('fa-moon', 'fa-sun'); localStorage.setItem('theme', 'dark'); }
    }

    function getSwal() {
        const isLight = document.body.classList.contains('light-mode');
        return Swal.mixin({ background: isLight ? '#ffffff' : '#1e1e2d', color: isLight ? '#181c32' : '#ffffff', confirmButtonColor: '#3699ff' });
    }

    async function requestWakeLock() {
        try { if ('wakeLock' in navigator) { wakeLock = await navigator.wakeLock.request('screen'); } } 
        catch (err) { console.log('Wake Lock error:', err.message); }
    }

    function login() {
        const email = document.getElementById('email').value; const password = document.getElementById('password').value;
        getSwal().fire({ title: 'Logging in...', didOpen: () => { Swal.showLoading() } });
        fetch(`${API_BASE}/mobile-login`, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ email, password }) })
        .then(res => res.json()).then(data => {
            if (data.status === 'success') {
                localStorage.setItem('mobile_token', data.token); localStorage.setItem('user_name', data.user.name); localStorage.setItem('user_role', data.user.role.toUpperCase());
                Swal.close(); showMenu();
            } else { getSwal().fire('Error', data.message, 'error'); }
        });
    }

    function showMenu() {
        document.getElementById('login-section').classList.add('d-none'); document.getElementById('scanner-section').classList.add('d-none'); document.getElementById('processing-section').classList.add('d-none');
        document.getElementById('menu-section').classList.remove('d-none'); document.getElementById('nav-logout-btn').classList.remove('d-none'); 
        document.getElementById('user-name').innerText = "Welcome, " + localStorage.getItem('user_name');
    }

    function openScanner() {
        document.getElementById('menu-section').classList.add('d-none'); document.getElementById('scanner-section').classList.remove('d-none');
        document.getElementById('nav-logout-btn').classList.add('d-none'); document.getElementById('theme-btn').classList.add('d-none');
        
        requestWakeLock();
        
        // Audio Unlock Trick (So it plays without user clicking later)
        let beepAudio = document.getElementById('beepSound');
        let successAudio = document.getElementById('successSound');
        beepAudio.play().then(() => { beepAudio.pause(); beepAudio.currentTime = 0; }).catch(()=>{});
        successAudio.play().then(() => { successAudio.pause(); successAudio.currentTime = 0; }).catch(()=>{});
        
        if(html5QrCode && html5QrCode.isScanning) return; 

        html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: { width: 250, height: 250 } }, (decodedText) => {
            sendScanData(decodedText);
        });
    }

    function closeScanner() {
        if (wakeLock !== null) { wakeLock.release().then(() => { wakeLock = null; }); }
        if (html5QrCode) { html5QrCode.stop().then(() => { document.getElementById('theme-btn').classList.remove('d-none'); showMenu(); }); } 
        else { document.getElementById('theme-btn').classList.remove('d-none'); showMenu(); }
    }

    function cancelProcessing() {
        document.getElementById('processing-section').classList.add('d-none');
        document.getElementById('scanner-section').classList.remove('d-none');
        if(html5QrCode) html5QrCode.resume();
    }

    function sendScanData(scannedId) {
        html5QrCode.pause(true); 
        document.getElementById('beepSound').play().catch(e => console.log(e));

        fetch(`${API_BASE}/mobile-scan`, {
            method: 'POST', headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${localStorage.getItem('mobile_token')}` },
            body: JSON.stringify({ card_number: scannedId })
        }).then(res => res.json()).then(data => {
            if (data.status === 'success') {
                showProcessingScreen(data.student_name, data.photo_url, scannedId);
                startCheckingStatus(scannedId);
            } else {
                getSwal().fire('Failed', data.message, 'error'); setTimeout(() => { html5QrCode.resume(); }, 1500);
            }
        });
    }

    function showProcessingScreen(name, photoUrl, id) {
        document.getElementById('scanner-section').classList.add('d-none'); document.getElementById('processing-section').classList.remove('d-none');
        document.getElementById('student-name').innerText = name || 'Student'; document.getElementById('student-id-display').innerText = id;
        if (photoUrl && !photoUrl.includes('logo')) {
            document.getElementById('student-img').src = photoUrl.replace(/http:\/\/127\.0\.0\.1(:\d+)?/g, window.location.origin).replace(/http:\/\/localhost(:\d+)?/g, window.location.origin);
        } else {
            document.getElementById('student-img').src = `https://ui-avatars.com/api/?name=${name || 'S'}&background=3699ff&color=fff&size=150`;
        }
    }

    // 💥 THE AUTO RESUME LOGIC (USING WEBSOCKETS / REVERB) 💥
    function startCheckingStatus(cardNumber) {
        // Echo ලෝඩ් වෙලා තියෙනවා නම් විතරක් වැඩේ කරනවා
        setTimeout(() => {
            if(window.Echo && !echoListenerAdded) {
                window.Echo.channel('attendance-channel')
                    .listen('AttendanceMarked', (e) => {
                        console.log("WebSocket Signal Received!", e);
                        
                        document.getElementById('successSound').play().catch(err => console.log(err));
                        
                        getSwal().fire({
                            title: '<span style="color:#1bc5bd">Success!</span>',
                            text: 'Ready for Next Student',
                            icon: 'success',
                            timer: 800,
                            showConfirmButton: false
                        }).then(() => {
                            document.getElementById('processing-section').classList.add('d-none');
                            document.getElementById('scanner-section').classList.remove('d-none');
                            if(html5QrCode) html5QrCode.resume(); 
                        });
                    });
                
                // ආයෙ ආයෙ Listener එකතු කරන එක නවත්තන්න මේක True කරනවා
                echoListenerAdded = true; 
            } else if (!window.Echo) {
                console.log("Laravel Echo load වෙලා නෑ! WebSockets වැඩ කරන්නේ නෑ. Terminal එකේ npm run dev ගහලා තියෙන්න ඕනේ.");
            }
        }, 500); 
    }

    function checkHistory() { getSwal().fire('Info', 'Watch your laptop screen to see scan results.', 'info'); }
    function logout() { localStorage.removeItem('mobile_token'); window.location.reload(); }
</script>
</body>
</html>