@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR EDIT TEACHER --- */
    .text-neu { color: var(--neu-text) !important; }

    :root {
        --neu-bg: #e0e5ec;
        --neu-shadow-dark: #a3b1c6;
        --neu-shadow-light: #ffffff;
        --neu-text: #333333;
        --neu-primary: #0d6efd;
    }

    [data-bs-theme="dark"] {
        --neu-bg: #242731; 
        --neu-shadow-dark: #15171d; 
        --neu-shadow-light: #2a2d38; /* සුදු ගතිය අයින් කළා */
        --neu-text: #e0e5ec;
        --neu-primary: #4facfe;
    }

    /* 3D Main Card */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 30px;
        border: none !important;
        /* 24px තිබ්බ ෂැඩෝ එක 18px කළා */
        box-shadow: 9px 9px 18px var(--neu-shadow-dark), 
                   -9px -9px 18px var(--neu-shadow-light) !important;
        padding: 40px;
    }

    /* 3D Icon Box */
    .neu-icon-box {
        width: 60px; 
        height: 60px;
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        font-size: 26px;
    }

    /* 3D Inputs (ඇතුළට එබිලා) */
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 15px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light) !important;
        padding: 15px 20px;
        transition: all 0.2s ease;
        outline: none;
    }
    .neu-input:focus {
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), 
                    inset -6px -6px 12px var(--neu-shadow-light) !important;
    }

    /* 3D Inset Box (For Password Section) */
    .neu-inset-box {
        background-color: var(--neu-bg);
        border-radius: 20px;
        padding: 25px;
        /* ෂැඩෝ එක පොඩ්ඩක් අඩු කළා */
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        margin-bottom: 25px;
    }

    /* 3D Buttons */
    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
        border-radius: 15px;
        padding: 12px 25px;
        font-weight: 700;
        font-size: 1.05rem;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .neu-btn:hover { transform: translateY(-2px); }
    .neu-btn:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(2px);
    }
    .neu-btn-primary { color: var(--neu-primary) !important; }

    /* 3D Avatar Frame */
    .neu-avatar-frame {
        padding: 10px;
        border-radius: 50%;
        background-color: var(--neu-bg);
        /* ෆොටෝ එක වටේ ෂැඩෝ එක සිනිඳු කළා */
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        display: inline-block;
        margin-bottom: 30px;
    }
    .neu-avatar-frame img {
        width: 110px; 
        height: 110px; 
        border-radius: 50%; 
        object-fit: cover;
        border: 4px solid var(--neu-bg);
        box-shadow: inset 3px 3px 6px rgba(0,0,0,0.15);
    }

    /* Custom File Input */
    input[type="file"].neu-input::file-selector-button {
        background-color: var(--neu-bg);
        color: var(--neu-primary);
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
    input[type="file"].neu-input::file-selector-button:active {
        box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), 
                    inset -2px -2px 4px var(--neu-shadow-light);
        transform: translateY(1px);
    }
</style>

<div class="container mt-4 mb-5" style="max-width: 650px;">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-5 gap-3">
        <div class="d-flex align-items-center">
            <div class="neu-icon-box me-3" style="color: var(--neu-primary);">
                <i class="bi bi-pencil-square"></i>
            </div>
            <h2 class="fw-bold text-neu mb-0">Edit Teacher</h2>
        </div>
        <a href="/teachers" class="neu-btn" style="color: var(--neu-text);">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card neu-card">
        
        <div class="text-center">
            <div class="neu-avatar-frame">
                <img src="{{ $teacher->photo ? asset($teacher->photo) : 'https://cdn-icons-png.flaticon.com/512/2784/2784445.png' }}" alt="Profile">
            </div>
        </div>

        <form action="/update-teacher/{{ $teacher->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Full Name</label>
                <input type="text" name="name" class="form-control neu-input fw-bold" value="{{ $teacher->name }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Phone Number</label>
                <input type="text" name="phone" class="form-control neu-input fw-bold" value="{{ $teacher->phone }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Username (For Login)</label>
                <input type="text" name="username" class="form-control neu-input fw-bold" value="{{ $teacher->username }}" required>
            </div>

            <div class="neu-inset-box">
                <label class="form-label fw-bold" style="color: #dc3545;">
                    <i class="bi bi-shield-lock-fill me-2"></i>Change Password
                </label>
                <input type="text" name="password" class="form-control neu-input fw-bold mb-2" placeholder="Leave blank to keep current password">
                <small class="text-neu" style="opacity: 0.6; font-weight: 500;">
                    <i class="bi bi-info-circle me-1"></i> Only type here if you want to reset the teacher's password.
                </small>
            </div>

            <div class="mb-5">
                <label class="form-label fw-bold text-neu ms-2" style="opacity: 0.8;">Change Profile Photo</label>
                <input type="file" name="photo" class="form-control neu-input fw-bold px-3 py-2" accept="image/*">
            </div>

            <button type="submit" class="neu-btn neu-btn-primary w-100 py-3 fs-5">
                <i class="bi bi-save-fill me-2"></i> Update Teacher
            </button>
            
        </form>

    </div>
</div>

@endsection