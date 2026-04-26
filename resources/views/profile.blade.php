@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR STUDENT PROFILE --- */
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Main Cards */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 30px;
        border: none !important;
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light) !important;
        padding: 30px;
    }

    /* 3D Avatar Frame */
    .neu-avatar-frame {
        padding: 12px;
        border-radius: 50%;
        background-color: var(--neu-bg);
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                   -8px -8px 16px var(--neu-shadow-light);
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 25px;
    }
    .neu-avatar-frame img {
        width: 150px; 
        height: 150px; 
        border-radius: 50%; 
        object-fit: cover;
        border: 5px solid var(--neu-bg);
        box-shadow: inset 4px 4px 8px rgba(0,0,0,0.15);
    }
    .placeholder-avatar {
        width: 150px; 
        height: 150px; 
        border-radius: 50%; 
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 80px;
        color: var(--neu-text);
        opacity: 0.4;
        border: 5px solid var(--neu-bg);
        box-shadow: inset 4px 4px 8px rgba(0,0,0,0.1);
    }

    /* Inset Badges for Details */
    .neu-badge {
        background-color: var(--neu-bg);
        padding: 10px 20px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        display: inline-block;
        margin: 5px;
    }

    /* 3D Divider */
    .neu-divider {
        width: 80%;
        height: 4px;
        background-color: var(--neu-bg);
        border-radius: 2px;
        box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), 
                    inset -2px -2px 4px var(--neu-shadow-light);
        margin: 30px auto;
    }

    /* 3D Icon Box */
    .neu-icon-box {
        width: 50px; 
        height: 50px;
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        font-size: 22px;
    }

    /* 3D List Items for Payments */
    .neu-list-item {
        background-color: var(--neu-bg);
        border-radius: 18px;
        padding: 18px 25px;
        margin-bottom: 18px;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.2s ease;
    }
    .neu-list-item:hover {
        transform: translateY(-3px);
    }
    
    /* Back Button */
    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .neu-btn:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(2px);
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="mb-4">
        <a href="/students" class="neu-btn" style="color: var(--neu-text);">
            <i class="bi bi-arrow-left me-2"></i> Back to Students
        </a>
    </div>

    <div class="row g-4 g-lg-5">
        
        <div class="col-md-5 col-lg-4">
            <div class="card neu-card text-center h-100">
                
                <div class="neu-avatar-frame mx-auto">
                    @if($student->photo)
                        <img src="{{ asset('storage/'.$student->photo) }}" alt="Student Photo">
                    @else
                        <div class="placeholder-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    @endif
                </div>
                
                <h3 class="fw-bold text-neu mb-1">{{ $student->student_name }}</h3>
                <p class="fs-5 mb-4" style="color: var(--neu-primary); font-weight: 600;">{{ $student->grade_course }}</p>
                
                <div>
                    <div class="neu-badge mb-3" style="color: var(--neu-text);">
                        <i class="bi bi-credit-card me-2" style="color: var(--neu-primary);"></i> ID: {{ $student->card_number }}
                    </div>
                    <br>
                    <div class="neu-badge" style="color: var(--neu-danger);">
                        <i class="bi bi-exclamation-circle me-2"></i> Arrears: Rs. {{ number_format($student->arrears, 2) }}
                    </div>
                </div>
                
                <div class="neu-divider"></div>
                
                <a href="https://wa.me/{{ $student->parent_phone }}" target="_blank" class="text-decoration-none d-inline-flex align-items-center justify-content-center fw-bold fs-5" style="color: #05cd99; transition: 0.2s;">
                    <i class="bi bi-whatsapp me-2 fs-4"></i> {{ $student->parent_phone }}
                </a>
                
            </div>
        </div>

        <div class="col-md-7 col-lg-8">
            <div class="card neu-card h-100">
                
                <div class="d-flex align-items-center mb-4 pb-3" style="border-bottom: 2px dashed rgba(0,0,0,0.1);">
                    <div class="neu-icon-box me-3" style="color: #10b981;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h4 class="fw-bold mb-0 text-neu">Payment History</h4>
                </div>
                
                <div class="payment-list mt-2">
                    @forelse($payments as $p)
                        <div class="neu-list-item">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-3 fs-4" style="color: #10b981;"></i>
                                <div>
                                    <h6 class="fw-bold text-neu mb-1 fs-5">{{ $p->payment_type }} Payment</h6>
                                    <small class="text-neu" style="opacity: 0.6; font-weight: 500;">
                                        <i class="bi bi-calendar-check me-1"></i> {{ $p->payment_date }}
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold fs-4" style="color: #10b981;">Rs. {{ number_format($p->amount, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-receipt display-1 d-block mb-3" style="color: var(--neu-text); opacity: 0.2;"></i>
                            <h4 class="fw-bold text-neu" style="opacity: 0.6;">No payments recorded.</h4>
                            <p class="text-neu" style="opacity: 0.5;">This student hasn't made any payments yet.</p>
                        </div>
                    @endforelse
                </div>
                
            </div>
        </div>

    </div>
</div>

@endsection