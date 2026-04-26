

<?php $__env->startSection('content'); ?>

<style>
    /* 3D Title Box */
    .neu-title-box {
        display: inline-flex;
        align-items: center;
        background-color: var(--neu-bg);
        border-radius: 15px;
        padding: 10px 25px;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
    }

    /* 3D Big Action Buttons */
    .neu-big-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: var(--neu-bg);
        border-radius: 20px;
        padding: 40px 20px;
        text-decoration: none;
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                   -8px -8px 16px var(--neu-shadow-light);
        transition: all 0.3s ease;
        height: 100%;
        color: var(--neu-text) !important;
    }

    .neu-big-btn:hover {
        transform: translateY(-5px);
        box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                   -10px -10px 20px var(--neu-shadow-light);
    }

    .neu-big-btn:active {
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light);
        transform: translateY(2px);
    }

    .neu-big-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 35px;
        background-color: var(--neu-bg);
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        margin-bottom: 20px;
    }
</style>

<div class="container mt-5 mb-5 px-xl-4">
    
    <div class="d-flex align-items-center mb-5">
        <a href="/dashboard" class="btn neu-btn me-4 px-3 py-2" data-bs-toggle="tooltip" title="Back to Dashboard">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <div class="neu-title-box">
            <i class="bi bi-person-workspace fs-4 me-3" style="color: var(--neu-success);"></i>
            <h3 class="fw-bold mb-0 text-neu">Teacher Management</h3>
        </div>
    </div>

    <div class="row g-5 justify-content-center">
        
        <div class="col-md-4 col-sm-6">
            <a href="/add-teacher" class="neu-big-btn">
                <div class="neu-big-icon" style="color: var(--neu-primary);">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h4 class="fw-bold mb-2">Add Teacher</h4>
                <p class="text-center mb-0" style="opacity: 0.6; font-size: 0.9rem;">Register a new teacher to the system.</p>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="/teachers-list" class="neu-big-btn">
                <div class="neu-big-icon" style="color: var(--neu-warning);">
                    <i class="bi bi-card-list"></i>
                </div>
                <h4 class="fw-bold mb-2">Teachers List</h4>
                <p class="text-center mb-0" style="opacity: 0.6; font-size: 0.9rem;">View and manage all registered teachers.</p>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="/teachers" class="neu-big-btn">
                <div class="neu-big-icon" style="color: var(--neu-danger);">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h4 class="fw-bold mb-2">Teacher Salaries</h4>
                <p class="text-center mb-0" style="opacity: 0.6; font-size: 0.9rem;">Calculate and manage teacher payouts.</p>
            </a>
        </div>

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
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Supun\Desktop\EduGo_Live_Code\resources\views/teachers-menu.blade.php ENDPATH**/ ?>