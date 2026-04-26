@extends('superadmin.layout')

@section('title', 'System Settings')

@section('content')

<style>
    .neu-input {
        background-color: var(--neu-bg);
        border: none;
        border-radius: 12px;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px rgba(0, 0, 0, 0.03); 
        color: var(--neu-text);
        padding: 12px 15px;
        width: 100%;
        transition: all 0.2s ease;
    }
    .neu-input:focus {
        outline: none;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px rgba(0, 0, 0, 0.05);
    }
    
    /* ලස්සන Neumorphism On/Off Switch එකක් (Toggle) */
    .neu-toggle {
        appearance: none;
        width: 60px;
        height: 30px;
        background: var(--neu-bg);
        border-radius: 15px;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        position: relative;
        cursor: pointer;
        outline: none;
        transition: all 0.3s ease;
    }
    .neu-toggle::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--neu-bg);
        top: 3px;
        left: 3px;
        box-shadow: 2px 2px 5px var(--neu-shadow-dark), 
                   -2px -2px 5px var(--neu-shadow-light);
        transition: 0.3s;
    }
    .neu-toggle:checked {
        background-color: var(--neu-success);
        box-shadow: inset 3px 3px 6px rgba(0,0,0,0.2);
    }
    .neu-toggle:checked::after {
        left: 33px;
        background: #fff;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold text-neu mb-0"><i class="bi bi-gear-fill me-2" style="color: var(--neu-danger);"></i> System Settings</h5>
</div>

<form action="#" method="POST">
    @csrf
    <div class="row g-4">
        
        <div class="col-md-7">
            <div class="card neu-card p-4 h-100">
                <h6 class="fw-bold mb-4" style="color: var(--neu-primary);"><i class="bi bi-sliders me-2"></i>General Configurations</h6>
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">System Name</label>
                    <input type="text" name="system_name" class="neu-input" value="EduGo SaaS" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Support Email Address</label>
                    <input type="email" name="support_email" class="neu-input" value="support@edugo.lk" required>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Default Currency</label>
                        <select name="currency" class="neu-input">
                            <option value="LKR" selected>LKR (Sri Lankan Rupee)</option>
                            <option value="USD">USD (US Dollar)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Timezone</label>
                        <select name="timezone" class="neu-input">
                            <option value="Asia/Colombo" selected>Asia/Colombo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card neu-card p-4 h-100">
                <h6 class="fw-bold mb-4" style="color: var(--neu-warning);"><i class="bi bi-shield-lock-fill me-2"></i>Security & Controls</h6>
                
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <div>
                        <h6 class="fw-bold text-neu mb-1">Maintenance Mode</h6>
                        <small class="text-neu" style="opacity: 0.6;">Temporarily disable login for all institutes.</small>
                    </div>
                    <input type="checkbox" name="maintenance_mode" class="neu-toggle">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <div>
                        <h6 class="fw-bold text-neu mb-1">Allow New Registrations</h6>
                        <small class="text-neu" style="opacity: 0.6;">Enable or disable new user signups.</small>
                    </div>
                    <input type="checkbox" name="allow_registrations" class="neu-toggle" checked>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold text-neu mb-1">Enable Email Alerts</h6>
                        <small class="text-neu" style="opacity: 0.6;">Send system notifications via email.</small>
                    </div>
                    <input type="checkbox" name="email_alerts" class="neu-toggle" checked>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="neu-btn px-5 py-3" style="color: var(--neu-primary); font-size: 1.1rem;">
            <i class="bi bi-save-fill me-2"></i> Save Changes
        </button>
    </div>
</form>

@endsection