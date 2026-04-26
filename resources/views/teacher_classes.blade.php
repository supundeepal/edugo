@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR TEACHER'S CLASSES --- */
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Header Icon Box */
    .neu-icon-box {
        width: 65px; 
        height: 65px;
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light);
        font-size: 28px;
    }

    /* 3D Action Buttons (View Students / Back) */
    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
        border-radius: 16px;
        padding: 12px 20px;
        font-weight: 700;
        font-size: 1rem;
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
    }

    /* 3D Divider */
    .neu-divider {
        width: 100%;
        height: 4px;
        background-color: var(--neu-bg);
        border-radius: 2px;
        box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), 
                    inset -2px -2px 4px var(--neu-shadow-light);
        margin: 25px 0;
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-5 gap-4">
        
        <div class="d-flex align-items-center">
            <div class="neu-icon-box me-3" style="color: var(--neu-primary);">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-neu">My Classes</h2>
                <p class="text-neu mb-0" style="opacity: 0.6; font-weight: 500;">Here are the classes currently assigned to you.</p>
            </div>
        </div>
        
        <div>
            <a href="/teacher-dashboard" class="neu-btn" style="color: var(--neu-text);">
                <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
            </a>
        </div>
        
    </div>

    <div class="row g-4 g-lg-5">
        @forelse($courses as $course)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card neu-card p-4 h-100 d-flex flex-column text-center">
                
                <div class="neu-inset-icon mx-auto mb-4" style="color: var(--neu-primary);">
                    <i class="bi bi-book-half fs-1"></i>
                </div>
                
                <h4 class="fw-bold text-neu mb-2" style="font-size: 1.3rem;">{{ $course->course_name }}</h4>
                
                <p class="text-neu mb-0" style="opacity: 0.7; font-weight: 600;">
                    Class Fee: <span style="color: #10b981; font-size: 1.1rem;">Rs. {{ number_format($course->fee, 2) }}</span>
                </p>
                
                <div class="neu-divider"></div>
                
                <div class="mt-auto">
                    <a href="/teacher-classes/{{ $course->id }}/students" class="neu-btn w-100" style="color: var(--neu-primary);">
                        <i class="bi bi-people-fill me-2 fs-5"></i> View Students
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="neu-icon-box mx-auto mb-4" style="width: 100px; height: 100px; font-size: 40px; color: var(--neu-text); opacity: 0.5;">
                <i class="bi bi-journal-x"></i>
            </div>
            <h3 class="fw-bold text-neu" style="opacity: 0.7;">No classes assigned yet!</h3>
            <p class="text-neu" style="opacity: 0.5;">You don't have any classes assigned at the moment.</p>
        </div>
        @endforelse
    </div>
    
</div>

@endsection