@extends('layouts.admin-new')

@section('title', 'Create Role')
@section('page-title', 'Create New Role')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Role Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Display name, e.g., "Administrator"</small>
                        </div>
                        
                        <!-- Code -->
                        <div class="col-md-6">
                            <label class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code') }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">System code, e.g., "admin"</small>
                        </div>
                        
                        <!-- Libelle -->
                        <div class="col-md-12">
                            <label class="form-label">Label <span class="text-danger">*</span></label>
                            <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" 
                                   value="{{ old('libelle') }}" required>
                            @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">User-friendly label</small>
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <hr>
                            <h6>Permissions</h6>
                            <p class="text-muted small">Select the permissions for this role</p>
                        </div>
                        
                        <!-- Permissions -->
                        <div class="col-12">
                            <div class="row">
                                @foreach($permissions as $group => $groupPermissions)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-light py-2">
                                            <div class="form-check">
                                                <input class="form-check-input group-checkbox" type="checkbox" data-group="{{ $group }}">
                                                <label class="form-check-label fw-semibold">
                                                    {{ ucfirst($group) }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body py-2">
                                            @foreach($groupPermissions as $permission)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input permission-checkbox" 
                                                       type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}"
                                                       data-group="{{ $group }}"
                                                       id="perm_{{ $permission->id }}">
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->libelle }}
                                                    <small class="text-muted d-block">{{ $permission->code }}</small>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Create Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Group checkbox functionality
        $('.group-checkbox').change(function() {
            const group = $(this).data('group');
            const isChecked = $(this).is(':checked');
            $(`.permission-checkbox[data-group="${group}"]`).prop('checked', isChecked);
        });
        
        // Individual checkbox updates group checkbox
        $('.permission-checkbox').change(function() {
            const group = $(this).data('group');
            const allChecked = $(`.permission-checkbox[data-group="${group}"]:checked`).length === 
                              $(`.permission-checkbox[data-group="${group}"]`).length;
            $(`.group-checkbox[data-group="${group}"]`).prop('checked', allChecked);
        });
    });
</script>
@endpush
@endsection


