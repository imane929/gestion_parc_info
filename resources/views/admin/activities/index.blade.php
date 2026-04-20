@extends('layouts.admin-new')

@section('title', 'Activities')
@section('page-title', 'Activities')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Activity Log</h5>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($activities->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No activities found.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        @if($activity->utilisateur)
                                            <span class="avatar-sm" style="background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%);">
                                                {{ $activity->utilisateur->initials }}
                                            </span>
                                            {{ $activity->utilisateur->full_name }}
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge-status 
                                            @if($activity->action === 'created') success
                                            @elseif($activity->action === 'updated') warning
                                            @elseif($activity->action === 'deleted') danger
                                            @else active @endif">
                                            {{ $activity->action }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($activity->objet_type)
                                            {{ class_basename($activity->objet_type) }} #{{ $activity->objet_id }}
                                        @else
                                            {{ $activity->description ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ $activity->ip ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


