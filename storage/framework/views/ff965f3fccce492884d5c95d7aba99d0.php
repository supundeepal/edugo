

<?php $__env->startSection('content'); ?>

<style>
    .text-neu { color: var(--neu-text) !important; }

    .neu-table {
        border-collapse: separate;
        border-spacing: 0 18px; /* පේළි අතර පරතරය ටිකක් වැඩි කළා */
        width: 100%;
    }
    .neu-table th {
        border: none;
        padding: 10px 25px;
        color: var(--neu-text);
        opacity: 0.5;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }
    .neu-table td {
        background-color: var(--neu-bg);
        border: none;
        padding: 20px 25px;
        vertical-align: middle;
        color: var(--neu-text);
    }
    .neu-table td:first-child { border-top-left-radius: 20px; border-bottom-left-radius: 20px; }
    .neu-table td:last-child { border-top-right-radius: 20px; border-bottom-right-radius: 20px; }

    /* 3D Row Effect */
    .neu-table tr.neu-row {
        box-shadow: 7px 7px 14px var(--neu-shadow-dark), 
                   -7px -7px 14px var(--neu-shadow-light);
        transition: all 0.3s ease;
    }
    .neu-table tr.neu-row:hover {
        transform: translateY(-4px);
        box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                   -10px -10px 20px var(--neu-shadow-light);
    }

    /* Avatars */
    .neu-avatar {
        border-radius: 50%;
        border: 4px solid var(--neu-bg);
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        width: 55px; 
        height: 55px; 
        object-fit: cover;
    }
    
    .neu-avatar-placeholder {
        width: 55px; 
        height: 55px; 
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        color: var(--neu-text); 
        opacity: 0.6;
        font-size: 1.5rem;
    }

    /* Title Box */
    .neu-title-box {
        display: inline-flex;
        align-items: center;
        background-color: var(--neu-bg);
        border-radius: 15px;
        padding: 12px 30px;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
    }

    /* Small ID Badge */
    .neu-id-badge {
        background-color: var(--neu-bg);
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), 
                    inset -2px -2px 5px var(--neu-shadow-light);
        color: var(--neu-primary);
        display: inline-block;
        margin-top: 5px;
    }

    /* Status Indicator Dot */
    .status-dot {
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 8px #10b981;
        margin-right: 8px;
    }

    /* Payout Button */
    .neu-pay-pill {
        background-color: var(--neu-bg);
        color: var(--neu-text); 
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 10px 20px;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .neu-pay-pill i { color: #10b981; transition: 0.3s; }
    
    .neu-pay-pill:hover {
        transform: translateY(-2px);
        color: #10b981; 
    }
    .neu-pay-pill:hover i {
        transform: translateX(3px);
    }
    .neu-pay-pill:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(1px);
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div class="d-flex align-items-center">
            <a href="/teachers-menu" class="btn neu-btn me-4 px-3 py-2" style="border-radius: 12px; box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light); color: var(--neu-text);" data-bs-toggle="tooltip" title="Back to Menu">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <div class="neu-title-box">
                <i class="bi bi-wallet2 fs-4 me-3" style="color: #10b981;"></i>
                <h3 class="fw-bold mb-0 text-neu">Payroll Dashboard</h3>
            </div>
        </div>
        
        <div class="d-none d-md-block px-4 py-2" style="border-radius: 12px; box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);">
            <span class="fw-bold text-neu" style="opacity: 0.7; font-size: 0.9rem;">Total Instructors: <span style="color: var(--neu-primary);"><?php echo e($teachers->count()); ?></span></span>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert fw-bold text-center border-0 mb-4" style="background-color: var(--neu-bg); color: #10b981; border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="table-responsive px-2 pb-4">
        <table class="neu-table">
            <thead>
                <tr>
                    <th class="ps-4">Instructor Details</th>
                    <th>Contact Information</th>
                    <th>Account Status</th>
                    <th class="text-end pe-4">Payroll Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="neu-row">
                    
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <?php if($teacher->photo): ?>
                                <img src="<?php echo e(asset($teacher->photo)); ?>" class="neu-avatar me-4">
                            <?php else: ?>
                                <div class="neu-avatar-placeholder me-4">
                                    <i class="bi bi-person"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h5 class="fw-bold text-neu mb-1" style="letter-spacing: -0.3px;"><?php echo e($teacher->name); ?></h5>
                                <div class="neu-id-badge">
                                    <i class="bi bi-upc-scan me-1"></i> TCH-<?php echo e(str_pad($teacher->id, 3, '0', STR_PAD_LEFT)); ?>

                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="d-flex flex-column justify-content-center text-neu" style="font-size: 0.9rem; font-weight: 500;">
                            <div class="mb-2" style="opacity: 0.9;">
                                <i class="bi bi-envelope-at-fill me-2" style="color: var(--neu-primary);"></i>
                                <?php echo e($teacher->email ?? 'Email not provided'); ?>

                            </div>
                            <div style="opacity: 0.7;">
                                <i class="bi bi-telephone-fill me-2" style="color: var(--neu-warning);"></i>
                                <?php echo e($teacher->phone ?? 'Phone not provided'); ?>

                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center fw-bold text-neu" style="opacity: 0.8; font-size: 0.95rem;">
                            <span class="status-dot"></span> Active Staff
                        </div>
                    </td>
                    
                    <td class="text-end pe-4">
                        <a href="<?php echo e(url('/teachers/' . $teacher->id . '/courses')); ?>" class="neu-pay-pill" data-bs-toggle="tooltip" title="Calculate & Pay Salaries">
                            Process Payout <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr class="neu-row">
                    <td colspan="4" class="text-center py-5 text-neu" style="opacity: 0.6;">
                        <i class="bi bi-cash-coin display-4 d-block mb-3"></i>
                        <h4 class="fw-bold">No Instructors Found!</h4>
                        <p class="mb-0">Please register a new teacher to manage payroll.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Supun\Desktop\EduGo_Live_Code\resources\views/teacher-salaries.blade.php ENDPATH**/ ?>