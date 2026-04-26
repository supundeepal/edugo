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
        padding: 12px 20px; 
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
    .neu-btn:hover { transform: translateY(-2px); }
    .neu-btn:active {
        transform: translateY(2px);
        box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light);
    }

    .neu-btn-danger {
        color: #ef4444;
    }

    .material-item {
        background-color: var(--neu-bg);
        border-radius: 15px;
        padding: 15px 20px;
        box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        transition: 0.3s;
    }
    .material-item:hover {
        transform: translateY(-3px);
    }

    .file-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background-color: var(--neu-bg);
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #8b5cf6;
    }
</style>

<div class="container-fluid mt-4 mb-5 px-xl-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-neu" style="color: #8b5cf6 !important;"><i class="bi bi-file-earmark-pdf-fill me-2"></i>Study Materials</h2>
            <p class="mb-0 text-neu" style="opacity: 0.7; font-weight: 500;">Upload and manage course notes or tutes</p>
        </div>
        <a href="/teacher-dashboard" class="btn neu-btn px-4 py-2 text-decoration-none text-neu">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success fw-bold" style="border-radius: 15px; border: none; box-shadow: inset 3px 3px 6px rgba(0,0,0,0.1);"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger fw-bold" style="border-radius: 15px; border: none; box-shadow: inset 3px 3px 6px rgba(0,0,0,0.1);"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger fw-bold" style="border-radius: 15px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="card neu-card p-4 h-100">
                <h4 class="fw-bold text-neu mb-4"><i class="bi bi-cloud-arrow-up-fill me-2" style="color: #8b5cf6;"></i>Upload New File</h4>
                
                <form action="/teacher-materials/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="fw-bold mb-2 text-neu">Select Class</label>
                        <select name="course_id" class="form-select neu-input fw-bold" required>
                            <option value="" disabled selected>-- Choose Class --</option>
                            @forelse($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }} ({{ $course->grade }})</option>
                            @empty
                                <option value="" disabled>No courses available</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold mb-2 text-neu">Material Title</label>
                        <input type="text" name="title" class="form-control neu-input fw-medium" placeholder="e.g. Unit 1 - Past Papers" required>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold mb-2 text-neu">Choose File (PDF, Image, Word)</label>
                        <input type="file" name="file" class="form-control neu-input fw-medium" accept=".pdf,.doc,.docx,.jpg,.png" required style="padding: 10px 20px;">
                        <small class="text-neu mt-2 d-block" style="opacity: 0.6;">Max file size: 5MB</small>
                    </div>

                    <button type="submit" class="btn neu-btn w-100 py-3 fs-5 mt-2" style="color: #8b5cf6 !important;">
                        <i class="bi bi-upload me-2"></i> Upload Material
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card neu-card p-4 h-100">
                <h4 class="fw-bold text-neu mb-4"><i class="bi bi-archive-fill me-2" style="color: var(--neu-primary);"></i>Uploaded Materials</h4>
                
                <div class="materials-list" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                    @forelse($materials as $material)
                        <div class="material-item">
                            <div class="d-flex align-items-center">
                                <div class="file-icon me-3">
                                    @if(Str::endsWith($material->file_path, '.pdf'))
                                        <i class="bi bi-filetype-pdf text-danger"></i>
                                    @elseif(Str::endsWith($material->file_path, ['.doc', '.docx']))
                                        <i class="bi bi-filetype-doc text-primary"></i>
                                    @else
                                        <i class="bi bi-file-image text-success"></i>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="fw-bold text-neu mb-1">{{ $material->title }}</h6>
                                    <p class="mb-0 text-neu" style="font-size: 0.85rem; opacity: 0.7;">
                                        <i class="bi bi-book-half me-1"></i> {{ $material->course->course_name }} &nbsp;|&nbsp; 
                                        <i class="bi bi-clock me-1"></i> {{ $material->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ asset($material->file_path) }}" target="_blank" class="btn neu-btn px-3 py-2" title="View/Download">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="/teacher-materials/{{ $material->id }}/delete" class="btn neu-btn neu-btn-danger px-3 py-2" onclick="return confirm('Are you sure you want to delete this file?');" title="Delete">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center mt-5">
                            <i class="bi bi-folder-x" style="font-size: 4rem; color: #8b5cf6; opacity: 0.5;"></i>
                            <h5 class="fw-bold text-neu mt-3" style="opacity: 0.7;">No materials uploaded yet.</h5>
                            <p class="text-neu" style="opacity: 0.5;">Use the form on the left to add notes for your students.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@endsection