

<?php $__env->startSection('content'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* 3D Card */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 20px;
        border: none !important;
        box-shadow: 7px 7px 14px var(--neu-shadow-dark), 
                   -7px -7px 14px var(--neu-shadow-light) !important; 
        transition: all 0.3s ease;
    }

    /* Hover & Active */
    .neu-card-interactive { cursor: pointer; }
    .neu-card-interactive:hover { transform: translateY(-3px); }
    .neu-card-interactive:active {
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light) !important;
        transform: translateY(2px);
    }

    /* 3D Icon Box */
    .neu-icon-box {
        width: 60px; height: 60px; border-radius: 50%; display: flex; 
        justify-content: center; align-items: center; background-color: var(--neu-bg);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        font-size: 26px; transition: 0.3s;
    }

    /* 3D Button */
    .neu-btn-primary {
        background-color: var(--neu-bg); color: var(--neu-primary); border: none;
        border-radius: 15px; box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                                      -5px -5px 10px var(--neu-shadow-light);
        font-weight: 700; transition: all 0.2s ease;
    }
    .neu-btn-primary:hover { color: var(--neu-primary); transform: translateY(-2px); }
    .neu-btn-primary:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(2px);
    }
    
    /* අලුත් Mobile Scanner Button එකේ පාට */
    .neu-btn-mobile {
        color: #10b981 !important; /* ලස්සන කොළ පාටක් */
    }
    .neu-btn-mobile:hover { color: #10b981 !important; }

    .text-neu { color: var(--neu-text); }
    
    /* Scrollbar for lists */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: var(--neu-shadow-dark); border-radius: 10px; }
</style>

<div class="container-fluid mt-4 mb-5">

    <div class="row mb-5">
        <div class="col-12">
            <div class="card neu-card p-4 p-md-5 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-4 mb-md-0 text-center text-md-start">
                    <h2 class="mb-2 fw-bold" style="color: var(--neu-primary); letter-spacing: -0.5px;">Gate Check-In System</h2>
                    <p class="mb-0 fs-5 text-neu" style="opacity: 0.7;">Open the QR scanner to mark attendance and collect payments.</p>
                </div>
                
                <!-- ⭐ මෙන්න අලුතින් දාපු බටන් සෙට් එක -->
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="/scan-attendance" class="btn neu-btn-primary neu-btn-mobile px-4 py-3 fs-5 d-flex align-items-center text-decoration-none">
                        <i class="bi bi-phone-vibrate-fill me-2"></i> Mobile Scanner
                    </a>
                    <a href="/gate-scanner" class="btn neu-btn-primary px-4 py-3 fs-5 d-flex align-items-center text-decoration-none">
                        <i class="bi bi-pc-display me-2"></i> Desk Scanner
                    </a>
                </div>
                <!-- ============================== -->

            </div>
        </div>
    </div>


    <?php if(Auth::check() && Auth::user()->role === 'staff'): ?>
    <h5 class="fw-bold mb-3 text-neu"><i class="bi bi-briefcase-fill me-2" style="color: var(--neu-primary);"></i>My Workspace</h5>
    
    <div class="row mb-5 g-4 align-items-stretch">
        
        <div class="col-xl-4 col-md-6">
            <div class="card neu-card p-4 text-center h-100 d-flex flex-column justify-content-center">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--neu-bg); box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: var(--neu-primary);">
                    <i class="bi bi-wallet2"></i>
                </div>
                <h6 class="text-uppercase fw-bold mb-2 text-neu" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">My Today's Collection</h6>
                <h1 class="fw-bolder mb-3" style="color: var(--neu-primary); letter-spacing: -1px; font-size: 2.5rem;">
                    <span style="font-size: 1.2rem; opacity: 0.8;">Rs.</span> <?php echo e(number_format($my_today_collection ?? 0, 2)); ?>

                </h1>
                <div>
                    <div style="background-color: var(--neu-bg); box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light); border-radius: 12px; padding: 10px 20px; display: inline-block;">
                        <span class="text-neu" style="font-weight: 600; font-size: 0.95rem;">
                            <i class="bi bi-receipt-cutoff me-2" style="color: var(--neu-primary);"></i><?php echo e($my_today_payments_count ?? 0); ?> Transactions Today
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card neu-card p-4 h-100">
                <h6 class="fw-bold text-neu mb-4 opacity-75 text-center">Quick Tools</h6>
                <div class="d-flex flex-column gap-3 h-100 justify-content-center">
                    <a href="/punch" class="text-decoration-none">
                        <div class="neu-btn-primary p-3 d-flex align-items-center justify-content-center w-100" style="border-radius: 15px;">
                            <i class="bi bi-upc-scan me-2 fs-5"></i> Manual Punch
                        </div>
                    </a>
                    <a href="/payment" class="text-decoration-none">
                        <div class="neu-btn-primary p-3 d-flex align-items-center justify-content-center w-100" style="border-radius: 15px; color: var(--neu-warning);">
                            <i class="bi bi-credit-card-fill me-2 fs-5"></i> Collect Payment
                        </div>
                    </a>
                    <a href="/register" class="text-decoration-none">
                        <div class="neu-btn-primary p-3 d-flex align-items-center justify-content-center w-100" style="border-radius: 15px; color: var(--neu-success);">
                            <i class="bi bi-person-plus-fill me-2 fs-5"></i> Register Student
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="card neu-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-neu mb-0 opacity-75">Recent Payments</h6>
                    <i class="bi bi-clock-history text-neu opacity-50"></i>
                </div>
                
                <div class="custom-scrollbar" style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
                    <?php
                        $recent_payments = \App\Models\Payment::with('student')
                            ->where('user_id', Auth::id())
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->orderBy('id', 'desc')
                            ->take(5)
                            ->get();
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $recent_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="border-bottom: 1px solid rgba(163, 177, 198, 0.2);">
                            <div class="d-flex align-items-center">
                                <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--neu-bg); box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light); display: flex; align-items: center; justify-content: center; font-size: 14px; color: var(--neu-text); font-weight: bold;" class="me-3">
                                    <?php echo e(substr($rp->student->student_name ?? 'S', 0, 1)); ?>

                                </div>
                                <div>
                                    <p class="mb-0 fw-bold text-neu" style="font-size: 0.85rem;"><?php echo e(Str::limit($rp->student->student_name ?? 'Unknown', 15)); ?></p>
                                    <small class="text-neu opacity-50" style="font-size: 0.7rem;"><?php echo e($rp->created_at->format('h:i A')); ?></small>
                                </div>
                            </div>
                            <div class="fw-bold" style="color: var(--neu-primary); font-size: 0.9rem;">
                                +Rs. <?php echo e(number_format($rp->amount, 0)); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center p-4 mt-2" style="background: var(--neu-bg); box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light); border-radius: 15px;">
                            <i class="bi bi-inbox text-neu opacity-50 fs-2 mb-2"></i>
                            <p class="text-neu opacity-50 mb-0" style="font-size: 0.85rem;">No payments collected yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>


    <h5 class="fw-bold mb-3 text-neu"><i class="bi bi-grid-fill me-2" style="color: var(--neu-primary);"></i>Data Overview</h5>
    <div class="row mb-5 g-4">
        
        <?php
            $boxSize = (Auth::check() && Auth::user()->role === 'owner') ? 'col-md-4' : 'col-md-6';
        ?>

        <div class="<?php echo e($boxSize); ?>">
            <div class="card neu-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="neu-icon-box me-4" style="color: var(--neu-primary);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase fw-bold mb-1 text-neu" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">Total Students</h6>
                        <h2 class="fw-bold mb-0 text-neu"><?php echo e($totalStudents); ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="<?php echo e($boxSize); ?>">
            <div class="card neu-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="neu-icon-box me-4" style="color: var(--neu-success);">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase fw-bold mb-1 text-neu" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">Today's Attendance</h6>
                        <h2 class="fw-bold mb-0 text-neu"><?php echo e($todayAttendance); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <?php if(Auth::check() && Auth::user()->role === 'owner'): ?>
        <div class="col-md-4">
            <div class="card neu-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="neu-icon-box me-4" style="color: var(--neu-warning);">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase fw-bold mb-1 text-neu" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">Total Income (Rs.)</h6>
                        <h2 class="fw-bold mb-0 text-neu"><?php echo e(number_format($totalIncome, 2)); ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if(Auth::check() && Auth::user()->role === 'owner'): ?>
    <h5 class="fw-bold mb-3 text-neu"><i class="bi bi-lightning-charge-fill me-2" style="color: var(--neu-warning);"></i>Quick Actions</h5>
    <div class="row mb-5 g-4">
        <div class="col-md-3 col-6">
            <a href="/register" class="text-decoration-none">
                <div class="card neu-card neu-card-interactive text-center p-4 h-100">
                    <div class="neu-icon-box mx-auto mb-3" style="color: var(--neu-success);"><i class="bi bi-person-plus-fill"></i></div>
                    <h6 class="fw-bold mb-0 text-neu">Add Student</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="/students" class="text-decoration-none">
                <div class="card neu-card neu-card-interactive text-center p-4 h-100">
                    <div class="neu-icon-box mx-auto mb-3" style="color: var(--neu-primary);"><i class="bi bi-person-lines-fill"></i></div>
                    <h6 class="fw-bold mb-0 text-neu">Student List</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="/payment" class="text-decoration-none">
                <div class="card neu-card neu-card-interactive text-center p-4 h-100">
                    <div class="neu-icon-box mx-auto mb-3" style="color: var(--neu-warning);"><i class="bi bi-credit-card-fill"></i></div>
                    <h6 class="fw-bold mb-0 text-neu">Payments</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="/punch" class="text-decoration-none">
                <div class="card neu-card neu-card-interactive text-center p-4 h-100">
                    <div class="neu-icon-box mx-auto mb-3" style="color: var(--neu-danger);"><i class="bi bi-upc-scan"></i></div>
                    <h6 class="fw-bold mb-0 text-neu">Manual Punch</h6>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div class="row g-4 mb-4">
        
        <div class="col-xl-8">
            <div class="card neu-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-neu mb-0">Attendance Growth</h5>
                    <span class="text-neu" style="opacity: 0.6; font-size: 0.85rem;">Last 7 Days</span>
                </div>
                <div style="position: relative; height: 280px; width: 100%;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        <?php if(Auth::check() && Auth::user()->role === 'owner'): ?>
        <div class="col-xl-4">
            <div class="card neu-card p-4 h-100">
                <h5 class="fw-bold text-neu mb-4">Management</h5>
                
                <a href="/reports" class="text-decoration-none mb-4 d-block">
                    <div class="card neu-card neu-card-interactive p-3 d-flex flex-row align-items-center">
                        <div class="neu-icon-box me-3" style="color: var(--neu-warning); width: 50px; height: 50px; font-size: 20px;">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-neu mb-1">Monthly Reports</h6>
                            <small class="text-neu" style="opacity: 0.6;">Analytics & Income</small>
                        </div>
                    </div>
                </a>

                <a href="/teachers-menu" class="text-decoration-none mb-4 d-block">
                    <div class="card neu-card neu-card-interactive p-3 d-flex flex-row align-items-center">
                        <div class="neu-icon-box me-3" style="color: var(--neu-success); width: 50px; height: 50px; font-size: 20px;">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-neu mb-1">Teachers</h6>
                            <small class="text-neu" style="opacity: 0.6;">Manage Staff & Payouts</small>
                        </div>
                    </div>
                </a>

                <a href="/admin-materials" class="text-decoration-none d-block">
                    <div class="card neu-card neu-card-interactive p-3 d-flex flex-row align-items-center">
                        <div class="neu-icon-box me-3" style="color: var(--neu-primary); width: 50px; height: 50px; font-size: 20px;">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-neu mb-1">Study Materials</h6>
                            <small class="text-neu" style="opacity: 0.6;">View & Download Files</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <?php if(Auth::check() && Auth::user()->role === 'staff'): ?>
        <div class="col-xl-4">
            <div class="card neu-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-neu mb-0">Daily Highlights</h5>
                    <i class="bi bi-star-fill" style="color: var(--neu-warning);"></i>
                </div>
                
                <?php
                    $new_students_today = \App\Models\Student::where('institute_id', Auth::user()->institute_id)
                                            ->whereDate('created_at', \Carbon\Carbon::today())
                                            ->count();
                ?>

                <div class="card neu-card p-3 mb-4 d-flex flex-row align-items-center" style="box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light) !important;">
                    <div class="neu-icon-box me-3" style="color: var(--neu-success); width: 55px; height: 55px; font-size: 22px; box-shadow: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light) !important;">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-neu mb-0"><?php echo e($new_students_today); ?></h3>
                        <small class="text-neu fw-bold" style="opacity: 0.6; font-size: 0.8rem;">New Registrations Today</small>
                    </div>
                </div>

                <div class="card neu-card p-4 d-flex flex-column justify-content-center text-center mt-auto" style="border: 2px dashed rgba(25, 135, 84, 0.2) !important;">
                    <div class="spinner-grow spinner-grow-sm mx-auto mb-3" style="color: var(--neu-success);" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <i class="bi bi-shield-check mb-2" style="font-size: 2.5rem; color: var(--neu-primary);"></i>
                    <h6 class="fw-bold text-neu mb-1">System Active</h6>
                    <small class="text-neu opacity-50" style="font-size: 0.85rem;">Gate scanner & payments are fully operational.</small>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script id="chart-data" type="application/json">
    <?php echo json_encode($attendanceData ?? []); ?>

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        
        let rawData = [];
        try {
            rawData = JSON.parse(document.getElementById('chart-data').textContent);
        } catch (e) {
            console.error("No chart data available");
        }
        
        const labels = rawData.map(item => item.date);
        const counts = rawData.map(item => item.count);

        Chart.defaults.font.family = "'Poppins', sans-serif";

        const savedTheme = localStorage.getItem('theme') || 'light';
        const isDark = savedTheme === 'dark';
        const primaryColor = isDark ? '#4facfe' : '#0d6efd';
        const textColor = isDark ? '#e0e5ec' : '#333333';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

        let gradient = ctx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, isDark ? 'rgba(79, 172, 254, 0.3)' : 'rgba(13, 110, 253, 0.3)');
        gradient.addColorStop(1, isDark ? 'rgba(79, 172, 254, 0.0)' : 'rgba(13, 110, 253, 0.0)');

        window.attendanceChart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: labels,
                datasets: [{
                    label: 'Students',
                    data: counts,
                    backgroundColor: gradient,
                    borderColor: primaryColor,
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: primaryColor,
                    pointBorderWidth: 3,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1, color: textColor },
                        border: { display: false },
                        grid: { color: gridColor, borderDash: [5, 5] }
                    },
                    x: { 
                        ticks: { color: textColor },
                        border: { display: false },
                        grid: { display: false } 
                    }
                },
                plugins: { legend: { display: false } }
            }
        });

        window.updateChartTheme = function(theme) {
            const isDarkMode = theme === 'dark';
            const newTextColor = isDarkMode ? '#e0e5ec' : '#333333';
            const newGridColor = isDarkMode ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
            const newPrimary = isDarkMode ? '#4facfe' : '#0d6efd';
            
            if(window.attendanceChart) {
                window.attendanceChart.options.scales.x.ticks.color = newTextColor;
                window.attendanceChart.options.scales.y.ticks.color = newTextColor;
                window.attendanceChart.options.scales.y.grid.color = newGridColor;
                
                window.attendanceChart.data.datasets[0].borderColor = newPrimary;
                window.attendanceChart.data.datasets[0].pointBorderColor = newPrimary;
                
                window.attendanceChart.update();
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Supun\Desktop\EduGo_Live_Code\resources\views/dashboard.blade.php ENDPATH**/ ?>