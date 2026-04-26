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
    
    .neu-input { 
        background-color: var(--neu-bg) !important; 
        border: none !important; 
        border-radius: 15px !important; 
        color: var(--neu-text) !important; 
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light) !important; 
        padding: 15px 20px; 
        outline: none; 
        transition: 0.2s; 
    }
    
    .neu-input:focus { 
        box-shadow: inset 7px 7px 14px var(--neu-shadow-dark), inset -7px -7px 14px var(--neu-shadow-light) !important; 
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
    .neu-btn:hover {
        transform: translateY(-2px);
    }
    .neu-btn:active {
        transform: translateY(2px);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light);
    }

    .char-counter {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--neu-text);
        opacity: 0.6;
        text-align: right;
        margin-top: 8px;
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-neu" style="color: var(--neu-primary) !important;">Class Announcements</h2>
            <p class="mb-0 text-neu" style="opacity: 0.7; font-weight: 500;">Send bulk SMS to your students</p>
        </div>
        <a href="/teacher-dashboard" class="btn neu-btn px-4 py-2 fs-5 text-decoration-none" style="color: var(--neu-text);">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success fw-bold" style="border-radius: 15px; border: none; box-shadow: inset 3px 3px 6px rgba(0,0,0,0.1);"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger fw-bold" style="border-radius: 15px; border: none; box-shadow: inset 3px 3px 6px rgba(0,0,0,0.1);"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card neu-card p-4 p-md-5 mt-3">
                <form action="/teacher-announcements/send" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="fw-bold fs-5 mb-2 text-neu"><i class="bi bi-mortarboard-fill me-2" style="color: var(--neu-primary);"></i>Select Course</label>
                        <select name="course_id" class="form-select neu-input fw-bold fs-6" required>
                            <option value="" disabled selected>-- Choose your class --</option>
                            @forelse($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }} ({{ $course->grade }} - {{ $course->subject }})</option>
                            @empty
                                <option value="" disabled>No courses found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="fw-bold fs-5 mb-2 text-neu"><i class="bi bi-chat-left-text-fill me-2" style="color: var(--neu-primary);"></i>Message Content</label>
                        <textarea name="message" id="smsMessage" rows="4" class="form-control neu-input fw-medium fs-6" placeholder="Type your announcement here... (Max 160 characters)" maxlength="160" required></textarea>
                        <div class="char-counter" id="charCount">0 / 160 characters</div>
                    </div>

                    <div class="alert alert-warning mt-3 mb-4 fw-medium" style="background-color: transparent; border: 1px dashed #ffb547; color: #ffb547;">
                        <i class="bi bi-info-circle-fill me-2"></i> Only students who have registered a phone number will receive this SMS.
                    </div>

                    <button type="submit" class="btn neu-btn w-100 py-3 fs-5 mt-2" style="color: var(--neu-primary) !important;">
                        <i class="bi bi-send-fill me-2"></i> Send Announcement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // අකුරු ගාණ මනින Script එක
    document.addEventListener('DOMContentLoaded', function() {
        const messageInput = document.getElementById('smsMessage');
        const charCount = document.getElementById('charCount');

        if(messageInput && charCount) {
            messageInput.addEventListener('input', function() {
                const currentLength = this.value.length;
                charCount.textContent = currentLength + ' / 160 characters';
                
                if(currentLength >= 160) {
                    charCount.style.color = '#dc3545'; // රතු පාට වෙනවා අකුරු 160 වුණාම
                } else {
                    charCount.style.color = 'var(--neu-text)';
                }
            });
        }
    });
</script>

@endsection