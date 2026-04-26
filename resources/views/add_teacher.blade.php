@extends('layout')

@section('content')

<style>
    .text-neu { color: var(--neu-text) !important; }

    /* 3D Main Cards */
    .neu-card {
        background-color: var(--neu-bg) !important;
        border-radius: 25px;
        border: none !important;
        box-shadow: 10px 10px 20px var(--neu-shadow-dark), 
                   -10px -10px 20px var(--neu-shadow-light) !important;
        padding: 35px;
    }

    /* 3D Inputs */
    .neu-input {
        background-color: var(--neu-bg) !important;
        border: none !important;
        border-radius: 12px !important;
        color: var(--neu-text) !important;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px var(--neu-shadow-light) !important;
        padding: 12px 18px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .neu-input:focus {
        box-shadow: inset 7px 7px 14px var(--neu-shadow-dark), 
                    inset -7px -7px 14px var(--neu-shadow-light) !important;
    }

    /* 3D Table Styles */
    .neu-table { border-collapse: separate; border-spacing: 0 12px; width: 100%; }
    .neu-table th { border: none; padding: 10px 20px; color: var(--neu-text); opacity: 0.5; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; }
    .neu-table td { background-color: var(--neu-bg); border: none; padding: 15px 20px; vertical-align: middle; color: var(--neu-text); }
    .neu-table td:first-child { border-top-left-radius: 15px; border-bottom-left-radius: 15px; }
    .neu-table td:last-child { border-top-right-radius: 15px; border-bottom-right-radius: 15px; }
    .neu-table tr.neu-row { box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light); transition: 0.3s; }
    .neu-table tr.neu-row:hover { transform: scale(1.01); }

    /* Action Buttons */
    .neu-action-btn { width: 38px; height: 38px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background-color: var(--neu-bg); box-shadow: 4px 4px 8px var(--neu-shadow-dark), -4px -4px 8px var(--neu-shadow-light); text-decoration: none; transition: 0.2s; }
    .neu-action-btn:hover { transform: translateY(-2px); }

    /* Back Button */
    .neu-btn-back { background-color: var(--neu-bg); color: var(--neu-text); border: none; border-radius: 12px; padding: 10px 20px; font-weight: 700; box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light); transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; }

    /* Main Register Button */
    .neu-btn-submit { background-color: var(--neu-bg); color: #10b981; border: none; border-radius: 15px; padding: 15px 40px; font-weight: 800; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light); transition: 0.3s; cursor: pointer; }
    .neu-btn-submit:hover { transform: translateY(-2px); box-shadow: 8px 8px 16px var(--neu-shadow-dark), -8px -8px 16px var(--neu-shadow-light); }

    /* Search Button */
    .neu-btn-search { background-color: var(--neu-bg); color: var(--neu-primary); border: none; border-radius: 12px; padding: 12px 30px; font-weight: 800; box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light); transition: 0.3s; cursor: pointer; height: 100%; display: flex; align-items: center; justify-content: center;}
    .neu-btn-search:active { box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light); }

    .neu-title-badge { display: inline-flex; align-items: center; background-color: var(--neu-bg); padding: 8px 20px; border-radius: 12px; box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light); margin-bottom: 25px; }

    /* Found Teacher Card */
    .found-teacher-card { border-radius: 15px; box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light); padding: 20px; margin-top: 20px; display: flex; align-items: center; justify-content: space-between; }
</style>

<div class="container mt-4 mb-5 px-xl-5">
    
    <div class="mb-4">
        <a href="/teachers-menu" class="neu-btn-back" data-bs-toggle="tooltip" title="Back to Teacher Menu">
            <i class="bi bi-arrow-left fs-5 me-2"></i> Back to Menu
        </a>
    </div>

    @if(session('success'))
        <div class="alert fw-bold text-center border-0 mb-4" style="background-color: var(--neu-bg); color: #10b981; border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert fw-bold text-center border-0 mb-4" style="background-color: var(--neu-bg); color: var(--neu-danger); border-radius: 15px; box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light);">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="card neu-card mb-5">
        <div class="neu-title-badge">
            <i class="bi bi-person-plus-fill me-2" style="color: #10b981;"></i>
            <h5 class="fw-bold mb-0 text-neu">Register New Instructor</h5>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-9">
                <label class="form-label fw-bold text-neu opacity-75 ms-1">Teacher's Phone Number</label>
                <input type="text" id="searchPhone" class="form-control neu-input fs-5" placeholder="Enter mobile number (e.g. 0771234567)" autocomplete="off">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="searchBtn" class="neu-btn-search w-100">
                    <i class="bi bi-search me-2"></i> Search
                </button>
            </div>
        </div>

        <div id="loadingIndicator" class="text-center d-none my-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="text-neu mt-2 fw-bold opacity-75">Searching Global Database...</p>
        </div>

        <div id="teacherFoundSection" class="d-none">
            <h6 class="fw-bold text-success mb-0 ms-1"><i class="bi bi-check-circle-fill me-1"></i> Teacher Found in EduGo Network!</h6>
            <div class="found-teacher-card">
                <div class="d-flex align-items-center">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--neu-bg); box-shadow: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--neu-primary);">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="fw-bold text-neu mb-0" id="foundName">Name Here</h4>
                        <span class="text-neu opacity-75 fw-medium" id="foundUsername">@username</span>
                    </div>
                </div>
                <form action="/add-existing-teacher" method="POST">
                    @csrf
                    <input type="hidden" name="teacher_id" id="foundTeacherId">
                    <button type="submit" class="neu-btn-submit py-2 px-4" style="font-size: 0.9rem;">
                        <i class="bi bi-plus-circle-fill me-2"></i> Add to My Institute
                    </button>
                </form>
            </div>
        </div>

        <div id="newTeacherFormSection" class="d-none mt-4 pt-4" style="border-top: 2px dashed rgba(163, 177, 198, 0.3);">
            <h6 class="fw-bold text-warning mb-4 ms-1"><i class="bi bi-info-circle-fill me-1"></i> No existing profile found. Please register as new.</h6>
            <form action="/add-teacher" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="phone" id="registerPhone"> <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-neu opacity-75 ms-1">Full Name</label>
                        <input type="text" name="name" class="form-control neu-input" placeholder="e.g. Kamal Sir" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-neu opacity-75 ms-1">Login Username</label>
                        <input type="text" name="username" class="form-control neu-input" placeholder="unique_username" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-neu opacity-75 ms-1">Account Password</label>
                        <input type="password" name="password" class="form-control neu-input" placeholder="••••••••" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-neu opacity-75 ms-1">Profile Picture (Optional)</label>
                        <input type="file" name="photo" class="form-control neu-input" accept="image/*">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="neu-btn-submit w-100">
                            <i class="bi bi-shield-check me-2"></i> Save New Teacher
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="card neu-card">
        <div class="neu-title-badge">
            <i class="bi bi-person-lines-fill me-2" style="color: var(--neu-primary);"></i>
            <h5 class="fw-bold mb-0 text-neu">Instructors Directory</h5>
        </div>

        <div class="table-responsive px-1">
            <table class="neu-table">
                <thead>
                    <tr>
                        <th class="ps-4">Teacher Information</th>
                        <th>Username</th>
                        <th>Phone</th>
                        <th class="text-end pe-4">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr class="neu-row">
                        <td class="ps-4">
                            <div class="d-flex align-items-center fw-bold text-neu">
                                <i class="bi bi-person-fill me-2" style="color: #10b981;"></i>
                                {{ $teacher->name }}
                            </div>
                        </td>
                        <td>
                            <span class="px-3 py-1 fw-bold" style="background-color: var(--neu-bg); color: var(--neu-primary); box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light); border-radius: 8px; font-size: 0.9rem;">
                                {{ $teacher->username }}
                            </span>
                        </td>
                        <td><span class="text-neu fw-medium">{{ $teacher->phone }}</span></td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="/teachers/{{ $teacher->id }}/remove" class="neu-action-btn" style="color: var(--neu-danger);" data-bs-toggle="tooltip" title="Remove from My Institute" onclick="return confirm('Are you sure you want to remove this teacher from your institute?');">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-neu opacity-50">No instructors added to your institute yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Smart Search Logic
        const searchBtn = document.getElementById('searchBtn');
        const phoneInput = document.getElementById('searchPhone');
        
        const loading = document.getElementById('loadingIndicator');
        const foundSection = document.getElementById('teacherFoundSection');
        const newFormSection = document.getElementById('newTeacherFormSection');
        
        searchBtn.addEventListener('click', function() {
            let phone = phoneInput.value.trim();
            if(phone === '') {
                alert("Please enter a phone number first!");
                return;
            }

            // Hide previous results & show loading
            foundSection.classList.add('d-none');
            newFormSection.classList.add('d-none');
            loading.classList.remove('d-none');

            // Send AJAX request to check database
            fetch('/api/search-teacher?phone=' + phone)
                .then(response => response.json())
                .then(data => {
                    loading.classList.add('d-none');
                    
                    if(data.found) {
                        // Teacher exists! Show quick add button
                        document.getElementById('foundName').innerText = data.teacher.name;
                        document.getElementById('foundUsername').innerText = '@' + data.teacher.username;
                        document.getElementById('foundTeacherId').value = data.teacher.id;
                        
                        foundSection.classList.remove('d-none');
                    } else {
                        // Not found. Show full registration form
                        document.getElementById('registerPhone').value = phone; // Auto fill hidden input
                        newFormSection.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    loading.classList.add('d-none');
                    alert("Something went wrong! Please try again.");
                });
        });
    });
</script>
@endsection