@extends('layouts.admin-new')

@section('title', 'Assign Permissions')
@section('page-title', 'Assign Permissions')

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-extrabold tracking-tight text-on-surface mb-1">
            <span class="material-symbols-outlined text-primary align-middle me-2">user_sharring</span>
            Assign Permissions to: <strong class="text-primary">{{ $utilisateur->full_name }}</strong>
        </h2>
        <p class="text-on-surface-variant text-sm font-medium">{{ $utilisateur->email }}</p>
    </div>
    <a href="{{ route('admin.utilisateurs.index') }}" class="flex items-center gap-2 bg-surface-container-low hover:bg-surface-container text-on-surface px-4 py-2 rounded-lg font-medium transition-all border border-outline-variant/20">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Back to Users
    </a>
</div>

<div class="bg-surface-container-lowest rounded-xl ghost-border overflow-hidden">
    <form action="{{ route('admin.utilisateurs.sync-permissions', $utilisateur) }}" method="POST" id="permissionsForm">
        @csrf
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Roles Section -->
                <div class="bg-surface-container-low p-6 rounded-xl">
                    <h4 class="text-lg font-bold text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">group</span>
                        Roles
                    </h4>
                    <div class="space-y-3" style="max-height: 400px; overflow-y: auto;">
                        @forelse($roles as $role)
                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-surface-container-lowest cursor-pointer transition-all border border-transparent hover:border-outline-variant/20">
                            <input type="checkbox" 
                                   name="roles[]" 
                                   value="{{ $role->id }}" 
                                   class="mt-1 h-4 w-4 rounded border-outline-variant/30 text-primary focus:ring-primary/20"
                                   {{ $utilisateur->roles->contains('id', $role->id) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">{{ $role->libelle }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $role->description ?? 'No description' }}</p>
                                <span class="inline-flex mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-surface-container text-on-surface-variant uppercase tracking-tight">
                                    {{ $role->code }}
                                </span>
                            </div>
                        </label>
                        @empty
                        <p class="text-center text-on-surface-variant py-4">No roles available</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Permissions Section -->
                <div class="bg-surface-container-low p-6 rounded-xl">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-amber-600">key</span>
                            Direct Permissions
                        </h4>
                        <label class="flex items-center gap-2 text-xs font-semibold text-on-surface-variant cursor-pointer">
                            <input type="checkbox" id="selectAllPermissions" class="h-4 w-4 rounded border-outline-variant/30 text-primary focus:ring-primary/20">
                            Select All
                        </label>
                    </div>
                    <div class="space-y-4" style="max-height: 400px; overflow-y: auto;">
                        @forelse($permissions as $group => $groupPermissions)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">
                                    {{ ucfirst($group) }}
                                </h5>
                                <label class="flex items-center gap-1 text-[10px] font-semibold text-on-surface-variant cursor-pointer">
                                    <input type="checkbox" class="select-group h-3 w-3 rounded border-outline-variant/30 text-primary focus:ring-primary/20" data-group="{{ $group }}">
                                    Select All
                                </label>
                            </div>
                            <div class="space-y-2 pl-2 border-l-2 border-outline-variant/20">
                                @foreach($groupPermissions as $permission)
                                <label class="flex items-center gap-2 p-2 rounded-lg hover:bg-surface-container-lowest cursor-pointer transition-all">
                                    <input type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}" 
                                           class="permission-checkbox h-4 w-4 rounded border-outline-variant/30 text-primary focus:ring-primary/20"
                                           data-group="{{ $group }}"
                                           {{ $utilisateur->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-on-surface">{{ $permission->libelle }}</p>
                                        <p class="text-[10px] text-on-surface-variant font-mono">{{ $permission->code }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-on-surface-variant py-4">No permissions available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/10 flex items-center justify-between">
            <div class="text-xs text-on-surface-variant">
                <span class="font-semibold">{{ $utilisateur->roles->count() }}</span> roles assigned | 
                <span class="font-semibold">{{ $utilisateur->permissions->count() }}</span> direct permissions
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.utilisateurs.index') }}" class="px-4 py-2 text-sm font-medium text-on-surface-variant hover:text-on-surface transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex items-center gap-2 bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg shadow-primary/20 transition-all">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Save Permissions
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Current Permissions Summary -->
<div class="mt-6 bg-surface-container-lowest rounded-xl ghost-border p-6">
    <h4 class="text-lg font-bold text-on-surface mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">info</span>
        Current Permissions Summary
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h5 class="text-[11px] font-bold uppercase tracking-widest text-on-surface-variant mb-3">Assigned Roles</h5>
            @if($utilisateur->roles->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($utilisateur->roles as $role)
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-sm">group</span>
                            {{ $role->libelle }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-on-surface-variant italic">No roles assigned</p>
            @endif
        </div>
        <div>
            <h5 class="text-[11px] font-bold uppercase tracking-widest text-on-surface-variant mb-3">Direct Permissions</h5>
            @if($utilisateur->permissions->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($utilisateur->permissions as $permission)
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-surface-container text-on-surface-variant border border-outline-variant/20">
                            <span class="material-symbols-outlined text-sm">key</span>
                            {{ $permission->libelle }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-on-surface-variant italic">No direct permissions</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllPermissions');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        permissionCheckboxes.forEach(cb => cb.checked = this.checked);
    });
    
    document.querySelectorAll('.select-group').forEach(function(groupCheckbox) {
        groupCheckbox.addEventListener('change', function() {
            const group = this.dataset.group;
            document.querySelectorAll('.permission-checkbox[data-group="' + group + '"]').forEach(cb => {
                cb.checked = this.checked;
            });
        });
    });
    
    permissionCheckboxes.forEach(function(cb) {
        cb.addEventListener('change', function() {
            const allChecked = Array.from(permissionCheckboxes).every(c => c.checked);
            selectAllCheckbox.checked = allChecked;
            
            const group = this.dataset.group;
            const groupCheckboxes = document.querySelectorAll('.permission-checkbox[data-group="' + group + '"]');
            const groupAllChecked = Array.from(groupCheckboxes).every(c => c.checked);
            const groupCheckbox = document.querySelector('.select-group[data-group="' + group + '"]');
            if (groupCheckbox) groupCheckbox.checked = groupAllChecked;
        });
    });
    
    document.getElementById('permissionsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Confirm Changes',
            text: 'Are you sure you want to update permissions for this user?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0058be',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, Save',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endpush

