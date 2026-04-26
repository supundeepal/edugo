@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR COURSE STUDENTS --- */
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Main Card */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 24px;
        border: none !important;
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light) !important;
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
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        font-size: 26px;
    }

    /* 3D Button (Back Button) */
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
    .neu-btn:hover {
        transform: translateY(-2px);
        color: var(--neu-primary);
    }
    .neu-btn:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(2px);
    }

    /* --- 3D Table Rows --- */
    .neu-table {
        border-collapse: separate;
        border-spacing: 0 15px; 
        width: 100%;
    }
    .neu-table th {
        border: none;
        padding: 10px 20px;
        color: var(--neu-text);
        opacity: 0.6;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .neu-table td {
        background-color: var(--neu-bg);
        border: none;
        padding: 15px 20px;
        vertical-align: middle;
        color: var(--neu-text);
    }
    .neu-table td:first-child {
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
    }
    .neu-table td:last-child {
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
    }
    .neu-table tr.neu-row {
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
        transition: all 0.3s ease;
    }
    .neu-table tr.neu-row:hover {
        transform: translateY(-3px);
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), 
                   -8px -8px 16px var(--neu-shadow-light);
    }

    /* Avatars & Badges */
    .neu-avatar {
        border-radius: 50%;
        border: 3px solid var(--neu-bg);
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
    }
    .neu-badge {
        background-color: var(--neu-bg);
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* WhatsApp Button inside Table */
    .neu-wa-btn {
        background-color: var(--neu-bg);
        color: #05cd99;
        padding: 6px 15px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }
    .neu-wa-btn:hover {
        transform: translateY(-2px);
    }
    .neu-wa-btn:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(1px);
    }

</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="row mb-5 align-items-center">
        <div class="col-md-8 col-lg-9 mb-3 mb-md-0 d-flex flex-column flex-sm-row align-items-sm-center">
            <div class="neu-icon-box me-3 mb-3 mb-sm-0" style="color: var(--neu-primary);">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-1 text-neu">Students In {{ $course->course_name }}</h3>
                <div class="d-flex align-items-center">
                    <span class="text-neu me-2" style="opacity: 0.7; font-weight: 500;">Total Students:</span>
                    <span class="neu-badge" style="color: var(--neu-primary); padding: 4px 12px;">{{ $course->students->count() }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-lg-3 text-md-end">
            <a href="/teacher-classes" class="neu-btn">
                <i class="bi bi-arrow-left me-2"></i> Back to Classes
            </a>
        </div>
    </div>

    <div class="card neu-card p-4 p-md-4">
        <div class="table-responsive px-2 pb-2">
            <table class="neu-table">
                <thead>
                    <tr>
                        <th class="ps-4">Index No</th>
                        <th>Student Name</th>
                        <th>WhatsApp No</th>
                        <th class="text-center pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->students as $student)
                    <tr class="neu-row">
                        <td class="ps-4 fw-bold" style="color: var(--neu-primary); font-size: 1.05rem;">
                            {{ $student->card_number }}
                        </td>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                @if($student->photo)
                                    <img src="{{ asset('storage/'.$student->photo) }}" class="neu-avatar me-3" style="width: 48px; height: 48px; object-fit: cover;">
                                @else
                                    <div class="neu-avatar me-3 d-flex justify-content-center align-items-center" style="width: 48px; height: 48px; color: var(--neu-text); opacity: 0.6;">
                                        <i class="bi bi-person fs-4"></i>
                                    </div>
                                @endif
                                <span class="fw-bold text-neu" style="font-size: 1.05rem;">{{ $student->student_name }}</span>
                            </div>
                        </td>
                        
                        <td>
                            <a href="https://wa.me/{{ $student->parent_phone }}" target="_blank" class="neu-wa-btn">
                                <i class="bi bi-whatsapp me-2 fs-5"></i> {{ $student->parent_phone }}
                            </a>
                        </td>
                        
                        <td class="text-center pe-4">
                            <span class="neu-badge" style="color: #10b981;">Active</span>
                        </td>
                    </tr>
                    @empty
                    <tr class="neu-row">
                        <td colspan="4" class="text-center py-5 text-neu" style="opacity: 0.6;">
                            <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                            <h5 class="fw-bold">No students enrolled!</h5>
                            <p class="mb-0">This class doesn't have any students yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection