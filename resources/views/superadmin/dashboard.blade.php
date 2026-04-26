@extends('superadmin.layout')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="row g-4 mb-4">
    
    <div class="col-md-4">
        <div class="card neu-card h-100 p-4">
            <div class="d-flex align-items-center">
                <div class="sidebar-icon me-4" style="color: var(--neu-primary); width: 60px; height: 60px; font-size: 24px;">
                    <i class="bi bi-buildings-fill"></i>
                </div>
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 text-neu" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">Total Institutes</h6>
                    <h2 class="fw-bold mb-0 text-neu">{{ sprintf('%02d', $total_institutes) }}</h2> 
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card neu-card h-100 p-4">
            <div class="d-flex align-items-center">
                <div class="sidebar-icon me-4" style="color: var(--neu-success); width: 60px; height: 60px; font-size: 24px;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 text-neu" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">Registered Owners</h6>
                    <h2 class="fw-bold mb-0 text-neu">{{ sprintf('%02d', $total_users) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card neu-card h-100 p-4">
            <div class="d-flex align-items-center">
                <div class="sidebar-icon me-4" style="color: var(--neu-warning); width: 60px; height: 60px; font-size: 24px;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 text-neu" style="opacity: 0.6; font-size: 0.85rem; letter-spacing: 1px;">System Income</h6>
                    <h2 class="fw-bold mb-0 text-neu">Rs. 0.00</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card neu-card p-5 text-center mt-4">
    <h3 class="fw-bold" style="color: var(--neu-primary);">Welcome to EduGo SaaS! 🚀</h3>
    <p class="text-neu mb-0" style="opacity: 0.7;">This is your master control panel. You can manage all tuition institutes from here.</p>
</div>
@endsection