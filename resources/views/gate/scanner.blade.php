@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR GATE SCANNER --- */
    .text-neu { color: var(--neu-text) !important; }

    .neu-scanner-card {
        background-color: var(--neu-bg) !important;
        border-radius: 35px;
        border: none !important;
        box-shadow: 15px 15px 30px var(--neu-shadow-dark), 
                   -15px -15px 30px var(--neu-shadow-light) !important;
        max-width: 650px;
        width: 100%;
        padding: 40px 30px;
    }

    .neu-icon-circle {
        width: 90px; height: 90px;
        border-radius: 50%;
        background-color: var(--neu-bg);
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                    -8px -8px 16px var(--neu-shadow-light);
        display: flex; justify-content: center; align-items: center;
        margin: 0 auto 25px;
        font-size: 40px;
        color: var(--neu-primary);
    }

    .neu-input-scan {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 20px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 8px 8px 16px var(--neu-shadow-dark), 
                    inset -8px -8px 16px var(--neu-shadow-light) !important;
        padding: 18px;
        font-size: 1.4rem;
        text-align: center;
        transition: 0.3s;
    }

    /* 3D Result Area */
    #result_card {
        margin-top: 30px;
        border-radius: 30px;
        background-color: var(--neu-bg);
        box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                    -10px -10px 20px var(--neu-shadow-light);
        padding: 30px;
    }

    .student-photo-3d {
        width: 120px; height: 120px;
        border-radius: 50%;
        border: 5px solid var(--neu-bg);
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                    -6px -6px 12px var(--neu-shadow-light);
        object-fit: cover;
    }

    /* Quick Pay & Skip Buttons */
    .neu-btn-pay {
        border: none; border-radius: 15px; padding: 12px 25px; font-weight: bold;
        background: var(--neu-bg);
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);
        transition: 0.2s;
    }
    .neu-btn-pay:active { box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light); }

    .sms-tag {
        display: block; margin-top: 10px; font-size: 0.85rem; padding-top: 8px;
        border-top: 1px solid rgba(0,0,0,0.05); font-weight: 600;
    }
</style>

<div class="container d-flex flex-column justify-content-center align-items-center mt-4 mb-5" style="min-height: 85vh;">
    
    <div class="neu-scanner-card text-center">
        <div class="neu-icon-circle">
            <i class="bi bi-person-bounding-box"></i>
        </div>
        
        <h1 class="fw-bold text-neu mb-1">GATE SCANNER</h1>
        <p class="text-neu opacity-50 mb-4">Smart Attendance Gate System</p>

        <div class="px-md-4 mb-4">
            <input type="text" id="barcode_input" class="form-control neu-input-scan fw-bold" placeholder="READY TO SCAN..." autofocus autocomplete="off">
        </div>

        <div class="form-check form-switch d-inline-flex align-items-center gap-3">
            <input class="form-check-input ms-0" type="checkbox" id="manual_mode_cb" style="width: 50px; height: 25px; cursor: pointer;">
            <label class="form-check-label fw-bold text-neu opacity-75" for="manual_mode_cb" style="cursor: pointer;">Manual Mode</label>
        </div>

        <div id="result_card" class="d-none">
            <img id="student_photo" src="" class="student-photo-3d mb-3">
            <h2 id="student_name" class="fw-bold text-neu mb-1"></h2>
            <p id="student_id" class="text-neu opacity-50 small mb-3"></p>
            
            <div id="course_selection_box" class="d-none mb-3 p-3" style="background: rgba(0,0,0,0.02); border-radius: 20px;">
                <h6 class="fw-bold text-neu mb-3 small">SELECT CLASS:</h6>
                <div id="course_buttons" class="d-flex flex-wrap justify-content-center gap-2"></div>
            </div>

            <div id="status_alert" class="alert fw-bold py-3 mb-3 border-0" style="border-radius: 20px; font-size: 1.2rem;"></div>

            <div id="arrears_box" class="d-none mt-3 p-3 rounded-4" style="background: rgba(220, 53, 69, 0.05);">
                <h4 class="fw-bold text-danger mb-3">Pending: Rs. <span id="arrears_amount"></span></h4>
                <div class="d-flex justify-content-center gap-3">
                    <button id="quick_pay_btn" class="neu-btn-pay text-success">
                        <i class="bi bi-cash-stack me-2"></i>Pay & Enter
                    </button>
                    <button id="skip_pay_btn" class="neu-btn-pay text-secondary">
                        <i class="bi bi-arrow-right-circle me-2"></i>Skip
                    </button>
                </div>
            </div>
            
            <p id="click_to_continue" class="text-neu small mt-3 fw-bold d-none" style="cursor: pointer; opacity: 0.5;">
                <i class="bi bi-hand-index-thumb me-1"></i> Click anywhere to reset
            </p>
        </div>
    </div>
</div>

<script>
    const input = document.getElementById('barcode_input');
    const resultCard = document.getElementById('result_card');
    const statusAlert = document.getElementById('status_alert');
    const arrearsBox = document.getElementById('arrears_box');
    const manualModeCb = document.getElementById('manual_mode_cb');
    const courseButtons = document.getElementById('course_buttons');
    const courseSelectionBox = document.getElementById('course_selection_box');

    let resetTimer; 
    let currentStudentId = null; 
    let currentCourseId = null; 
    let currentArrears = 0;

    function resetScanner() {
        resultCard.classList.add('d-none');
        courseSelectionBox.classList.add('d-none');
        arrearsBox.classList.add('d-none');
        input.value = '';
        input.focus();
    }

    // Input handle
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const cardNo = this.value; if (cardNo.trim() === '') return;
            this.value = ''; clearTimeout(resetTimer);
            resultCard.classList.remove('d-none');
            statusAlert.innerText = "Checking...";
            statusAlert.className = "alert alert-secondary py-3 mb-3 border-0";

            fetch('/gate-scan', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ card_number: cardNo })
            })
            .then(res => res.json())
            .then(data => {
                const student = data.student;
                if (student) {
                    document.getElementById('student_photo').src = student.photo ? '/storage/' + student.photo : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                    document.getElementById('student_name').innerText = student.student_name;
                    document.getElementById('student_id').innerText = "CARD: " + student.card_number;
                    currentStudentId = student.id;

                    if (data.status === 'select_course') {
                        courseSelectionBox.classList.remove('d-none');
                        statusAlert.classList.add('d-none');
                        courseButtons.innerHTML = '';
                        data.courses.forEach(course => {
                            let btn = document.createElement('button');
                            btn.className = 'neu-btn-pay text-neu small py-2 px-3';
                            btn.innerHTML = `<i class="bi bi-book-fill me-1"></i> ${course.course_name}`;
                            btn.onclick = () => processSelectedCourse(course.id);
                            courseButtons.appendChild(btn);
                        });
                    } else {
                        handleProcessResponse(data);
                    }
                } else {
                    statusAlert.innerText = "INVALID CARD NUMBER! ❌";
                    statusAlert.className = "alert alert-danger py-3 mb-3 border-0";
                    setTimeout(resetScanner, 3000);
                }
            });
        }
    });

    function processSelectedCourse(courseId) {
        courseSelectionBox.classList.add('d-none');
        statusAlert.classList.remove('d-none');
        statusAlert.innerText = "Processing...";
        
        fetch('/gate-process-course', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ student_id: currentStudentId, course_id: courseId })
        }).then(res => res.json()).then(data => handleProcessResponse(data));
    }

    function handleProcessResponse(data) {
        statusAlert.classList.remove('d-none');
        let smsTag = data.sms_status ? `<span class="sms-tag ${data.sms_status.includes('✅') ? 'text-success' : 'text-warning'}">${data.sms_status}</span>` : "";

        if (data.status === 'success') {
            statusAlert.className = "alert alert-success py-3 mb-3 border-0";
            statusAlert.innerHTML = `ACCESS GRANTED! ✅ ${smsTag}`;
        } else if (data.status === 'payment_due') {
            statusAlert.className = "alert alert-danger py-3 mb-3 border-0";
            statusAlert.innerHTML = `PAYMENT PENDING! ❌ ${smsTag}`;
            currentCourseId = data.course_id; currentArrears = data.arrears;
            document.getElementById('arrears_amount').innerText = data.arrears;
            arrearsBox.classList.remove('d-none');
        } else if (data.status === 'already_attended') {
            statusAlert.className = "alert alert-warning py-3 mb-3 border-0 text-dark";
            statusAlert.innerHTML = `ALREADY MARKED TODAY! ⚠️`;
        }

        if (manualModeCb.checked) {
            document.getElementById('click_to_continue').classList.remove('d-none');
        } else if(data.status !== 'payment_due') {
            resetTimer = setTimeout(resetScanner, 4000);
        }
    }

    // Quick Pay / Skip handlers
    document.getElementById('quick_pay_btn').onclick = () => {
        fetch('/gate-quick-pay', {
            method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ student_id: currentStudentId, course_id: currentCourseId, amount: currentArrears })
        }).then(res => res.json()).then(data => {
            if(data.status === 'success') {
                arrearsBox.classList.add('d-none');
                statusAlert.className = "alert alert-success py-3 mb-3 border-0";
                statusAlert.innerText = "PAID & ENTERED! ✅";
                setTimeout(resetScanner, 3000);
            }
        });
    };

    document.getElementById('skip_pay_btn').onclick = () => {
        fetch('/gate-skip-pay', {
            method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ student_id: currentStudentId, course_id: currentCourseId })
        }).then(res => res.json()).then(data => {
            if(data.status === 'success') {
                arrearsBox.classList.add('d-none');
                statusAlert.className = "alert alert-warning py-3 mb-3 border-0 text-dark";
                statusAlert.innerText = "ENTERED (OWED)! ⚠️";
                setTimeout(resetScanner, 3000);
            }
        });
    };

    document.addEventListener('click', () => { if(manualModeCb.checked) resetScanner(); });
</script>

@endsection