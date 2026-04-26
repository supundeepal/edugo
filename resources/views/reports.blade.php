@extends('layout')

@section('content')

<style>
    .text-neu { color: var(--neu-text) !important; }
    
    .neu-card { 
        background-color: var(--neu-bg) !important; 
        border-radius: 24px; 
        border: none !important; 
        box-shadow: 12px 12px 24px var(--neu-shadow-dark), -12px -12px 24px var(--neu-shadow-light) !important; 
    }
    
    .neu-icon-box { 
        border-radius: 50%; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        background-color: var(--neu-bg); 
        box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), inset -6px -6px 12px var(--neu-shadow-light); 
    }
    
    .neu-input { 
        background-color: var(--neu-bg) !important; 
        border: none !important; 
        border-radius: 15px !important; 
        color: var(--neu-text) !important; 
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light) !important; 
        padding: 10px 18px; 
        outline: none; 
        transition: 0.2s; 
    }
    
    .neu-input:focus { 
        box-shadow: inset 7px 7px 14px var(--neu-shadow-dark), inset -7px -7px 14px var(--neu-shadow-light) !important; 
    }
    
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
    
    .neu-table td:first-child { 
        border-top-left-radius: 15px; 
        border-bottom-left-radius: 15px; 
    }
    
    .neu-table td:last-child { 
        border-top-right-radius: 15px; 
        border-bottom-right-radius: 15px; 
    }
    
    .neu-row { 
        box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light); 
        transition: all 0.3s ease; 
    }
    
    .neu-row:hover { 
        transform: translateY(-3px); 
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), -8px -8px 16px var(--neu-shadow-light); 
    }
    
    .neu-badge { 
        background-color: var(--neu-bg); 
        padding: 6px 15px; 
        border-radius: 10px; 
        font-weight: 600; 
        font-size: 0.85rem; 
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light); 
        display: inline-block; 
    }

    .neu-btn {
        background-color: var(--neu-bg);
        border: none;
        border-radius: 12px;
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light);
        transition: all 0.2s ease;
    }
    .neu-btn:hover { transform: translateY(-2px); }
    .neu-btn:active { box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light); transform: translateY(2px); }

    /* --- Back Button Styling --- */
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

    @media print {
        body { 
            background-color: #fff !important; 
            color: #000 !important; 
            font-family: Arial, sans-serif !important; 
        }
        .neu-card, .neu-icon-box, .neu-table tr.neu-row, .neu-badge, .neu-btn-back { 
            box-shadow: none !important; 
            border: 1px solid #ddd; 
            border-radius: 0; 
            background-color: #fff; 
            color: #000; 
        }
        .neu-table { border-spacing: 0; border-collapse: collapse; }
        .neu-table td, .neu-table th { border: 1px solid #000; padding: 10px; }
        .d-print-none { display: none !important; }
        .d-print-block { display: block !important; }
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="mb-4 d-print-none">
        <a href="/dashboard" class="neu-btn-back">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 d-print-none">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="neu-icon-box me-3" style="color: var(--neu-primary); width: 60px; height: 60px; font-size: 26px;">
                <i class="bi bi-pie-chart-fill"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 text-neu">Financial Reports</h2>
                <span class="text-neu fw-bold opacity-50">{{ $displayTitle }}</span>
            </div>
        </div>
        <div class="d-flex gap-3">
            <button class="btn neu-btn px-4 py-3 fw-bold d-flex align-items-center fs-5 text-danger" data-bs-toggle="modal" data-bs-target="#expenseModal">
                <i class="bi bi-dash-circle-fill me-2"></i> Add Expense
            </button>
            <a href="/backup-database" class="btn neu-btn px-4 py-3 fw-bold d-flex align-items-center fs-5 text-primary text-decoration-none">
                <i class="bi bi-cloud-arrow-down-fill me-2"></i> Backup DB
            </a>
            <button onclick="window.print()" class="btn neu-btn px-4 py-3 fw-bold d-flex align-items-center fs-5" style="color: var(--neu-text) !important;">
                <i class="bi bi-printer-fill me-2" style="color: var(--neu-warning);"></i> Print
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success fw-bold d-print-none"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="card neu-card p-4 p-md-4 mb-5 d-print-none">
        <form action="/reports" method="GET" class="d-flex flex-wrap align-items-end gap-4">
            <div>
                <label class="fw-bold fs-6 mb-2 text-neu" style="opacity: 0.8;">Select Duration:</label>
                <select name="filter_type" id="filterType" class="form-select neu-input fw-bold fs-5" style="width: auto; height: 55px; cursor: pointer;">
                    <option value="today" {{ $filterType == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ $filterType == 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ $filterType == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="custom" {{ $filterType == 'custom' ? 'selected' : '' }}>Custom Dates</option>
                </select>
            </div>
            
            <div id="monthPickerGroup" class="{{ $filterType == 'month' ? 'd-block' : 'd-none' }}">
                <label class="fw-bold fs-6 mb-2 text-neu" style="opacity: 0.8;">Select Month:</label>
                <input type="month" name="month" class="form-control neu-input fw-bold fs-5" style="width: auto; height: 55px;" value="{{ request('month', \Carbon\Carbon::now()->format('Y-m')) }}">
            </div>
            
            <div id="customDateGroup" class="gap-3 {{ $filterType == 'custom' ? 'd-flex' : 'd-none' }}">
                <div>
                    <label class="fw-bold fs-6 mb-2 text-neu" style="opacity: 0.8;">Start Date:</label>
                    <input type="date" name="start_date" class="form-control neu-input fw-bold fs-5" style="height: 55px;" value="{{ request('start_date', \Carbon\Carbon::now()->toDateString()) }}">
                </div>
                <div>
                    <label class="fw-bold fs-6 mb-2 text-neu" style="opacity: 0.8;">End Date:</label>
                    <input type="date" name="end_date" class="form-control neu-input fw-bold fs-5" style="height: 55px;" value="{{ request('end_date', \Carbon\Carbon::now()->toDateString()) }}">
                </div>
            </div>

            <button type="submit" class="btn neu-btn px-5 py-2 fw-bold fs-5" style="height: 55px; color: var(--neu-primary) !important;">
                <i class="bi bi-funnel-fill me-2"></i> Filter
            </button>
        </form>
    </div>

    <div class="d-none d-print-block text-center mb-4">
        <h2 class="fw-bold" style="font-size: 24pt;">SMART INSTITUTE</h2>
        <h4 style="font-size: 16pt;">Financial Report - {{ $displayTitle }}</h4>
        <hr style="border: 2px solid #000; opacity: 1;">
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card neu-card p-3 h-100 text-center d-flex flex-column justify-content-center">
                <h6 class="text-uppercase fw-bold mb-2 text-neu" style="opacity: 0.6; font-size: 0.8rem;">Total Revenue</h6>
                <h3 class="fw-bold mb-0 text-neu">Rs. {{ number_format($totalIncome, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card neu-card p-3 h-100 text-center d-flex flex-column justify-content-center">
                <h6 class="text-uppercase fw-bold mb-2 text-primary" style="font-size: 0.8rem;">Teachers (80%)</h6>
                <h3 class="fw-bold mb-0 text-primary">Rs. {{ number_format($teachersShare, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card neu-card p-3 h-100 text-center d-flex flex-column justify-content-center">
                <h6 class="text-uppercase fw-bold mb-2 text-warning" style="font-size: 0.8rem;">Gross Profit (20%)</h6>
                <h3 class="fw-bold mb-0 text-warning">Rs. {{ number_format($grossProfit, 2) }}</h3>
                <span class="d-block small text-danger mt-1">- Rs. {{ number_format($totalExpenses ?? 0, 2) }} (Expenses)</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card neu-card p-3 h-100 text-center d-flex flex-column justify-content-center" style="border: 2px solid #10b981 !important;">
                <div class="neu-icon-box mx-auto mb-2" style="color: #10b981; width: 40px; height: 40px; font-size: 20px;">
                    <i class="bi bi-piggy-bank-fill"></i>
                </div>
                <h6 class="text-uppercase fw-bold mb-1" style="color: #10b981; font-size: 0.9rem;">Net Profit</h6>
                <h3 class="fw-bold mb-0" style="color: #10b981;">Rs. {{ number_format($netProfit ?? 0, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="card neu-card p-4 mb-5 d-flex flex-row align-items-center mx-auto" style="max-width: 400px;">
        <div class="neu-icon-box me-4" style="color: #ffb547; width: 60px; height: 60px; font-size: 25px;">
            <i class="bi bi-person-check-fill"></i>
        </div>
        <div>
            <h6 class="text-uppercase fw-bold mb-1 text-neu" style="opacity: 0.6; letter-spacing: 1px;">Total Attendance</h6>
            <h3 class="fw-bold mb-0 text-neu">{{ $totalAttendance }} Records</h3>
        </div>
    </div>

    <div class="d-flex align-items-center mb-4 mt-5">
        <h4 class="mb-0 fw-bold text-neu"><i class="bi bi-exclamation-triangle-fill me-2" style="color: var(--neu-danger);"></i>Pending Payments / Arrears</h4>
    </div>
    <div class="table-responsive px-2 pb-4">
        <table class="neu-table">
            <thead>
                <tr>
                    <th class="ps-4">Student Name</th><th>Card Number</th><th>Course</th><th>Expected (Rs.)</th><th>Paid (Rs.)</th><th class="text-end pe-4">Arrears (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($defaulters as $defaulter)
                <tr class="neu-row">
                    <td class="ps-4 fw-bold text-neu" style="font-size: 1.05rem;">{{ $defaulter->student->student_name }}</td>
                    <td class="text-neu" style="opacity: 0.8; font-weight: 500;"><i class="bi bi-credit-card me-1"></i> {{ $defaulter->student->card_number }}</td>
                    <td class="fw-bold text-neu" style="opacity: 0.9;">{{ $defaulter->course->course_name }} <span class="d-block small" style="opacity: 0.6; font-weight:normal;">({{ $defaulter->course->fee_type }})</span></td>
                    <td class="text-neu fw-medium">{{ number_format($defaulter->expected, 2) }}</td>
                    <td class="text-neu fw-medium">{{ number_format($defaulter->paid, 2) }}</td>
                    <td class="text-end pe-4 fw-bold" style="color: var(--neu-danger); font-size: 1.15rem;">{{ number_format($defaulter->arrears, 2) }}</td>
                </tr>
                @empty
                <tr class="neu-row"><td colspan="6" class="text-center py-5 text-neu fw-bold" style="opacity: 0.6;"><i class="bi bi-check-circle fs-2 d-block mb-2" style="color: #10b981;"></i> No pending payments for this duration!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <hr class="my-5" style="border-top: 2px dashed var(--neu-shadow-dark); opacity: 0.3;">
    <div class="d-flex align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-neu"><i class="bi bi-list-check me-2" style="color: var(--neu-warning);"></i>Payment History</h4>
    </div>
    <div class="table-responsive px-2 pb-4">
        <table class="neu-table">
            <thead>
                <tr>
                    <th class="ps-4">Receipt ID</th><th>Date & Time</th><th>Student Details</th><th>Course</th><th>Type</th><th class="text-end pe-4">Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr class="neu-row">
                    <td class="ps-4 fw-bold text-neu" style="font-size: 1.05rem;">#{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="text-neu fw-medium" style="opacity: 0.8;"><i class="bi bi-clock me-1"></i> {{ $payment->created_at->format('Y-m-d h:i A') }}</td>
                    <td>
                        @if($payment->student)
                            <div class="fw-bold text-neu" style="font-size: 1.05rem;">{{ $payment->student->student_name }}</div>
                            <div class="small text-neu" style="opacity: 0.6;"><i class="bi bi-credit-card me-1"></i>{{ $payment->student->card_number }}</div>
                        @else
                            <span class="neu-badge" style="color: var(--neu-danger);"><i class="bi bi-exclamation-circle me-1"></i>Deleted Student</span>
                        @endif
                    </td>
                    <td class="fw-bold text-neu" style="opacity: 0.9;">{{ $payment->course ? $payment->course->course_name : 'N/A' }}</td>
                    <td>
                        @if(trim(strtolower($payment->month)) == 'daily') <span class="neu-badge" style="color: var(--neu-primary);">Daily</span>
                        @else <span class="neu-badge" style="color: #ffb547;">{{ $payment->month }}</span> @endif
                    </td>
                    <td class="text-end pe-4 fw-bold" style="color: #10b981; font-size: 1.15rem;">{{ number_format($payment->amount, 2) }}</td>
                </tr>
                @empty
                <tr class="neu-row"><td colspan="6" class="text-center py-5 text-neu fw-bold" style="opacity: 0.6;"><i class="bi bi-inbox fs-2 d-block mb-2"></i> No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content neu-card">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-danger"><i class="bi bi-dash-circle-fill me-2"></i> Add New Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/add-expense" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="fw-bold text-neu mb-1">Category</label>
                        <select name="category" id="expenseCategorySelect" class="form-select neu-input fw-bold" required>
                            <option value="Electricity">Electricity Bill</option>
                            <option value="Water">Water Bill</option>
                            <option value="Rent">Building Rent</option>
                            <option value="Internet">Internet / Phone</option>
                            <option value="Custom" style="color: var(--neu-primary);">+ Add Custom Category...</option>
                        </select>
                        <input type="text" name="custom_category" id="customCategoryInput" class="form-control neu-input fw-bold mt-3 d-none" placeholder="Type category name... (e.g. Staff Tea)">
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-neu mb-1">Amount (Rs.)</label>
                        <input type="number" name="amount" class="form-control neu-input fw-bold" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-neu mb-1">Date</label>
                        <input type="date" name="date" class="form-control neu-input fw-bold" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="fw-bold text-neu mb-1">Description (Optional)</label>
                        <input type="text" name="description" class="form-control neu-input fw-bold">
                    </div>
                    <button type="submit" class="btn neu-btn w-100 fw-bold py-3 text-danger fs-5">Save Expense</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter Form Logic
        const filterType = document.getElementById('filterType');
        const monthGroup = document.getElementById('monthPickerGroup');
        const customGroup = document.getElementById('customDateGroup');

        function updateFormUI() {
            // මුලින්ම ඔක්කොම හංගනවා
            monthGroup.classList.remove('d-block');
            monthGroup.classList.add('d-none');
            customGroup.classList.remove('d-flex');
            customGroup.classList.add('d-none');

            // ඊට පස්සේ අදාළ එක විතරක් පෙන්වනවා
            if (filterType.value === 'month') {
                monthGroup.classList.remove('d-none');
                monthGroup.classList.add('d-block');
            } else if (filterType.value === 'custom') {
                customGroup.classList.remove('d-none');
                customGroup.classList.add('d-flex');
            }
        }

        if(filterType) {
            filterType.addEventListener('change', updateFormUI);
        }

        // Custom Expense Category Logic
        const expenseCategorySelect = document.getElementById('expenseCategorySelect');
        const customCategoryInput = document.getElementById('customCategoryInput');

        if(expenseCategorySelect && customCategoryInput) {
            expenseCategorySelect.addEventListener('change', function() {
                if(this.value === 'Custom') {
                    customCategoryInput.classList.remove('d-none');
                    customCategoryInput.setAttribute('required', 'true');
                    customCategoryInput.focus();
                } else {
                    customCategoryInput.classList.add('d-none');
                    customCategoryInput.removeAttribute('required');
                    customCategoryInput.value = '';
                }
            });
        }
    });
</script>
@endsection