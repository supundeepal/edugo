@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR EDIT PROFILE --- */
    .text-neu { color: var(--neu-text) !important; }

    :root {
        --neu-bg: #e0e5ec;
        --neu-shadow-dark: #a3b1c6;
        --neu-shadow-light: #ffffff;
        --neu-text: #333333;
        --neu-warning: #ffb547;
    }

    [data-bs-theme="dark"] {
        --neu-bg: #242731; 
        --neu-shadow-dark: #15171d; 
        --neu-shadow-light: #2a2d38; /* සුදු ගතිය අයින් කළා */
        --neu-text: #e0e5ec;
        --neu-warning: #f59e0b;
    }

    /* Main 3D Card */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 24px;
        border: none !important;
        /* 24px තිබ්බ ෂැඩෝ එක 18px කළා */
        box-shadow: 9px 9px 18px var(--neu-shadow-dark), 
                   -9px -9px 18px var(--neu-shadow-light) !important;
    }

    /* 3D Icon Box (Top Header) */
    .neu-icon-box-warning {
        width: 70px; 
        height: 70px;
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        font-size: 30px;
        color: var(--neu-warning);
    }

    /* 3D Inputs (ඇතුළට එබිලා පේන පෙට්ටි) */
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 15px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light) !important;
        padding: 14px 18px;
        transition: all 0.2s ease;
    }
    .neu-input:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light) !important;
    }
    
    /* Input Group with Icons */
    .neu-input-group {
        display: flex;
        align-items: center;
        background-color: var(--neu-bg);
        border-radius: 15px;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        padding: 0 15px;
    }
    .neu-input-group i { opacity: 0.6; }
    .neu-input-group input {
        border: none;
        background: transparent;
        box-shadow: none !important;
        padding-left: 10px;
    }

    /* Course Selection 3D Cards */
    .neu-course-card {
        background-color: var(--neu-bg);
        border-radius: 18px;
        padding: 15px;
        /* ෂැඩෝ එක සිනිඳු කළා */
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .neu-course-card:hover { transform: translateY(-3px); }
    .neu-course-card.course-selected {
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
    }

    /* Custom 3D Checkbox */
    .neu-checkbox {
        appearance: none;
        -webkit-appearance: none;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background-color: var(--neu-bg);
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        outline: none;
        transition: 0.2s;
    }
    .neu-checkbox:checked::after {
        content: '\F272';
        font-family: 'bootstrap-icons';
        color: var(--neu-primary, #0d6efd);
        font-size: 20px;
        font-weight: bold;
    }

    /* Custom File Input */
    input[type="file"].neu-input::file-selector-button {
        background-color: var(--neu-bg);
        color: var(--neu-warning);
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        margin-right: 15px;
        font-weight: 600;
        box-shadow: 3px 3px 6px var(--neu-shadow-dark), 
                   -3px -3px 6px var(--neu-shadow-light);
        cursor: pointer;
        transition: 0.2s;
    }
    input[type="file"].neu-input::file-selector-button:hover { transform: translateY(-2px); }
    input[type="file"].neu-input::file-selector-button:active {
        box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), 
                    inset -2px -2px 4px var(--neu-shadow-light);
        transform: translateY(1px);
    }

    /* Warning Button Override */
    .neu-btn-warning { color: var(--neu-warning) !important; }
</style>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            <div class="card neu-card p-4 p-md-5">
                
                <div class="text-center mb-5">
                    <div class="neu-icon-box-warning mx-auto mb-3">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-neu">Edit Student Profile</h2>
                    <p class="mb-0 fs-6 text-neu" style="opacity: 0.6;">Update details or change enrolled classes</p>
                </div>

                <form action="/students/{{ $student->id }}/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Full Name</label>
                        <div class="neu-input-group">
                            <i class="bi bi-person fs-5 text-neu"></i>
                            <input type="text" name="student_name" value="{{ $student->student_name }}" class="form-control fw-bold text-neu" required>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold fs-5 mb-4 ms-2 text-neu border-bottom pb-2 w-100" style="opacity: 0.9; border-color: var(--neu-shadow-dark) !important;">
                            <i class="bi bi-journal-bookmark-fill me-2" style="color: var(--neu-warning);"></i>Enrolled Classes
                        </label>
                        
                        <div class="row mx-0">
                            @forelse($courses as $course)
                                @php $isEnrolled = $student->courses->contains($course->id); @endphp
                                
                                <div class="col-md-6 px-2">
                                    <label class="w-100 neu-course-card {{ $isEnrolled ? 'course-selected' : '' }}" for="course_{{ $course->id }}">
                                        
                                        <input class="neu-checkbox me-3 mt-0" type="checkbox" name="courses[]" value="{{ $course->id }}" id="course_{{ $course->id }}" {{ $isEnrolled ? 'checked' : '' }}>
                                        
                                        <div class="flex-grow-1">
                                            <div class="fw-bold mb-1 {{ $isEnrolled ? 'text-primary' : 'text-neu' }} course-title" style="font-size: 1.05rem;">
                                                {{ $course->course_name }}
                                            </div>
                                            <div class="text-neu small fw-semibold" style="opacity: 0.6;">
                                                <i class="bi bi-person-workspace me-1" style="color: var(--neu-warning);"></i> 
                                                {{ $course->teacher->name ?? 'Unknown Teacher' }}
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @empty
                                <div class="col-12 text-danger small fw-bold ms-2">No classes available in the system.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Index / Card Number</label>
                            <div class="neu-input-group">
                                <i class="bi bi-credit-card fs-5 text-neu"></i>
                                <input type="text" name="card_number" value="{{ $student->card_number }}" class="form-control fw-bold text-neu" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Parent's WhatsApp No</label>
                            <div class="neu-input-group">
                                <i class="bi bi-whatsapp fs-5" style="color: #05cd99;"></i>
                                <input type="text" name="parent_phone" value="{{ $student->parent_phone }}" class="form-control fw-bold text-neu" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 mt-4">
                        <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Update Profile Photo (Optional)</label>
                        <input type="file" name="photo" class="form-control neu-input fw-bold px-3 py-2" accept="image/*">
                    </div>

                    <button type="submit" class="btn neu-btn neu-btn-warning w-100 fw-bold py-3 fs-5 mt-2">
                        <i class="bi bi-save-fill me-2"></i> Update Details
                    </button>
                    
                </form>
            </div>
            
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Course Card Selection Logic
        const checkboxes = document.querySelectorAll('.neu-checkbox');
        
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const card = this.closest('.neu-course-card');
                const title = card.querySelector('.course-title');
                
                if(this.checked) {
                    card.classList.add('course-selected');
                    title.classList.remove('text-neu');
                    title.classList.add('text-primary');
                } else {
                    card.classList.remove('course-selected');
                    title.classList.remove('text-primary');
                    title.classList.add('text-neu');
                }
            });
        });
    });
</script>
@endsection