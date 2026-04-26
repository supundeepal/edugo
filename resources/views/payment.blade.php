@extends('layout')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* --- NEUMORPHISM FOR INPUTS & SELECT2 --- */
    
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Card */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 20px;
        border: none !important;
        box-shadow: 9px 9px 16px var(--neu-shadow-dark), 
                   -9px -9px 16px var(--neu-shadow-light) !important;
    }

    /* 3D Icon Box */
    .neu-icon-box {
        width: 65px; 
        height: 65px;
        border-radius: 50%;
        display: flex; 
        justify-content: center; 
        align-items: center;
        background-color: var(--neu-bg);
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light);
        font-size: 28px;
    }

    /* 3D Inputs (ඇතුළට එබිලා පේන පෙට්ටි) */
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 12px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light) !important;
        transition: all 0.2s ease;
    }
    .neu-input:focus-within, .neu-input:focus {
        outline: none;
        box-shadow: inset 7px 7px 14px var(--neu-shadow-dark), 
                    inset -7px -7px 14px var(--neu-shadow-light) !important;
    }
    .neu-input input::placeholder { color: var(--neu-text); opacity: 0.5; }

    /* Select2 Neumorphism Overrides */
    .select2-container--default .select2-selection--single {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 12px !important;
        height: 50px !important;
        display: flex;
        align-items: center;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--neu-text) !important;
        font-weight: 600;
        padding-left: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px !important;
        right: 15px !important;
    }
    .select2-dropdown {
        background-color: var(--neu-bg) !important;
        border: none !important;
        box-shadow: 0px 10px 25px var(--neu-shadow-dark) !important;
        border-radius: 12px !important;
        overflow: hidden;
        margin-top: 5px;
    }
    .select2-search__field {
        background-color: var(--neu-bg) !important;
        color: var(--neu-text) !important;
        border: none !important;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light) !important;
        border-radius: 8px !important;
        padding: 10px !important;
        outline: none !important;
    }
    .select2-results__option { color: var(--neu-text) !important; font-weight: 500; }
    .select2-results__option--highlighted[aria-selected] {
        background-color: var(--neu-primary) !important;
        color: #fff !important;
    }

    /* Custom Confirm Button */
    .neu-btn-success {
        background-color: var(--neu-bg);
        color: #10b981 !important; /* Green color for confirm */
        border: none;
        border-radius: 15px;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        transition: 0.2s;
    }
    .neu-btn-success:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(2px);
    }

    /* Manual Print Button */
    .neu-btn-print {
        background-color: var(--neu-bg);
        color: var(--neu-primary) !important; 
        border: none;
        border-radius: 12px;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), 
                   -5px -5px 10px var(--neu-shadow-light);
        transition: 0.2s;
        text-decoration: none;
    }
    .neu-btn-print:active {
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px var(--neu-shadow-light);
        transform: translateY(2px);
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
        margin-bottom: 30px;
    }
    .neu-btn-back:hover { 
        transform: translateY(-2px); 
        color: var(--neu-primary); 
    }
</style>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-center">
        <div style="width: 100%; max-width: 550px;">
           <a href="{{ Auth::user()->role === 'owner' ? '/owner/dashboard' : '/staff/dashboard' }}" class="neu-btn-back">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>

            @if(session('payment_id'))
                <div class="alert border-0 mb-4 d-flex flex-column flex-sm-row justify-content-between align-items-center p-4" style="background-color: var(--neu-bg); border-radius: 20px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
                    <div class="text-neu fw-bold fs-5 mb-3 mb-sm-0 text-center text-sm-start">
                        <i class="bi bi-check-circle-fill me-2" style="color: #10b981;"></i> Payment Saved!
                    </div>
                    <a href="/receipt/{{ session('payment_id') }}" target="_blank" class="neu-btn-print px-4 py-2 fw-bold d-inline-flex align-items-center">
                        <i class="bi bi-printer-fill me-2"></i> Print Slip
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card neu-card p-4 p-md-5" style="width: 100%; max-width: 550px;">
            
            <div class="text-center mb-5">
                <div class="neu-icon-box mx-auto mb-3" style="color: #10b981;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h3 class="fw-bold mb-0 text-neu">Accept Payment</h3>
                <p class="mb-0 fs-6 text-neu" style="opacity: 0.6;">Select student and class to collect fee</p>
            </div>

            <form action="/payment" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-neu" style="opacity: 0.8; margin-left: 5px;">Select Student</label>
                    <select name="student_id" id="student_select" class="form-select select2" required>
                        <option value="" disabled selected>Search by Name or Card ID...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->student_name }} (Card: {{ $student->card_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-neu" style="opacity: 0.8; margin-left: 5px;">Select Course / Class</label>
                    <select name="course_id" id="course_select" class="form-select neu-input fw-bold" style="height: 50px; padding: 0 15px;" required>
                        <option value="" disabled selected>-- Select a Class --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" data-fee="{{ $course->fee }}">
                                {{ $course->course_name }} (Fee: Rs.{{ $course->fee }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold text-neu" style="opacity: 0.8; margin-left: 5px;">Payment Amount</label>
                    <div class="neu-input d-flex align-items-center" style="height: 50px; padding: 0 15px;">
                        <span class="fw-bold me-2 text-neu" style="opacity: 0.7;">Rs.</span>
                        <input type="number" name="amount" id="payment_amount" class="form-control shadow-none bg-transparent border-0 px-0 fw-bold text-neu" placeholder="e.g. 2500" required>
                    </div>
                </div>

                <button type="submit" class="btn neu-btn-success w-100 fw-bold py-3 fs-5 mt-2">
                    <i class="bi bi-check-circle-fill me-2"></i> Confirm Payment
                </button>
            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 with Custom Class
        $('#student_select').select2({
            placeholder: "🔍 Type Name or Card No...",
            allowClear: true,
            width: '100%'
        });

        // Auto-fill Amount when Class is selected
        $('#course_select').on('change', function() {
            let feeAmount = $(this).find(':selected').data('fee');
            if(feeAmount) {
                $('#payment_amount').val(feeAmount);
            }
        });
    });
</script>
@endsection