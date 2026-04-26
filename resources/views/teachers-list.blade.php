@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR TEACHERS LIST --- */
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
    .neu-action-btn:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(1px);
    }

    /* Avatar */
    .neu-avatar {
        border-radius: 50%;
        border: 3px solid var(--neu-bg);
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        width: 48px; 
        height: 48px; 
        object-fit: cover;
    }
    
    .neu-avatar-placeholder {
        width: 48px; 
        height: 48px; 
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), 
                   -4px -4px 8px var(--neu-shadow-light);
        color: var(--neu-text); 
        opacity: 0.6;
    }

    /* Top Title Box */
    .neu-title-box {
        display: inline-flex;
        align-items: center;
        background-color: var(--neu-bg);
        border-radius: 15px;
        padding: 10px 25px;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex align-items-center mb-5">
        <a href="/teachers-menu" class="btn neu-btn me-4 px-3 py-2" data-bs-toggle="tooltip" title="Back to Teacher Menu">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <div class="neu-title-box">
            <i class="bi bi-card-list fs-4 me-3" style="color: var(--neu-warning);"></i>
            <h3 class="fw-bold mb-0 text-neu">Teachers List</h3>
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
                    <th class="ps-4">Teacher Profile</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                <tr class="neu-row">
                    
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            @if($teacher->photo)
                                <img src="{{ asset($teacher->photo) }}" class="neu-avatar me-3">
                            @else
                                <div class="neu-avatar-placeholder me-3">
                                    <i class="bi bi-person fs-4"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold text-neu mb-0" style="font-size: 1.05rem;">{{ $teacher->name }}</h6>
                                <small class="text-neu" style="opacity: 0.6;">ID: TCH-{{ str_pad($teacher->id, 3, '0', STR_PAD_LEFT) }}</small>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="d-flex align-items-center fw-medium text-neu" style="opacity: 0.8;">
                            <i class="bi bi-envelope-fill me-2 fs-5" style="color: var(--neu-primary);"></i>
                            <span>{{ $teacher->email ?? 'Not Provided' }}</span>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center fw-medium text-neu" style="opacity: 0.8;">
                            <i class="bi bi-check-circle-fill me-2 fs-5" style="color: var(--neu-success);"></i>
                            <span>Active</span>
                        </div>
                    </td>
                    
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="/teachers/{{ $teacher->id }}/courses" class="neu-action-btn" style="color: var(--neu-primary);" data-bs-toggle="tooltip" title="View Classes">
                                <i class="bi bi-journal-bookmark-fill"></i>
                            </a>
                            <a href="/edit-teacher/{{ $teacher->id }}" class="neu-action-btn" style="color: #ffb547;" data-bs-toggle="tooltip" title="Edit Teacher">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            </div>
                    </td>
                </tr>
                @empty
                <tr class="neu-row">
                    <td colspan="4" class="text-center py-5 text-neu" style="opacity: 0.6;">
                        <i class="bi bi-person-x display-4 d-block mb-3"></i>
                        <h5 class="fw-bold">No teachers found!</h5>
                        <p class="mb-0">Please register a new teacher to see them here.</p>
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
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection