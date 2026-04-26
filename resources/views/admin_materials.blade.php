@extends('layout')

@section('content')

<style>
    .text-neu { color: var(--neu-text) !important; }
    
    .neu-card { 
        background-color: var(--neu-bg) !important; 
        border-radius: 22px; 
        border: none !important; 
        /* 24px තිබ්බ එක 18px කළා සිනිඳු වෙන්න */
        box-shadow: 9px 9px 18px var(--neu-shadow-dark), -9px -9px 18px var(--neu-shadow-light) !important; 
    }

    .neu-btn {
        background-color: var(--neu-bg);
        color: var(--neu-primary);
        border: none;
        border-radius: 12px;
        /* 10px තිබ්බ එක 8px කළා */
        box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light);
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .neu-btn:hover { transform: translateY(-2px); }
    .neu-btn:active { box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light); transform: translateY(2px); }

    .neu-table { border-collapse: separate; border-spacing: 0 12px; width: 100%; }
    .neu-table th { border: none; padding: 10px 20px; color: var(--neu-text); opacity: 0.6; text-transform: uppercase; font-size: 0.85rem; }
    .neu-table td { background-color: var(--neu-bg); border: none; padding: 15px 20px; vertical-align: middle; color: var(--neu-text); }
    .neu-table td:first-child { border-top-left-radius: 15px; border-bottom-left-radius: 15px; }
    .neu-table td:last-child { border-top-right-radius: 15px; border-bottom-right-radius: 15px; }
    
    /* ටේබල් එකේ පේළි වල ෂැඩෝ එකත් සිනිඳු කළා */
    .neu-row { box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light); transition: 0.2s; }
    .neu-row:hover { transform: scale(1.01); }

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
</style>

<div class="container mt-4 mb-5">
    
    <div class="mb-4">
        <a href="/dashboard" class="neu-btn-back">
            <i class="bi bi-arrow-left-short fs-4 me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="d-flex align-items-center mb-4">
        <div class="me-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: var(--neu-bg); box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light); font-size: 24px; color: #8b5cf6;">
            <i class="bi bi-file-earmark-arrow-down-fill"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0 text-neu">Study Materials Database</h2>
            <p class="mb-0 text-neu" style="opacity: 0.7; font-weight: 500;">View and download materials uploaded by teachers</p>
        </div>
    </div>

    <div class="table-responsive px-2 pb-4">
        <table class="neu-table">
            <thead>
                <tr>
                    <th class="ps-4">Date</th>
                    <th>Teacher Name</th>
                    <th>Class / Subject</th>
                    <th>File Title</th>
                    <th class="text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                    <tr class="neu-row">
                        <td class="ps-4 fw-bold text-neu" style="opacity: 0.8;">{{ $material->created_at->format('Y-m-d') }}</td>
                        <td class="fw-bold text-neu"><i class="bi bi-person-badge-fill me-2" style="color: #ffb547;"></i>{{ $material->teacher->name }}</td>
                        <td class="fw-medium text-neu" style="opacity: 0.8;">{{ $material->course->course_name }}</td>
                        <td class="fw-bold text-neu" style="color: var(--neu-primary) !important;">
                            @if(Str::endsWith($material->file_path, '.pdf'))
                                <i class="bi bi-filetype-pdf text-danger me-2"></i>
                            @elseif(Str::endsWith($material->file_path, ['.doc', '.docx']))
                                <i class="bi bi-filetype-doc text-primary me-2"></i>
                            @else
                                <i class="bi bi-file-image text-success me-2"></i>
                            @endif
                            {{ $material->title }}
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ asset($material->file_path) }}" target="_blank" class="btn neu-btn px-4 py-2" style="color: #8b5cf6;">
                                <i class="bi bi-cloud-download-fill me-2"></i> Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="neu-row">
                        <td colspan="5" class="text-center py-5 text-neu fw-bold" style="opacity: 0.6;">
                            <i class="bi bi-folder2-open display-4 d-block mb-3"></i>
                            No study materials have been uploaded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection