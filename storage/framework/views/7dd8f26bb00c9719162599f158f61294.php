

<?php $__env->startSection('content'); ?>

<style>
    /* --- NEUMORPHISM FOR TEACHER DASHBOARD --- */
    .text-neu { color: var(--neu-text) !important; }

    .neu-banner {
        background-color: var(--neu-bg);
        border-radius: 22px; 
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light);
        position: relative;
        overflow: hidden;
    }
    
    .neu-banner::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        border-radius: 50%;
    }

    .neu-avatar-frame {
        padding: 8px;
        border-radius: 50%;
        background-color: var(--neu-bg);
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
        display: inline-block;
    }
    .neu-avatar-frame img {
        width: 75px; 
        height: 75px; 
        border-radius: 50%; 
        object-fit: cover;
        border: 3px solid var(--neu-bg);
        box-shadow: inset 3px 3px 6px rgba(0,0,0,0.2);
    }

    .neu-action-card {
        background-color: var(--neu-bg);
        border-radius: 22px;
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                   -8px -8px 16px var(--neu-shadow-light);
        transition: all 0.3s ease;
        padding: 25px 15px; 
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: none;
        text-align: center;
    }
    .neu-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                   -10px -10px 20px var(--neu-shadow-light);
    }
    .neu-action-card:active {
        transform: translateY(2px);
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                     inset -6px -6px 12px var(--neu-shadow-light);
    }

    .neu-inset-icon {
        width: 65px; 
        height: 65px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--neu-bg);
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        margin-bottom: 20px;
    }

    /* ⭐ New Institute Badge Style */
    .institute-badge {
        background: var(--neu-bg);
        border-radius: 12px;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        padding: 8px 15px;
        display: inline-flex;
        align-items: center;
        font-weight: 700;
        color: var(--neu-primary);
        font-size: 0.9rem;
        margin-top: 10px;
    }
</style>

<div class="container-fluid mt-4 mb-4 px-xl-4">
    
    <div class="row mb-4"> 
        <div class="col-12">
            <div class="neu-banner p-4 p-md-5 d-flex flex-column flex-sm-row justify-content-between align-items-center text-center text-sm-start">
                
                <div class="mb-3 mb-sm-0 z-1">
                    <h2 class="fw-bold mb-2" style="color: #10b981; font-size: 2.2rem; letter-spacing: -1px;">
                        Welcome, <?php echo e(Session::get('teacher_name')); ?>!
                    </h2>
                    <p class="mb-0 text-neu opacity-75 fw-medium">
                        Here is your teaching overview for today.
                    </p>
                    
                    <div class="institute-badge">
                        <i class="bi bi-buildings-fill me-2 fs-6"></i>
                        <?php echo e(session('current_institute_name', 'My Institute')); ?>

                    </div>
                </div>
                
                <div class="z-1">
                    <div class="neu-avatar-frame">
                        <img src="<?php echo e(Session::get('teacher_photo') ? asset(Session::get('teacher_photo')) : 'https://cdn-icons-png.flaticon.com/512/2784/2784445.png'); ?>" alt="Teacher Profile">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex align-items-center mb-4 mt-2">
        <div class="neu-inset-icon me-3" style="width: 45px; height: 45px; margin-bottom: 0; box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light);">
            <i class="bi bi-grid-fill text-success fs-5"></i>
        </div>
        <h5 class="fw-bold mb-0 text-neu">My Quick Actions</h5>
    </div>

    <div class="row g-4 justify-content-center">
        
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <a href="/teacher-classes" class="text-decoration-none"> 
                <div class="neu-action-card">
                    <div class="neu-inset-icon">
                        <i class="bi bi-journal-bookmark-fill display-6" style="color: var(--neu-primary);"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-neu">My Classes</h6>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <a href="/teacher-classes" class="text-decoration-none">
                <div class="neu-action-card">
                    <div class="neu-inset-icon">
                        <i class="bi bi-people-fill display-6" style="color: #ffb547;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-neu">My Students</h6>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <a href="/teacher-announcements" class="text-decoration-none">
                <div class="neu-action-card">
                    <div class="neu-inset-icon">
                        <i class="bi bi-megaphone-fill display-6" style="color: #ef4444;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-neu">Announcements</h6>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <a href="/teacher-earnings" class="text-decoration-none">
                <div class="neu-action-card">
                    <div class="neu-inset-icon">
                        <i class="bi bi-wallet2 display-6" style="color: #10b981;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-neu">My Earnings</h6>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <a href="/teacher-attendance" class="text-decoration-none">
                <div class="neu-action-card">
                    <div class="neu-inset-icon">
                        <i class="bi bi-person-check-fill display-6" style="color: #3b82f6;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-neu">Attendance</h6>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <a href="/teacher-materials" class="text-decoration-none">
                <div class="neu-action-card">
                    <div class="neu-inset-icon">
                        <i class="bi bi-file-earmark-pdf-fill display-6" style="color: #8b5cf6;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-neu">Materials</h6>
                </div>
            </a>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Supun\Desktop\EduGo_Live_Code\resources\views/teacher_dashboard.blade.php ENDPATH**/ ?>