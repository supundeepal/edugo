@extends('layout')

@section('content')

<style>
    .text-neu { color: var(--neu-text) !important; }

    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 20px;
        border: none !important;
        box-shadow: 10px 10px 20px var(--neu-shadow-dark),
                   -10px -10px 20px var(--neu-shadow-light) !important;
    }

    .neu-icon-box {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark),
                    inset -6px -6px 12px var(--neu-shadow-light);
        font-size: 30px;
    }

    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 12px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark),
                    inset -4px -4px 8px var(--neu-shadow-light) !important;
        padding: 10px 15px;
        outline: none;
    }

    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-text);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 700;
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
        transform: translateY(1px);
    }

    /* ලස්සන Value Cards 3 */
    .value-card {
        padding: 30px 20px;
        text-align: center;
        border-radius: 20px;
        background-color: var(--neu-bg);
        box-shadow: 8px 8px 16px var(--neu-shadow-dark),
                   -8px -8px 16px var(--neu-shadow-light);
        transition: 0.3s;
        height: 100%;
    }
    .value-card:hover { transform: translateY(-5px); }

    /* Action Card එක */
    .pay-action-card {
        border-radius: 20px;
        padding: 40px 30px;
        background-color: var(--neu-bg);
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark),
                    inset -6px -6px 12px var(--neu-shadow-light);
        text-align: center;
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-5 gap-3">
        <div class="d-flex align-items-center">
            <a href="/teachers/{{ $course->teacher_id }}/courses" class="btn neu-btn me-4" data-bs-toggle="tooltip" title="Back to Classes">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <div class="neu-icon-box me-3" style="color: var(--neu-primary); width: 55px; height: 55px; font-size: 24px;">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-neu">{{ $course->course_name }}</h3>
                <p class="text-neu mb-0" style="opacity: 0.6; font-weight: 500;">Detailed Salary Breakdown</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert fw-bold text-center border-0 mb-4 py-3" style="background-color: var(--neu-bg); color: #10b981; border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card neu-card p-4 mb-5">
        <form action="/teacher-salary/{{ $course->id }}" method="GET" class="d-flex flex-wrap align-items-center justify-content-center gap-4">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-calendar-month fs-4" style="color: var(--neu-primary);"></i>
                <h5 class="fw-bold mb-0 text-neu">Select Payroll Month:</h5>
            </div>
            <input type="month" name="month" class="form-control neu-input fw-bold fs-5 text-center" style="width: 250px;" value="{{ $selectedMonth }}" required>
            <button type="submit" class="neu-btn" style="color: var(--neu-primary);">
                <i class="bi bi-arrow-clockwise me-2"></i> Load Data
            </button>
        </form>
    </div>

    @if($salaryData)
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="value-card">
                    <div class="neu-icon-box mx-auto mb-4" style="color: var(--neu-primary);">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h6 class="fw-bold text-neu mb-2" style="opacity: 0.6; letter-spacing: 1px;">TOTAL COURSE INCOME</h6>
                    <h2 class="fw-bold mb-0 text-neu">Rs. {{ number_format($salaryData->total_collected, 2) }}</h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="value-card">
                    <div class="neu-icon-box mx-auto mb-4" style="color: #ffb547;">
                        <i class="bi bi-building"></i>
                    </div>
                    <h6 class="fw-bold text-neu mb-2" style="opacity: 0.6; letter-spacing: 1px;">INSTITUTE SHARE (20%)</h6>
                    <h2 class="fw-bold mb-0" style="color: #ffb547;">Rs. {{ number_format($salaryData->institute_share, 2) }}</h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="value-card">
                    <div class="neu-icon-box mx-auto mb-4" style="color: #10b981;">
                        <i class="bi bi-person-video3"></i>
                    </div>
                    <h6 class="fw-bold text-neu mb-2" style="opacity: 0.6; letter-spacing: 1px;">INSTRUCTOR PAYOUT (80%)</h6>
                    <h2 class="fw-bold mb-0" style="color: #10b981;">Rs. {{ number_format($salaryData->teacher_share, 2) }}</h2>
                </div>
            </div>
        </div>

        <div class="pay-action-card">
            @if($salaryData->is_paid)
                <div class="d-flex flex-column align-items-center">
                    <div class="neu-icon-box mb-3" style="color: #10b981; width: 80px; height: 80px; font-size: 40px; box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light);">
                        <i class="bi bi-check2-all"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #10b981;">Payout Settled</h3>
                    <p class="text-neu" style="opacity: 0.7; font-size: 1.1rem;">The instructor has already been paid for this month.</p>
                </div>
            @else
                <div class="d-flex flex-column align-items-center">
                    <div class="neu-icon-box mb-3" style="color: var(--neu-danger); width: 80px; height: 80px; font-size: 40px; box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light);">
                        <i class="bi bi-exclamation-lg"></i>
                    </div>
                    <h3 class="fw-bold" style="color: var(--neu-danger);">Payout Pending</h3>
                    <p class="text-neu mb-4" style="opacity: 0.7; font-size: 1.1rem;">Ready to release <strong>Rs. {{ number_format($salaryData->teacher_share, 2) }}</strong> to the instructor?</p>
                    
                    <form action="/pay-teacher" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <input type="hidden" name="amount" value="{{ $salaryData->teacher_share }}">
                        <button type="submit" class="neu-btn px-5 py-3 fs-5" style="color: #10b981;">
                            <i class="bi bi-send-check-fill me-2"></i> Release Payout Now
                        </button>
                    </form>
                </div>
            @endif
        </div>

    @else
        <div class="card neu-card p-5 text-center">
            <i class="bi bi-inbox text-neu opacity-50 mb-4" style="font-size: 6rem;"></i>
            <h3 class="fw-bold text-neu opacity-75">No Revenue Recorded</h3>
            <p class="text-neu opacity-50 fs-5 mb-0">There are no student payments recorded for "{{ $course->course_name }}" in {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}.</p>
        </div>
    @endif

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