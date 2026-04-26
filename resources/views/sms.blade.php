@extends('layout')

@section('content')

<style>
    .neu-card {
        background-color: var(--neu-bg);
        border-radius: 20px;
        border: none;
        box-shadow: 8px 8px 16px var(--neu-shadow-dark), -8px -8px 16px var(--neu-shadow-light);
    }
    
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 12px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light) !important;
        padding: 12px 18px;
    }
    .neu-input:focus { outline: none; box-shadow: inset 8px 8px 16px var(--neu-shadow-dark), inset -8px -8px 16px var(--neu-shadow-light) !important; }

    .stats-box {
        background-color: var(--neu-bg);
        border-radius: 15px;
        padding: 15px;
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light);
        text-align: center;
    }
</style>

<div class="container mt-4 mb-5 px-xl-5">
    
    <div class="mb-4">
        <a href="/dashboard" class="btn fw-bold d-inline-flex align-items-center" style="background-color: var(--neu-bg); color: var(--neu-text); border-radius: 12px; padding: 10px 20px; box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light); text-decoration: none;">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="neu-card p-4 p-md-5">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0" style="color: var(--neu-primary);">
                        <i class="bi bi-broadcast me-2"></i> SMS Broadcast
                    </h4>
                    
                    <div class="badge rounded-pill fs-6 px-3 py-2 fw-bold" style="background-color: var(--neu-bg); color: var(--neu-success); box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);">
                        <i class="bi bi-wallet2 me-2"></i> Wallet: Rs. {{ number_format($currentBalance, 2) }}
                    </div>
                </div>

                <form action="/sms-broadcast" method="POST" id="smsForm">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="fw-bold text-neu mb-2 ms-2">Select Class</label>
                            <select name="course_id" id="courseSelect" class="form-select neu-input fw-bold" required>
                                <option value="" data-count="0">-- Choose Class --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" data-count="{{ $course->students_count }}">
                                        {{ $course->course_name }} ({{ $course->students_count }} Students)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-neu mb-2 ms-2">Send To</label>
                            <select name="recipient_type" id="recipientSelect" class="form-select neu-input fw-bold" required>
                                <option value="parent">Parents Only</option>
                                <option value="student">Students Only</option>
                                <option value="both">Both (Parents & Students)</option>
                            </select>
                        </div>
                    </div>

                    <label class="fw-bold text-neu mb-2 ms-2">Message Content</label>
                    <textarea name="message" id="smsMessage" class="form-control neu-input mb-3" rows="5" placeholder="Type your message here..." required></textarea>

                    <div class="row g-3 mb-4">
                        <div class="col-4">
                            <div class="stats-box">
                                <h6 class="text-neu opacity-75 mb-1" style="font-size: 0.8rem; text-transform: uppercase; font-weight: 800;">Characters</h6>
                                <h3 class="fw-bold text-primary mb-0" id="charCount">0</h3>
                                <small class="text-neu fw-bold opacity-50" style="font-size: 0.7rem;" id="encodingType">Standard (GSM)</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-box">
                                <h6 class="text-neu opacity-75 mb-1" style="font-size: 0.8rem; text-transform: uppercase; font-weight: 800;">SMS Parts</h6>
                                <h3 class="fw-bold text-warning mb-0" id="smsParts">0</h3>
                                <small class="text-neu fw-bold opacity-50" style="font-size: 0.7rem;">Per Person</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-box" style="border: 2px dashed rgba(13, 110, 253, 0.3);">
                                <h6 class="text-neu opacity-75 mb-1" style="font-size: 0.8rem; text-transform: uppercase; font-weight: 800;">Est. Cost</h6>
                                <h3 class="fw-bold text-success mb-0" id="totalCost">Rs. 0</h3>
                                <small class="text-neu fw-bold opacity-50" style="font-size: 0.7rem;">Rs. 1 / SMS Part</small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 fw-bold py-3 fs-5" style="background: var(--neu-bg); box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light); border:none; border-radius: 20px; color: var(--neu-primary) !important; transition: 0.3s;">
                        <i class="bi bi-send-fill me-2"></i> Send Broadcast
                    </button>
                </form>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="neu-card p-4 h-100" style="background: var(--neu-bg); box-shadow: inset 6px 6px 12px var(--neu-shadow-dark), inset -6px -6px 12px var(--neu-shadow-light);">
                <h6 class="fw-bold text-danger mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i>SMS Pricing Rules
                </h6>
                <ul class="text-neu small fw-medium" style="line-height: 1.8; opacity: 0.85;">
                    <li class="mb-3">
                        <strong class="text-primary">Standard English:</strong><br> 
                        160 chars = 1 SMS.<br>If longer, it splits every 153 chars.
                    </li>
                    <li class="mb-3">
                        <strong class="text-warning" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Sinhala / Unicode:</strong><br> 
                        If even one Sinhala letter or Emoji is used, the limit drops.<br>70 chars = 1 SMS.<br>If longer, it splits every 67 chars.
                    </li>
                    <li>
                        <strong class="text-success">Cost:</strong><br> 
                        Rs. 1.00 per SMS part per person.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h5 class="fw-bold text-neu mb-4"><i class="bi bi-clock-history me-2 text-warning"></i> Recent Broadcasts History</h5>
            
            <div class="neu-card p-4" style="overflow-x: auto;">
                <table class="table table-borderless align-middle mb-0 text-neu">
                    <thead style="border-bottom: 2px solid rgba(163, 177, 198, 0.3);">
                        <tr class="opacity-75" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                            <th>Date & Time</th>
                            <th>Class</th>
                            <th>Target</th>
                            <th style="max-width: 300px;">Message Preview</th>
                            <th class="text-center">Sent To</th>
                            <th class="text-end">Cost (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($smsHistories as $history)
                        <tr style="border-bottom: 1px solid rgba(163, 177, 198, 0.1);">
                            <td class="fw-bold py-3" style="font-size: 0.9rem;">
                                {{ $history->created_at->format('M d, Y') }}<br>
                                <small class="opacity-50">{{ $history->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="fw-bold text-primary">{{ $history->course_name }}</td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark shadow-sm">
                                    {{ ucfirst($history->recipient_type) }}
                                </span>
                            </td>
                            <td style="max-width: 300px;">
                                <div class="text-truncate opacity-75" title="{{ $history->message }}">
                                    {{ $history->message }}
                                </div>
                                <small class="text-danger fw-bold">{{ $history->sms_parts }} SMS Parts</small>
                            </td>
                            <td class="text-center fw-bold fs-5">{{ $history->audience_count }} <i class="bi bi-people-fill text-success" style="font-size: 1rem;"></i></td>
                            <td class="text-end fw-bold text-danger fs-5">Rs. {{ number_format($history->total_cost, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 opacity-50">
                                <i class="bi bi-envelope-x fs-1 d-block mb-2"></i>
                                <span class="fw-bold">No SMS history found yet!</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const messageInput = document.getElementById('smsMessage');
        const courseSelect = document.getElementById('courseSelect');
        const recipientSelect = document.getElementById('recipientSelect');
        
        const charCountEl = document.getElementById('charCount');
        const encodingTypeEl = document.getElementById('encodingType');
        const smsPartsEl = document.getElementById('smsParts');
        const totalCostEl = document.getElementById('totalCost');

        function calculateSMS() {
            let text = messageInput.value;
            let length = text.length;
            
            // Check for Unicode (Sinhala, Tamil, Emojis etc.)
            let isUnicode = /[^\u0000-\u007F]/.test(text);

            let partLimit = isUnicode ? 70 : 160;
            let multiPartLimit = isUnicode ? 67 : 153;
            let parts = 0;

            if (length === 0) {
                parts = 0;
            } else if (length <= partLimit) {
                parts = 1;
            } else {
                parts = Math.ceil(length / multiPartLimit);
            }

            // Get selected audience count
            let selectedOption = courseSelect.options[courseSelect.selectedIndex];
            let studentCount = parseInt(selectedOption.getAttribute('data-count')) || 0;
            
            let recipientMultiplier = 1;
            if (recipientSelect.value === 'both') {
                recipientMultiplier = 2; // Assuming both parent and student numbers exist
            }

            let totalAudience = studentCount * recipientMultiplier;
            let totalEstimatedCost = parts * totalAudience; // Rs 1 per part

            // Update UI
            charCountEl.innerText = length;
            smsPartsEl.innerText = parts;
            totalCostEl.innerText = 'Rs. ' + totalEstimatedCost;

            if (isUnicode && length > 0) {
                encodingTypeEl.innerText = "Sinhala/Unicode";
                encodingTypeEl.style.color = "var(--neu-danger)";
            } else {
                encodingTypeEl.innerText = "Standard (GSM)";
                encodingTypeEl.style.color = "";
            }
        }

        messageInput.addEventListener('input', calculateSMS);
        courseSelect.addEventListener('change', calculateSMS);
        recipientSelect.addEventListener('change', calculateSMS);

        // ⭐ ලස්සන SweetAlert Popup එක
        document.getElementById('smsForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            let totalCost = totalCostEl.innerText; 

            Swal.fire({
                title: 'Send Broadcast?',
                html: `Are you sure you want to send this message? <br><br> <span class="badge bg-success fs-6">Estimated Cost: ${totalCost}</span>`,
                icon: 'question',
                showCancelButton: true,
                background: 'var(--neu-bg)',
                color: 'var(--neu-text)',
                confirmButtonColor: 'var(--neu-primary)',
                cancelButtonColor: 'var(--neu-danger)',
                confirmButtonText: '<i class="bi bi-send-fill me-2"></i> Yes, Send It!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sending SMS...',
                        text: 'Please wait, this might take a moment.',
                        allowOutsideClick: false,
                        background: 'var(--neu-bg)',
                        color: 'var(--neu-text)',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    this.submit();
                }
            });
        });
    });
</script>
@endsection