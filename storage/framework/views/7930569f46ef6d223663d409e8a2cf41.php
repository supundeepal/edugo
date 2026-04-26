

<?php $__env->startSection('content'); ?>

<style>
    .neu-card {
        background-color: var(--neu-bg);
        border-radius: 20px;
        border: none;
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                   -8px -8px 16px var(--neu-shadow-light);
    }
    
    .neu-input-group {
        background-color: var(--neu-bg);
        border-radius: 12px;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        display: flex;
        align-items: center;
        padding: 5px 15px;
        margin-bottom: 20px;
    }

    .neu-input {
        background-color: transparent !important;
        border: none !important;
        color: var(--neu-text) !important;
        padding: 10px !important;
        width: 100%;
        box-shadow: none !important;
        outline: none !important;
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
    }

    .neu-btn:hover {
        transform: translateY(-2px);
    }

    .neu-btn:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(1px);
    }

    .neu-table-row {
        background-color: var(--neu-bg);
        border-radius: 15px;
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        margin-bottom: 15px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .neu-action-btn {
        width: 40px; height: 40px;
        border-radius: 50%;
        display: flex; justify-content: center; align-items: center;
        background-color: var(--neu-bg);
        box-shadow: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light);
        transition: 0.3s;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .neu-action-btn.delete-btn { color: var(--neu-danger); }
    .neu-action-btn.view-btn { color: var(--neu-primary); }

    .neu-action-btn:hover {
        box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light);
    }
    
    /* Back Button Style */
    .neu-btn-back {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 700;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        transition: 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .neu-btn-back:hover { 
        transform: translateY(-2px); 
        color: var(--neu-primary); 
    }

    /* Modal Styling */
    .modal-content {
        background-color: var(--neu-bg);
        border-radius: 20px;
        border: none;
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light);
    }
    .modal-header {
        border-bottom: 2px dashed rgba(163, 177, 198, 0.2);
    }
    .btn-close-neu {
        background: var(--neu-bg);
        border: none;
        width: 35px; height: 35px;
        border-radius: 50%;
        box-shadow: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light);
        color: var(--neu-text);
        display: flex; align-items: center; justify-content: center;
        transition: 0.3s;
    }
    .btn-close-neu:hover {
        box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), inset -2px -2px 4px var(--neu-shadow-light);
        color: var(--neu-danger);
    }
    
    .info-box {
        background: var(--neu-bg);
        border-radius: 12px;
        padding: 15px;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);
        margin-bottom: 15px;
    }
</style>

<div class="container mt-4 mb-5 px-xl-5">

    <div class="mb-4">
        <a href="<?php echo e(Auth::user()->role === 'owner' ? '/owner/dashboard' : '/staff/dashboard'); ?>" class="neu-btn-back">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="neu-card p-4 p-md-5">
                <h4 class="fw-bold mb-4" style="color: var(--neu-primary);">
                    <i class="bi bi-person-badge-fill me-2"></i> Add New Staff
                </h4>
                <p class="text-neu mb-4" style="opacity: 0.7; font-size: 0.9rem;">
                    Create an account for your reception or gate staff. They will only have access to manage students and payments.
                </p>

                <form action="/manage-staff" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <label class="fw-bold text-neu mb-2 ms-2" style="font-size: 0.9rem;">Full Name</label>
                    <div class="neu-input-group">
                        <i class="bi bi-person text-neu" style="opacity: 0.5;"></i>
                        <input type="text" name="name" class="neu-input" required placeholder="e.g. Kasun Perera">
                    </div>

                    <label class="fw-bold text-neu mb-2 ms-2" style="font-size: 0.9rem;">Username / Email</label>
                    <div class="neu-input-group">
                        <i class="bi bi-envelope text-neu" style="opacity: 0.5;"></i>
                        <input type="text" name="email" class="neu-input" required placeholder="staff@institute.com">
                    </div>

                    <label class="fw-bold text-neu mb-2 ms-2" style="font-size: 0.9rem;">Password</label>
                    <div class="neu-input-group">
                        <i class="bi bi-lock text-neu" style="opacity: 0.5;"></i>
                        <input type="password" name="password" class="neu-input" required placeholder="Minimum 6 characters">
                    </div>

                    <button type="submit" class="neu-btn w-100 mt-3">
                        <i class="bi bi-plus-circle-fill me-2"></i> Create Account
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="neu-card p-4 p-md-5 h-100">
                <h4 class="fw-bold mb-4 text-neu">
                    <i class="bi bi-people-fill me-2" style="color: var(--neu-success);"></i> Existing Staff
                </h4>

                <?php if($staffs->count() > 0): ?>
                    <div class="d-flex flex-column gap-2 mt-4">
                        <?php $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="neu-table-row">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 45px; height: 45px; border-radius: 50%; background: var(--neu-bg); box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--neu-primary); font-weight: bold;">
                                        <?php echo e(strtoupper(substr($staff->name, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-neu mb-0"><?php echo e($staff->name); ?></h6>
                                        <small class="text-neu" style="opacity: 0.6;"><i class="bi bi-envelope me-1"></i> <?php echo e($staff->email); ?></small>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="button" class="neu-action-btn view-btn" data-bs-toggle="modal" data-bs-target="#viewStaffModal<?php echo e($staff->id); ?>" title="View & Edit">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>

                                    <a href="/manage-staff/<?php echo e($staff->id); ?>/delete" class="neu-action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this staff account?')" title="Delete">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="modal fade" id="viewStaffModal<?php echo e($staff->id); ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-neu"><i class="bi bi-person-lines-fill text-primary me-2"></i> Staff Details</h5>
                                            <button type="button" class="btn-close-neu" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                        <div class="modal-body px-4 pt-4 pb-4">
                                            
                                            <div class="info-box">
                                                <small class="fw-bold text-primary text-uppercase">Full Name</small>
                                                <h5 class="fw-bold text-neu mb-0 mt-1"><?php echo e($staff->name); ?></h5>
                                            </div>
                                            
                                            <div class="info-box">
                                                <small class="fw-bold text-primary text-uppercase">Email / Username</small>
                                                <h6 class="fw-bold text-neu mb-0 mt-1"><?php echo e($staff->email); ?></h6>
                                            </div>

                                            <div class="info-box d-flex justify-content-between align-items-center">
                                                <div>
                                                    <small class="fw-bold text-primary text-uppercase">Role & Access</small>
                                                    <h6 class="fw-bold text-neu mb-0 mt-1 text-capitalize"><?php echo e($staff->role); ?></h6>
                                                </div>
                                                <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                                            </div>

                                            <hr class="my-4" style="border-top: 2px dashed rgba(163, 177, 198, 0.3);">

                                            <h6 class="fw-bold text-neu mb-3"><i class="bi bi-shield-lock-fill text-warning me-2"></i> Update Password</h6>
                                            
                                            <form action="/manage-staff/<?php echo e($staff->id); ?>/update-password" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="neu-input-group mb-3">
                                                    <i class="bi bi-key text-neu" style="opacity: 0.5;"></i>
                                                    <input type="password" name="new_password" class="neu-input" required placeholder="Enter new password">
                                                </div>
                                                <button type="submit" class="neu-btn w-100" style="color: var(--neu-warning);">
                                                    <i class="bi bi-arrow-repeat me-2"></i> Update Password
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-person-x text-neu mb-3 d-block" style="font-size: 3rem; opacity: 0.3;"></i>
                        <h5 class="text-neu" style="opacity: 0.5;">No staff accounts found.</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Supun\Desktop\EduGo_Live_Code\resources\views/staff.blade.php ENDPATH**/ ?>