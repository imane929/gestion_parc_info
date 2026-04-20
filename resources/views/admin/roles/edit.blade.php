@extends('layouts.admin-new')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role: ' . $role->libelle)

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Edit Role</h2>
            </div>
            <div class="p-4 lg:p-6">
                <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                                   value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Code -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Code <span class="text-red-500">*</span></label>
                            <input type="text" name="code" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror" 
                                   value="{{ old('code', $role->code) }}" required>
                            @error('code')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Libelle -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Label <span class="text-red-500">*</span></label>
                            <input type="text" name="libelle" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('libelle') border-red-500 @enderror" 
                                   value="{{ old('libelle', $role->libelle) }}" required>
                            @error('libelle')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-1">Permissions</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Select the permissions for this role</p>
                    </div>
                    
                    <!-- Permissions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($permissions as $group => $groupPermissions)
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl overflow-hidden">
                            <div class="px-4 py-3 bg-slate-100 dark:bg-slate-700 border-b border-slate-200 dark:border-slate-600">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 group-checkbox" 
                                           data-group="{{ $group }}"
                                           {{ $groupPermissions->pluck('id')->intersect($role->permissions->pluck('id'))->count() == $groupPermissions->count() ? 'checked' : '' }}>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">{{ ucfirst($group) }}</span>
                                </label>
                            </div>
                            <div class="p-4 space-y-3">
                                @foreach($groupPermissions as $permission)
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" 
                                           class="w-4 h-4 mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 permission-checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}"
                                           data-group="{{ $group }}"
                                           id="perm_{{ $permission->id }}"
                                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                    <div>
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $permission->libelle }}</div>
                                        <div class="text-xs text-slate-500">{{ $permission->code }}</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            Update Role
                        </button>
                        <a href="{{ route('admin.roles.show', $role) }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined">close</span>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Group checkbox functionality
        document.querySelectorAll('.group-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const group = this.dataset.group;
                const isChecked = this.checked;
                document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`).forEach(function(cb) {
                    cb.checked = isChecked;
                });
            });
        });
        
        // Individual checkbox updates group checkbox
        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const group = this.dataset.group;
                const total = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`).length;
                const checked = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]:checked`).length;
                document.querySelectorAll(`.group-checkbox[data-group="${group}"]`).forEach(function(cb) {
                    cb.checked = total === checked;
                });
            });
        });
    });
</script>
@endpush
@endsection

