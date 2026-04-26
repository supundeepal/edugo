@extends('superadmin.layout')

@section('title', 'Manage Institutes')

@section('content')

<style>
    .neu-input {
        background-color: var(--neu-bg);
        border: none;
        border-radius: 12px;
        box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), 
                    inset -3px -3px 6px rgba(0, 0, 0, 0.03); 
        color: var(--neu-text);
        padding: 12px 15px;
        width: 100%;
        transition: all 0.2s ease;
    }
    .neu-input:focus {
        outline: none;
        box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), 
                    inset -5px -5px 10px rgba(0, 0, 0, 0.05);
    }
    .modal-backdrop.show {
        opacity: 1 !important; 
        background-color: rgba(18, 25, 38, 0.7) !important; 
        backdrop-filter: blur(6px);
    }
    .table {
        --bs-table-bg: transparent !important;
    }
    .table th, .table td {
        background-color: transparent !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold text-neu mb-0"><i class="bi bi-buildings-fill me-2" style="color: var(--neu-primary);"></i> Registered Institutes</h5>
    
    <button class="neu-btn px-4 py-2" style="color: var(--neu-success);" data-bs-toggle="modal" data-bs-target="#addInstituteModal">
        <i class="bi bi-plus-lg me-2"></i> Add New Institute
    </button>
</div>

@if(session('success'))
<div class="alert alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; background-color: var(--neu-bg); box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light); border: none; color: var(--neu-success); font-weight: 500;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card neu-card p-4">
    <div class="table-responsive">
        <table class="table table-borderless align-middle text-neu mb-0">
            <thead>
                <tr style="border-bottom: 2px solid rgba(0,0,0,0.1);">
                    <th class="py-3 text-neu" style="opacity: 0.7;">ID</th>
                    <th class="py-3 text-neu" style="opacity: 0.7;">Institute Name</th>
                    <th class="py-3 text-neu" style="opacity: 0.7;">Owner / Contact</th>
                    <th class="py-3 text-neu" style="opacity: 0.7;">Status</th>
                    <th class="py-3 text-end text-neu" style="opacity: 0.7;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($institutes as $institute)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <td class="py-3 fw-bold">#INS-{{ sprintf('%03d', $institute->id) }}</td>
                    <td class="py-3">
                        <div class="fw-bold">{{ $institute->name }}</div>
                        <small style="opacity: 0.6;">{{ $institute->city }}</small>
                    </td>
                    <td class="py-3">
                        <div class="fw-bold">{{ $institute->owner_name }}</div>
                        <small style="opacity: 0.6;">{{ $institute->phone }}</small>
                    </td>
                    <td class="py-3">
                        <span class="badge rounded-pill" style="background-color: var(--neu-success); color: white; padding: 8px 12px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);">{{ $institute->status }}</span>
                    </td>
                    <td class="py-3 text-end">
                        
                        <button class="neu-btn d-inline-flex justify-content-center me-2 edit-btn" 
                            style="width: 35px; height: 35px; padding: 0; color: var(--neu-primary);"
                            data-bs-toggle="modal" data-bs-target="#editInstituteModal"
                            data-id="{{ $institute->id }}"
                            data-name="{{ $institute->name }}"
                            data-owner="{{ $institute->owner_name }}"
                            data-phone="{{ $institute->phone }}"
                            data-city="{{ $institute->city }}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>

                        <button type="button" class="neu-btn d-inline-flex justify-content-center delete-btn" 
                                style="width: 35px; height: 35px; padding: 0; color: var(--neu-danger);" 
                                data-bs-toggle="modal" data-bs-target="#deleteInstituteModal"
                                data-id="{{ $institute->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addInstituteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content neu-card" style="border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-neu"><i class="bi bi-building-add me-2" style="color: var(--neu-primary);"></i>Register New Institute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/superadmin/institutes/store" method="POST">
                    @csrf 
                    <div class="mb-4">
                        <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Institute Name</label>
                        <input type="text" name="name" class="neu-input" required>
                    </div>
                    <div class="row mb-4 g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Owner Name</label>
                            <input type="text" name="owner_name" class="neu-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Contact Number</label>
                            <input type="text" name="phone" class="neu-input" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Location (City)</label>
                        <input type="text" name="city" class="neu-input" required>
                    </div>
                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <button type="button" class="neu-btn px-4 py-2" data-bs-dismiss="modal" style="color: var(--neu-danger);">Cancel</button>
                        <button type="submit" class="neu-btn px-4 py-2" style="color: var(--neu-primary);"><i class="bi bi-save-fill me-2"></i> Save Institute</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editInstituteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content neu-card" style="border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-neu"><i class="bi bi-pencil-square me-2" style="color: var(--neu-primary);"></i>Edit Institute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editForm" method="POST">
                    @csrf 
                    <div class="mb-4">
                        <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Institute Name</label>
                        <input type="text" name="name" id="edit_name" class="neu-input" required>
                    </div>
                    <div class="row mb-4 g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Owner Name</label>
                            <input type="text" name="owner_name" id="edit_owner_name" class="neu-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Contact Number</label>
                            <input type="text" name="phone" id="edit_phone" class="neu-input" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-neu mb-2" style="font-size: 0.9rem;">Location (City)</label>
                        <input type="text" name="city" id="edit_city" class="neu-input" required>
                    </div>
                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <button type="button" class="neu-btn px-4 py-2" data-bs-dismiss="modal" style="color: var(--neu-danger);">Cancel</button>
                        <button type="submit" class="neu-btn px-4 py-2" style="color: var(--neu-primary);"><i class="bi bi-save-fill me-2"></i> Update Institute</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteInstituteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content neu-card" style="border: none; text-align: center;">
            <div class="modal-body p-5">
                <i class="bi bi-exclamation-triangle-fill mb-3" style="font-size: 3.5rem; color: var(--neu-danger);"></i>
                <h4 class="fw-bold text-neu mb-2">Are you sure?</h4>
                <p class="text-neu mb-4" style="opacity: 0.7; font-size: 0.9rem;">Do you really want to delete this institute? This process cannot be undone.</p>
                
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="neu-btn px-4 py-2" data-bs-dismiss="modal" style="color: var(--neu-text);">Cancel</button>
                    <a href="#" id="confirmDeleteBtn" class="neu-btn px-4 py-2" style="color: var(--neu-danger); font-weight: bold;">
                        Yes, Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Button Logic
        const editBtns = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editForm');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_owner_name').value = this.dataset.owner;
                document.getElementById('edit_phone').value = this.dataset.phone;
                document.getElementById('edit_city').value = this.dataset.city;
                editForm.action = "/superadmin/institutes/update/" + this.dataset.id;
            });
        });

        // Delete Button Logic
        const deleteBtns = document.querySelectorAll('.delete-btn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                confirmDeleteBtn.href = "/superadmin/institutes/delete/" + this.dataset.id;
            });
        });
    });
</script>
@endsection