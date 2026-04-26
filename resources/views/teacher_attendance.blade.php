@extends('layout')

@section('content')

<style>
    .text-neu { color: var(--neu-text) !important; }
    
    .neu-card { 
        background-color: var(--neu-bg) !important; 
        border-radius: 22px; 
        border: none !important; 
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), -12px -12px 24px var(--neu-shadow-light) !important; 
    }

    .neu-stat-card {
        background-color: var(--neu-bg);
        border-radius: 20px;
        padding: 20px;
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), inset -6px -6px 12px var(--neu-shadow-light);
        text-align: center;
    }
    
    .neu-input { 
        background-color: var(--neu-bg) !important; 
        border: none !important; 
        border-radius: 15px !important; 
        color: var(--neu-text) !important; 
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light) !important; 
        padding: 12px 20px; 
        outline: none; 
        transition: 0.2s; 
    }
    
    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-primary);
        border: none;
        border-radius: 15px;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .neu-btn:active {
        transform: translateY(2px);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light);
    }

    .neu-table { border-collapse: separate; border-spacing: 0 12px; width: 100%; }
    .neu-table th { border: none; padding: 10px 20px; color: var(--neu-text); opacity: 0.6; text-transform: uppercase; font-size: 0.85rem; }
    .neu-table td { background-color: var(--neu-bg); border: none; padding: 15px 20px; vertical-align: middle; color: var(--neu-text); }
    .neu-table td:first-child { border-top-left-radius: 15px; border-bottom-left-radius: 15px; }
    .neu-table td:last-child { border-top-right-radius: 15px; border-bottom-right-radius: 15px; }
    .neu-row { box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light); }

    .badge-present { background-color: rgba(16, 185, 129, 0.1); color: #10b981; padding: 6px 12px; border-radius: 10px; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-absent { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 6px 12px; border-radius: 10px; font-weight: 600; border: 1px solid rgba(239, 68, 68, 0.3); }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-neu" style="color: var(--neu-primary) !important;"><i class="bi bi-person-check-fill me-2"></i>Attendance Report</h2>
            <p class="mb-0 text-neu" style="opacity: 0.7; font-weight: 500;">Track student presence and absences</p>
        </div>
        <a href="/teacher-dashboard" class="btn neu-btn px-4 py-2 text-decoration-none text-neu">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card neu-card p-4 mb-4">
        <form action="/teacher-attendance" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="fw-bold mb-2 text-neu">Select Class</label>
                <select name="course_id" class="form-select neu-input fw-bold" required>
                    <option value="" disabled selected>-- Choose Class --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }} ({{ $course->grade }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="fw-bold mb-2 text-neu">Select Date</label>
                <input type="date" name="date" class="form-control neu-input fw-bold" value="{{ $selectedDate }}" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn neu-btn w-100 py-2 fs-5" style="height: 50px;">
                    <i class="bi bi-search me-2"></i> Check
                </button>
            </div>
        </form>
    </div>

    @if($selectedCourseId)
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="neu-stat-card">
                    <h6 class="text-uppercase fw-bold text-neu mb-1" style="opacity: 0.6;">Total Students</h6>
                    <h2 class="fw-bold mb-0 text-primary">{{ $totalStudents }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="neu-stat-card" style="box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), inset -6px -6px 12px var(--neu-shadow-light), 0 0 0 2px rgba(16, 185, 129, 0.2);">
                    <h6 class="text-uppercase fw-bold text-neu mb-1" style="opacity: 0.6;">Present</h6>
                    <h2 class="fw-bold mb-0" style="color: #10b981;">{{ $presentCount }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="neu-stat-card" style="box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), inset -6px -6px 12px var(--neu-shadow-light), 0 0 0 2px rgba(239, 68, 68, 0.2);">
                    <h6 class="text-uppercase fw-bold text-neu mb-1" style="opacity: 0.6;">Absent</h6>
                    <h2 class="fw-bold mb-0" style="color: #ef4444;">{{ $absentCount }}</h2>
                </div>
            </div>
        </div>

        <div class="table-responsive px-2 pb-4">
            <table class="neu-table">
                <thead>
                    <tr>
                        <th class="ps-4">Student Name</th>
                        <th>Card Number</th>
                        <th>Phone</th>
                        <th class="text-end pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceData as $data)
                        <tr class="neu-row">
                            <td class="ps-4 fw-bold text-neu">
                                <i class="bi bi-person-circle me-2" style="opacity: 0.5;"></i> {{ $data->student->student_name }}
                            </td>
                            <td class="text-neu fw-medium" style="opacity: 0.8;">{{ $data->student->card_number }}</td>
                            <td class="text-neu fw-medium" style="opacity: 0.8;">{{ $data->student->phone ?? 'N/A' }}</td>
                            <td class="text-end pe-4">
                                @if($data->is_present)
                                    <span class="badge-present"><i class="bi bi-check-circle-fill me-1"></i> Present</span>
                                @else
                                    <span class="badge-absent"><i class="bi bi-x-circle-fill me-1"></i> Absent</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="neu-row">
                            <td colspan="4" class="text-center py-4 text-neu fw-bold" style="opacity: 0.6;">No students found in this class.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center mt-5">
            <i class="bi bi-clipboard2-data" style="font-size: 4rem; color: var(--neu-primary); opacity: 0.5;"></i>
            <h4 class="fw-bold text-neu mt-3" style="opacity: 0.7;">Select a class and date to view attendance.</h4>
        </div>
    @endif

</div>

@endsection