@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR TEACHER'S CLASSES --- */
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Main Header Icon */
    .neu-icon-box {
        width: 60px; 
        height: 60px;
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light);
        font-size: 26px;
    }

    /* 3D Action Buttons (Back & Salary) */
    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
        border-radius: 15px;
        padding: 12px 20px;
        font-weight: 700;
        font-size: 0.95rem;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .neu-btn:hover {
        transform: translateY(-3px);
    }
    .neu-btn:active {
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        transform: translateY(2px);
    }

    /* 3D Class Cards */
    .neu-card {
        background-color: var(--neu-bg);
        border-radius: 25px;
        box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                   -10px -10px 20px var(--neu-shadow-light);
        transition: all 0.3s ease;
        border: none;
    }
    .neu-card:hover {
        transform: translateY(-8px);
        box-shadow: 15px 15px 30px var(--neu-shadow-dark), 
                   -15px -15px 30px var(--neu-shadow-light);
    }

    /* Inset Icon inside Class Cards */
    .neu-inset-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--neu-bg);
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        margin: 0 auto 20px auto;
    }

    /* 3D Divider (Instead of <hr>) */
    .neu-divider {
        width: 100%;
        height: 4px;
        background-color: var(--neu-bg);
        border-radius: 2px;
        box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), 
                    inset -2px -2px 4px var(--neu-shadow-light);
        margin: 20px 0;
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-5">
        <a href="/teachers" class="neu-btn me-sm-4 mb-4 mb-sm-0" style="color: var(--neu-text);">
            <i class="bi bi-arrow-left me-2"></i> Back to Teachers
        </a>
        <div class="d-flex align-items-center">
            <div class="neu-icon-box me-3" style="color: var(--neu-primary);">
                <i class="bi bi-person-badge"></i>
            </div>
            <h2 class="fw-bold text-neu mb-0">{{ $teacher->name }}'s Classes</h2>
        </div>
    </div>

    <div class="row g-4 g-lg-5">
        @forelse($courses as $course)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card neu-card p-4 h-100 d-flex flex-column text-center">
                
                <div class="neu-inset-icon">
                    <i class="bi bi-easel2-fill fs-1" style="color: #ffb547;"></i>
                </div>
                
                <h4 class="fw-bold text-neu mb-2" style="font-size: 1.3rem;">{{ $course->course_name }}</h4>
                
                <p class="text-neu mb-0" style="opacity: 0.7; font-weight: 600;">
                    Course Fee: <span style="color: var(--neu-primary);">Rs. {{ number_format($course->fee, 2) }}</span>
                </p>
                
                <div class="neu-divider"></div>
                
                <div class="mt-auto">
                    <a href="/teacher-salary/{{ $course->id }}" class="neu-btn w-100" style="color: #10b981;">
                        <i class="bi bi-wallet2 me-2 fs-5"></i> Salary Details
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="neu-icon-box mx-auto mb-4" style="width: 100px; height: 100px; font-size: 40px; color: var(--neu-text); opacity: 0.5;">
                <i class="bi bi-easel3"></i>
            </div>
            <h3 class="fw-bold text-neu" style="opacity: 0.7;">No classes assigned!</h3>
            <p class="text-neu" style="opacity: 0.5;">{{ $teacher->name }} doesn't have any assigned classes yet.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection