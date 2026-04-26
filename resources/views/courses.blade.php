@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR COURSES PAGE --- */
    .text-neu { color: var(--neu-text) !important; }

    /* Main 3D Cards */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 30px;
        border: none !important;
        /* 24px තිබ්බ ෂැඩෝ එක 18px කළා සිනිඳු වෙන්න */
        box-shadow: 9px 9px 18px var(--neu-shadow-dark), 
                   -9px -9px 18px var(--neu-shadow-light) !important;
    }

    /* 3D Icon Box */
    .neu-icon-box {
        width: 60px; height: 60px;
        border-radius: 50%;
        display: flex; justify-content: center; align-items: center;
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
        padding: 14px 20px;
        transition: all 0.2s ease;
    }

    /* --- 3D TABLE STYLES (FULL WIDTH) --- */
    .neu-table {
        border-collapse: separate;
        border-spacing: 0 15px; 
        width: 100%;
    }
    .neu-table th {
        border: none;
        padding: 10px 25px;
        color: var(--neu-text);
        opacity: 0.6;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .neu-table td {
        background-color: var(--neu-bg);
        border: none;
        padding: 20px 25px;
        vertical-align: middle;
        color: var(--neu-text);
    }
    .neu-table td:first-child { border-top-left-radius: 20px; border-bottom-left-radius: 20px; }
    .neu-table td:last-child { border-top-right-radius: 20px; border-bottom-right-radius: 20px; }
    
    .neu-table tr.neu-row {
        /* ටේබල් එකේ පේළි වල ෂැඩෝ එක සිනිඳු කළා */
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        transition: all 0.3s ease;
    }
    .neu-table tr.neu-row:hover { transform: translateY(-3px); }

    /* 3D Badges (Teacher Name) */
    .neu-badge {
        background-color: var(--neu-bg);
        color: var(--neu-success);
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        display: inline-flex;
        align-items: center;
    }

    /* Main Button */
    .neu-btn-main {
        background-color: var(--neu-bg);
        border: none;
        border-radius: 20px;
        padding: 15px 30px;
        font-weight: bold;
        /* ෂැඩෝ එක පොඩ්ඩක් අඩු කළා */
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
        transition: 0.2s;
        color: var(--neu-primary);
    }
    .neu-btn-main:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
    }

    /* Back Button Styling */
    .neu-btn-back {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
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
    .neu-btn-back:hover { 
        transform: translateY(-2px); 
        color: var(--neu-primary); 
    }
</style>

<div class="container mt-4 mb-5">
    
    <div class="mb-4">
        <a href="/dashboard" class="neu-btn-back">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert fw-bold text-center border-0 mb-4" style="background-color: var(--neu-bg); color: var(--neu-success); border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row mb-5">
        <div class="col-12">
            <div class="card neu-card p-4 p-md-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="neu-icon-box me-3" style="color: var(--neu-primary);">
                        <i class="bi bi-journal-plus"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-neu">Create New Class</h3>
                        <p class="mb-0 text-neu opacity-50">Add a new course subject and assign a teacher</p>
                    </div>
                </div>

                <form action="/courses" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-neu ms-2">Class / Course Name</label>
                            <input type="text" name="course_name" class="form-control neu-input fw-bold" placeholder="e.g. Grade 10 Maths" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-neu ms-2">Assign Teacher</label>
                            <select name="teacher_id" class="form-select neu-input fw-bold" required>
                                <option value="" disabled selected>-- Select a Teacher --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-neu ms-2">Class Fee (Rs.)</label>
                            <input type="number" name="fee" class="form-control neu-input fw-bold" placeholder="e.g. 2000" required>
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="neu-btn-main px-5 py-3 fs-5">
                                <i class="bi bi-plus-circle-fill me-2"></i> Add Class
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card neu-card p-4 p-md-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="neu-icon-box me-3" style="color: var(--neu-warning);">
                        <i class="bi bi-list-stars"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-neu">Available Classes</h4>
                </div>

                <div class="table-responsive">
                    <table class="neu-table">
                        <thead>
                            <tr>
                                <th>Class Name</th>
                                <th>Assigned Teacher</th>
                                <th class="text-end">Fee (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                            <tr class="neu-row">
                                <td class="fw-bold fs-5">
                                    <i class="bi bi-book-half me-2" style="color: var(--neu-primary);"></i>{{ $course->course_name }}
                                </td>
                                <td>
                                    <span class="neu-badge">
                                        <i class="bi bi-person-workspace me-2"></i>{{ $course->teacher->name }}
                                    </span>
                                </td>
                                <td class="fw-bold text-end fs-4" style="color: var(--neu-danger);">
                                    {{ number_format($course->fee, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr class="neu-row">
                                <td colspan="3" class="text-center py-5 opacity-50">No classes added yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection