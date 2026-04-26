@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR FORMS & CARDS --- */
    .text-neu { color: var(--neu-text) !important; }

    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 24px;
        border: none !important;
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light) !important;
    }

    .neu-icon-box {
        width: 70px; height: 70px; border-radius: 50%;
        display: flex; justify-content: center; align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light);
        font-size: 30px;
    }

    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 15px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light) !important;
        padding: 14px 18px;
        transition: all 0.2s ease;
    }
    .neu-input:focus {
        outline: none;
        box-shadow: inset 8px 8px 16px var(--neu-shadow-dark), 
                    inset -8px -8px 16px var(--neu-shadow-light) !important;
    }

    /* --- Custom File Upload Style --- */
    .neu-file-upload {
        position: relative;
        display: block;
        width: 100%;
        height: 55px;
        background-color: var(--neu-bg);
        border-radius: 15px;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        cursor: pointer;
        overflow: hidden;
    }
    .neu-file-upload input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }
    .neu-file-label {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        display: flex; align-items: center; padding: 0 20px;
        color: var(--neu-text); opacity: 0.7; font-weight: 600;
    }
    .neu-file-btn {
        margin-left: auto;
        padding: 6px 15px;
        background-color: var(--neu-bg);
        border-radius: 10px;
        box-shadow: 3px 3px 6px var(--neu-shadow-dark), 
                   -3px -3px 6px var(--neu-shadow-light);
        font-size: 0.85rem;
    }

    /* Course Selection 3D Cards */
    .neu-course-card {
        background-color: var(--neu-bg);
        border-radius: 18px;
        padding: 15px;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        border: 2px solid transparent;
    }
    .neu-course-card:hover { transform: translateY(-3px); }
    .neu-course-card.course-selected {
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light);
        border-color: rgba(13, 110, 253, 0.1);
    }

    .neu-checkbox {
        appearance: none; width: 28px; height: 28px; border-radius: 8px;
        background-color: var(--neu-bg);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        display: flex; justify-content: center; align-items: center;
        cursor: pointer; outline: none;
    }
    .neu-checkbox:checked::after {
        content: '\F272'; font-family: 'bootstrap-icons';
        color: var(--neu-primary); font-size: 20px; font-weight: bold;
    }

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
    .neu-btn-back:hover { transform: translateY(-2px); color: var(--neu-primary); }
</style>

<div class="container mt-4 mb-5 px-xl-5">
    
    <div class="mb-4">
        <a href="/dashboard" class="neu-btn-back">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card neu-card p-4 p-md-5">
                
                <div class="text-center mb-5">
                    <div class="neu-icon-box mx-auto mb-3" style="color: var(--neu-success);">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-neu">Register Student</h2>
                    <p class="mb-0 fs-6 text-neu opacity-50">Create a profile and assign courses for a new student</p>
                </div>

                @if(session('success'))
                    <div class="alert fw-bold text-center border-0 mb-4" style="background-color: var(--neu-bg); color: #10b981; border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert fw-bold border-0 mb-4 text-danger" style="background-color: var(--neu-bg); border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
                        <ul class="mb-0 list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/students" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu ms-2 opacity-75">Student Full Name</label>
                            <input type="text" name="student_name" class="form-control neu-input fw-bold" placeholder="e.g. John Doe" value="{{ old('student_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu ms-2 opacity-75">Card Number / ID</label>
                            
                            <input type="text" name="card_number" class="form-control neu-input fw-bold" value="{{ $nextCardNumber }}" required>
                            
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu ms-2 opacity-75">Phone Number</label>
                            <input type="text" name="phone" class="form-control neu-input fw-bold" placeholder="07xxxxxxxx" value="{{ old('phone') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu ms-2 opacity-75">Student Photo</label>
                            <div class="neu-file-upload">
                                <input type="file" name="photo" id="photoInput" accept="image/*">
                                <div class="neu-file-label" id="fileLabel">
                                    <i class="bi bi-camera-fill me-2"></i>
                                    <span id="fileNameDisplay">Choose a photo...</span>
                                    <span class="neu-file-btn">Browse</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--neu-shadow-dark) !important;">
                             <i class="bi bi-journal-check fs-4 me-2" style="color: var(--neu-warning);"></i>
                             <h5 class="fw-bold mb-0 text-neu">Assign Courses</h5>
                        </div>
                        
                        <div class="row">
                            @foreach($courses as $course)
                                <div class="col-md-6 px-3">
                                    <label class="w-100 neu-course-card {{ in_array($course->id, old('courses', [])) ? 'course-selected' : '' }}" for="course{{ $course->id }}">
                                        
                                        <input class="neu-checkbox me-3 mt-0" type="checkbox" name="courses[]" value="{{ $course->id }}" id="course{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'checked' : '' }}>
                                        
                                        <div class="flex-grow-1">
                                            <div class="fw-bold text-neu mb-0" style="font-size: 1.05rem;">{{ $course->course_name }}</div>
                                            <small class="text-neu opacity-50 fw-bold">
                                                {{ $course->teacher->name ?? 'Instructor' }}
                                            </small>
                                        </div>
                                        
                                        <div class="ms-2">
                                            <span class="badge fw-bold px-3 py-2 rounded-pill" style="background-color: var(--neu-bg); color: var(--neu-primary); box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light); font-size: 0.85rem;">
                                                Rs. {{ number_format($course->fee, 0) }}
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 fw-bold py-3 fs-5" style="background: var(--neu-bg); box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light); border:none; border-radius: 20px; color: var(--neu-primary) !important; transition: 0.3s;">
                        <i class="bi bi-shield-check-fill me-2"></i> Finalize Registration
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
        // --- Course Selection Logic ---
        const checkboxes = document.querySelectorAll('.neu-checkbox');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const card = this.closest('.neu-course-card');
                if(this.checked) {
                    card.classList.add('course-selected');
                } else {
                    card.classList.remove('course-selected');
                }
            });
        });

        // --- Custom File Input Logic ---
        const photoInput = document.getElementById('photoInput');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        
        photoInput.addEventListener('change', function() {
            if(this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.style.color = 'var(--neu-primary)';
            } else {
                fileNameDisplay.textContent = 'Choose a photo...';
                fileNameDisplay.style.color = '';
            }
        });
    });
</script>
@endsection