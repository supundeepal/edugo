

<?php $__env->startSection('content'); ?>

<style>
    /* --- NEUMORPHISM FOR MANUAL PUNCH PAGE --- */
    .text-neu { color: var(--neu-text) !important; }

    /* Main 3D Cards */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 24px;
        border: none !important;
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light) !important;
    }

    /* 3D Icon Box */
    .neu-icon-box {
        width: 80px; 
        height: 80px;
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light);
        font-size: 35px;
    }

    /* 3D Inputs (ඇතුළට එබිලා පේන පෙට්ටි) */
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 15px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light) !important;
        padding: 14px 18px;
        transition: all 0.2s ease;
    }
    .neu-input:focus {
        outline: none;
        box-shadow: inset 8px 8px 16px var(--neu-shadow-dark), 
                    inset -8px -8px 16px var(--neu-shadow-light) !important;
    }
    .neu-input::placeholder { color: var(--neu-text); opacity: 0.5; }

    /* Inset Box for Checkboxes/Sections */
    .neu-inset-box {
        background-color: var(--neu-bg);
        border-radius: 15px;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        padding: 15px;
    }

    /* Custom 3D Checkbox */
    .neu-checkbox {
        appearance: none;
        -webkit-appearance: none;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background-color: var(--neu-bg);
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        outline: none;
        transition: 0.2s;
    }
    .neu-checkbox:checked::after {
        content: '\F272';
        font-family: 'bootstrap-icons';
        color: var(--neu-danger); /* Skip payment use danger color */
        font-size: 18px;
        font-weight: bold;
    }

    /* Custom 3D Radio Button */
    .neu-radio {
        appearance: none;
        -webkit-appearance: none;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background-color: var(--neu-bg);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        display: inline-flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        outline: none;
        transition: 0.2s;
        margin-top: 2px;
    }
    .neu-radio:checked::after {
        content: '';
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--neu-primary);
        box-shadow: 2px 2px 4px var(--neu-shadow-dark);
    }

    /* Modal Tweaks */
    .modal-content.neu-card {
        background-color: var(--neu-bg) !important;
    }
    .modal-header { border-bottom: 2px solid rgba(0,0,0,0.05); }
    [data-bs-theme="dark"] .modal-header { border-bottom: 2px solid rgba(255,255,255,0.05); }
    [data-bs-theme="dark"] .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }

    /* Alert Tweaks */
    .neu-alert {
        background-color: var(--neu-bg);
        border: none;
        border-radius: 15px;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
    }
</style>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-7 col-lg-6 text-center">
        
        <div id="punch-card" class="card neu-card p-4 p-md-5">
            
            <div class="neu-icon-box mx-auto mb-4" style="color: var(--neu-danger);">
                <i class="bi bi-upc-scan"></i>
            </div>
            <h2 class="fw-bold mb-4 text-neu">Manual Card Punch</h2>
            
            <div id="success-msg" class="alert neu-alert text-success d-none fw-bold fs-5 mb-4 py-3">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span id="main-msg"></span>
                <div id="sms-status-box" class="mt-2 pt-2 border-top border-secondary opacity-75" style="font-size: 0.9rem;"></div>
            </div>
            <div id="error-msg" class="alert neu-alert text-danger d-none fw-bold fs-5 mb-4 py-3"><i class="bi bi-x-circle-fill me-2"></i><span></span></div>
            <div id="loading-msg" class="alert neu-alert text-warning d-none fw-bold fs-5 mb-4 py-3"><span class="spinner-border spinner-border-sm me-2"></span><span>Checking...</span></div>

            <div class="mb-4">
                <input type="text" id="card_number" class="form-control form-control-lg text-center fw-bold neu-input" placeholder="Enter Card Number" autofocus autocomplete="off" style="font-size: 1.5rem;">
            </div>
            <p class="text-neu mb-2" style="opacity: 0.6; font-weight: 500;">Type the card number and press Enter, or Scan from Mobile App.</p>
        </div>
        
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content neu-card">
            
            <div class="modal-header border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold text-neu"><i class="bi bi-wallet2 me-2" style="color: #10b981;"></i>Payment & Attendance</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="opacity: 0.5;"></button>
            </div>
            
            <div class="modal-body p-4 p-md-5 text-start">
                
                <h3 id="modal-student-name" class="fw-bold text-center mb-4" style="color: #10b981;"></h3>
                <input type="hidden" id="modal-student-id">

                <div class="mb-4">
                    <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Select Course</label>
                    <select id="modal-course" class="form-select neu-input fw-bold" style="height: 50px; cursor: pointer;"></select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Fee Type</label>
                    <div class="d-flex gap-4 neu-inset-box">
                        <div class="d-flex align-items-center">
                            <input class="neu-radio me-2" type="radio" name="feeType" id="dayFee" value="daily" checked>
                            <label class="form-check-label fw-bold text-neu" for="dayFee" style="cursor: pointer;">Day Payment</label>
                        </div>
                        <div class="d-flex align-items-center">
                            <input class="neu-radio me-2" type="radio" name="feeType" id="monthFee" value="monthly">
                            <label class="form-check-label fw-bold text-neu" for="monthFee" style="cursor: pointer;">Monthly Payment</label>
                        </div>
                    </div>
                </div>

                <div id="arrears-alert" class="alert neu-alert d-none py-3 mb-4 text-danger border-0">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i><strong class="fs-5">Previous Arrears: Rs. <span id="arrears-amount">0</span></strong>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Amount to Pay Today</label>
                    <div class="neu-input d-flex align-items-center" style="height: 55px; padding: 0 15px;">
                        <span class="fw-bold me-2 text-neu" style="opacity: 0.7;">Rs.</span>
                        <input type="number" id="modal-amount" class="form-control shadow-none bg-transparent border-0 px-0 fw-bold text-danger fs-4">
                    </div>
                </div>

                <div class="mb-5 neu-inset-box d-flex align-items-center justify-content-center" id="skip-box" style="cursor: pointer;">
                    <input class="neu-checkbox me-3" type="checkbox" id="skipPayment">
                    <label class="form-check-label fw-bold text-danger fs-6" for="skipPayment" style="cursor: pointer;">
                        Skip Payment (Pay Next Day)
                    </label>
                </div>

                <button type="button" id="confirm-btn" class="btn neu-btn w-100 fw-bold py-3 fs-5" style="color: #10b981 !important; background: var(--neu-bg); box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light); border-radius:15px; border:none;">
                    <i class="bi bi-check2-circle me-2"></i> Confirm & Mark Attendance
                </button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    // 💥 මම මේක type="module" කලා! දැන් WebSockets 100% වැඩ කරනවා!
    // 💥 ඒ වගේම පහළින් තිබුණු jQuery සහ Bootstrap ලින්ක් දෙක මකලා දැම්මා (ඒකෙන් තමයි Modal එක හිර වුණේ).

    const input = document.getElementById('card_number');
    const successMsg = document.getElementById('success-msg');
    const errorMsg = document.getElementById('error-msg');
    const loadingMsg = document.getElementById('loading-msg');
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    const courseSelect = document.getElementById('modal-course');
    const skipPayment = document.getElementById('skipPayment');
    const amountInput = document.getElementById('modal-amount');
    const confirmBtn = document.getElementById('confirm-btn');
    const skipBox = document.getElementById('skip-box');

    skipBox.addEventListener('click', function(e) {
        if(e.target !== skipPayment) {
            skipPayment.checked = !skipPayment.checked;
            skipPayment.dispatchEvent(new Event('change'));
        }
    });

    function processCardNumber(cardNo) {
        if(cardNo.trim() === '') return;
        input.value = ''; 
        
        successMsg.classList.add('d-none');
        errorMsg.classList.add('d-none');
        loadingMsg.classList.remove('d-none'); 

        fetch('/get-student-info', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
            body: JSON.stringify({ card_number: cardNo })
        })
        .then(res => res.json())
        .then(data => {
            loadingMsg.classList.add('d-none'); 
            
            if (data.status === 'success') {
                const student = data.student;
                document.getElementById('modal-student-id').value = student.id;
                document.getElementById('modal-student-name').innerText = student.student_name;
                
                courseSelect.innerHTML = student.courses.map(c => 
                    `<option value="${c.id}" data-due="${c.total_due_today}" data-arrears="${c.arrears}" ${c.id == data.recommended_course_id ? 'selected' : ''}>
                        ${c.course_name}
                    </option>`
                ).join('');
                
                document.getElementById('dayFee').checked = true;
                skipPayment.checked = false;
                amountInput.removeAttribute('readonly');
                updateAmountField(); 
                
                paymentModal.show();
                
                window.history.replaceState({}, document.title, window.location.pathname);

            } else {
                errorMsg.querySelector('span').innerText = data.message;
                errorMsg.classList.remove('d-none');
                setTimeout(() => { errorMsg.classList.add('d-none'); }, 4000);
            }
        })
        .catch(error => {
            loadingMsg.classList.add('d-none');
            errorMsg.querySelector('span').innerText = "System Error!";
            errorMsg.classList.remove('d-none');
            setTimeout(() => { errorMsg.classList.add('d-none'); }, 4000);
        });
    }

    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            processCardNumber(this.value);
        }
    });

    courseSelect.addEventListener('change', updateAmountField);

    function updateAmountField() {
        if(skipPayment.checked) return;

        const selectedOption = courseSelect.options[courseSelect.selectedIndex];
        if(!selectedOption) return;

        const totalDue = Number(selectedOption.getAttribute('data-due')) || 0;
        const arrears = Number(selectedOption.getAttribute('data-arrears')) || 0;

        amountInput.value = totalDue;

        if (arrears > 0) {
            document.getElementById('arrears-amount').innerText = arrears;
            document.getElementById('arrears-alert').classList.remove('d-none');
        } else {
            document.getElementById('arrears-alert').classList.add('d-none');
        }
    }

    skipPayment.addEventListener('change', function() {
        if (this.checked) {
            amountInput.value = 0;
            amountInput.setAttribute('readonly', true);
        } else {
            amountInput.removeAttribute('readonly');
            updateAmountField(); 
        }
    });

    confirmBtn.addEventListener('click', function() {
        const studentId = document.getElementById('modal-student-id').value;
        const courseId = courseSelect.value;
        const feeType = document.querySelector('input[name="feeType"]:checked').value;
        const amount = amountInput.value || 0;

        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
        confirmBtn.disabled = true;

        fetch('/punch-pay-attend', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
            body: JSON.stringify({ student_id: studentId, course_id: courseId, fee_type: feeType, amount: amount })
        })
        .then(res => res.json())
        .then(data => {
            paymentModal.hide(); // 💥 දැන් මේක කිසිම අවුලක් නැතුව ලස්සනට Close වෙනවා!
            if (data.status === 'success' || data.status === 'already_attended') {
                document.getElementById('main-msg').innerText = data.message;
                const smsBox = document.getElementById('sms-status-box');
                
                if (data.sms_status) {
                    smsBox.innerText = data.sms_status;
                    smsBox.className = data.sms_status.includes('✅') ? "mt-2 pt-2 border-top border-secondary text-success" : "mt-2 pt-2 border-top border-secondary text-warning";
                    smsBox.classList.remove('d-none');
                } else {
                    smsBox.classList.add('d-none');
                }

                successMsg.classList.remove('d-none');
                
                if(data.payment_id) {
                    window.open('/receipt/' + data.payment_id, '_blank');
                }
                
                input.focus();
                setTimeout(() => { successMsg.classList.add('d-none'); }, 6000);
            } else {
                errorMsg.querySelector('span').innerText = data.message;
                errorMsg.classList.remove('d-none');
                setTimeout(() => { errorMsg.classList.add('d-none'); }, 4000);
            }
        })
        .catch(error => {
            paymentModal.hide();
            errorMsg.querySelector('span').innerText = "System Error!";
            errorMsg.classList.remove('d-none');
            setTimeout(() => { errorMsg.classList.add('d-none'); }, 4000);
        })
        .finally(() => {
            confirmBtn.innerHTML = '<i class="bi bi-check2-circle me-2"></i> Confirm & Mark Attendance';
            confirmBtn.disabled = false;
            input.focus();
        });
    });

    document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
        input.focus();
    });

    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const mobileScannedId = urlParams.get('student_id');

        if (mobileScannedId) {
            setTimeout(() => {
                input.value = mobileScannedId; 
                processCardNumber(mobileScannedId);
            }, 500);
        }
    });

    // 💥 අලුත් කෑල්ල (type="module" නිසා මේක දැන් සුපිරියටම වැඩ!)
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            if(window.Echo) {
                console.log("🟢 Reverb එකට සම්බන්ධයි! ෆෝන් එකෙන් ස්කෑන් කරනකන් බලාගෙන ඉන්නවා...");
                
                window.Echo.channel('gate-scanner')
                    .listen('.student.scanned', (e) => {
                        console.log("📱 ෆෝන් එකෙන් සිග්නල් එක ආවා! කාඩ් නම්බර්: ", e.cardNumber);
                        
                        input.value = e.cardNumber;
                        processCardNumber(e.cardNumber);
                    });
            } else {
                console.error("🔴 Echo ලෝඩ් වෙලා නෑ.");
            }
        }, 1000);
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Supun\Desktop\EduGo_Live_Code\resources\views/punch.blade.php ENDPATH**/ ?>