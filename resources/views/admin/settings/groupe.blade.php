@extends('layouts.admin-new')

@section('title', ucfirst($groupe) . ' Settings')
@section('page-title', ucfirst($groupe) . ' Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ ucfirst($groupe) }} Settings</h5>
                <div>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Settings
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update-multiple') }}">
                    @csrf
                    <input type="hidden" name="groupe" value="{{ $groupe }}">
                    
                    <div class="row">
                        @foreach($parametres as $parametre)
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                {{ ucfirst(str_replace('_', ' ', $parametre->cle)) }}
                                @if($parametre->description)
                                    <small class="text-muted d-block">{{ $parametre->description }}</small>
                                @endif
                            </label>
                            
                            @if($parametre->type === 'boolean')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           name="param_{{ $parametre->cle }}" 
                                           id="{{ $parametre->cle }}"
                                           {{ $parametre->valeur === 'true' || $parametre->valeur === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $parametre->cle }}">
                                        Enabled
                                    </label>
                                </div>
                            @elseif($parametre->type === 'text')
                                <textarea name="param_{{ $parametre->cle }}" 
                                          class="form-control" 
                                          rows="3">{{ $parametre->valeur }}</textarea>
                            @elseif($parametre->type === 'integer' || $parametre->type === 'decimal')
                                <input type="number" 
                                       name="param_{{ $parametre->cle }}" 
                                       class="form-control" 
                                       value="{{ $parametre->valeur }}">
                            @else
                                <input type="{{ $parametre->type === 'email' ? 'email' : ($parametre->type === 'url' ? 'url' : 'text') }}" 
                                       name="param_{{ $parametre->cle }}" 
                                       class="form-control" 
                                       value="{{ $parametre->valeur }}">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Save Changes
                        </button>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

