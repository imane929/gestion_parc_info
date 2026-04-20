@extends('layouts.admin-new')

@section('title', 'Permissions')
@section('page-title', 'All Permissions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">System Permissions</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Permissions are organized by module. These are system-defined and cannot be modified directly.
                </div>
                
                @foreach($permissions as $group => $groupPermissions)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">{{ ucfirst($group) }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($groupPermissions as $permission)
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border rounded">
                                    <strong>{{ $permission->libelle }}</strong>
                                    <p class="mb-0">
                                        <small class="text-muted">{{ $permission->code }}</small>
                                    </p>
                                    @if($permission->description)
                                    <p class="mb-0 mt-2">
                                        <small>{{ $permission->description }}</small>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

