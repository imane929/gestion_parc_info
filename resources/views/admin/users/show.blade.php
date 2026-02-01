@extends('admin.layouts.admin')

@section('title', 'Détails Utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Détails de l'utilisateur</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center mx-auto rounded-circle mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'technicien' ? 'warning' : 'info') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Email</label>
                                    <p class="form-control-plaintext">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Rôle</label>
                                    <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Date d'inscription</label>
                                    <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Dernière connexion</label>
                                    <p class="form-control-plaintext">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Statut</label>
                                    <p class="form-control-plaintext">
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Vérifié</span>
                                        @else
                                            <span class="badge bg-warning">Non vérifié</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">ID</label>
                                    <p class="form-control-plaintext">#{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- User Statistics -->
                    <h5 class="mb-3">Statistiques</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-start border-primary border-4">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">0</h5>
                                    <small class="text-muted">Équipements assignés</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-start border-success border-4">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">0</h5>
                                    <small class="text-muted">Tickets créés</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-start border-warning border-4">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">0</h5>
                                    <small class="text-muted">Tickets résolus</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-start border-info border-4">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">0</h5>
                                    <small class="text-muted">Affectations actives</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection