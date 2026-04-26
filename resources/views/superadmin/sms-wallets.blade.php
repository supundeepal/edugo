@extends('superadmin.layout')

@section('title', 'SMS Wallets Management')

@section('content')
<div class="container mt-4 mb-5 px-xl-5">
    
    <div class="mb-4">
        <a href="/superadmin/dashboard" class="btn fw-bold d-inline-flex align-items-center" style="background-color: var(--neu-bg); color: var(--neu-text); border-radius: 12px; padding: 10px 20px; box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light); text-decoration: none;">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card p-4 p-md-5" style="background-color: var(--neu-bg); border: none; border-radius: 20px; box-shadow: 8px 8px 16px var(--neu-shadow-dark), -8px -8px 16px var(--neu-shadow-light);">
                
                <div class="mb-4">
                    <h4 class="fw-bold mb-2" style="color: var(--neu-primary);">
                        <i class="bi bi-wallet2 me-2"></i> Top-up SMS Wallet
                    </h4>
                    <p class="text-neu opacity-75 mb-0" style="font-size: 0.95rem;">Add funds to an institute's account so they can send SMS broadcasts.</p>
                </div>

                <form action="/superadmin/sms-wallets/topup" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="fw-bold text-neu mb-2 ms-2">Select Institute</label>
                            <select name="institute_id" class="form-select fw-bold w-100" style="background-color: var(--neu-bg); border: none; border-radius: 12px; color: var(--neu-text); box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light); padding: 12px 18px;" required>
                                <option value="">-- Choose Institute --</option>
                                @foreach($institutes as $institute)
                                    <option value="{{ $institute->id }}">{{ $institute->name }} (Rs. {{ number_format($institute->sms_balance, 2) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="fw-bold text-neu mb-2 ms-2">Top-up Amount (Rs.)</label>
                            <input type="number" name="amount" class="form-control fw-bold w-100" placeholder="e.g. 1000" min="1" step="0.01" style="background-color: var(--neu-bg); border: none; border-radius: 12px; color: var(--neu-text); box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light); padding: 12px 18px;" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-neu mb-2 ms-2">Reference Note (Optional)</label>
                        <input type="text" name="reference_note" class="form-control fw-bold w-100" placeholder="Bank receipt number, date, paid by cash etc." style="background-color: var(--neu-bg); border: none; border-radius: 12px; color: var(--neu-text); box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light); padding: 12px 18px;">
                    </div>

                    <button type="submit" class="btn w-100 fw-bold py-3 fs-5 mt-2" style="background: var(--neu-bg); box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light); border:none; border-radius: 15px; color: var(--neu-success) !important; transition: 0.3s;" onclick="return confirm('Are you sure you want to top-up this wallet?')">
                        <i class="bi bi-cash-stack me-2"></i> Confirm & Add Funds
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-4 p-md-5" style="background-color: var(--neu-bg); border: none; border-radius: 20px; box-shadow: 8px 8px 16px var(--neu-shadow-dark), -8px -8px 16px var(--neu-shadow-light);">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-neu mb-0"><i class="bi bi-clock-history me-2 text-warning"></i> Top-up History</h4>
                    <span class="badge rounded-pill text-neu opacity-75" style="background: var(--neu-bg); box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light); padding: 8px 15px; font-weight: 600;">Last 10 Records</span>
                </div>
                
                <div class="table-responsive" style="border-radius: 15px; box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light); padding: 15px 20px;">
                    <table class="table table-borderless align-middle mb-0 text-neu">
                        <thead style="border-bottom: 2px solid rgba(163, 177, 198, 0.2);">
                            <tr class="opacity-75" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                                <th class="py-3">Date & Time</th>
                                <th>Institute</th>
                                <th class="text-center">Reference</th>
                                <th class="text-end">Amount Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTopups as $topup)
                            <tr style="border-bottom: 1px solid rgba(163, 177, 198, 0.1);">
                                <td class="py-3">
                                    <div class="fw-bold" style="font-size: 0.95rem;">{{ $topup->created_at->format('M d, Y') }}</div>
                                    <small class="opacity-50 fw-semibold">{{ $topup->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 text-neu" style="background-color: var(--neu-bg); box-shadow: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light); font-weight: 700; border: 1px solid rgba(255,255,255,0.05);">
                                        <i class="bi bi-building me-1" style="color: var(--neu-primary);"></i> {{ $topup->institute_name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($topup->reference_note)
                                        <span class="opacity-75 fw-medium" style="font-size: 0.9rem;">{{ $topup->reference_note }}</span>
                                    @else
                                        <span class="opacity-25">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <h5 class="fw-bold text-success mb-0">
                                        <i class="bi bi-arrow-up-circle-fill me-1" style="font-size: 1.1rem;"></i>Rs. {{ number_format($topup->amount, 2) }}
                                    </h5>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="bi bi-wallet2 text-neu opacity-25 mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="fw-bold text-neu opacity-50">No top-ups made yet!</h5>
                                </td>
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