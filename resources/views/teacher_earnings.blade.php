@extends('layout')

@section('content')

<style>
    /* --- NEUMORPHISM FOR TEACHER EARNINGS --- */
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Main Cards */
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

    /* 3D Profile Pill (උඩ තියෙන නමයි ෆොටෝ එකයි පෙන්වන කෑල්ල) */
    .neu-profile-pill {
        background-color: var(--neu-bg);
        border-radius: 50px;
        padding: 8px 25px 8px 8px;
        display: inline-flex;
        align-items: center;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
    }
    .neu-profile-pill img {
        width: 45px; 
        height: 45px; 
        border-radius: 50%; 
        object-fit: cover;
        margin-right: 15px;
        border: 2px solid var(--neu-bg);
        box-shadow: inset 2px 2px 5px rgba(0,0,0,0.1);
    }

    /* 3D Inputs (ඇතුළට එබිලා) */
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 15px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light) !important;
        padding: 12px 18px;
        transition: all 0.2s ease;
        outline: none;
    }
    .neu-input:focus {
        box-shadow: inset 7px 7px 14px var(--neu-shadow-dark), 
                    inset -7px -7px 14px var(--neu-shadow-light) !important;
    }

    /* 3D Buttons */
    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
        border-radius: 15px;
        padding: 12px 25px;
        font-weight: 700;
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), 
                   -6px -6px 12px var(--neu-shadow-light);
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

    /* --- 3D Table Rows --- */
    .neu-table {
        border-collapse: separate;
        border-spacing: 0 15px; 
        width: 100%;
    }
    .neu-table th {
        border: none;
        padding: 12px 20px;
        color: var(--neu-text);
        opacity: 0.6;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .neu-table td {
        background-color: var(--neu-bg);
        border: none;
        padding: 18px 20px;
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

    /* Badges (Inset) */
    .neu-badge {
        background-color: var(--neu-bg);
        padding: 8px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), 
                    inset -4px -4px 8px var(--neu-shadow-light);
        display: inline-block;
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5 gap-4">
        
        <div class="d-flex flex-column flex-sm-row align-items-sm-center">
            <a href="/teacher-dashboard" class="neu-btn me-sm-4 mb-3 mb-sm-0">
                <i class="bi bi-arrow-left me-2"></i> Back
            </a>
            <div class="d-flex align-items-center">
                <div class="neu-icon-box me-3" style="color: #10b981;">
                    <i class="bi bi-wallet2"></i>
                </div>
                <h2 class="fw-bold text-neu mb-0">My Earnings</h2>
            </div>
        </div>

        <div class="neu-profile-pill">
            <img src="{{ Session::get('teacher_photo') ? asset(Session::get('teacher_photo')) : 'https://cdn-icons-png.flaticon.com/512/2784/2784445.png' }}" alt="Profile">
            <span class="fw-bold fs-5 text-neu">{{ Session::get('teacher_name') }}</span>
        </div>
        
    </div>

    <div class="card neu-card p-4 mb-5">
        <form action="/teacher-earnings" method="GET" class="d-flex flex-wrap align-items-center gap-4">
            <label class="fw-bold fs-5 mb-0 text-neu" style="opacity: 0.8;">Select Month:</label>
            <input type="month" name="month" class="form-control neu-input fw-bold fs-5" style="width: auto;" value="{{ $selectedMonth }}" required>
            <button type="submit" class="neu-btn fs-5" style="color: var(--neu-primary) !important;">
                <i class="bi bi-search me-2"></i> View
            </button>
        </form>
    </div>

    <div class="card neu-card p-4">
        <div class="table-responsive px-2 pb-2">
            <table class="neu-table">
                <thead>
                    <tr>
                        <th class="ps-4">Class Name</th>
                        <th class="text-center">My Earnings (80%)</th>
                        <th class="text-center pe-4">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($earningsData as $data)
                    <tr class="neu-row">
                        <td class="fw-bold text-neu ps-4" style="font-size: 1.1rem;">
                            {{ $data->course->course_name }}
                        </td>
                        
                        <td class="text-center fw-bold" style="color: var(--neu-primary); font-size: 1.25rem;">
                            Rs. {{ number_format($data->teacher_share, 2) }}
                        </td>
                        
                        <td class="text-center pe-4">
                            @if($data->is_paid)
                                <span class="neu-badge" style="color: #10b981;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Paid by Admin
                                </span>
                            @else
                                <span class="neu-badge" style="color: #ffb547;">
                                    <i class="bi bi-clock-history me-1"></i> Pending
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="neu-row">
                        <td colspan="3" class="text-center py-5 text-neu fw-bold" style="opacity: 0.6; font-size: 1.1rem;">
                            <i class="bi bi-info-circle fs-2 d-block mb-3"></i>
                            No earnings recorded for {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection