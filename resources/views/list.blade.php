@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR STUDENT LIST --- */
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Icon Box (Headers) */
    .neu-icon-box {
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
    }

    /* 3D Inputs & Selects */
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 12px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light) !important;
        padding: 10px 15px;
        outline: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    /* Search Input Group */
    .neu-search-group {
        display: flex;
        align-items: center;
        background-color: var(--neu-bg);
        border-radius: 12px;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        padding: 0 5px;
    }
    .neu-search-group input {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        color: var(--neu-text) !important;
    }
    .neu-search-group button {
        background: transparent !important;
        border: none !important;
        color: var(--neu-primary);
        outline: none;
        transition: transform 0.2s ease;
        padding-right: 15px;
    }
    .neu-search-group button:hover {
        transform: scale(1.15);
    }

    /* --- 3D Table Styles --- */
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
    .neu-table td:first-child { border-top-left-radius: 15px; border-bottom-left-radius: 15px; }
    .neu-table td:last-child { border-top-right-radius: 15px; border-bottom-right-radius: 15px; }

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

    /* Action Buttons */
    .neu-action-btn {
        width: 42px; 
        height: 42px; 
        border-radius: 50%; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        background-color: var(--neu-bg);
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        transition: 0.2s;
        text-decoration: none;
    }
    .neu-action-btn:hover { transform: translateY(-3px); }

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
    .neu-btn-back:hover { transform: translateY(-2px); color: var(--neu-primary); }

    /* Badges & Avatars */
    .neu-badge {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        display: inline-block;
        margin: 2px;
    }
    .neu-avatar {
        border-radius: 50%;
        border: 3px solid var(--neu-bg);
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
    }

    /* --- SweetAlert2 Neumorphism Customization --- */
    .swal2-popup.neu-swal {
        background-color: var(--neu-bg) !important;
        color: var(--neu-text) !important;
        border-radius: 20px !important;
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), 
                   -12px -12px 24px var(--neu-shadow-light) !important;
        padding: 2rem !important;
    }
    .swal2-title.neu-swal-title { color: var(--neu-text) !important; font-family: 'Poppins', sans-serif !important; font-weight: 700 !important; }
    .swal2-html-container.neu-swal-text { color: var(--neu-text) !important; opacity: 0.8; font-family: 'Poppins', sans-serif !important; }
    
    .swal2-confirm.neu-swal-btn-danger {
        background-color: var(--neu-bg) !important; color: var(--neu-danger) !important;
        border: none !important; border-radius: 12px !important; font-weight: 700 !important;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light) !important;
        padding: 10px 25px !important; margin: 0 10px !important; transition: 0.2s !important;
    }
    .swal2-confirm.neu-swal-btn-danger:active {
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light) !important; transform: translateY(2px);
    }

    .swal2-cancel.neu-swal-btn-cancel {
        background-color: var(--neu-bg) !important; color: var(--neu-text) !important;
        border: none !important; border-radius: 12px !important; font-weight: 700 !important;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light) !important;
        padding: 10px 25px !important; margin: 0 10px !important; transition: 0.2s !important;
    }
    .swal2-cancel.neu-swal-btn-cancel:active {
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light) !important; transform: translateY(2px);
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="mb-4">
        <a href="{{ Auth::user()->role === 'owner' ? '/owner/dashboard' : '/staff/dashboard' }}" class="neu-btn-back">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="row mb-5 align-items-center">
        <div class="col-xl-4 col-lg-3 mb-4 mb-lg-0 d-flex align-items-center">
            <div class="neu-icon-box me-3" style="color: var(--neu-primary); width: 55px; height: 55px; font-size: 24px;">
                <i class="bi bi-people-fill"></i>
            </div>
            <h2 class="fw-bold mb-0 text-neu">Student List</h2>
        </div>
        
        <div class="col-xl-8 col-lg-9">
            <form action="/students" method="GET" class="d-flex gap-3 flex-wrap justify-content-lg-end align-items-center">
                
                <select name="teacher" class="form-select neu-input fw-bold" style="width: auto; min-width: 160px; height: 46px;">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>

                <select name="course" class="form-select neu-input fw-bold" style="width: auto; min-width: 160px; height: 46px;">
                    <option value="">All Classes</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
                
                <div class="neu-search-group" style="width: 240px; height: 46px;">
                    <input type="text" name="search" class="form-control px-3 fw-medium" placeholder="Search name..." value="{{ request('search') }}">
                    <button type="submit"><i class="bi bi-search fs-5 fw-bold"></i></button>
                </div>
                
                @if(request('search') || request('course') || request('teacher'))
                    <a href="/students" class="neu-action-btn ms-1" style="color: var(--neu-danger);" data-bs-toggle="tooltip" title="Clear Filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert fw-bold text-center border-0 mb-4" style="background-color: var(--neu-bg); color: #10b981; border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="table-responsive px-2 pb-3">
        <table class="neu-table">
            <thead>
                <tr>
                    <th class="ps-4">Index No</th>
                    <th>Name</th>
                    <th style="width: 30%;">Enrolled Classes</th>
                    <th>Parent's Phone</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="neu-row">
                    <td class="ps-4 fw-bold" style="color: var(--neu-primary); font-size: 1.05rem;">
                        {{ $student->card_number }}
                    </td>
                    
                    <td>
                        <div class="d-flex align-items-center">
                            @if($student->photo)
                                <img src="{{ asset('storage/'.$student->photo) }}" class="neu-avatar me-3" style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <div class="neu-avatar me-3 d-flex justify-content-center align-items-center" style="width: 48px; height: 48px; color: var(--neu-text); opacity: 0.6; background: var(--neu-bg); box-shadow: 4px 4px 8px var(--neu-shadow-dark);">
                                    <i class="bi bi-person fs-4"></i>
                                </div>
                            @endif
                            <span class="fw-bold text-neu" style="font-size: 1.05rem;">{{ $student->student_name }}</span>
                        </div>
                    </td>
                    
                    <td>
                        @forelse($student->courses as $course)
                            <span class="neu-badge" style="color: var(--neu-primary);">{{ $course->course_name }}</span>
                        @empty
                            <span class="neu-badge" style="opacity: 0.5;">No Classes</span>
                        @endforelse
                    </td>
                    
                    <td class="neu-wa-col">
                        <div class="d-flex align-items-center fw-medium text-neu" style="opacity: 0.8;">
                            <i class="bi bi-whatsapp me-2 fs-5" style="color: #05cd99;"></i>
                            <span>{{ $student->parent_phone ?? 'N/A' }}</span>
                        </div>
                    </td>
                    
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="/profile/{{ $student->id }}" class="neu-action-btn" style="color: var(--neu-primary);" data-bs-toggle="tooltip" title="View Profile">
                                <i class="bi bi-person-vcard"></i>
                            </a>
                            <a href="/id-card/{{ $student->id }}" target="_blank" class="neu-action-btn" style="color: #10b981;" data-bs-toggle="tooltip" title="Print ID Card">
                                <i class="bi bi-printer"></i>
                            </a>
                            <a href="/students/{{ $student->id }}/edit" class="neu-action-btn" style="color: #ffb547;" data-bs-toggle="tooltip" title="Edit Student">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="neu-action-btn border-0" style="color: var(--neu-danger);" data-bs-toggle="tooltip" title="Delete Student" onclick="confirmDelete({{ $student->id }}, '{{ $student->student_name }}')">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="neu-row">
                    <td colspan="5" class="text-center py-5 text-neu" style="opacity: 0.6;">
                        <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                        <h5 class="fw-bold">No students found!</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    // ⭐ SweetAlert2 Delete Confirmation Logic
    function confirmDelete(studentId, studentName) {
        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete <b>${studentName}</b>.<br>This action cannot be undone!`,
            icon: 'warning',
            iconColor: 'var(--neu-danger)',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash3-fill me-2"></i> Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                popup: 'neu-swal',
                title: 'neu-swal-title',
                htmlContainer: 'neu-swal-text',
                confirmButton: 'neu-swal-btn-danger',
                cancelButton: 'neu-swal-btn-cancel'
            },
            buttonsStyling: false // Disable SweetAlert default styling to use our Neumorphism CSS
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, redirect to the delete route
                window.location.href = `/students/${studentId}/delete`;
            }
        });
    }
</script>
@endsection